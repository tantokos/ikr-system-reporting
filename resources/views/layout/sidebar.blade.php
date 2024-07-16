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
        <li class="pcoded-trigger {{ request()->is('reportDash*', '/') ? 'active' : '' }}">
            <a href="{{ route('report.dashboard')}}">
                <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                <span class="pcoded-mtext" data-i18n="nav.dash.main">IKR Dashboard</span>
                <span class="pcoded-mcaret"></span>
            </a>
        </li>

        <li
            {{-- class="pcoded-hasmenu pcoded-trigger {{ request()->is('report*') ? 'active' : '' }}"> --}}
            class="pcoded-hasmenu pcoded-trigger {{ request()->is('report*') ? 'active' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-view-list-alt"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">IKR Monthly Report</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                
                <li class="{{ request()->is('reportIBFtth*') ? 'active' : '' }}">
                    <a href="{{ route('reportIBFtth.index')}}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">FTTH New Installation</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->is('reportMtFtth*') ? 'active' : '' }}">
                    <a href="{{ route('reportMtFtth.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">FTTH Maintenance</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->is('reportDismantleFtth*') ? 'active' : '' }}">
                    <a href="{{ route('reportDismantleFtth.index')}}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">FTTH Dismantle</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->is('reportIBFttx*') ? 'active' : '' }}">
                    <a href="{{ route('reportIBFttx.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">FTTX/B New Installation</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->is('reportMTFttx*') ? 'active' : '' }}">
                    <a href="{{ route('reportMTFttx.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">FTTX/B Maintenance</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->is('reportFat*') ? 'active' : '' }}">
                    <a href="{{ route('reportFat.index') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Report Activity FAT</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                
            </ul>
        </li>
    </ul>


    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
    <ul class="pcoded-item pcoded-left-item">
        <li
            class="pcoded-hasmenu pcoded-trigger {{ request()->is('importftthmt*','importftthib*','importftthDismantle*','importfttxMT*','importfttxIB*') ? 'active' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-view-list-alt"></i></span>
                <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Import Data</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                
                <li class="{{ request()->is('importftthIBtem*') ? 'active' : '' }}">
                    <a href="{{ route('import.ftthIBtempIndex') }}"> 
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Import Ftth IB</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->is('importftthmt*') ? 'active' : '' }}">
                    <a href="{{ route('import.ftthmttempIndex') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Import Ftth MT</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                {{-- <li class="{{ request()->is('importftthmtsortir*') ? 'active' : '' }}">
                    <a href="{{ route('import.ftthmtsortirIndex') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Import Ftth MT Sortir</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li> --}}

                

                {{-- <li class="{{ request()->is('importftthIBSortirIndex*') ? 'active' : '' }}">
                    <a href="{{ route('import.ftthIBSortirIndex') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Import Ftth IB Sortir</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li> --}}

                <li class="{{ request()->is('importftthDismantle*') ? 'active' : '' }}">
                    <a href="{{ route('import.ftthDismantletempIndex') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Import Ftth Dismantle</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->is('importfttxIB*') ? 'active' : '' }}">
                    <a href="{{ route('import.fttxIBtempIndex') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Import Fttx IB</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ request()->is('importfttxMT*') ? 'active' : '' }}">
                    <a href="{{ route('import.fttxMTtempIndex') }}">
                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Import Fttx MT</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

            </ul>
        </li>
    </ul>

    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
    
  
</div>
