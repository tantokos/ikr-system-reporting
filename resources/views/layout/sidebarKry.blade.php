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
        <li class="">

            <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
            <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ $portal_menu }}</span>
            <span class="pcoded-mcaret"></span>
        </li>
        <li class="{{ request()->is('dashEmployee*') ? 'active' : '' }}">
            <a href="{{ route('dashEmployee') }}">
                <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard Karyawan</span>
                <span class="pcoded-mcaret"></span>
            </a>
        </li>

    </ul>

    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
    <ul class="pcoded-item pcoded-left-item">
        <li
            class="pcoded-hasmenu pcoded-trigger {{ request()->is('employee*', 'branch*', 'callsignLead*', 'callsignTim*', 'fat*', 'aset*') ? 'active' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-view-list-alt"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Data Master</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ request()->is('employee*') ? 'active' : '' }}">
                    <a href="/employee">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data Karyawan</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->is('branch*') ? 'active' : '' }} ">
                    <a href="{{ route('branch.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data Branch</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->is('callsignLead*') ? 'active' : '' }} ">
                    <a href="{{ route('callsignLead.index') }}">
                        {{-- <a href="/callsignLeadShow/2"> --}}
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data Lead Callsign</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->is('callsignTim*') ? 'active' : '' }} ">
                    <a href="{{ route('callsignTim.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data Callsign</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->is('fat*') ? 'active' : '' }}">
                    <a href="{{ route('fat.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Data FAT & Cluster</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

            </ul>
    </ul>




</div>
