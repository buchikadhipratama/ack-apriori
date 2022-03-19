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
                        <h4 class="card-title float-left mt-2">Daftar Semua Transaksi</h4>
                        <button type="button" class="btn btn-primary float-right veiwbutton">View All</button>
                    </div>
                    <div class="card-body m-2">
                        <div class="table-responsive">
                            <table id="daftarTransaksi" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Product</th>
                                        <th>Jumlah Total</th>
                                        <th>Total Harga</th>
                                        <th>Tanggal Transaksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0 ; $i < count($transaction) ; $i++)
                                        <tr>
                                        @php
                                        $totalProduct = 0
                                        @endphp
                                        <td>{{ $i+1 }}</td>
                                        <td>
                                            @for ($j = 0; $j < count($transaction[$i]->item); $j++)
                                                @php
                                                $totalProduct += $transaction[$i]->item[$j]->count
                                                @endphp
                                                @if ($j > 0)
                                                ,
                                                @endif
                                                {{ $transaction[$i]->item[$j]->product->name }} - {{ $transaction[$i]->item[$j]->product->variant->name }}
                                                ({{ $transaction[$i]->item[$j]->count }})
                                                @endfor
                                        </td>
                                        <td>{{ $totalProduct }}</td>
                                        <td>Rp. {{ number_format($transaction[$i]->total_price) }}</td>
                                        <td>{{ date_format($transaction[$i]->created_at, 'd-m-Y H:i') }}</td>
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
        $('#daftarTransaksi').DataTable();
    });
</script>
@endsection
