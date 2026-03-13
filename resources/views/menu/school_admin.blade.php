        <li class="{{ Request::routeIs('school_users.*') || Request::routeIs('users.*') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#" class="{{ Request::routeIs('school_users.*') || Request::routeIs('users.*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                Users Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('school_users.index_admin') }}" class="{{ Request::routeIs('school_users.index_admin') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('school_users.index_teacher') }}" class="{{ Request::routeIs('school_users.index_teacher') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Teacher</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('school_users.index_student') }}" class="{{ Request::routeIs('school_users.index_student') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student</p>
                </a>
              </li>
            </ul>
        </li>
        <li class="{{ Request::routeIs('class.*') || Request::routeIs('subject.*') || Request::routeIs('enrollment.*') || Request::routeIs('subject_teachers.*') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#" class="{{ Request::routeIs('class.*') || Request::routeIs('subject.*') || Request::routeIs('enrollment.*') || Request::routeIs('subject_teachers.*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-chalkboard"></i>
              <p>
                Academic Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="{{ Request::routeIs('class.*') || Request::routeIs('subject.*') ? 'nav-item menu-open' : 'nav-item menu' }}">
                <a href="#" class="{{ Request::routeIs('class.*') || Request::routeIs('subject.*') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Classes & Subjects
                      <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('class.index') }}" class="{{ Request::routeIs('class.index') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Classes</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('subject.index') }}" class="{{ Request::routeIs('subject.index') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Subjects</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="{{ Request::routeIs('enrollment.*') || Request::routeIs('subject_teachers.*') ? 'nav-item menu-open' : 'nav-item menu' }}">
                <a href="#" class="{{ Request::routeIs('enrollment.*') || Request::routeIs('subject_teachers.*') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Enrollments
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('subject_teachers.assignTeachersForm') }}" class="{{ Request::routeIs('subject_teachers.assignTeachersForm') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Assign Teachers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('enrollment.index') }}" class="{{ Request::routeIs('enrollment.index') ? 'nav-link active' : 'nav-link' }}">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Enroll Student</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
        </li>
        <li class="{{ Request::routeIs('schedule.*') ? 'nav-item menu-open' : 'nav-item menu'}}">
            <a href="#" class="{{ Request::routeIs('schedule.*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Schedule Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('schedule.index') }}" class="{{ Request::routeIs('schedule.index') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Class Schedule</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Teacher Schedule</p>
                </a>
              </li>
            </ul>
        </li>
        <li class="{{ Request::routeIs('academic_year.*') || Request::routeIs('semester.*') ? 'nav-item menu-open' : 'nav-item menu' }}">
            <a href="#" class="{{ Request::routeIs('academic_year.*') || Request::routeIs('semester.*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Academic Setup
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('academic_year.index') }}" class="{{ Request::routeIs('academic_year.index') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Academic Year</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('semester.index') }}" class="{{ Request::routeIs('semester.index') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Semester</p>
                </a>
              </li>
            </ul>
        </li>
        <li class="nav-item menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Reports
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Attendance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Grades</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Students</p>
                </a>
              </li>
            </ul>
        </li>
        