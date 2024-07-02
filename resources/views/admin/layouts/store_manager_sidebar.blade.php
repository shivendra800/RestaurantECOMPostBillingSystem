<li class="nav-item">
    <a href="{{ url('/') }}/admin/store-manager-dashboard" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
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
        {{-- <li class="nav-item">
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
</li> --}}
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
{{-- <li class="nav-item">
        <a href="{{url('/')}}/admin/tax" class="nav-link">
<i class="far fa-circle nav-icon"></i>
<p>Tax List</p>
</a>
</li> --}}
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

<!--<li class="nav-item">-->
<!--    <a href="#" class="nav-link">-->
<!--        <i class="nav-icon fa fa-warehouse"></i>-->
<!--        <p>-->
<!--            MakeProductPurchase Note-->
<!--            <i class="right fas fa-angle-left"></i>-->
<!--        </p>-->
<!--    </a>-->
<!--    <ul class="nav nav-treeview">-->

<!--        <li class="nav-item">-->
<!--            <a href="{{url('admin/Dummypurchase-inv-product')}}" class="nav-link">-->
<!--                <i class="far fa-circle nav-icon"></i>-->
<!--                <p>ProductPurchaseNoteList</p>-->
<!--            </a>-->
<!--        </li>-->
<!--        <li class="nav-item">-->
<!--          <a href="{{url('admin/add-edit-DummyPurchaseInvProdIndex')}}" class="nav-link">-->
<!--              <i class="far fa-circle nav-icon"></i>-->
<!--              <p>CreateProductPurchaseNote</p>-->
<!--          </a>-->
<!--      </li>-->
<!--    </ul>-->
<!--</li>-->

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

        <li class="nav-item">
            <a href="{{url('admin/purchase-inv-product')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Purchase Inv Prod</p>
            </a>
        </li>
        

        <li class="nav-item">
            <a href="{{url('/')}}/admin/inventory-stock" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Inventory Stock Lists</p>
            </a>
        </li>
        
           <li class="nav-item">
                <a href="{{url('/')}}/admin/get-Invpurchase-product-List" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inv Purchase Item List</p>
                </a>
              </li>
    </ul>
</li>

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-warehouse"></i>
        <p>
            Update SpoilExpire
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="{{url('admin/update-stock-for-spoil-expire')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Update Spoil-Expire</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/')}}/admin/updateStockforspoilexpireLog" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>StockSpoilExpireLog </p>
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
            <a href="{{url('/')}}/admin/Store-To-Kitchen" class="nav-link">
                <i class="nav-icon fa fa-toolbox"></i>
                <p>Stock Transfer <br>(StoreToKitchen)</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/')}}/admin/ReviceStockTransferFromKitchen" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Receive Stock KitchenToStore </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/')}}/admin/transfer-KitchenToStoreStockLog" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>TransferKitchenToStoreStockLog</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/')}}/admin/Kitchen-Stock" class="nav-link">
                <i class="nav-icon fa fa-toolbox"></i>
                <p>Current Kitchen Stock </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/')}}/admin/Kitchen-Stock-Histroy" class="nav-link">
                <i class="nav-icon fa fa-toolbox"></i>
                <p>Kitchen Stock Histroy</p>
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
            <a href="{{url('/')}}/admin/Store-To-Bar" class="nav-link">
                <i class="nav-icon fa fa-toolbox"></i>
                <p>Stock Transfer <br>(StoreToBar)</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/')}}/admin/ReviceStockTransferFromBar" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Receive Stock BarToStore </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/')}}/admin/transfer-BarToStoreStockLog" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>TransferBarToStoreStockLog</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/')}}/admin/BarCurrent-Stock" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Current Bar Stock </p>
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