
<aside class="main-sidebar elevation-4 sidebar-light-primary">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{url('/')}}/admin_assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{Auth::guard('admin')->user()->type}}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar os-host os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition os-theme-dark"><div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div><div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 320px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;"><div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{url('/')}}/admin_assets/dist/img/dummy-user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{Auth::guard('admin')->user()->type}}</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div><div class="sidebar-search-results"><div class="list-group"><a href="#" class="list-group-item"><div class="search-title"><strong class="text-light"></strong>N<strong class="text-light"></strong>o<strong class="text-light"></strong> <strong class="text-light"></strong>e<strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light"></strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong> <strong class="text-light"></strong>f<strong class="text-light"></strong>o<strong class="text-light"></strong>u<strong class="text-light"></strong>n<strong class="text-light"></strong>d<strong class="text-light"></strong>!<strong class="text-light"></strong></div><div class="search-path"></div></a></div></div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
       @if(Auth::guard('admin')->user()->type=="Admin")
        <li class="nav-item">
          <a href="{{ url('admin/dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Home  
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
            <i class="nav-icon far fa-plus-square"></i>
            <p>
              Dashboard
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Payment Details
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/cashpaymentdetails') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cash</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('admin/onlinepaymentdetails') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Onilne </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('admin/totalpaymentdetails') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Overall Collection </p>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item">
              <a href="{{ url('admin/tax-collection-report') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tax Collection Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/takeaway-dashboard') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>TakeAway Order</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/table-dashboard') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Table Order</p>
              </a>
            </li>

            {{-- <li class="nav-item">
              <a href="{{ url('admin/Menu-Item-Order') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu Item Order</p>
              </a>
            </li> --}}
            <li class="nav-item">
              <a href="{{ url('admin/purchaseInv-graph') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Purchase Inventory</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/kitchen-graph') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kitchen Details</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/table-booking-graph') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Table Booking</p>
              </a>
            </li>
           <li class="nav-item">
              <a href="{{ url('admin/free-item') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Free Item Given</p>
              </a>
            </li>
            <!--<li class="nav-item">-->
            <!--  <a href="{{ url('admin/discount-order-graph') }}" class="nav-link">-->
            <!--    <i class="far fa-circle nav-icon"></i>-->
            <!--    <p>Discount On Bill </p>-->
            <!--  </a>-->
            <!--</li> -->

            <li class="nav-item">
              <a href="{{ url('admin/defect-menu-item') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Defect Menu Item</p>
              </a>
            </li> 
            <li class="nav-item">
              <a href="{{ url('admin/selling-menu-item') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu Item Selling Report</p>
              </a>
            </li>
             <li class="nav-item">
              <a href="{{ url('admin/nc-report') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>NC Report</p>
              </a>
            </li>
             <li class="nav-item">
              <a href="{{ url('admin/NumbersBill-report') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Generated Bill-report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/UsedCoupon-report') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>UsedCoupon-Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/FoodSell-report') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Food Sell Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/BarSell-report') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bar Sell Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/discount-order-graph') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Discount Sell Report </p>
              </a>
            </li>
            
             <li class="nav-item">
              <a href="{{ url('admin/topselling-menu-report') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>TopSellingMenuItem</p>
              </a>
            </li>
           
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-cog"></i>
            <p>
              Configuration
              <i class="fas fa-angle-left right"></i>
             
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('admin/staffs') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Staffs</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/table') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Table</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/bartable') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>BarTable</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('/')}}/admin/unit" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Unit List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('admin/category-type')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Product Type</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('/')}}/admin/ingredient" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Product List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('/')}}/admin/tax" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tax List</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-cog"></i>
            <p>
             Coupon Configuration
              <i class="fas fa-angle-left right"></i>
             
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('/')}}/admin/Coupon-List" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Product Wise Coupon</p>
              </a>
            </li>
            <!--<li class="nav-item">-->
            <!--  <a href="{{url('/')}}/admin/Coupon-On-price" class="nav-link">-->
            <!--    <i class="far fa-circle nav-icon"></i>-->
            <!--    <p>Coupon On Price</p>-->
            <!--  </a>-->
            <!--</li>-->
           
           
          </ul>
        </li>
        <li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-warehouse"></i>
        <p>
            External Expenses
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="{{url('admin/expense-vendor')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>External Vendor List</p>
            </a>
        </li>
        <li class="nav-item">
          <a href="{{url('admin/expense-TypeProduct')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Expense Type/Product</p>
          </a>
        </li>
        <li class="nav-item">
            <a href="{{url('admin/capital-purchaseInvList')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Capital Purchase List</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/capital-CurentStockList')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Capital CurentStock List</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/capital-UseStock')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Capital UseStock</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/capital-UseStockLog')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Capital UseStock History</p>
            </a>
          </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-warehouse"></i>
        <p>
            MakeProductPurchase Note
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="{{url('admin/Dummypurchase-inv-product')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ProductPurchaseNoteList</p>
            </a>
        </li>
        <li class="nav-item">
          <a href="{{url('admin/add-edit-DummyPurchaseInvProdIndex')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>CreateProductPurchaseNote</p>
          </a>
      </li>
    </ul>
