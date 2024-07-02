@extends('admin.layouts.layout')
@section('title', 'TableOrderCheckout')

@section('content')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .form {
            background: #cccccc;
            height: 100vh;
            width: 100%;
        }

        .form-row {
            background: #1b2236;
            ;
            border-radius: 50px;
            height: 40px;
            margin: 10px;
            overflow: hidden;
            position: relative;
            width: 150px;
        }

        .form-input {
            -webkit-appearance: none;
            appearance: none;
        }

        .form-input::before {
            content: '';
            cursor: pointer;
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }

        .form-input:checked::before {
            background: #F80;
            ;
        }

        .form-input::after {
            content: '';
            cursor: pointer;
            height: 40px;
            border-radius: 50px;
            border: 4px solid #F80;
            ;
            left: .05%;
            right: .05%;
            position: absolute;
            top: 50%;
            transform: translate(0, -50%);
            width: 150px;
        }

        .form-input:checked::after {
            border: 4px solid#1b2236;
            ;
        }

        .form-label {
            color: #F80;
            ;
            font-size: 13px;
            margin-left: 10px;
            z-index: 1;
            /*position: absolute; This is an alternative option */
        }

        .form-input:checked~.form-label {
            color: #1b2236;
            ;
        }
    </style>

    <section class="content-header">
        <div class="container-fluid">
            @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success:</strong> {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">View Bar Table Order Checkout </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header bg-info  ">
                            <div class="card-title " style="display:inline-flex; float:right">
                                <div type="button" class="btn btn-block btn-danger btn-flat ">
                                    {{ $orderes['tables']->table_name }}--{{ $orderes['tables']->table_type }}</div> &nbsp;

                            </div>
                            <div class="card-title  " style="display:inline-flex; float:center">
                                <div type="button" class="btn btn-block btn-danger btn-flat ">
                                    {{ $orderes['staffs']->name }}</div> &nbsp;

                            </div>
                            <div class="card-title " style="display:inline-flex; float:left">
                                <div type="button" class="btn btn-block btn-danger btn-flat ">{{ $orderes->order_no }}
                                </div> &nbsp;

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">



                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <!-- info row -->

                        <!-- /.row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class=" table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Product Name</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($ordereitemlist as $index => $itemList)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $itemList['menuitem']['menu_item_name'] }}<br>
                                                        @if ($itemList['extraItemPrice'] != null)
                                                            <small class="text-danger">
                                                                Extra:-{{ $itemList['extraitemadd']['extra_menu'] }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $itemList['item_qty'] }}</td>
                                                    <td>
                                                        {{ $itemList['menuitem']['menu_item_price'] }}<br>
                                                        @if ($itemList['extraItemPrice'] != null)
                                                            <small class="badge badge-info"> ExtraItemPrice:-
                                                                {{ $itemList['extraItemPrice'] }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $itemList['amount'] }}
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-6">

                                    </div>
                                    <!-- /.col -->
                                    <div class="col-6">


                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th style="width:50%">Subtotal:</th>
                                                    <td>{{ $orderes['sub_total'] }}</td>
                                                </tr>
                                                @if ($orderes['coupon_per'] > 0)
                                                    <tr>
                                                        <th style="width:50%">Discount:</th>
                                                        <td>{{ $orderes['coupon_per'] }}%</td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:50%">AfterDiscountSubtotal:</th>
                                                        <td>{{ $orderes['subtotalwithoffer'] }}</td>
                                                    </tr>
                                                @endif
                                                @foreach ($gettaxinst as $usetaxlist)
                                                    <tr>
                                                        <th style="width:50%">
                                                            {{ $usetaxlist['tax_name'] }}({{ $usetaxlist['tax_percentage'] }}%):
                                                        </th>
                                                        <td>{{ $usetaxlist['tax_amount'] }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <th>Grand Total</th>
                                                    <td>{{ $orderes['grand_total'] }}</td>

                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <a style="max-width: 250px; float:right; display:inline-block;"
                                        href="{{ url('admin/table-orderSlip/' . $orderes['order_no']) }}" rel="noopener"
                                        target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>&nbsp;
                                    <a style="max-width: 250px; float:right; display:inline-block;"
                                        href="{{ url('admin/View-order-details/' . $orderes['order_no']) }}"
                                        class="btn btn-info"> Update Bill</a>&nbsp;
                                    <a style="max-width: 250px; float:right; display:inline-block;"
                                        href="{{ url('admin/update-payable-mode/' . $orderes['order_no']) }}"
                                        class="btn btn-secondary"> Update PayAble Mode</a>&nbsp;
                                    <!-- /.col -->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <form action="{{ url('admin/tableorder-checkout/' . $orderes['order_no']) }}">

                                    @csrf

                                    <input type="hidden" name="orderid" class="order_id"
                                        value="{{ $orderes['order_no'] }}">
                                    @php
                                        $grandtotal = $orderes['grand_total'];
                                        $gandtotalroundoff = round($grandtotal);
                                    @endphp

                                    <div class="card-body">
                                        @if (Session::has('error_message'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error:</strong> {{ Session::get('error_message') }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label>Grand Total RoundOff</label>
                                                <input class="form-control grand_total" type="text" name="grand_total"
                                                    id="grand_total" value="{{ $gandtotalroundoff }}" readonly>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Mobile No</label>
                                                <input
                                                    class="form-control mobile_no @error('mobile_no') is-invalid @enderror"
                                                    id="mobile_no" type="number" name="mobile_no">
                                                @error('mobile_no')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Enter By Waiter PayAble Mode</label>
                                                <input class="form-control " type="text" name="payableamt"
                                                    value="{{ $orderes['payableamt'] }}" readonly>
                                            </div>
                                            @if ($orderes['payableamt'] != 'General')
                                                <div class="form-group">
                                                    <label>Enter By Waiter NC Remark</label>
                                                    <input class="form-control " type="text" name="nc_remark"
                                                        value="{{ $orderes['nc_remark'] }}">
                                                </div>
                                            @endif
                                        </div>
                                        <hr>
                                        @if ($orderes['payableamt'] == 'General')
                                            <div class="row">


                                                <div id="myRadioGroup">
                                                    <form class="form flex-center">
                                                        <div class="row">
                                                            <div class="form-row flex-center col-sx-3">
                                                                <input type="radio" name="payment_mode"
                                                                    id="radiobuttonid" value="Cash" class="form-input">
                                                                <label for="Cash" class="form-label">Cash</label>
                                                            </div>
                                                            <div class="form-row flex-center">
                                                                <input type="radio" name="payment_mode"
                                                                    id="radiobuttonid" value="Card-Swip"
                                                                    class="form-input">
                                                                <label for="Card-Swip"
                                                                    class="form-label">Card-Swip</label>
                                                            </div>
                                                            <div class="form-row flex-center">
                                                                <input type="radio" name="payment_mode"
                                                                    id="radiobuttonid" value="QRCodeWithSlip"
                                                                    class="form-input">
                                                                <label for="QRCodeWithSlip"
                                                                    class="form-label">QRCodeWithSlip</label>
                                                            </div>
                                                            <div class="form-row flex-center">
                                                                <input type="radio" name="payment_mode"
                                                                    id="radiobuttonid" value="Cash-Card"
                                                                    class="form-input">
                                                                <label for="Cash-Card"
                                                                    class="form-label">Cash-Card</label>
                                                            </div>
                                                            <div class="form-row flex-center">
                                                                <input type="radio" name="payment_mode"
                                                                    id="radiobuttonid" value="QR-Card"
                                                                    class="form-input">
                                                                <label for="QR-Card" class="form-label">QR-Card</label>
                                                            </div>
                                                            <div class="form-row flex-center">
                                                                <input type="radio" name="payment_mode"
                                                                    id="radiobuttonid" value="QR-Cash"
                                                                    class="form-input">
                                                                <label for="QR-Cash" class="form-label">QR-Cash</label>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <hr>
                                                    {{-- @if (Session::has('error_message'))
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>Errors:</strong> {{Session::get('error_message')}}
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                @endif --}}

                                                    @if ($errors->any(''))
                                                        <div class="alert alert-success alert-dismissible fade show"
                                                            role="alert">
                                                            <strong>Success:</strong> <?php echo implode('', $errors->all('<div>:message</div>')); ?>
                                                            <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    @endif
                                                    <hr>


                                                    <div id="Card-Swip" class="desc">
                                                        <button type="submit" class="btn btn-primary">Card
                                                            Submit</button>
                                                    </div>
                                                    <div id="Cash" class="desc">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="Taken Cash Amount">Taken Cash Amount</label>
                                                                <input type="number" step=0.001 min=0.01
                                                                    name="taken_cash_amount" id="cash_amount"
                                                                    class="form-control" placeholder="Taken Cash Amount">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="Given Change Amount">Given Change
                                                                    Amount</label>
                                                                <input type="number" step=0.001 min=0.01
                                                                    name="given_change_amount" id="change_amount"
                                                                    class="form-control" placeholder="Given Change Amount"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Cash
                                                            Submit</button>
                                                    </div>
                                                    <div id="QRCodeWithSlip" class="desc">
                                                        <button type="submit" class="btn btn-primary">QR Submit</button>
                                                    </div>
                                                    <div id="QR-Card" class="desc">

                                                        <label for="QR Amount">QR Amount</label>
                                                        <input type="number" step=0.001 min=0.01 name="qr_amt_qc"
                                                            id="cash_amountQC" class="form-control "
                                                            placeholder="QR Amount">

                                                        <label for="Card Amount">Card Amount</label>
                                                        <input type="number" step=0.001 min=0.01 name="card_amt_qc"
                                                            id="change_amountQC" class="form-control"
                                                            placeholder="Card Amount" readonly>

                                                        <button type="submit" class="btn btn-primary">QR-Card
                                                            Submit</button>
                                                    </div>
                                                    <div id="Cash-Card" class="desc">
                                                        <label for="Taken Cash Amount"> Cash Amount</label>
                                                        <input type="number" step=0.001 min=0.01 name="cash_amt_cc"
                                                            id="cash_amountCashCard"
                                                            class="form-control cash_amountparitial"
                                                            placeholder="Cash Amount">

                                                        <label for="Card Amount">Card Amount</label>
                                                        <input type="number" step=0.001 min=0.01 name="card_amt_cc"
                                                            id="change_amountCashCard"
                                                            class="form-control partial_other_value"
                                                            placeholder="Card  Amount" readonly>

                                                        <button type="submit" class="btn btn-primary">Cash-Card
                                                            Submit</button>
                                                    </div>
                                                    <div id="QR-Cash" class="desc">
                                                        <label for="Taken Cash Amount"> Cash Amount</label>
                                                        <input type="number" step=0.001 min=0.01 name="cash_amt_qcash"
                                                            id="cash_amountCashQR"
                                                            class="form-control cash_amountparitial"
                                                            placeholder="Cash Amount">

                                                        <label for="QR Amount">QR Amount</label>
                                                        <input type="number" step=0.001 min=0.01 name="qr_amt_qcash"
                                                            id="change_amountCashQR"
                                                            class="form-control partial_other_value"
                                                            placeholder="QR  Amount" readonly>

                                                        <button type="submit" class="btn btn-primary">QR-Cash
                                                            Submit</button>
                                                    </div>
                                                </div>


                                                <hr>
                                            @else
                                                <button type="submit" class="btn btn-primary">NC Submit</button>
                                        @endif

                                    </div>
                                    <!-- /.card-body -->

                                </form>
                            </div>

                        </div>






                        <!-- /.row -->

                        <!-- this row will not appear when printing -->

                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->




@endsection
@section('script')

    <script>
        $(document).ready(function() {
            $("div.desc").hide();
            $("input[name$='payment_mode']").click(function() {
                var test = $(this).val();
                $("div.desc").hide();
                $("#" + test).show();
            });



            $("#cash_amount").keyup(function() {

                var cash_amount = $("#cash_amount").val();
                var grand_total = $("#grand_total").val();
                $("#change_amount").val(cash_amount - grand_total);
            });
            $("#cash_amountQC").keyup(function() {

                var cash_amountQC = $("#cash_amountQC").val();
                var grand_totalQC = $("#grand_total").val();
                $("#change_amountQC").val(grand_totalQC - cash_amountQC);
            });

            $("#cash_amountCashCard").keyup(function() {

                var cash_amountCashCard = $("#cash_amountCashCard").val();
                var grand_totalCashCard = $("#grand_total").val();
                $("#change_amountCashCard").val(grand_totalCashCard - cash_amountCashCard);
            });
            $("#cash_amountCashQR").keyup(function() {
                var cash_amountCashQR = $("#cash_amountCashQR").val();
                var grand_totalCashQR = $("#grand_total").val();
                $("#change_amountCashQR").val(grand_totalCashQR - cash_amountCashQR);
            });



        });
    </script>
@endsection
