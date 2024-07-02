<li class="nav-item">
    <a href="{{ url('/') }}/admin/Waiter-Dashboard" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
        Dashboard  
      </p>
    </a>
  </li>

      <li class="nav-item">
        <a href="{{ url('admin/select-table') }}" class="nav-link">
          <i class="nav-icon fa fa-toolbox"></i>
          <p>Take Customer Order </p>
        </a>
      </li>    
      <li class="nav-item">
        <a href="{{ url('admin/today-orders') }}" class="nav-link">
          <i class="nav-icon fa fa-toolbox"></i>
          <p>Today Pending Taken Order </p>
        </a>
      </li>     
      <li class="nav-item">
        <a href="{{ url('admin/today-complete-orders') }}" class="nav-link">
          <i class="nav-icon fa fa-toolbox"></i>
          <p>Today Complete Taken Order </p>
        </a>
      </li>  
 