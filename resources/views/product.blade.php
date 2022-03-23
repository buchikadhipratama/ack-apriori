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
                        <button type="button" class="btn btn-primary float-right veiwbutton">
                            <span class="fas fa-plus"> </span> Tambah Produk Baru</button>
                    </div>
                    <div class="card-body m-2">
                        <div class="table-responsive">
                            <table id="daftarProduk" class="display table-bordered text-center">
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
                                            src="assets/img/image_not_found.png"
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
                                        <td>
                                            <a href="/product/detail/{{ $product[$i]->id }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-s"
                                                onclick="deleteModal({{ $product[$i]->id }})">
                                                <i class="fas fa-trash-alt"></i>
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
        </div>
    </div>
</div>

{{-- modal delete --}}
<div class="modal fade show" id="modal-delete" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Peringatan!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="x-modal" onclick="keluar()">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda Yakin Menghapus Produk ini?</p>
                <input type="hidden" id="product-id">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                <button type="button" class="btn btn-warning tombol" onclick="goToDelete();">Yakin dan
                    Hapus</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- modal sukses --}}
<div class="modal fade show" id="modal-success" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pesan Sistem</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Sukses Menghapus Produk&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                {{-- <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-warning tombol" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#daftarProduk').DataTable();
        if(window.sessionStorage.getItem("delete")){
            window.sessionStorage.clear();
            $('#modal-success').modal('toggle');
        }
    });

    function deleteModal(id){
        $('#product-id').val(id);
        $('#modal-delete').modal('toggle');
    }

    function goToDelete(){
        var id = $('#product-id').val();
        window.sessionStorage.setItem("delete", true);
        window.location.href = "/produk/hapus/"+id;
    }
</script>
@endsection
