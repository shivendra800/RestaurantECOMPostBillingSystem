<li class="nav-item">
    <a href="{{ url('/') }}/admin/BarChasier-dashboard" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
        Dashboard  
      </p>
    </a>
  </li>


  <li class="nav-item">
    <a href="{{ url('/') }}/admin/bar-menu-item-list" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
        Bar Menu Item List  
      </p>
    </a>
  </li>


      <li class="nav-item">
        <a href="{{ url('admin/restaurant-barorder') }}" class="nav-link">
          <i class="nav-icon fa fa-toolbox"></i>
          <p>Restaurant Bar Order </p>
        </a>
      </li> 
      <li class="nav-item">
        <a href="{{ url('admin/take-tableWiseOrder') }}" class="nav-link">
          <i class="nav-icon fa fa-toolbox"></i>
          <p>Take Table Wise Order </p>
        </a>
      </li>  
      <li class="nav-item">
        <a href="{{ url('admin/take-chairWiseOrder') }}" class="nav-link">
          <i class="nav-icon fa fa-toolbox"></i>
          <p>Take Chair Wise  Order </p>
        </a>
      </li>   

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-warehouse"></i>
          <p>
              Transfer BarToStore
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
       
          <li class="nav-item">
            <a href="{{url('/')}}/admin/transfer-BarToStoreStock" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Update BarToStoreStock</p>
            </a>
          </li>

           <li class="nav-item">
            <a href="{{url('/')}}/admin/transfer-BarToStoreStockLog" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>TransferBarToStoreStockLog</p>
            </a>
          </li>

        </ul>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-warehouse"></i>
          <p>
            Bar Stock Management
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
        
          <li class="nav-item">
            <a href="{{url('/')}}/admin/bar-recive-stock" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Receive Stock </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/')}}/admin/BarCurrent-Stock" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Current Kitchen  Stock </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/')}}/admin/BarRecive-Stock-Histroy" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Stock Histroy</p>
            </a>
          </li>
        </ul>
      </li>


      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-warehouse"></i>
          <p>
              Stock Management
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
       
          <li class="nav-item">
            <a href="{{url('/')}}/admin/Bar-UseStock-Log" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Use Stock Log </p>
            </a>
          </li>

        </ul>
      </li>
      