        <li class="nav-item">
            <a href="{{ route('teacher.dash') }}" class="{{ Request::routeIs('teacher.dash') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
        </li>
        <li class="{{ Request::routeIs('teacher.classes.*') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#" class="{{ Request::routeIs('teacher.classes.*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-chalkboard"></i>  
              <p>
                Class Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('teacher.classes.index') }}" class="{{ Request::routeIs('teacher.classes.index') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>My Classes</p>
                </a>
              </li>
            </ul>
        </li>