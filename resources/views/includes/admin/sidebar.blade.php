<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    @can('view_dashboard')
    <li class="nav-item">
      <a href="{{route('admin.dashboard')}}" class="nav-link {{ (Request::segment(2) == "dashboard") ? "active" : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Dashboard</p>
      </a>
    </li>
    @endcan


    @can('view_roles')
    <li class="nav-item">
      <a href="{{route('admin.roles.index')}}" class="nav-link {{ (Request::segment(2) == "roles") ? "active" : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Roles</p>
      </a>
    </li>
    @endcan


    @can('view_users')
    <li class="nav-item">
      <a href="{{route('admin.users.index')}}" class="nav-link {{ (Request::segment(2) == "users") ? "active" : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Users</p>
      </a>
    </li>
    @endcan

    @can('view_technology')
    <li class="nav-item">
      <a href="{{route('admin.technology.index')}}" class="nav-link {{ (Request::segment(2) == "technology") ? "active" : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Technology</p>
      </a>
    </li>
    @endcan


    @can('view_durations')
    <li class="nav-item">
      <a href="{{route('admin.durations.index')}}" class="nav-link {{ (Request::segment(2) == "durations") ? "active" : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Durations</p>
      </a>
    </li>
    @endcan

    @can('view_batches')
    <li class="nav-item">
      <a href="{{route('admin.batches.index')}}" class="nav-link {{ (Request::segment(2) == "batches") ? "active" : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Btaches</p>
      </a>
    </li>
    @endcan


    @can('view_students')
    <li class="nav-item">
      <a href="{{route('admin.students.index')}}" class="nav-link {{ (Request::segment(2) == "students") ? "active" : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Students</p>
      </a>
    </li>
    @endcan


    @can('view_certificate')
    <li class="nav-item">
      <a href="{{route('admin.certificates.index')}}" class="nav-link {{ (Request::segment(2) == "certificates") ? "active" : '' }}">
        <i class="far fa-circle nav-icon"></i>
        <p>Certificates</p>
      </a>
    </li>
    @endcan

    
  </ul>
</nav>