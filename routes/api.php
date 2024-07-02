<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('WaiterLogin', [App\Http\Controllers\API\LoginController::class, 'WaiterLogin']);

Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('WaiterLogout', [App\Http\Controllers\API\LoginController::class, 'WaiterLogout']);

    Route::get('WaiterDashboard', [App\Http\Controllers\API\DashboardController::class, 'WaiterDashboard']);
    Route::namespace('App\Http\Controllers\API')->group(function () {
        Route::controller(\WaiterController::class)->group(function(){
             // get all table list
            Route::get('/SelectTable', 'SelectTable');
             // get table order data
            Route::post('/TakeTableOrder', 'TakeTableOrder');//with table id
             // post table take order save
            Route::post('/TakeTableOrderSave', 'TakeTableOrderSave');

              // get today order list
            Route::get('/WaiterTodayOrderList', 'WaiterTodayOrderList');
             // get edit order page
            Route::post('/WaiterEditOrder', 'WaiterEditOrder');//with order id
             // post table trasnfer data
            Route::post('/WaiterTransferTable', 'WaiterTransferTable'); //with order id


            // post more item data
            Route::post('/WaiterTakeMoreItem', 'WaiterTakeMoreItem');////with order id
             // get tax tem data
            Route::post('/WaiterReviewOrderwithTax', 'WaiterReviewOrderwithTax');////with order id
             // post tax temp data
            Route::post('/WaiterSavetaxtempdata', 'WaiterSavetaxtempdata');////with order id

             // get  TablePaymentupdated data
            Route::post('/TblPaymentUpdatedCheckoutPage', 'TblPaymentUpdatedCheckoutPage');////with order id get page
            // post TableOrderCheckout page
            Route::post('/TblPaymentUpdatedCheckoutsave', 'TblPaymentUpdatedCheckoutsave');////with order id save page
            // get table order slip data
            Route::post('/TableOrderSlip', 'TableOrderSlip');////with order id get slip data

            // get today order complete data
            Route::get('/WaiterTodayOrderCompleteList', 'WaiterTodayOrderCompleteList');

             // post transfer item to one table to other table
             Route::put('/transfer-TableOrderitemToOtherTable', 'TransferTableOrderitemToOtherTable');

             // Delete Item
           Route::delete('Delete-Order-Item', 'DeleteOrderItem');

           // item replace
          Route::put('waiter-order-item-replace', 'OrderItemReplace');
          Route::post('/orderedItemList', 'orderedItemList');
           Route::post('/searchmenuitem', 'searchmenuitem');

        });
    });

});
