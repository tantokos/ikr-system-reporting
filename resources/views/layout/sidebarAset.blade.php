<div class="pcoded-inner-navbar main-menu">

    <div class="pcoded-search">
        <span class="searchbar-toggle"> </span>
        <div class="pcoded-search-box ">
            <input type="text" placeholder="Search">
            <span class="search-icon"><i class="ti-search" aria-hidden="true"></i></span>
        </div>
    </div>
    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
    <ul class="pcoded-item pcoded-left-item">
        
        
        <li class="{{ request()->is('dashAset*') ? 'active' : '' }}">
            <a href="{{ route('dashAset.index') }}">
                <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard Aset</span>
                <span class="pcoded-mcaret"></span>
            </a>
        </li>
        
    </ul>
    
    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
    <ul class="pcoded-item pcoded-left-item">
        <li
            class="pcoded-hasmenu pcoded-trigger {{ request()->is('employee*', 'branch*', 'callsignLead*', 'callsignTim*','fat*','aset*') ? 'active' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-view-list-alt"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Data Master</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                
                
                <li class="{{ request()->is('aset*') ? 'active' : '' }}">
                    <a href="{{ route('aset.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data Asset</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                
            </ul>
    </ul>

    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>

    <ul class="pcoded-item pcoded-left-item">
        <li
            class="pcoded-hasmenu pcoded-trigger {{ request()->is('peminjaman*','pengembalian*') ? 'active' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Transaksi</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->is('peminjaman*') ? 'active' : '' }}  ">
                    <a href="{{ route('peminjaman.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Distribusi Aset</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->is('pengembalian*') ? 'active' : '' }}  ">
                    <a href="{{ route('pengembalian.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Pengembalian Aset</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
    </ul>


   
</div>
