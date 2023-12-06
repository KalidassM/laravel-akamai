<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fa fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>
@can('user-list')
<li class="nav-item">
    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users.index') ? 'active' : '' }}">
        <i class="nav-icon fa fa-users"></i>
        <p>Manage Users</p>
    </a>
</li>
@endcan
@can('role-list')
<li class="nav-item">
    <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles.index') ? 'active' : '' }}">
        <i class="nav-icon fa fa-lock"></i>
        <p>Manage Role</p>
    </a>
</li>
@endcan
@can('whitelist-list')
<li class="nav-item">
    <a href="{{ route('whitelist.index') }}" class="nav-link {{ Request::is('whitelist.index') ? 'active' : '' }}">
        <i class="nav-icon fa fa-server"></i>
        <p>Manage IP's List</p>
    </a>
</li>
@endcan