<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::namespace('App\Http\Controllers\Front')->group(function () {

    Route::controller(\HomeController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/about', 'About');
        Route::get('/privacy-policy', 'PrivacyPolicy');
        Route::get('/term-condition', 'Termcondition');
        Route::get('/service', 'Service');
        Route::get('/menu', 'Menu');
        Route::get('/table-booking', 'TableBooking');
        Route::get('/contact', 'Contact');
        Route::get('/menu-item/{id}','menuitem');
        Route::post('/store-table-booking', 'StoreTableBooking');
        Route::post('/tablebooking-proceed-to-pay', 'TableBookingPay');
            Route::get('Menu-List', 'MenuList');
        Route::get('restype', 'restype');
        Route::get('bartype', 'bartype');
    });

    Route::group(['middleware'=> ['auth']],function()
    {
        Route::controller(\CartController::class)->group(function(){
            Route::post('/add-to-cart', 'AddToCart');
            Route::post('/add-tocart/{id}', 'AddToCartWithId');

            Route::get('/view-cart', 'ViewCart');
                 // update Cart Item Quantity
           Route::post('cart/update','cartUpdate');
           // update Cart Item Quantity
           Route::post('cart/delete','deleteUpdate');
            Route::get('Delete-Cart-Item/{id}','DeleteCartItem');
            Route::match(['get','post'], '/checkout','Checkout');
            Route::match(['get','post'], '/get-delivery-address','getDeliveryAddress');
            Route::match(['get','post'],'save-delivery-address','SaveDeliveryAddress');
            Route::match(['get','post'],'remove-delivery-address','removeDeliveryAddress');
            Route::get('thanks','thanks');
            Route::get('my-order-list','MyOrderList');
            Route::get('my-order-details/{order_no}','MyOrderDetails');
            Route::get('cancle-MyOrder/{orderId}','CancleMyOrder');

        });
        Route::controller(\RazorpayController::class)->group(function(){
        Route::get('razorpay','index');
        Route::post('razorpay-payment','store')->name('razorpay.payment.store');
          });
    });


});

