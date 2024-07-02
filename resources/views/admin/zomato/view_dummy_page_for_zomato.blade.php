@extends('admin.layouts.layout')

@section('title', 'Today-Zomato-Order')

@section('content')



    <style>

            @media (min-width: 768px) {

                .col-sm-11,
                .col-sm-12,
                .col-sm-3,
                .col-sm-4,
                .col-sm-6,
                .col-sm-8 {
                    float: left;
                }

                .col-sm-12 {
                    width: 100%;
                }

                .col-sm-11 {
                    width: 91.66666667%;
                }

                .col-sm-8 {
                    width: 66.66666667%;
                }

                .col-sm-6 {
                    width: 50%;
                }

                .col-sm-4 {
                    width: 33.33333333%;
                }

                .col-sm-3 {
                    width: 25%;
                }

                .col-sm-offset-1 {
                    margin-left: 8.33333333%;
                }
            }

            @media (min-width: 992px) {

                .col-md-12,
                .col-md-2,
                .col-md-3,
                .col-md-4,
                .col-md-5,
                .col-md-6,
                .col-md-7,
                .col-md-8,
                .col-md-9 {
                    float: left;
                }

                .col-md-12 {
                    width: 100%;
                }

                .col-md-9 {
                    width: 75%;
                }

                .col-md-8 {
                    width: 66.66666667%;
                }

                .col-md-7 {
                    width: 58.33333333%;
                }

                .col-md-6 {
                    width: 50%;
                }

                .col-md-5 {
                    width: 41.66666667%;
                }

                .col-md-4 {
                    width: 33.33333333%;
                }

                .col-md-3 {
                    width: 25%;
                }

                .col-md-2 {
                    width: 16.66666667%;
                }
            }



        .table-bordered>tbody>tr>td,
        .table-bordered>tbody>tr>th,
        .table-bordered>thead>tr>th {
            border: 1px solid #ddd;
        }

        .table-bordered>thead>tr>th {
            border-bottom-width: 2px;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        table th[class*="col-"] {
            position: static;
            display: table-cell;
            float: none;
        }

        .table>tbody>tr.success>td,
        .table>tbody>tr.success>th {
            background-color: #dff0d8;
        }

        .table-responsive {
            min-height: 0.01%;
            overflow-x: auto;
        }

        @media screen and (max-width: 767px) {
            .table-responsive {
                width: 100%;
                margin-bottom: 15px;
                overflow-y: hidden;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                border: 1px solid #ddd;
            }

            .table-responsive>.table {
                margin-bottom: 0;
            }

            .table-responsive>.table>tbody>tr>td,
            .table-responsive>.table>tbody>tr>th {
                white-space: nowrap;
            }

            .table-responsive>.table-bordered {
                border: 0;
            }

            .table-responsive>.table-bordered>tbody>tr>td:first-child,
            .table-responsive>.table-bordered>tbody>tr>th:first-child {
                border-left: 0;
            }

            .table-responsive>.table-bordered>tbody>tr>td:last-child,
            .table-responsive>.table-bordered>tbody>tr>th:last-child {
                border-right: 0;
            }

            .table-responsive>.table-bordered>tbody>tr:last-child>td {
                border-bottom: 0;
            }

        }


        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
        }




        .content {
            min-height: 250px;
            padding: 15px;
            margin-right: auto;
            margin-left: auto;
            padding-left: 15px;
            padding-right: 15px;
        }




        .box {
            position: relative;
            border-radius: 3px;
            background: #fff;
            border-top: 3px solid #d2d6de;
            margin-bottom: 20px;
            width: 100%;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .box.box-solid {
            border-top: 0;
        }

        .box-body:after,
        .box-body:before {
            content: " ";
            display: table;
        }

        .box-body:after {
            clear: both;
        }

        .box-body {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
            padding: 10px;
        }


        .select2-container--default.select2-container--focus,
        .select2-container--default:active,
        .select2-container--default:focus,
        .select2-selection:active,
        .select2-selection:focus {
            outline: 0;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0;
            padding: 6px 12px;
            height: 34px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            padding-right: 0;
            height: auto;
            margin-top: -4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 28px;
            right: 3px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            margin-top: 0;
        }

        .select2-search--inline .select2-search__field {
            border: 1px solid #d2d6de;
        }

        .select2-search--inline .select2-search__field:focus {
            outline: 0;
        }


        #product_list_body {
            max-height: 485px;
            overflow-y: scroll;
            overflow-x: hidden;
        }


        .product_list {
            padding-left: 8px;
            padding-right: 8px;
        }

        .product_box {
            width: 100%;
            margin-bottom: 10px;
            text-align: center;
            cursor: pointer;
            font-weight: 600;
            background-color: #fff;
            border-radius: 2px;
            padding-top: 3px;
        }

        .product_box .image-container {
            height: 55px;
            margin: auto;
        }



        .product_box .text_div {
            margin-top: 3px;
        }

        .product_box .text {
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
            line-height: 14px;
            max-height: 14px;
        }


    </style>
    </head>


    <div id="app"></div>

    <div class="wrapper thetop" style="height: auto;">



        <!-- Content Wrapper. Contains page content -->
        <div class="">

            <!-- Add currency related field-->


            <section class="content no-print">

                <form method="POST" action="">
                    <div class="row mb-12">
                        <div class="col-md-12">
                            <div class="row">
                                <div class=" col-md-7  no-padding pr-12">
                                    <div class="box box-solid mb-12">
                                        <div class="box-body pb-0">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group" style="width: 100% !important">

                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-btn">
                                                                <button type="button"
                                                                    class="btn btn-default bg-white btn-flat"
                                                                    data-toggle="modal"
                                                                    data-target="#configure_search_modal"
                                                                    title="Configure product search"><i
                                                                        class="fa fa-barcode"></i></button>
                                                            </div>
                                                            <input class="form-control mousetrap ui-autocomplete-input"
                                                                id="search_product"
                                                                placeholder="Enter Product name / SKU / Scan bar code"
                                                                autofocus="" name="search_product" type="text"
                                                                autocomplete="off">
                                                            <span class="input-group-btn">

                                                                <!-- Show button for weighing scale modal -->

                                                                <button type="button"
                                                                    class="btn btn-default bg-white btn-flat pos_add_quick_product"
                                                                    data-href="https://pos.ultimatefosters.com/products/quick_add"
                                                                    data-container=".quick_add_product_modal"><i
                                                                        class="fa fa-plus-circle text-primary fa-lg"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">


                                                <input id="price_group" name="price_group" type="hidden" value="0">

                                                <!-- Call restaurant module if defined -->
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 pos_product_div"
                                                    style="min-height: 332.64px; max-height: 332.64px;">


                                                    <table
                                                        class="table table-condensed table-bordered table-striped table-responsive"
                                                        id="pos_table">
                                                        <thead>
                                                            <tr>
                                                                <th class="tex-center  col-md-4 ">
                                                                    Product <i
                                                                        class="fa fa-info-circle text-info hover-q no-print "
                                                                        aria-hidden="true" data-container="body"
                                                                        data-toggle="popover" data-placement="auto bottom"
                                                                        data-content="Click <i>product name</i> to edit price, discount &amp; tax. <br/>Click <i>Comment Icon</i> to enter serial number / IMEI or additional note.<br/><br/>Click <i>Modifier Icon</i>(if enabled) for modifiers"
                                                                        data-html="true" data-trigger="hover"></i>
                                                                </th>
                                                                <th class="text-center col-md-3">
                                                                    Quantity </th>
                                                                <th class="text-center col-md-2 ">
                                                                    Price inc. tax </th>
                                                                <th class="text-center col-md-2">
                                                                    Subtotal </th>
                                                                <th class="text-center"><i class="fas fa-times"
                                                                        aria-hidden="true"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="product_row" data-row_index="14">
                                                                <td>

                                                                    <div data-toggle="tooltip" data-placement="bottom"
                                                                        title="Edit product Unit Price and Tax">
                                                                        <span class="text-link text-info cursor-pointer"
                                                                            data-toggle="modal"
                                                                            data-target="#row_edit_product_price_modal_14">
                                                                            Apple iPhone 8 (Internal Memory:32
                                                                            GB)<br>AS0015-1 Apple
                                                                            &nbsp;<i class="fa fa-info-circle"></i>
                                                                        </span>
                                                                    </div>


                                                                </td>

                                                                <td>



                                                                    <div class="input-group input-number">
                                                                        <span class="input-group-btn"><button type="button"
                                                                                class="btn btn-default btn-flat quantity-down"><i
                                                                                    class="fa fa-minus text-danger"></i></button></span>
                                                                        <input type="text" data-min="1"
                                                                            class="form-control pos_quantity input_number mousetrap input_quantity valid"
                                                                            value="1.00" name="products[14][quantity]"
                                                                            data-allow-overselling="false" data-decimal="0"
                                                                            data-rule-abs_digit="true"
                                                                            data-msg-abs_digit="Decimal value not allowed"
                                                                            data-rule-required="true"
                                                                            data-msg-required="This field is required"
                                                                            data-rule-max-value="18.0000"
                                                                            data-qty_available="18.0000"
                                                                            data-msg-max-value="Only 18.00 Pc(s) available"
                                                                            data-msg_max_default="Only 18.00 Pc(s) available"
                                                                            aria-required="true" aria-invalid="false">
                                                                        <span class="input-group-btn"><button
                                                                                type="button"
                                                                                class="btn btn-default btn-flat quantity-up"><i
                                                                                    class="fa fa-plus text-success"></i></button></span>
                                                                    </div>



                                                                </td>

                                                                <td class="">
                                                                    <input type="text"
                                                                        name="products[14][unit_price_inc_tax]"
                                                                        class="form-control pos_unit_price_inc_tax input_number"
                                                                        value="1,306.25">
                                                                </td>
                                                                <td class="text-center v-center">
                                                                    <input type="hidden"
                                                                        class="form-control pos_line_total "
                                                                        value="2,612.50">
                                                                    <span class="display_currency pos_line_total_text "
                                                                        data-currency_symbol="true">$ 2,612.50</span>
                                                                </td>
                                                                <td class="text-center">
                                                                    <i class="fa fa-times text-danger pos_remove_row cursor-pointer"
                                                                        aria-hidden="true"></i>
                                                                </td>
                                                            </tr>


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-condensed">
                                                        <tbody>
                                                            <tr>
                                                                <td><b>Items:</b>&nbsp;
                                                                    <span class="total_quantity">4.00</span>
                                                                </td>
                                                                <td>
                                                                    <b>Total:</b> &nbsp;
                                                                    <span class="price_total">4,356.25</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <b>
                                                                        Discount <i
                                                                            class="fa fa-info-circle text-info hover-q no-print "
                                                                            aria-hidden="true" data-container="body"
                                                                            data-toggle="popover"
                                                                            data-placement="auto bottom"
                                                                            data-content="Set 'Default Sale Discount' for all sales in Business Settings. Click on the edit icon below to add/update discount."
                                                                            data-html="true" data-trigger="hover"></i>
                                                                        (-):
                                                                        <i class="fas fa-edit cursor-pointer"
                                                                            id="pos-edit-discount" title="Edit Discount"
                                                                            aria-hidden="true" data-toggle="modal"
                                                                            data-target="#posEditDiscountModal"></i>
                                                                        <span id="total_discount">435.63</span>
                                                                        <input type="hidden" name="discount_type"
                                                                            id="discount_type" value="percentage"
                                                                            data-default="percentage">

                                                                        <input type="hidden" name="discount_amount"
                                                                            id="discount_amount" value="10.00"
                                                                            data-default="10.00">

                                                                        <input type="hidden" name="rp_redeemed"
                                                                            id="rp_redeemed" value="0">

                                                                        <input type="hidden" name="rp_redeemed_amount"
                                                                            id="rp_redeemed_amount" value="0">

                                                                    </b>
                                                                </td>
                                                                <td class="">
                                                                    <span>
                                                                        <b>Order Tax(+): <i
                                                                                class="fa fa-info-circle text-info hover-q no-print "
                                                                                aria-hidden="true" data-container="body"
                                                                                data-toggle="popover"
                                                                                data-placement="auto bottom"
                                                                                data-content="Set 'Default Sale Tax' for all sales in Business Settings. Click on the edit icon below to add/update Order Tax."
                                                                                data-html="true" data-trigger="hover"
                                                                                data-original-title=""
                                                                                title=""></i></b>
                                                                        <i class="fas fa-edit cursor-pointer"
                                                                            title="Edit Order Tax" aria-hidden="true"
                                                                            data-toggle="modal"
                                                                            data-target="#posEditOrderTaxModal"
                                                                            id="pos-edit-tax"></i>
                                                                        <span id="order_tax">0.00</span>

                                                                        <input type="hidden" name="tax_rate_id"
                                                                            id="tax_rate_id" value=""
                                                                            data-default="">

                                                                        <input type="hidden"
                                                                            name="tax_calculation_amount"
                                                                            id="tax_calculation_amount" value="0.00"
                                                                            data-default="">

                                                                    </span>
                                                                </td>
                                                                <td class="">
                                                                    <span>

                                                                        <b>Shipping(+): <i
                                                                                class="fa fa-info-circle text-info hover-q no-print "
                                                                                aria-hidden="true" data-container="body"
                                                                                data-toggle="popover"
                                                                                data-placement="auto bottom"
                                                                                data-content="Set shipping details and shipping charges. Click on the edit icon below to add/update shipping details and charges."
                                                                                data-html="true" data-trigger="hover"
                                                                                data-original-title=""
                                                                                title=""></i></b>
                                                                        <i class="fas fa-edit cursor-pointer"
                                                                            title="Shipping" aria-hidden="true"
                                                                            data-toggle="modal"
                                                                            data-target="#posShippingModal"></i>
                                                                        <span id="shipping_charges_amount">0.00</span>
                                                                        <input type="hidden" name="shipping_details"
                                                                            id="shipping_details" value=""
                                                                            data-default="">

                                                                        <input type="hidden" name="shipping_address"
                                                                            id="shipping_address" value="">

                                                                        <input type="hidden" name="shipping_status"
                                                                            id="shipping_status" value="">

                                                                        <input type="hidden" name="delivered_to"
                                                                            id="delivered_to" value="">

                                                                        <input type="hidden" name="shipping_charges"
                                                                            id="shipping_charges" value="0.00"
                                                                            data-default="0.00">
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 no-padding">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="select2 select2-hidden-accessible" id="product_category"
                                                style="width:100% !important" tabindex="-1" aria-hidden="true">

                                                <option value="all">All Menu Items</option>
                                                @php
                                                    use App\Models\MenuItemPrice;
                                                @endphp
                                                @foreach ($subcategory as $subcategoryitems)
                                                @php

                                                     $subcatmenuitem = MenuItemPrice::where('menu_subcat_id', $subcategoryitems->id)->get();
                                                @endphp
                                                 <optgroup label="{{ $subcategoryitems->menu_subcat_name }}">
                                                    @foreach ($subcatmenuitem as $subcatmenuitems)
                                                        <option value="{{ $subcatmenuitems->id }}">{{ $subcatmenuitems->menu_item_name }}</option>
                                                    @endforeach

                                                 </optgroup>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <select id="product_brand" class="select2 select2-hidden-accessible"
                                                name="size" style="width:100% !important" tabindex="-1"
                                                aria-hidden="true">
                                                <option value="all">All Category</option>
                                                @foreach ($subcategory as $subcategoryitems)
                                                      <option value="{{ $subcategoryitems->id }}">{{ $subcategoryitems->menu_subcat_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="eq-height-row" id="product_list_body">
                                                @foreach ($menuitem as $item)

                                                    <div class="col-md-3 col-xs-4 product_list no-print">
                                                        <div class="product_box" >

                                                            <div class="image-container"
                                                                style="background-image: url(https://pos.ultimatefosters.com/uploads/img/1528780234_apples.jpg );
                                                                background-repeat: no-repeat; background-position: center;
                                                                background-size: contain;">

                                                            </div>

                                                            <div class="text_div">
                                                                <small
                                                                    class="text text-muted">{{ $item['menu_item_name'] }}
                                                                </small>

                                                                <small class="text-muted">
                                                                    {{ $item['menu_item_price'] }}
                                                                </small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach








                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </form>
            </section>







        </div>



    </div>



@endsection
