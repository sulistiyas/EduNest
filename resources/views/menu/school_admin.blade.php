        <li class="{{ Request::routeIs('roles.*') || Request::routeIs('users.*') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#" class="{{ Request::routeIs('roles.*') || Request::routeIs('users.*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                Users Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('school_users.index') }}" class="{{ Request::routeIs('school_users.index') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
            </ul>
        </li>