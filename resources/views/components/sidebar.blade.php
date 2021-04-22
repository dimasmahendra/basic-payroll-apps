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
            <li class="menu-label my-2">Dashboard</li>
            <li class="nav-item {{ (strpos($page, 'dashboard') !== false) ? 'item-active' : '' }}">
                <a href="{{ route('dashboard') }}"><i data-feather="home" class="align-self-center menu-icon"></i><span>Dashboard</span></a>
            </li>

            <hr class="hr-dashed hr-menu" />
            <li class="menu-label my-2">Data Karyawan</li>
            <li class="nav-item {{ (strpos($page, 'karyawan') !== false) ? 'item-active' : '' }}">
                <a href="{{ route('karyawan') }}"><i data-feather="list" class="align-self-center menu-icon"></i><span>Daftar</span></a>
            </li>

            <hr class="hr-dashed hr-menu" />
            <li class="menu-label my-2">Absensi</li>
            <li class="nav-item {{ (strpos($page, 'absensi') !== false) ? 'item-active' : '' }}">
                <a href="{{ route('absensi') }}"><i data-feather="list" class="align-self-center menu-icon"></i><span>Daftar</span></a>
            </li>

            <hr class="hr-dashed hr-menu" />
            <li class="menu-label my-2">Angsuran</li>
            <li class="nav-item {{ (strpos($page, 'kantor') !== false) ? 'item-active' : '' }}">
                <a href="{{ route('angsuran.kantor') }}"><i data-feather="list" class="align-self-center menu-icon"></i><span>Kantor</span></a>
            </li>
            <li class="nav-item {{ (strpos($page, 'koperasi') !== false) ? 'item-active' : '' }}">
                <a href="{{ route('angsuran.koperasi') }}"><i data-feather="list" class="align-self-center menu-icon"></i><span>Koperasi</span></a>
            </li>
            
      </ul>
  </div>
</div>
    