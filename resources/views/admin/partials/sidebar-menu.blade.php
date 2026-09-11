{{-- resources/views/admin/partials/sidebar-menu.blade.php --}}
<li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
<li><a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}"><i class="bi bi-people"></i> Data Siswa</a></li>
<li><a href="{{ route('admin.gejala.index') }}" class="nav-link {{ request()->routeIs('admin.gejala.*') ? 'active' : '' }}">
<i class="bi bi-clipboard2-pulse"></i> Data Gejala</a></li>
<li><a href="{{ route('admin.rules.index') }}" class="nav-link {{ request()->routeIs('admin.rules.*') ? 'active' : '' }}"><i class="bi bi-diagram-3"></i> Data Aturan</a></li>
<li><a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
<i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>