</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-warehouse"></i>
            <p>
              Inventory Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('admin/vendor-type')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vendor Type</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('admin/vendor')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vendor</p>
              </a>
            </li>
           
            {{-- <li class="nav-item">
              <a href="{{url('admin/category')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Category</p>
              </a>
            </li> --}}
            <li class="nav-item">
              <a href="{{url('/')}}/admin/inventory-stock" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inventory Stock Lists</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('admin/purchase-inv-product')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Purchase Inv Prod</p>
              </a>
            </li>
               <li class="nav-item">
                <a href="{{url('/')}}/admin/get-Invpurchase-product-List" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inv Purchase Item List</p>
                </a>
              </li>
            <li class="nav-item">
              <a href="{{url('/')}}/admin/Kitchen-Stock" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kitchen  Stock </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('/')}}/admin/Kitchen-Stock-Histroy" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kitchen Stock Histroy</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('/')}}/admin/Kitchen-Waste-Log" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kitchen Waste Log </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('/')}}/admin/Kitchen-UseStock-Log" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kitchen Use Stock Log </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-toolbox"></i>
            <p>
               Menu Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('admin/extra-menu') }}" class="nav-link">
                <i class="fa fa-bars"></i>
                <p>Extra Manu Item</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa fa-bars"></i>
                <p>
                  Restaurant Menu
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                </li>
                <li class="nav-item">
                  <a href="{{ url('admin/menu-subcategory') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Restaurant Category</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('admin/menu-item-price') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Restaurant Item </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('admin/menu-price-modify') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Restaurant Price Modify</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa fa-bars"></i>
                <p>
                  Bar Menu
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/bar-menu-subcategory') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Bar Category</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('admin/bar-menu-item-price') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Bar Item </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('admin/bar-menu-price-modify') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Bar Price Modify</p>
                  </a>
                </li>
              
              </ul>
            </li>
         
          </ul>
        </li>
        {{-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-toolbox"></i>
            <p>
              Menu Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
              <a href="{{ url('admin/menu-category') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu Category Item</p>
              </a>
            </li> 
            <li class="nav-item">
              <a href="{{ url('admin/menu-subcategory') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/menu-item-price') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu Item Price</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/menu-price-modify') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Menu Price Modify</p>
              </a>
            </li>
           
          </ul>
        </li> --}}
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

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-toolbox"></i>
            <p>
              Today Order Report
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('admin/today-orders') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Today Table Order </p>
              </a>
            </li> 
            <li class="nav-item">
              <a href="{{ url('admin/today-takeway-orders') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Today TakeWay Order </p>
              </a>
            </li> 
           
            
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-toolbox"></i>
            <p>
             Overall Order Report 
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('admin/table-orders') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Table Order</p>
              </a>
            </li>  
            <li class="nav-item">
              <a href="{{ url('/') }}/admin/today-Take-away-order" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                   TakeAway  Order 
                </p>
              </a>
            </li> 
            <li class="nav-item">
              <a href="{{ url('admin/overallOnline-orders') }}" class="nav-link">
                <i class="nav-icon fa fa-toolbox"></i>
                <p>Online Order</p>
              </a>
            </li>       
          </ul>
        </li>
        {{-- <li class="nav-item">
          <a href="{{ url('admin/site-settings') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Site-Setting  
            </p>
          </a>
        </li> --}}
        {{-- <li class="nav-item">
          <a href="{{ url('admin/tax-collection-report') }}" class="nav-link">
            <i class="nav-icon fa fa-calculator"></i>
            <p>
              Tax Collection Report  
            </p>
          </a>
        </li> --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-toolbox"></i>
            <p>
              Coupon Report 
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('admin/Total-Loss') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Total Loss</p>
              </a>
            </li>  
            <li class="nav-item">
              <a href="{{ url('/') }}/admin/Total-DiscountPercentage-CouponLoss" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                   Total Coupon % 
                </p>
              </a>
            </li>    
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-toolbox"></i>
            <p>
              Website-Setting  
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('admin/site-settings') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  All Site-Setting  
                </p>
              </a>
            </li>  
            <li class="nav-item">
              <a href="{{ url('/') }}/admin/slider" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                   Slider
                </p>
              </a>
            </li>    
          </ul>
        </li>
        
     

        @endif

        @if(Auth::guard('admin')->user()->type=="Waiter")
              @include('admin.layouts.waiter_sidebar')
        @endif

        @if(Auth::guard('admin')->user()->type=="Kitchen-Manager")
               @include('admin.layouts.kitchen_manager_sidebar')
        @endif

        @if(Auth::guard('admin')->user()->type=="store-manager")
           @include('admin.layouts.store_manager_sidebar')
       @endif

       @if(Auth::guard('admin')->user()->type=="Cashier")
          @include('admin.layouts.cashier_sidebar')
       @endif
       @if(Auth::guard('admin')->user()->type=="DeliveryBoy")
       @include('admin.layouts.deliveryboy_sidebar')
    @endif

    @if(Auth::guard('admin')->user()->type=="BarChasier")
    @include('admin.layouts.barchasier_sidebar')
 @endif
   @if(Auth::guard('admin')->user()->type=="Vendor")
      @include('admin.layouts.vendor_sidebar')
      @endif
      
      </ul>  
    </nav>
   
 
    <!-- /.sidebar-menu -->
  </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 23.6203%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar-corner"></div></div>
  <!-- /.sidebar -->

</aside>

 