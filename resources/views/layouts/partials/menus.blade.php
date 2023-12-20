<ul class="sidebar-nav">
    @role(['developer'])
        <li class="sidebar-header">
            Developer
        </li>
        <li class="sidebar-item{{ request()->is('fitur-aplikasi*') ? ' active' : '' }}">
            <a class="sidebar-link" href="{{ route('fitur-aplikasi.index') }}">
                <i class="align-middle" data-feather="package"></i> <span class="align-middle">Fitur Aplikasi</span>
            </a>
        </li>
    @endrole
    @can('dashboard')
        <li class="sidebar-item{{ request()->is('dashboard*') ? ' active' : '' }}">
            <a class="sidebar-link" href="{{ route('dashboard.index') }}">
                <i class="align-middle" data-feather="slack"></i> <span class="align-middle">Dashboard</span>
            </a>
        </li>
    @endcan
    @can('pengguna')
        <li class="sidebar-header">
            Pengguna
        </li>
        @can('peran pengguna')
            <li class="sidebar-item{{ request()->is('peran-pengguna*') ? ' active' : '' }}">
                <a class="sidebar-link" href="{{ route('peran-pengguna.index') }}">
                    <i class="align-middle" data-feather="user-check"></i> <span class="align-middle">Peran Pengguna</span>
                </a>
            </li>
        @endcan
        <li class="sidebar-item{{ request()->is('pengguna*') ? ' active' : '' }}">
            <a class="sidebar-link" href="{{ route('pengguna.index') }}">
                <i class="align-middle" data-feather="users"></i> <span class="align-middle">Pengguna</span>
            </a>
        </li>
    @endcan
    @canany(['merek', 'mobil'])
        <li class="sidebar-header">
            Master Data
        </li>
        @can('merek')
            <li class="sidebar-item{{ request()->is('merek*') ? ' active' : '' }}">
                <a class="sidebar-link" href="{{ route('merek.index') }}">
                    <i class="align-middle" data-feather="star"></i> <span class="align-middle">Merek</span>
                </a>
            </li>
        @endcan
        @can('mobil')
            <li class="sidebar-item{{ request()->is('mobil*') ? ' active' : '' }}">
                <a class="sidebar-link" href="{{ route('mobil.index') }}">
                    <i class="align-middle" data-feather="truck"></i> <span class="align-middle">Mobil</span>
                </a>
            </li>
        @endcan

    @endcanany
    @canany(['peminjaman', 'pengembalian'])
        <li class="sidebar-header">
            Transaksi
        </li>
        @can('peminjaman')
            <li class="sidebar-item{{ request()->is('peminjaman*') ? ' active' : '' }}">
                <a class="sidebar-link" href="{{ route('peminjaman.index') }}">
                    <i class="align-middle" data-feather="truck"></i> <span class="align-middle">Peminjaman</span>
                </a>
            </li>
        @endcan
        @can('pengembalian')
            <li class="sidebar-item{{ request()->is('pengembalian*') ? ' active' : '' }}">
                <a class="sidebar-link" href="{{ route('pengembalian.index') }}">
                    <i class="align-middle" data-feather="truck"></i> <span class="align-middle">Pengembalian</span>
                </a>
            </li>
        @endcan
    @endcanany
</ul>
