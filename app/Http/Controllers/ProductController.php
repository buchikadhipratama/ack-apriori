<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Variant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product()
    {
        // $product = Product::all();
        $product = Product::where('status','=',1)->get();
        return view ('product', compact('product'));
    }

    public function transaction()
    {
        $transaction = Transaction::all();
        return view ('transaction', compact('transaction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('editProduct', [
            'product' => $product,
            'message' => null,
            'category' => Category::all(),
            'variant' => Variant::all()
        ]);
    }
    public function editProduct(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id'            => 'required|numeric|exists:products,id',
            'name'          => 'required|string',
            'photo'         => 'nullable|mimes:jpg,jpeg,png|max:2000',
            'category_id'   => 'required|numeric|exists:categories,id',
            'variant_id'    => 'required|numeric|exists:variants,id',
            'stock'         => 'required|numeric',
            'price'         => 'required|numeric'
        ], [
            'photo.mimes'  => 'Format foto product harus berupa jpg/jpeg/png',
            'photo.max'    => 'Ukuran foto product maksumal 2 mb',
        ]);

        if ($validation->fails()) {
            return view('editProduk', [
                'message' => $validation->errors()->first(),
                'category' => Category::all(),
                'variant' => Variant::all()
            ]);
        } else {
            $product = Product::find($request->id);
            $path = $product->photo;
            if ($file = $request->file('photo')) {
                if ($path != null) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }

                $path = $file->store('product', 'public');
            }

            $product->update([
                'name'          => $request->name,
                'photo'         => $path,
                'category_id'   => $request->category_id,
                'variant_id'    => $request->variant_id,
                'stock'         => $request->stock,
                'price'         => $request->price
            ]);

            return view('editProduct', [
                'product' => Product::find($request->id),
                'message' => 'Data produk berhasil diperbaharui',
                'category' => Category::all(),
                'variant' => Variant::all()
            ]);
        }
    }

    public function delete($id)
    {
        $validation = Validator::make(['id' => $id],[
            'id' => 'required|numeric|exists:products,id'
        ]);

        if ($validation->fails()){
        } else {
            $product = Product::find($id);
            $product->status = 0;
            $product->save();
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
