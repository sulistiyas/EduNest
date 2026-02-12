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
        <li class="{{ Request::routeIs('class.*') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#" class="{{ Request::routeIs('class.*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-chalkboard"></i>
              <p>
                Class Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('class.index') }}" class="{{ Request::routeIs('class.index') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Classes</p>
                </a>
              </li>
            </ul>
        </li>