Route::prefix('/admin')->namespace('App\Http\Controllers\ExternalExpenses')->group(function()
{
    Route::group(['middleware'=> ['admin']],function()
    {
        Route::controller(\ExternalVendorController::class)->group(function(){

            Route::get('expense-vendor','ExternalVendor');
            Route::match(['get','post'],'add-edit-ExternalVendor/{id?}','AddEditExternalVendor');
            Route::Post('/Delete-ExternalVendor/{id}','ExternalVendorDelete');
            Route::post('/Change-ExternalVendorStatus','ExternalVendorStatusChange');
            Route::match(['get','post'],'assign-Extvendor-ExtProduc/{id}','AssignExternalVendorExtBuyProduct');
            Route::Post('/Delete-AssignExtProduct/{id}','DeleteAssignExtProduct');
            Route::get('Capitalpurchase-histroy/{id}','CapitalPurchaseHistroy');
            Route::match(['get','post'],'update-CapitalExternalvendor-payment/{id}','UpdateCapitalExternalVendorPayment');
            Route::match(['get','post'],'exchange-ExternalpurchasePrdouct/{id}','ExChangeExternalPurchaseProductList');
        });
        Route::controller(\ExternalProductController::class)->group(function(){

            Route::get('expense-TypeProduct','ExternalProduct');
            Route::match(['get','post'],'add-edit-ExternalProduct/{id?}','AddEditExternalProduct');
            Route::Post('/Delete-ExternalProduct/{id}','ExternalProductDelete');
            Route::post('/Change-ExternalProductStatus','ExternalProductStatusChange');
            Route::get('capital-CurentStockList','CapitalCurentStockList');
            Route::match(['get','post'],'capital-UseStock','CapitalUseStock');
            Route::get('capital-UseStockLog','CapitalUseStockLog');
        });

        Route::controller(\CapitalPurchaseInvController::class)->group(function(){

            Route::get('capital-purchaseInvList','CapitalPurchaseInvProdIndex');
            Route::get('View-CapitalPurchase/{id}','CapitalViewPurchaseDetails');
            Route::match(['get','post'],'add-edit-CapitalPurchaseInvProdIndexearch','CapitalPurchaseInvProdIndexearch');
            Route::match(['get','post'],'add-edit-CapitalPurchaseInvProdIndex/{id?}','AddEditCapitalPurchaseInvProdIndex');
            Route::post('/Delete-CapitalPurchaseInvProdIndex/{id}','CapitalPurchaseInvProdIndexDelete');

        });




    });
});

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function()
{

    Route::match(['get','post'],'/','AdminLoginController@login');
    Route::match(['get','post'],'/forget-password', 'AdminLoginController@forgetPassword');
    Route::group(['middleware'=> ['admin']],function()
    {

        Route::get('/logout','AdminLoginController@logout');

        Route::match(['get','post'],'/change-password','AdminLoginController@ChangePassword');
        Route::match(['get','post'],'check-current-password','AdminLoginController@CheckAdminPassword');

        Route::controller(\DashboardController::class)->group(function(){

            Route::get('/dashboard','dashboard');
             Route::get('/overall-report','overallreportCollection');
             Route::get('topselling-menu-report', 'TopSellingMenuReport');
                Route::get('/Vendor-dashboard','VendorDashboard');
            Route::get('/BarChasier-dashboard','BarChasierDashboard');
            Route::get('/DeliveryBoy-dashboard','DeliveryBoyDashboard');
            Route::get('/Waiter-Dashboard','WaiterDashboard');
            Route::get('/Kitchen-Manager-dashboard','KitchenManagerdashboard');
            Route::get('/store-manager-dashboard','storemanagerdashboard');
            Route::get('/Cashier-dashboard','Cashierdashboard');
            Route::get('/cashpaymentdetails','cashpaymentdetails');
            Route::get('/onlinepaymentdetails','onlinepaymentdetails');
            Route::get('/totalpaymentdetails','totalpaymentdetails');
            Route::get('getyearwisedatatakeawayorder/{year}','DashboardController@getyearwisedatatakeawayorder');
            Route::get('/takeaway-dashboard','takeawaydashboard');
            Route::get('/table-dashboard','tabledashboard');
            Route::get('/Menu-Item-Order', 'MenuItemOrderDashoard');
            Route::get('/purchaseInv-graph', 'PurchaseInvGraph');
            Route::get('/kitchen-graph', 'KitchenStockGraph');
            Route::get('/table-booking-graph', 'TableBookingGraph');
            Route::get('/free-item', 'FreeItemDetails');
            Route::get('/free-item-graph/{id}', 'FreeItemIdDetails');
            Route::get('/discount-order-graph', 'DiscountOrderGraph');
            Route::get('/defect-menu-item', 'DefectMenuItem');

            Route::get('selling-menu-item', 'SellingMenuItem');
            Route::get('selling-menu-itemwiseList/{id}', 'SellingMenuItemWiseList');
            Route::get('nc-report', 'NCReport');
            Route::get('NumbersBill-report', 'NumbersBillReport');
            Route::get('UsedCoupon-report', 'UsedCouponReport');

          Route::get('FoodSell-report', 'FoodSellReport');
            Route::get('BarSell-report', 'BarSellReport');


        });


        Route::controller(\VendorController::class)->group(function(){
            Route::get('vendor-type','vendortypeIndex');
            Route::match(['get','post'],'add-edit-vendortype/{id?}','AddEditVType');
            Route::Post('/Delete-vendortype/{id}','vendortypeDelete');
            Route::post('/Change-vendortype-status','VTypeStatusChange');
            Route::delete('vendortypeDeleteAll', 'deleteAllvendortype');

            Route::get('vendor','vendorIndex');
            Route::match(['get','post'],'add-edit-vendor/{id?}','AddEditVendor');
            Route::get('purchase-histroy/{id}','PurchaseHistroy');
            Route::Post('/Delete-vendor/{id}','vendorDelete');
            Route::post('/Change-vendor-status','VendorStatusChange');
            Route::delete('vendorDeleteAll', 'deleteAllvendor');
            Route::match(['get','post'],'update-vendor-payment/{id}','UpdateVendorPayment');

            Route::match(['get','post'],'assign-vendor-BuyProduct/{id}','AssignVendorBuyProduct');
            Route::Post('/Delete-AssignProduct/{id}','DeleteAssignProduct');

            Route::match(['get','post'],'exchange-purchasePrdouct/{id}','ExChangePurchaseProductList');




        });
        Route::controller(\CategoryController::class)->group(function(){

            Route::get('category-type','categorytypeIndex');
            Route::match(['get','post'],'add-edit-categorytype/{id?}','AddEditCType');
            Route::Post('/Delete-categorytype/{id}','categorytypeDelete');
            Route::post('/Change-categorytype-status','CTypeStatusChange');
            Route::delete('categorytypeDeleteAll', 'deleteAllcategorytype');

            Route::get('category','categoryIndex');
            Route::match(['get','post'],'add-edit-category/{id?}','AddEditCategory');
            Route::Post('/Delete-category/{id}','categoryDelete');
            Route::post('/Change-category-status','CategoryStatusChange');
            Route::delete('categoryDeleteAll', 'deleteAllcategory');

        });

        Route::controller(\UnitController::class)->group(function(){

            Route::get('unit','unitIndex');
            Route::match(['get','post'],'add-edit-unit/{id?}','AddEditUnit');
            Route::post('/Delete-unit/{id}','UnitDelete');
            Route::post('/Change-unit-status','ChangeUnitStatus');
            Route::delete('UnitDeleteAll', 'UnitdeleteAll');

        });

          Route::controller(\GenrateTokentController::class)->group(function(){

            Route::get('genarate-token','GenarateToken');
            Route::match(['get','post'],'add-edit-genarate-token/{id?}','AddEditGenarateToken');
            Route::post('/Delete-genarate-token/{id}','GenarateTokenDelete');
            Route::get('genaratetoken/{Tokenno}','PrintGenarateToken');

        });

        Route::controller(\IngredientController::class)->group(function(){

            Route::get('ingredient','IngredientIndex');
            Route::match(['get','post'],'add-edit-Ingredient/{id?}','AddEditIngredient');
            Route::post('/Delete-Ingredient/{id}','IngredientDelete');
            Route::post('/Change-Ingredient-status','ChangeIngredientStatus');
            Route::delete('IngredientDeleteAll', 'IngredientdeleteAll');

            Route::get('inventory-stock','InventoryStock');
            Route::match(['get','post'],'serach-prodtypewise', 'Serachprodtypewise');
                   Route::match(['get','post'],'serach-prodtypewises', 'Serachprodtypewises');
                     Route::match(['get','post'],'get-Invpurchase-product-List', 'GetInvPurchaseProductList');

        });
        Route::controller(\PurchaseInvProdController::class)->group(function(){

            Route::get('purchase-inv-product','PurchaseInvProdIndex');
            Route::get('View-Purchase/{id}','ViewPurchaseDetails');
            Route::match(['get','post'],'add-edit-PurchaseInvProdIndexearch','PurchaseInvProdIndexearch');
             Route::match(['get','post'],'add-edit-PurchaseInvProdIndex/','AddEditPurchaseInvProdIndex');
            Route::match(['get','post'],'edit-PurchaseInvProdIndex/{id}','EditPurchaseInvProdIndex');
            Route::post('/Delete-PurchaseInvProdIndex/{id}','PurchaseInvProdIndexDelete');
            Route::delete('PurchaseInvProdIndexDeleteAll', 'PurchaseInvProdIndexdeleteAll');

        });

        Route::controller(\DummyPurchaseInvProdController::class)->group(function(){
            Route::get('Dummypurchase-inv-product','DummyPurchaseInvProdIndex');
            Route::get('View-DummyPurchase/{id}','ViewDummyPurchaseDetails');
            Route::match(['get','post'],'add-edit-DummyPurchaseInvProdIndexearch','DummyPurchaseInvProdIndexearch');
            Route::match(['get','post'],'add-edit-DummyPurchaseInvProdIndex/{id?}','AddEditDummyPurchaseInvProdIndex');
            Route::post('/Delete-DummyPurchaseInvProdIndex/{id}','DummyPurchaseInvProdIndexDelete');
        });
        Route::controller(\RestaurantStoreRoomController::class)->group(function(){

            Route::get('Store-To-Kitchen','StoreToKitchen');
            Route::post('add-store-to-kitchen','AddEditStoreRoom');
            Route::get('Kitchen-Stock-Histroy','KitchenStockHistroy');
            Route::match(['get','post'],'date-wise-serach-KitchenStockHistroy', 'datewiseserachKitchenStockHistroy');
            Route::get('Kitchen-Receive-Stock','KitchenReciveStock');
            Route::post('Kitchen-Receive-Stock','KitchenReciveStocksave');
            Route::get('Kitchen-Stock','KitchenStock');
            Route::get('Kitchen-Waste ','KitchenWaste');
            Route::post('kitchen-waste-stockUpdate','KitchenWasteUpdate');
            Route::get('Kitchen-Waste-Log ','KitchenWasteLog');
            Route::match(['get','post'],'date-wise-serach-kitechenwaste', 'datewiseserachkitechenwaste');
            Route::match(['get','post'],'date-wise-serach-kitechenUseStock', 'datewiseserachkitechenUseStock');
            Route::get('Kitchen-UseStock','KitchenUseStock');
            Route::post('kitchen-Use-stockUpdate','KitchenUseStockUpdate');
            Route::get('Kitchen-UseStock-Log ','KitchenUseStockLog');

            Route::get('Store-To-Bar','StoreToBar');
            Route::post('add-store-to-Bar','AddStoreRoomBar');
            Route::match(['get','post'],'bar-recive-stock','BarReciveStock');
            Route::get('BarCurrent-Stock','BarCurrentStock');
            Route::get('BarRecive-Stock-Histroy','BarReciveStockHistroy');

            Route::get('update-stock-for-spoil-expire','UpdateStockForSpoilExpire');
            Route::post('updateStockforspoilexpireSave','UpdateStockForSpoilExpireSave');
            Route::get('updateStockforspoilexpireLog','UpdateStockForSpoilExpireLog');

            Route::get('transfer-BarToStoreStock','TransferBarToStoreStock');
            Route::post('transfer-BarToStoreStockSave','TransferBarToStoreStockSave');
            Route::match(['get','post'],'ReviceStockTransferFromBar','ReviceStockTransferFromBar');
            Route::get('transfer-BarToStoreStockLog','TransferBarToStoreStockLog');


            Route::match(['get','post'],'transfer-KitchenToStoreStock','TransferKitchenToStoreStock');
            Route::match(['get','post'],'ReviceStockTransferFromKitchen','ReviceStockTransferFromKitchen');
            Route::get('transfer-KitchenToStoreStockLog','TransferKitchenToStoreStockLog');



        });

        Route::controller(\MenuCategoryController::class)->group(function(){
            // Restaurant Menu start
                    Route::get('menu-subcategory','MenuSubCategoryIndex');
                    Route::match(['get','post'],'add-edit-menu-subcategory/{id?}','AddEditMenuSubCategory');
                    Route::Post('/Delete-menu-subcategory/{id}','MenuSubCategoryDelete');
                    Route::post('/Change-menu-subcategory-status','MenuSubCategoryStatusChange');
                    Route::delete('menu-subcategoryDeleteAll', 'deleteAllMenuSubCategory');
            // Restaurant Menu End
            // Bar Menu start
                    Route::get('bar-menu-subcategory','BarMenuSubCategoryIndex');
                    Route::match(['get','post'],'add-edit-barmenu-subcategory/{id?}','AddEditBarMenuSubCategory');
                    Route::Post('/Delete-barmenu-subcategory/{id}','BarMenuSubCategoryDelete');
                    Route::post('/Change-barmenu-subcategory-status','BarMenuSubCategoryStatusChange');
                    Route::delete('barmenu-subcategoryDeleteAll', 'deleteAllBarMenuSubCategory');
            // Bar Menu menu

            Route::get('extra-menu','ExtraMenuIndex');
            Route::match(['get','post'],'add-edit-extramenu/{id?}','AddEditExtraMenu');
            Route::Post('/Delete-extra-menu/{id}','ExtraMenuDelete');

        });

        Route::controller(\MenuItemPriceController::class)->group(function(){
            // Restaurant Menu start
                Route::get('menu-item-price','MenuItemPriceIndex');
                Route::match(['get','post'],'add-edit-MenuItemPrice/{id?}','AddEditMenuItemPrice');
                Route::Post('/Delete-MenuItemPrice/{id}','MenuItemPriceDelete');
                Route::post('/Change-MenuItemPrice-status','MenuItemPriceStatusChange');
                Route::delete('MenuItemPriceDeleteAll', 'deleteAllMenuItemPrice');
                Route::get('menu-price-modify','MenuPriceModify');
                Route::post('all-menu-price-modify','MenuPriceModifyall');

                Route::match(['get','post'],'menu-configuraton/{id}','MenuConfiguration');
                Route::Post('/Delete-MenuItemconfiguraton/{id}','MenuItemConfirlistDelete');
                Route::delete('MenuItemConfirlistDeleteAll', 'deleteAllMenuItemConfirlist');

                Route::match(['get', 'post'], 'add-images/{id}', 'AddImage');
                Route::post('delete-multiimage/{id}', 'DeleteImage');
            // Restaurant Menu End

            // Bar Menu start
                    Route::get('bar-menu-item-price','BarMenuItemPriceIndex');
                    Route::match(['get','post'],'add-edit-barMenuItemPrice/{id?}','AddEditBarMenuItemPrice');
                    Route::Post('/Delete-barMenuItemPrice/{id}','BarMenuItemPriceDelete');
                    Route::post('/Change-barMenuItemPrice-status','BarMenuItemPriceStatusChange');
                    Route::delete('barMenuItemPriceDeleteAll', 'deleteAllBarMenuItemPrice');
                    Route::get('bar-menu-price-modify','BarMenuPriceModify');
                    Route::post('all-barmenu-price-modify','BarMenuPriceModifyall');
             // Bar Menu End

        });
        Route::controller(\StaffController::class)->group(function(){

            Route::get('staffs','StaffsIndex');
            Route::match(['get','post'],'add-edit-staffs/{id?}','AddEditstaffs');
            Route::post('/Delete-staffs/{id}','staffsDelete');
            Route::post('/Change-menu-staff-status','StaffStatusChange');
            Route::delete('staffsDeleteAll', 'staffsdeleteAll');
             Route::match(['get','post'],'updatestaffWise-password/{id}','UpdateStaffWisePassword');

        });
        Route::controller(\TableController::class)->group(function(){

            Route::get('table','TableIndex');
            Route::match(['get','post'],'add-edit-Table/{id?}','AddEditTable');
            Route::post('/Delete-Table/{id}','TableDelete');
            Route::post('/Change-menu-table-status','TableStatusChange');
            Route::delete('TableIndexDeleteAll', 'TabledeleteAll');

            /// bar table chairs
            Route::get('bartable','BarTableIndex');
            Route::match(['get','post'],'add-edit-barTable/{id?}','AddEditBarTable');
            Route::post('/Delete-BarTable/{id}','BarTableDelete');
            Route::match(['get','post'],'Add-BarChairTablwWise/{bartableid}','AddBarChairTablwWise');
            Route::post('/Delete-BarTableWiseChair/{id}','BarTableWiseChairDelete');

        });

        Route::controller(\TaxController::class)->group(function(){
            Route::get('tax','TaxIndex');
            Route::match(['get','post'],'add-edit-Tax/{id?}','AddEditTax');
            Route::post('/Delete-Tax/{id}','TaxDelete');
            Route::delete('TaxIndexDeleteAll', 'TaxdeleteAll');
            Route::post('/Change-taxList-status','ChangeTaxStatus');
            Route::get('/tax-collection-report', 'TaxCollectionReport');
        });
        Route::controller(\CouponController::class)->group(function(){
            Route::get('Coupon-List','CouponList');
            Route::match(['get','post'],'add-edit-product-coupon/{id?}','AddCoupon');
            Route::post('/Delete-productwisecoupon/{id}','DeleteProductWiseCoupon');

            Route::get('Coupon-On-price','CouponOnpricelist');
            Route::match(['get','post'],'add-edit-Coupon-On-price/{id?}','AddCouponOnprice');
            Route::post('/Delete-CouponOnprice/{id}','DeleteCouponOnprice');

            Route::get('Total-Loss','TotalLoss');
            Route::get('Total-DiscountPercentage-CouponLoss','TotalDisPerCouponLoss');



        });
        Route::controller(\RestaurantOrderController::class)->group(function(){
            Route::match(['get','post'],'select-table','SelectTable');
            Route::match(['get','post'],'take-order/{id}','TakeOrderSave');
            Route::get('today-orders','TodayOrdersList');
            Route::get('delete-table-order/{orderno}','DeleteTableOrder');
            Route::get('today-complete-orders','TodayCompleteOrdersList');
            Route::get('table-orders','TableOrdersList');
            Route::get('today-takeway-orders','TodayTakwWayOrder');
            Route::get('view-order-details/{order_no}','ViewOrdersDetails');
            Route::post('transfer-cust-table/{order_no}','TranserCustTable');
                Route::post('transfer-OrderitemToOtherTable/{order_no}','TranserOrederitemToOtherTable');
            Route::match(['get','post'],'take-more-item/{order_no}','TakeMoreItem');
            Route::post('Delete-Order-Item/{id}', 'DeleteOrderItem');
            Route::match(['get','post'],'table-orders-SearchDateWsie','TableOrdersSearchDateWsie');
            Route::post('waiter-order-item-replace/{order_id}', 'OrderReplace');
            Route::post('RequestForDeleteItemKichen/{id}','RequestForDeleteItemKichen');
        });
        Route::controller(\BarChasierController::class)->group(function(){
            Route::get('bar-menu-item-list', 'BarMenuItemList');
            Route::get('restaurant-barorder','RestaurantBarOrder');
            Route::post('accept-restBarorder-status','AccepRestBartOrderStatus');
            Route::get('print-kot-restBarordersummary/{order_no}', 'PrintKOTRestBarOrderSummary');
            Route::get('view-restbar-orderitem/{order_no}','ViewRestBarOrderitem');
            Route::post('Change-BarOrder-Item-Status','ChangeBarOrderItemStatus');
            Route::get('Bar-UseStock-Log','BarUseStockLog');
            Route::get('take-tableWiseOrder','TakeBarCustOrder');
            Route::match(['get','post'],'bar-table-order/{tableid}','BarTableorder');
            Route::get('bar-table-order-view/{orderNo}','ViewBarTableOrder');
            Route::post('add-barTable-more-item/{order_no}','AddBarTableMoreItem');
            Route::post('bar-tableTransfer-order/{orderNo}','ViewBarTableTransferOrder');
            Route::post('Delete-BarTableOrder-Item/{id}', 'DeleteBarTableOrderItem');

            Route::get('take-chairWiseOrder','SelectTableWiseChair');
            Route::match(['get','post'],'take-bar-tableWiseChair-order/{tableid}','TakeBarTableWiseChairOrder');
            Route::get('take-bar-tableWiseChair-OrderView/{orderNo}','ViewBarTableWiseChairOrder');
            Route::post('add-barTableWiseChair-more-item/{order_no}','AddBarTableWiseChairMoreItem');


        });


        //Cashier Controller
        Route::controller(\CashierController::class)->group(function(){

            Route::get('today-table-order','tableOrderToday');
            Route::get('today-table-Completeorder','tableOrderTodaycompl');
            Route::get('View-order-details/{order_no}','ViewOrderDetails');
            Route::get('Take-away-order','TakeAwayOrder');
            Route::match(['get','post'],'tableorder-checkout/{order_no}','TableOrderCheckout');
            Route::get('table-paymentupdated/{order_no}','TablePaymentupdated');
            Route::get('table-orderSlip/{order_no}','TableOrderSlip');
            Route::get('product-list/{id}','PrdouctgetSub');
            Route::get('Take-away-order','TakeAwayOrder');
            Route::post('add_to_cart','TakeAwayOrderAddtocart');
            Route::post('update_cart','updatecart');
            Route::get('Delete-cartitem/{id}','deletecart');
            Route::post('process-next-takeorder','ProcessNextTakeorder');
            Route::get('takeorder-checkout/{order_no}','takeordercheckout');
            Route::match(['get','post'],'takeorder-checkout-save/{order_no}','takeordercheckoutSave');
            Route::get('today-Take-away-order','TodayTakeAwayOrder');
            Route::get('today-Take-away-orderSlip/{order_no}','TodayTakeAwayOrderSlip');
            Route::get('view-takeway-orderStatus/{order_no}', 'TakeWayOrderStatus');
            Route::match(['get','post'],'update-kitchen-order-status/{order_no}','UpdateKitechenOrderStatus');
            Route::post('proceed-to-pay','razorpaycheck');
            Route::post('proceed-to-pay-takeway','razorpaycheckTakeway');
            Route::post('proceed-to-pay-tableorder','razorpaycheckTable');
            Route::match(['get','post'],'takeway-orders-SearchDateWsie','TakewayOrdersSearchDateWsie');
            Route::match(['get','post'],'check-couponcode','CheckCouponcode');
            Route::post('save-tax-temprazordata/{order_no}', 'savetaxtemprazordata');




             Route::match(['get','post'],'take-table-order/{id}','TakeTableOrderSave');
            Route::match(['get','post'],'serach-menuitem','SearchMenuItem');

            Route::get('bar-tableOrderCheckout-list','BarTableOrderCheckoutList');
            Route::get('view-barTableCheckoutOrder/{BarTableOrderNo}','ViewBarTableOrderCheckout');
            Route::post('save-barTableCheckoutOrder/{BarTableOrderNo}','SaveBarTableOrderCheckout');
            Route::get('print-barorder-receipt/{BarTableOrderNo}','PrintBarOrderReceipt');
            Route::get('finallybarTableCheckoutOrder/{BarTableOrderNo}','finallyBarTableOrderCheckout');
            Route::match(['get','post'],'complete-barTableCheckoutOrder/{BarTableOrderNo}','completeBarTableOrderCheckout');

            Route::get('bar-tableWiseChairOrderCheckout-list','BarTableWiseChairOrderCheckoutList');
            Route::get('view-barTableWiseChairCheckoutOrder/{BarTableOrderNo}','ViewBarTableOrderWiseChaiCheckout');
            Route::post('Checkout-chairwiseorder/{BarChairNo}','CheckoutChairwiseorder');
            Route::get('chirwisebill','Chirwisebill');
            Route::get('print-barChairorder-receipt/{BarTableOrderNo}','PrintBarChairOrderReceipt');

             Route::post('proceed-to-pay-tableorderpartial','razorpaycheckTablepartial');
             Route::match(['get','post'],'tableorder-checkoutpartial/{order_no}','TableOrderCheckoutpartial');

             Route::match(['get','post'],'update-payable-mode/{order_no}','UpdatePayableMode');
        });

        Route::controller(\KitchenController::class)->group(function () {
            Route::get('menu-item-list', 'MenuItemList');
            Route::get('table-orderList', 'TableOrder');
            Route::post('accept-orderKich-status','AcceptOrderKichStatus');
            Route::get('print-kot-summary/{id}', 'PrintKOTSummary');
            Route::get('view-table-orderitem/{order_no}','TableOrderitemView');
            Route::post('Change-Order-Item-Status','ChangeOrderItemStatus');
   Route::post('accept-takewayorderKich-status','AcceptTakeWayOrderKichStatus');
            // Route::get('print-kot-summary/{id}', 'PrintKOTSummary');
             Route::get('print-takewayOrdrKot-summary/{id}', 'PrintTakeWayKOTSummary');
            Route::get('takeway-orderList', 'takewayOrder');
            Route::get('view-takeway-orderitem/{order_no}','takewayOrderitemView');
            Route::post('Change-TakeWayOrder-Item-Status','ChangeTakeWayOrderItemStatus');
            Route::post('delete-kitchen-approvel/{id}','DeleteKitchenApprovel');




        });

           Route::controller(\ZomatoOrderController::class)->group(function(){



            Route::get('Take-zomato-order','TakeZomatoOrder');
            Route::post('zomato_add_to_cart','ZomatoAddtocart');
            Route::post('update_zomato_cart','updateZomatocart');
            Route::get('DeleteZomato-cartitem/{id}','deletecartZomato');
            Route::post('Checkout-Zomato-Order','CheckoutZomatoOrder');

            Route::get('Today-Take-zomato-order','TodayTakeZomatoOrder');
             Route::get('Zomatao-Order-Slip/{order_no}','ZomataoOrderSlip');
            Route::get('view-Zomato-orderStatus/{order_no}', 'ViewZomatoOrderStatus');
            Route::match(['get','post'],'Update-Zomatao-KitchOrder/{order_no}','UpdateZomataoKitchOrder');
            Route::match(['get','post'],'Update-Zomatao-DeliveryBoySt/{order_no}','UpdateZomataoDeliveryBoySt');


        });
        Route::controller(\TableBookingController::class)->group(function () {
            Route::get('table-booking-request', 'tablerequest');
            Route::match(['get','post'],'add-edit-TableBooking/{id?}','AddEditTableBooking');
            Route::get('table-booking-confirm', 'TableBooked');

        });

        Route::controller(\SliderController::class)->group(function () {
            Route::get('slider',  'index');
            Route::match(['get', 'post'], 'add-banner-image/{id?}', 'AddBannerImage');
            Route::get('Delete-banner/{id}', 'DeleteBanner');


        });
        Route::controller(\OnlineOrderController::class)->group(function(){
            Route::get('online-order', 'OnlineOrderList');
            Route::get('view-onlineOrderDetails/{id}','OnlineOrdersDetails');
            Route::post('update-order-status','UpdateOrderStatus');
            Route::post('update-order-item-status','UpdateOrderItemStatus');
            Route::get('view-online-orderitem/{order_no}','ViewOnlineOrderItem');
            Route::post('Change-onlineOrder-Item-Status','ChangeOnlineOrderItemStatus');

            Route::get('assign-order', 'AssignOnlineOrderList');
            Route::get('overallOnline-orders', 'OverallOnlineOrderList');
            Route::get('delivery-orders', 'DeliveryOnlineOrderList');
            Route::get('assign-onlineOrderDetails/{order_no}','AssignViewOnlineOrder');
            Route::post('deliveryboy-ChangeOrderStatus','DeliveryboyChangeOrderStatus');

        });

        Route::get('site-settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'index']);
        Route::post('settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'store']);


        // api---

        Route::controller(\APIController::class)->group(function(){

            Route::get('getVendor/{vtypeid}','getVendor');
            Route::get('getProdType/{prodtypeid}','getProdType');
            Route::get('getCategory/{ctypeid}','getCategory');
            Route::get('getunit/{product_id}','getunit');
            Route::get('vendor_wise_previous_balance/{v_tye_wise_id}','vendor_wise_previous_balance');
            Route::get('getsubcatmenu/{meni_cat_id}','getsubcatmenu');
            Route::get('getItemprice/{item_id}','getItemprice');
            Route::get('getoffer/{item_id}/{item_qty}','getoffer');
            Route::get('extraMenuPrice/{extra_menu_item_id}','extraMenuPrice');
            Route::get('getExternalProdType/{prodtypeid}','getExternalProdType');
            Route::get('getExtrentalVendor/{v_type}','getExtrentalVendor');

        });



    });

});

