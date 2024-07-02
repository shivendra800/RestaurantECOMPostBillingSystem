
<li class="nav-item">
    <a href="{{ url('/') }}/admin/Cashier-dashboard" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
        Dashboard  
      </p>
    </a>
</li>

 <li class="nav-item">
          <a href="{{ url('admin/overall-report') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Overall CollectionReport  
            </p>
          </a>
        </li>

<li class="nav-item">
  <a href="{{ url('/') }}/admin/genarate-token" class="nav-link">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Generate Token Bar
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fa fa-warehouse"></i>
    <p>
      Table Order
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ url('/') }}/admin/select-table" class="nav-link">
       <i class="far fa-circle nav-icon"></i>
        <p>
           Take Table Order  
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ url('/') }}/admin/today-table-order" class="nav-link">
       <i class="far fa-circle nav-icon"></i>
        <p>
           TodayTablePendingOrder  
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ url('/') }}/admin/today-table-Completeorder" class="nav-link">
       <i class="far fa-circle nav-icon"></i>
        <p>
           TodayTableCompleteOrder  
        </p>
      </a>
    </li>
  </ul>
</li>

<li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fa fa-warehouse"></i>
      <p>
        Zomato Order
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{ url('/') }}/admin/Take-zomato-order" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>
            Take Zomato Order
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ url('/') }}/admin/Today-Take-zomato-order" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>
            Today Zomato  Order
          </p>
        </a>
      </li>
    </ul>
  </li>

<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fa fa-warehouse"></i>
    <p>
      Bar Order
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ url('/') }}/admin/bar-tableOrderCheckout-list" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>
           BarTableOrder Checkout 
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ url('/') }}/admin/bar-tableWiseChairOrderCheckout-list" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>
           BarTableWiseChairOrder Checkout 
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ url('/') }}/admin/chirwisebill" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>
           BarChairCheckout Histroy
        </p>
      </a>
    </li>
  </ul>
</li>


<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fa fa-warehouse"></i>
    <p>
      TakeWay Order
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ url('/') }}/admin/Take-away-order" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>
          Take Away Order
        </p>
      </a>
    </li>
    
    <li class="nav-item">
      <a href="{{ url('/') }}/admin/today-Take-away-order" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>
          Today TakeAway  Order 
        </p>
      </a>
    </li>
  </ul>
</li>







<li class="nav-item">
  <a href="{{ url('/') }}/admin/online-order" class="nav-link">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Online Order List
    </p>
  </a>
</li>


<li class="nav-item">
  <a href="#" class="nav-link">
    <i class="nav-icon fa fa-toolbox"></i>
    <p>
        Table Reservation 
      <i class="fas fa-angle-left right"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ url('admin/table-booking-request') }}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Table Booking Request</p>
      </a>
    </li>  
    <li class="nav-item">
      <a href="{{ url('/') }}/admin/table-booking-confirm" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>
           Table Booking confirm
        </p>
      </a>
    </li>    
  </ul>
</li>