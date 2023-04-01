<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{ url('/dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      {{-- End Dashboard Nav --}}

      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#serviceuser-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Service Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="serviceuser-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ url('/serviceUser/addnew')}}">
              <i class="bi bi-circle"></i><span>Add New Service User</span>
            </a>
          </li>
          <li>
            <a href="{{ url('/serviceUser/update')}}">
              <i class="bi bi-circle"></i><span>Update Service User</span>
            </a>
          </li>
          <li>
            <a href="{{ url('/serviceUser/show_surveyfeedback')}}">
              <i class="bi bi-circle"></i><span>Service User Survey</span>
            </a>
          </li>
        </ul>
      </li>
      {{-- End Service user Nav --}}

      {{-- BuildForms --}}
      <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-journal-text"></i><span>Build Forms</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                  <a href="{{ url('/buildforms/serviceUserFeedback')}}">
                    <i class="bi bi-circle"></i><span>Service user feedback</span>
                  </a>
              </li>
              <li>
                  <a href="{{ url('/buildforms/employeeFeedback')}}">
                    <i class="bi bi-circle"></i><span>Employee Feedback</span>
                  </a>
              </li>
          </ul>
      </li>
      {{-- End Forms Nav --}}

      {{--  Company Profile --}}
      <li class="nav-item">
        <a class="nav-link " href="{{ url('companyprofile')}}">
          <i class="bi bi-person"></i>
          <span>Company Profile</span>
        </a>
      {{--  End company Profile --}}

    </ul>

  </aside>