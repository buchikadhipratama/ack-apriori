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
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h4 class="card-title float-left mt-2">Daftar Semua Produk</h4>
                        <button type="button" class="btn btn-primary float-right veiwbutton">View All</button>
                    </div>
                    <div class="card-body m-2">
                        <div class="table-responsive">
                            <table id="daftarProduk" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto Product</th>
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
                                        <td>{{ $i+1 }}</td>
                                        <td>
                                            <img @if ($product[$i]->photo != null)
                                            src="{{ asset('/storage/app/public/'.$product[$i]->photo) }}"
                                            @else
                                            src="{{ asset('/img/placeholder.jpg') }}"
                                            @endif
                                            style="width: 100px; height: 100px; border-radius:5%">
                                        </td>
                                        <td>{{ $product[$i]->name }}</td>
                                        <td>{{ $product[$i]->category->name }}</td>
                                        <td>{{ $product[$i]->variant->name }}</td>
                                        <td>{{ $product[$i]->stock }}</td>
                                        <td>
                                            Rp. {{ number_format($product[$i]->price) }}
                                        </td>
                                        <td class="text-center"> <span class="badge badge-pill bg-success inv-badge">INACTIVE</span> </td>
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#daftarProduk').DataTable();
    });
</script>
@endsection
