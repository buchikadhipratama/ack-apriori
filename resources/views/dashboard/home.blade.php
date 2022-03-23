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
        <div class="row">
            <div class="col-xl-6 col-sm-6 col-12">
                <div class="card board1 fill">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <div>
                                <h3 class="card_widget_header">{{ $product }}</h3>
                                <h6 class="text-muted">Total Produk</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 col-12">
                <div class="card board1 fill">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <div>
                                <h3 class="card_widget_header">{{ $transaction }}</h3>
                                <h6 class="text-muted">Total Transaksi</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- produk habis --}}
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h4 class="card-title float-left mt-2">Produk Non Aktif</h4>
                        {{-- <button type="button" class="btn btn-primary float-right veiwbutton">Veiw All</button> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="produkNonAktif" class="display table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0 ; $i < count($disable) ; $i++)
                                        <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $disable[$i]->name }}</td>
                                        <td>{{ $disable[$i]->category->name }}</td>
                                        <td>{{ $disable[$i]->stock }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-s"
                                                onclick="deleteModal({{ $disable[$i]->id }})">
                                                <i class="fas fa-toggle-on"></i>
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
            <div class="col-md-12 col-lg-6">
                <div class="card card-chart">
                    <div class="card-header">
                        <h4 class="card-title">Produk Laku Berdasarkan Kategori</h4>
                    </div>
                    <div class="card-body">
                        <div id="donut-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- pie chart --}}
        <div class="row">
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

        </div>

    </div>
</div>
<script>
    $(document).ready(function(){
        $('#produkNonAktif').DataTable();
       });
</script>
@endsection
