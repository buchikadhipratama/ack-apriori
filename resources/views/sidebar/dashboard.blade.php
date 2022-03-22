<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="active"> <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a> </li>
                <li class="list-divider"></li>
                <li class="submenu"> <a href="#"><i class="fas fa-suitcase"></i> <span> Produk </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a href="{{ route('/produk') }}"> Semua Produk </a></li>
                        {{-- <li><a href="{{ route('form/allbooking') }}"> All Booking </a></li>
                        <li><a href="{{ url('form/booking/edit') }}"> Edit Booking </a></li>
                        <li><a href="{{ route('form/booking/add') }}"> Add Booking </a></li> --}}
                    </ul>
                </li>
                <li class="submenu"> <a href="#"><i class="fas fa-book"></i> <span> Transaksi </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a href="{{ route('/transaksi') }}"> Semua Transaksi </a></li>

                        {{-- <li><a href="{{ route('form/allcustomers/page') }}"> All customers </a></li>
                        <li><a href="{{ url('form/customer/edit/') }}"> Edit Customer </a></li>
                        <li><a href="{{ route('form/addcustomer/page') }}"> Add Customer </a></li> --}}
                    </ul>
                </li>
                <li class="submenu"> <a href="#"><i class="far fa-money-bill-alt"></i> <span> POS </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a href="{{ route('/kasir') }}"> Buka Kasir </a></li>
                        {{-- <li><a href="{{ route('form/allrooms/page') }}">All Rooms </a></li>
                        <li><a href="{{ url('form/room/edit') }}"> Edit Rooms </a></li>
                        <li><a href="{{ route('form/addroom/page') }}"> Add Rooms </a></li> --}}
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
