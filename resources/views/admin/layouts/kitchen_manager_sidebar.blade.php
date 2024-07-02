<li class="nav-item">
    <a href="{{ url('/') }}/admin/Kitchen-Manager-dashboard" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
        Dashboard  
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ url('/') }}/admin/menu-item-list" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
         Menu Item List  
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fa fa-warehouse"></i>
      <p>
         Order List
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
    
      <li class="nav-item">
        <a href="{{url('/')}}/admin/table-orderList" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Table Order </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{url('/')}}/admin/takeway-orderList" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>TakeWay/Zomato Order </p>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fa fa-warehouse"></i>
      <p>
        Kitchen Stock Management
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
    
      <li class="nav-item">
        <a href="{{url('/')}}/admin/Kitchen-Receive-Stock" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Receive Stock </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{url('/')}}/admin/Kitchen-Stock" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Current Kitchen  Stock </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{url('/')}}/admin/Kitchen-Stock-Histroy" class="nav-link">
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
        TransferStock To StoreRoom
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
    
      <li class="nav-item">
        <a href="{{url('/')}}/admin/transfer-KitchenToStoreStock" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Transfer Stock  </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{url('/')}}/admin/transfer-KitchenToStoreStockLog" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>stock Transfer Log </p>
        </a>
      </li>
  
    </ul>
  </li>
  
  <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fa fa-warehouse"></i>
      <p>
         Use Stock Management
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
    
      {{-- <li class="nav-item">
        <a href="{{url('/')}}/admin/Kitchen-UseStock" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Update Kitchen Use Stock </p>
        </a>
      </li> --}}
      <li class="nav-item">
        <a href="{{url('/')}}/admin/Kitchen-UseStock-Log" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Use Stock Log </p>
        </a>
      </li>
  
    </ul>
  </li>

  <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fa fa-warehouse"></i>
      <p>
        Wastage Stock Management
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
    
      <li class="nav-item">
        <a href="{{url('/')}}/admin/Kitchen-Waste" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Kitchen Waste Update </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{url('/')}}/admin/Kitchen-Waste-Log" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Kitchen Waste Log </p>
        </a>
      </li>
  
    </ul>
  </li>