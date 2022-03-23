@extends('layouts.master')
@section('menu')
@extends('sidebar.dashboard')
@endsection
@section('content')
{{-- message --}}
{{-- {!! Toastr::message() !!} --}}

<style>
    .row-recommendation {
        align-items: stretch;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        padding: 0px 16px 16px 16px;
        overflow-x: auto;
        max-width: 100%;
    }

    .card-recommendation {
        width: 200px;
        flex-grow: 0;
        flex-shrink: 0;
        border: 0.5px solid #4f5962;
        margin: 5px 5px 0px 5px;
        padding: 0px;
        border-radius: 10px;
        text-align: center
    }
</style>


<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12 mt-5">
                    {{-- <h3 class="page-title mt-3">Good Morning {{ Auth::user()->name }}!</h3> --}}
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- produk habis --}}
        <div class="row" id="recommendation-container">
            <div class="col-lg-12 col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Rekomendasi Makanan</h3>
                    </div>
                    <div class="card-body">
                        <div id="recommendation-not-found" style="text-align: center">
                            <i class="fas fa-times-circle fa-lg" style="color: #EC061D; font-size: 32px;"></i>
                            <h4 style="margin-top: 10px;">Rekomendasi tidak ditemukan</h4>
                        </div>
                        <div id="recommendation-loading" style="text-align: center" class="hide">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <h4 style="margin-top: 10px;">Sedang mencari rekomendasi yang sesuai...</h4>
                        </div>
                        <div id="recommendation-found" class="hide row-recommendation">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-lg-8">
                <div class="card card-table flex-fill ">
                    <div class="card-header inv-badge">
                        <h4 class="card-title float-left mt-2">Produk</h4>
                    </div>
                    <div class="card-body m-2">
                        <div class="table-responsive">
                            <table id="daftarMenu" class="display table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Varian</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0 ; $i < count($product) ; $i++)
                                        <tr>
                                        <td>{{ $product[$i]->name }}</td>
                                        <td>{{ $product[$i]->category->name }}</td>
                                        <td>{{ $product[$i]->variant->name }}</td>
                                        <td>{{ $product[$i]->stock }}</td>
                                        <td>
                                            {{ number_format($product[$i]->price) }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn inv-badge" onclick="clickItem({{ $product[$i] }},1)" style="width: 10px" id="addTransaction">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </td>
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- kasir --}}
            <div class="col-md-4 col-lg-4">
                <div class="card card-table flex-fill">
                    <div class="card-header inv-badge">
                        <h3 class="card-title">Keranjang Penjualan</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="/penjualan/kasir" enctype="form-data" id="form-order" method="POST">
                        {{ csrf_field() }}
                        <div class="tabel-kasir">
                            <div class="table-transaksi">
                                <table id="myTable" class="" style="width: 100%">
                                    <thead class="text-center">
                                        <tr>
                                            <th class="tabel menu" style="position:sticky; top:0; background-color:#fff">Produk</th>
                                            <th class="tabel varian" style="position:sticky; top:0; background-color:#fff">
                                                Varian</th>
                                            <th class="tabel jumlah" style="position:sticky; top:0; background-color:#fff">
                                                Jumlah</th>
                                            <th class="tabel aksi" style="position:sticky; top:0; background-color:#fff">Harga
                                            </th>
                                            <th class="tabel aksi" style="position:sticky; top:0; background-color:#fff">Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody style="" id="order-list">

                                    </tbody>
                                </table>
                            </div>
                            <div style="width: 100%; height: 0.1px; background-color: #e9e1e1;"></div>
                            <br>
                            <div style="margin: 10px">
                                <input type="hidden" name="total_price" id="input_total_price">
                                <h4><b>Total Harga: </b> <span><b>Rp. <span id="total-price">0</span></b></span>
                                </h4>
                            </div>
                        </div>
                    </form>
                    <div class="card-footer" style="text-align: center">
                        <button class="btn btn-danger tombol" onclick="testing();">Proses Pesanan</button>
                    </div>
                </div>
            </div>

            {{-- pie chart --}}
            {{-- <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h4 class="card-title">Produk Paling Laku</h4>
                        </div>
                        <div class="card-body">
                            <div id="line-chart"></div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
</div>

{{-- <input type="hidden" id="message-status" value="{{ $message }}"> --}}
<script>
    $(document).ready(function(){
      var messageStatus = $('#message-status').val();
      if(messageStatus != ""){
        $('#modal-success').modal('toggle');
      }

      $('#daftarMenu').DataTable({
      });
    });

        // function testing(){
        //     window.alert("hellow");
        // }

    var listOrderId = [];
    function clickItem(product, type){
      var data = product;
      if(type == 2){
        data = JSON.parse(JSON.stringify(product));
      }
      console.log(data);
      console.log(data.name);
      addOrderId(data.id);
      plusTotalPrice(data.price);
      var html = "<tr id='item-"+data.id+"'>";
          html += "<td class='tabel'>"+data.name+"</td>";
          html += "<td class='tabel'>"+data.variant.name+"</td>";
          html += "<td class='tabel' style=' text-align: center; margin:auto'>";
          html += "<select name='count[]' class='form-control' id='filter1' onchange='onCountChange(this,"+data.id+","+data.price+");'>";
          for(let i = 0; i < data.stock; i++){
            html += "<option value='"+(i+1)+"'>"+(i+1)+"</option>";
          }
          html += "</select>";
          html += "</td>";
          html += "<td class='tabel' id='price-"+data.id+"'>"+data.price+"</td>";
          html += "<input type='hidden' name='product_id[]' value='"+data.id+"'>";
          html += "<input type='hidden' name='product_price[]' id='price-"+data.id+"-temp' value='"+data.price+"'>";
          html += "<td class='tabel'><button onclick='removeItem("+data.id+",2);' type='button' class='btn btn-default btn-s'><i class='fas fa-trash-alt'></i></button></td>";
          html += "</tr>";

      $('#order-list').append(html);
      getRecommendation();
    }

    function onCountChange(data, id, price){
      var tempPrice = parseInt($('#price-'+id+'-temp').val());
      console.log(nyoba);
      var changePrice = price * data.value;

      console.log("dibawah")
      console.log(changePrice)

      if(changePrice > tempPrice){
        var total = changePrice - tempPrice;
        plusTotalPrice(total);
      }else if(changePrice < tempPrice){
        var total = tempPrice - changePrice;
        minusTotalPrice(total);
      }

      $('#price-'+id+'-temp').val(changePrice);
      $('#price-'+id+'').html(changePrice);
    }

    function removeItem(id){
      removeOrderId(id);
      $('#item-'+id+'').remove();
      getRecommendation();
    }

    function plusTotalPrice(price){
      var total = parseInt($('#total-price').html()) + price;
      $('#input_total_price').val(total);
      $('#total-price').html(total);
    }

    function minusTotalPrice(price){
      var total = parseInt($('#total-price').html()) - price;
      $('#input_total_price').val(total);
      $('#total-price').html(total);
    }

    // orderProcess()

    // doPayment()
    function addOrderId(id){
      listOrderId.push(parseInt(id));
      console.log("list order id = " + listOrderId);

    //   var temp = parseInt($('#price-'+id+'-temp').val());
    //   console.log(temp);

      return listOrderId;
    }

    function removeOrderId(data){
      var id = parseInt(data);
      for(var i = 0; i < listOrderId.length; i++){
        if(listOrderId[i] == id){
          listOrderId.splice(i, 1);
        }
      }

      console.log("list order id = " + listOrderId);
      return listOrderId;
    }

    function getRecommendation(){
        if(listOrderId.length > 0){
            var data = {
                order: listOrderId
            };

            console.log(data);

            $('#recommendation-not-found').hide();
            $('#recommendation-found').empty();
            $('#recommendation-found').hide();
            $('#recommendation-loading').show();

            $.ajax({
                url: "/penjualan/apriori",
                type: "GET",
                data: data,
                success: function(data) {
                    $('#recommendation-loading').hide();
                    if(data.length > 0){
                    var html = "";
                    for(var i = 0; i < data.length; i++){
                        html += "<div class='card-recommendation'>";
                        var img = "";
                        if(data[i].product.photo == null){
                        img = "{{ asset('/img/img_not_found.png') }}";
                        }else{
                        img = "{{ asset('/storage/" + data[i].product.photo+"') }}";
                        }

                        html += "<img src='"+img+"' class='img-fluid mb-2' alt='white sample' style='border-radius:10px; max-height:150px' />";
                        html += "<div style='padding: 0px 10px 0px 10px'>";
                        html += "<h5><b>"+data[i].product.name+"</b></h5>";
                        html += "<h6>("+data[i].product.variant.name+")</h6>";
                        html += "<h6>Stok "+data[i].product.stock+"</h6>";
                        html += "<h6>Rp. "+data[i].product.price+"</h6>";
                        html += "<button onclick='clickItem("+JSON.stringify(data[i].product)+",2);' class='btn btn-warning tombol' style='width: 100%; flex:100%; max-width:92%; margin-bottom:10px;'><i class='fas fa-plus'></i> Keranjang</button>";
                        html += "</div>";
                        html += "</div>";
                    }
                    $('#recommendation-found').append(html);
                    $('#recommendation-found').show();
                    }else{
                    $('#recommendation-not-found').show();
                    }
                },
                //   ini fungsi apa?
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log('error = '+err.message);
                }
            });
        }else{
            $('#recommendation-found').hide();
            $('#recommendation-loading').hide();
            $('#recommendation-not-found').show();
        }
    }
</script>
@endsection
