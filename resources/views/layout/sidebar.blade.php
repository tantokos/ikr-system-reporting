<div class="pcoded-inner-navbar main-menu">

    <div class="pcoded-search">
        <span class="searchbar-toggle"> </span>
        <div class="pcoded-search-box ">
            <input type="text" placeholder="Search">
            <span class="search-icon"><i class="ti-search" aria-hidden="true"></i></span>
        </div>
    </div>
    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
    {{-- <ul class="pcoded-item pcoded-left-item">
                                    
                                    
        <li class="{{ request()->is('report*','/') ? 'active' : '' }}">
            <a href="{{ route('report.index') }}">
                <span class="pcoded-micon"><i class="ti-home"></i><b>I</b></span>
                <span class="pcoded-mtext" data-i18n="nav.dash.main">Ikr Monthly Report</span>
                <span class="pcoded-mcaret"></span>
            </a>
            
        </li>
        
    </ul> --}}

    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
    <ul class="pcoded-item pcoded-left-item">
        <li
            class="pcoded-hasmenu pcoded-trigger {{ request()->is('report*', '/') ? 'active' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-view-list-alt"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">IKR Monthly Report</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                
                <li class="{{ request()->is('reportMtFtth*') ? 'active' : '' }}">
                    <a href="{{ route('reportMtFtth.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Report MT FTTH</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                
            </ul>
        </li>
    </ul>


    
    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
    <ul class="pcoded-item pcoded-left-item">
        <li
            class="pcoded-hasmenu pcoded-trigger {{ request()->is('importftthmt*') ? 'active' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-view-list-alt"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Data Master</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                
                
                <li class="{{ request()->is('importftthmt*') ? 'active' : '' }}">
                    <a href="{{ route('import.ftthmttempIndex') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Import Ftth MT</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                
            </ul>
        </li>
    </ul>

    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
    
    
    
  
</div>
