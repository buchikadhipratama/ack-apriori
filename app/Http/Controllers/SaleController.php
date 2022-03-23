<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{

    public function index()
    {
        $product = Product::all();
        return view('kasir', compact('product'));
    }

    public function apriori(Request $request)
    {
        $result = array();
        $transaction = Transaction::all();
        $asosiation = $request->order;
        //$asosiation = [325, 413];

        //325 -> poci original - take away
        //413 -> ayam a crispy - take away

        /*proses pencarian riwayat transaksi berdasarkan asosiasi yang diberikan
        pada proses ini,data akan langsung diolah sehingga riwayat transaksi yang
        telah didapatkan akan diolah sehingga hasil iteration hanya akan memiliki list
        dari daftar produk yang dibeli berbarengan dengan produk asosiasi yang diberikan
        */
        $iteration = $this->getFirstModelIteration($transaction, $asosiation);
        if (count($iteration) == 0) {
            if (count($asosiation) > 2) {
                $iteration = $this->getSecondModelIteration($transaction, $asosiation);
                if (count($iteration) == 0) {
                    $iteration = $this->getThirdModelIteration($transaction, $asosiation);
                }
            } else if (count($asosiation) == 2) {
                $iteration = $this->getThirdModelIteration($transaction, $asosiation);
            }
        }

        if (count($iteration) > 0) {
            //jika iteration ditemukan, maka proses memfilter rekomendasi dilakukan
            $recommendation = $this->getRecommendation($iteration);
            $recommendationResult = $this->limitRecommendation($recommendation, 3, 4);

            foreach ($recommendationResult as $r) {
                $product = Product::find($r->id);
                $product->variant = $product->variant;
                $result[] = array(
                    'product' => $product,
                    'frequency' => $r->frequency
                );
            }
        }

        return response()->json($result, 200);
    }

    //cari semua kemungkinan rekomendasi dari daftar produk yang dipesan
    public function getFirstModelIteration($transaction, $asosiation)
    {
        $iteration = array();

        /*mencari transaksi yang berisi pembelian produk berdasarkan asosiasi yang diberikan
        dan mencari jika terdapat pembelian produk lain dalam transaksi tersebut*/
        foreach ($transaction as $t) {
            $find = $t->item->whereIn('product_id', $asosiation);
            if (count($find) >= count($asosiation)) {
                $item = DB::table('items')->select('product_id')->where('transaction_id', $t->id)->distinct()->get();
                if (count($item) > count($asosiation)) {
                    $result = (object) array(
                        'transaction_id'    => $t->id,
                        'product'           => $item,
                    );
                    // $iteration[] = $result;`
                }
            }
        }
        dd($iteration);

        /*melakukan filter untuk mengumpulkan produk lain yang terdapat dalam transaksi
        yang telah dicari sebelumnya*/
        $secondIteration = array();
        if (count($iteration) > 0) {
            foreach ($iteration as $p) {
                $product = array();
                foreach ($p->product as $id) {
                    $statusTemp = 0;
                    foreach ($asosiation as $a) {
                        //mengecek apakah produk ini tidak termasuk dalam request produk yang dicari rekomendasinya
                        if ($id->product_id != $a) {
                            $statusTemp++;
                        }
                    }
                    if ($statusTemp == count($asosiation)) {
                        //mengecek apakah stok produk masih atau tidak
                        $productDB = Product::find($id->product_id);
                        if ($productDB->stock > 0) {
                            $product[] = $id;
                        }
                    }
                }
                $secondIteration[] = (object) array(
                    'transaction_id'    => $p->transaction_id,
                    'product'           => $product
                );
            }
        }

        return $secondIteration;
    }

    //cari semua kemungkinan rekomendasi dari kombinasi 2 produk yang dipesan
    public function getSecondModelIteration($transaction, $asosiation)
    {
        //function ini hanya dapat digunakan jika jumlah asosiasi/produk yg dipesan lebih dari 2
        $result = array();
        for ($i = 0; $i < count($asosiation) - 1; $i++) {
            $customAssosiation = array();
            //melakukan kombinasi 2 product_id
            for ($j = ($i + 1); $j < count($asosiation); $j++) {
                $customAssosiation = array($asosiation[$i], $asosiation[$j]);
                //mencari riwayat transaksi berdasarkan kombinasi product_id yang telah disusun
                $iteration = $this->getFirstModelIteration($transaction, $customAssosiation);
                if (count($iteration) > 0) {
                    $result += $iteration;
                }
            }
        }

        return $result;
    }

    //cari semua kemungkinan rekomendasi dari setiap produk yang dipesan
    public function getThirdModelIteration($transaction, $asosiation)
    {
        $result = array();
        foreach ($asosiation as $a) {
            $iteration = $this->getFirstModelIteration($transaction, array($a));
            if (count($iteration) > 0) {
                $result += $iteration;
            }
        }

        return $result;
    }

    /* function ini digunakan untuk mengurutkan rekomendasi produk
    dari yang paling sering mundul dalam transaksi sebelumnya, sampai
    yang paling jarang muncul */
    public function getRecommendation($iteration)
    {
        //menyimpan product_id dalam array produk
        $products = array();
        $index = 0;
        foreach ($iteration as $item) {
            foreach ($item->product as $p) {
                $products[$index] = $p->product_id;
                $index++;
            }
        }

        //menghitung frekuansi dari setiap produk
        $productFrequency = array();
        foreach ($products as $p) {
            if (count($productFrequency) == 0) {
                $productFrequency[] = (object) array(
                    'id'        => $p,
                    'frequency' => 1
                );
            } else {
                $status = false;
                foreach ($productFrequency as $frequency) {
                    if ($p == $frequency->id) {
                        $status = true;
                        $frequency->frequency += 1;
                    }
                }

                if (!$status) {
                    $productFrequency[] = (object) array(
                        'id'        => $p,
                        'frequency' => 1
                    );
                }
            }
        }

        //melakukan sort untuk frekuensi produk dari yang terbesar - terkecil
        $result = array();
        for ($i = count($productFrequency) - 1; $i >= 0; $i--) {
            $temp = 0;
            for ($j = 0; $j < count($productFrequency); $j++) {
                if ($productFrequency[$temp]->frequency < $productFrequency[$j]->frequency) {
                    $temp = $j;
                }
            }

            $result[] = $productFrequency[$temp];
            array_splice($productFrequency, $temp, 1);
        }

        return $result;
    }

    /*melakukan pengecekan apakah ada yang memenuhi golden rasio atau tidak
    jika tidak, maka ada tidak akan di filter dengan golden rasio
    kemudian diberikan limit berdasarkan frekuensi terbesar-terkecil*/
    public function limitRecommendation($recommendation, $goldenRasio, $limit)
    {
        $result = array();
        $goldenList = array();
        foreach ($recommendation as $recom) {
            if ($recom->frequency >= $goldenRasio) {
                $goldenList[] = $recom;
            }
        }

        $listRecom = $recommendation;
        if (count($goldenList) > 0) {
            $listRecom = $goldenList;
        }

        if ($limit < count($listRecom)) {
            for ($i = 0; $i < $limit; $i++) {
                $result[] = $listRecom[$i];
            }
        } else {
            $result = $listRecom;
        }

        return $result;
    }
}
