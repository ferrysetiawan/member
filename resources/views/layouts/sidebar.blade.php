<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">CRM</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">CRM</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="{{ request()->is('data-customer*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fire"></i> <span>Data Customer</span></a>
        </li>
        {{-- <li class="menu-header">Master Data</li>
        <li class="{{ request()->is('dashboard/kriteria*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kriteria.index') }}"><i class="fas fa-list"></i> <span>Kriteria</span></a>
        </li>
        <li class="{{ request()->is('dashboard/alternatif*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('alternatif.index') }}"><i class="fas fa-box"></i> <span>Alternatif</span></a>
        </li>
        <li class="{{ request()->is('dashboard/nilai*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('nilai.index') }}"><i class="fas fa-edit"></i> <span>Penilaian</span></a>
        </li>
        <li class="menu-header">Perhitungan SAW</li>
        <li class="{{ request()->is('dashboard/hasil-perhitungan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('hasil-evaluasi') }}"><i class="fas fa-file"></i> <span>Proses Perhitungan</span></a>
        </li>
        <li class="menu-header">Pengaturan</li>
        <li class="">
            <a class="nav-link" href="blank.html"><i class="fas fa-user"></i> <span>User</span></a>
        </li> --}}

    </ul>
</aside>
