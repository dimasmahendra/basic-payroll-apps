@php
    $page = URL::current();
@endphp

<div class="left-sidenav">
  <div class="brand">
      <a href="{{ route('dashboard') }}" class="logo">
          <span class="logo text-blue">SETI-AJI</span>
      </a>
  </div>
  <div class="menu-content h-100" data-simplebar>
      <ul class="metismenu left-sidenav-menu pt-0">
            <li class="menu-label my-2">Menu</li>
            <li class="nav-item {{ (strpos($page, 'dashboard') !== false) ? 'item-active' : '' }}">
                <a href="{{ route('dashboard') }}"><i data-feather="home" class="align-self-center menu-icon"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item {{ (strpos($page, 'karyawan') !== false) ? 'item-active' : '' }}">
                <a href="{{ route('karyawan') }}" class="{{ (strpos($page, 'karyawan') !== false) ? 'active' : '' }}"><i data-feather="users" class="align-self-center menu-icon"></i><span>Karyawan</span></a>
            </li>
            <li class="nav-item {{ (strpos($page, 'absensi') !== false) ? 'item-active' : '' }}">
                <a href="{{ route('absensi') }}" class="{{ (strpos($page, 'absensi') !== false) ? 'active' : '' }}"><i data-feather="calendar" class="align-self-center menu-icon"></i><span>Absensi</span></a>
            </li>
            <li class="">
                <a href="javascript: void(0);" aria-expanded="false">
                    <i data-feather="credit-card" class="align-self-center menu-icon"></i>
                    <span>Angsuran</span>
                    <span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i>
                    </span>
                </a>
                <ul class="nav-second-level mm-collapse {{ (strpos($page, 'bayar') !== false) ? 'mm-show' : '' }}" aria-expanded="false">
                    <li class="nav-item {{ (strpos($page, 'kantor') !== false) ? 'item-active' : '' }}">
                        <a class="nav-link" href="{{ route('angsuran.kantor') }}">
                            <i class="ti-control-record"></i>Kantor
                        </a>
                    </li>
                    <li class="nav-item {{ (strpos($page, 'koperasi') !== false) ? 'item-active' : '' }}">
                        <a class="nav-link" href="{{ route('angsuran.koperasi') }}">
                            <i class="ti-control-record"></i>Koperasi
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" aria-expanded="false">
                    <i data-feather="archive" class="align-self-center menu-icon"></i>
                    <span>Gaji Mingguan</span>
                    <span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i>
                    </span>
                </a>
                <ul class="nav-second-level mm-collapse" aria-expanded="false">
                    <li class="nav-item {{ (stripos($page, 'gaji/harian') !== false) ? 'item-active' : '' }}">
                        <a class="nav-link" href="{{ route('harian') }}">
                            <i class="ti-control-record"></i>Hitung
                        </a>
                    </li>
                    <li class="nav-item {{ (stripos($page, 'history/harian') !== false) ? 'item-active' : '' }}">
                        <a class="nav-link" href="{{ route('history-harian') }}">
                            <i class="ti-control-record"></i>History
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" aria-expanded="false">
                    <i data-feather="archive" class="align-self-center menu-icon"></i>
                    <span>Gaji Bulanan</span>
                    <span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i>
                    </span>
                </a>
                <ul class="nav-second-level mm-collapse" aria-expanded="false">
                    <li class="nav-item {{ (stripos($page, 'gaji/bulanan') !== false) ? 'item-active' : '' }}">
                        <a class="nav-link" href="{{ route('bulanan') }}">
                            <i class="ti-control-record"></i>Hitung
                        </a>
                    </li>
                    <li class="nav-item {{ (stripos($page, 'history/bulanan') !== false) ? 'item-active' : '' }}">
                        <a class="nav-link" href="{{ route('history-bulanan') }}">
                            <i class="ti-control-record"></i>History
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" aria-expanded="false">
                    <i data-feather="database" class="align-self-center menu-icon"></i>
                    <span>Master Data</span>
                    <span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i>
                    </span>
                </a>
                <ul class="nav-second-level mm-collapse" aria-expanded="false">
                    <li class="nav-item {{ (strpos($page, 'jabatan') !== false) ? 'item-active' : '' }}">
                        <a class="nav-link" href="{{ route('jabatan') }}">
                            <i class="ti-control-record"></i>Jabatan
                        </a>
                    </li>
                    <li class="nav-item {{ (strpos($page, 'bpjs') !== false) ? 'item-active' : '' }}">
                        <a class="nav-link" href="{{ route('bpjs') }}">
                            <i class="ti-control-record"></i>BPJS
                        </a>
                    </li>
                    <li class="nav-item {{ (strpos($page, 'history') !== false) ? 'item-active' : '' }}">
                        <a class="nav-link" href="{{ route('history') }}">
                            <i class="ti-control-record"></i>User Activity
                        </a>
                    </li>
                    <li class="nav-item {{ (strpos($page, 'jam-lembur') !== false) ? 'item-active' : '' }}">
                        <a class="nav-link" href="{{ route('jam-lembur') }}">
                            <i class="ti-control-record"></i>Jam Lembur
                        </a>
                    </li>
                </ul>
            </li>        
      </ul>
  </div>
</div>
    