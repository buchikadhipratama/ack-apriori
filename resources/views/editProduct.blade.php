@extends('layouts.master')
@section('menu')
@extends('sidebar.dashboard')
@endsection
@section('content')
{{-- message --}}
{{-- {!! Toastr::message() !!} --}}
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
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card card-chart ">
                    <div class="card-header inv-badge">
                        <h4 class="card-title">Prosentasi Berdasarkan Kategori</h4>
                    </div>
                    <div class="card-body">
                        <form action="/product/edit" enctype="multipart/form-data" method="POST">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFile">Input Foto</label>
                                    <div class="row">
                                        <div class="col-sm-1" style="width:200px; height:200px; margin-left:9px; margin-bottom:10px">
                                            <img id="preview" @if($product->photo != null) src="{{ asset('/storage/'.$product->photo) }}" @endif
                                            style="width:200px; height:200px; border: 0.5px dashed #495057; margin-left:-9px; margin-bottom:10px" />
                                        </div>
                                    </div>
                                    <input type="file" id="photo" class="input-group-text" accept="image/*" onchange="previewImage();"
                                        style="border-radius:5%" name="photo">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Produk</label>
                                    <input type="text" class="form-control" id="namaproduk" placeholder="Masukkan Nama Produk" name="name"
                                        value="{{ $product->name }}" required>
                                </div>
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kategori Produk</label>
                                    <select name="category_id" class="form-control" id="category_id">
                                        @for($i = 0; $i < count($category); $i++) <option value="{{ $category[$i]->id }}" @if ($category[$i]->id ==
                                            $product->category_id) selected
                                            @endif>{{ $category[$i]->name }}</option>
                                            @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Variant Produk</label>
                                    <select name="variant_id" class="form-control" id="variant_id">
                                        @for($i = 0; $i < count($variant); $i++) <option value="{{ $variant[$i]->id }}" @if($variant[$i]->id ==
                                            $product->variant_id) selected @endif>
                                            {{ $variant[$i]->name }}</option>
                                            @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Stok Produk</label>
                                    <input type="number" class="form-control" id="stokproduk" placeholder="Masukkan Stok Produk" name="stock"
                                        value="{{ $product->stock }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Harga Produk</label>
                                    <input type="number" class="form-control" id="hargaproduk" placeholder="Masukkan Harga Produk" name="price"
                                        value="{{ $product->price }}" required>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning tombol">Perbaharui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<input type="hidden" id="message-status" value="{{ $message }}">
<script>
    $(document).ready(function(){
    var messageStatus = $('#message-status').val();
    if(messageStatus != ""){
      console.log("message status = "+messageStatus);
      $('#modalSimpan').modal('toggle');
    }
    });

    function previewImage(){
           const reader = new FileReader();
           reader.readAsDataURL($('#photo').get(0).files[0]);
           reader.onload = () => {
              const preview = document.getElementById('preview');
              preview.src = reader.result;
           };
        };
</script>
@endsection
