@extends('admin.layouts.layout')

@section('title','Add-Edit-Product-Coupon')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Product-Coupon</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
                    <li class="breadcrumb-item active">{{$title}}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{$title}} Product-Coupon</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="forms-sample" @if(empty($productoffer['id'])) action="{{ url('admin/add-edit-product-coupon') }}" @else action="{{ url('admin/add-edit-product-coupon/'.$productoffer['id']) }}" @endif method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Select Menu Item </label>
                                            <select class="form-control @error('product_id') is-invalid @enderror" name="product_id">
                                                <option value="">Select Menu Item </option>
                                                @foreach ($menuitems as $menuitem)
                                                <option value="{{$menuitem->id}}" @selected($menuitem->id == $productoffer['product_id']) {{(old('product_id') == $menuitem->id?'selected':'')}}>{{$menuitem->menu_item_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('menu_subcat_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> <!-- // end form group -->
                                </div> <!-- End col-md-5 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">PromoCode</label>
                                        <input type="text" class="form-control @error('promocode') is-invalid @enderror" id="" placeholder="Enter PromoCode" name="promocode" @if(!empty($productoffer['promocode'])) value="{{ $productoffer['promocode'] }}" @else value="{{ old('promocode') }}" @endif>
                                        @error('promocode')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Remark</label>
                                        <input type="text" class="form-control @error('remark') is-invalid @enderror" id="" placeholder="Enter Remark" name="remark" @if(!empty($productoffer['remark'])) value="{{ $productoffer['remark'] }}" @else value="{{ old('remark') }}" @endif>
                                        @error('remark')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="offer_type">Offer Type</label>
                                        <select class="form-control @error('offer_type') is-invalid @enderror" id="offer_type" name="offer_type" @if($productoffer['id']!="" ) disabled="" @else  @endif >
                                            <option value="">Select Offer Type</option>

                                            
                                            <option value="Offer-In-Qty" @if (isset($productoffer['offer_type']) && $productoffer['offer_type']=='Offer-In-Qty' ) selected @endif>
                                                Offer-In-Qty</option>
                                        </select>
                                        @error('offer_type')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                {{-- @if($productoffer['offer_type']=='Offer-In(%)')
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Offer(%)</label>
                                        <input type="number" class="form-control @error('offer_per') is-invalid @enderror" placeholder="Enter Offer Percentage" name="offer_per" @if(!empty($productoffer['offer_per'])) value="{{ $productoffer['offer_per'] }}" @else value="{{ old('offer_per') }}" @endif>
                                    </div>
                                </div>

                                @endif --}}

                                {{-- <div class="col-md-6" id="offer_per">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Offer(%)</label>
                                        <input type="number" class="form-control @error('offer_per') is-invalid @enderror" id="" placeholder="Enter Offer Percentage" name="offer_per" @if(!empty($productoffer['offer_per'])) value="{{ $productoffer['offer_per'] }}" @else value="{{ old('offer_per') }}" @endif>

                                        @error('offer_per')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div> --}}
                                {{-- @if($productoffer['offer_type']=='Offer-In-Qty')
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Offer No Of Qty To Buy</label>
                                        <input type="number" class="form-control @error('no_of_qty_buy') is-invalid @enderror" placeholder="Enter Offer No Of Qty To Be Buy" name="no_of_qty_buy" @if(!empty($productoffer['no_of_qty_buy'])) value="{{ $productoffer['no_of_qty_buy'] }}" @else value="{{ old('no_of_qty_buy') }}" @endif>
                                    </div>
                                </div>
                                @endif --}}
                                {{-- <div class="col-md-6" id="no_of_qty_buy"> --}}
                                    <div class="col-md-6" >
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Offer No Of Qty To Buy</label>
                                        <input type="number" class="form-control @error('no_of_qty_buy') is-invalid @enderror" id="" placeholder="Enter Offer No Of Qty To Be Buy" name="no_of_qty_buy" @if(!empty($productoffer['no_of_qty_buy'])) value="{{ $productoffer['no_of_qty_buy'] }}" @else value="{{ old('no_of_qty_buy') }}" @endif>

                                        @error('no_of_qty_buy')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- @if($productoffer['offer_type']=='Offer-In-Qty')
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Offer No Of Qty Free</label>
                                        <input type="number" class="form-control @error('no_qty_buy_to_free') is-invalid @enderror" placeholder="Enter Offer No Of  Qty To Be Free" name="no_qty_buy_to_free" @if(!empty($productoffer['no_qty_buy_to_free'])) value="{{ $productoffer['no_qty_buy_to_free'] }}" @else value="{{ old('no_qty_buy_to_free') }}" @endif>
                                    </div>
                                </div>
                                @endif --}}
                                {{-- <div class="col-md-6" id="no_qty_buy_to_free"> --}}
                                    <div class="col-md-6" >
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Offer No Of Qty Free</label>
                                        <input type="number" class="form-control @error('no_qty_buy_to_free') is-invalid @enderror" id="" placeholder="Enter Offer No Of  Qty To Be Free" name="no_qty_buy_to_free" @if(!empty($productoffer['no_qty_buy_to_free'])) value="{{ $productoffer['no_qty_buy_to_free'] }}" @else value="{{ old('no_qty_buy_to_free') }}" @endif>

                                        @error('no_qty_buy_to_free')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Offer Start Date</label>
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="" placeholder="Enter Offer Start Date" name="start_date" @if(!empty($productoffer['start_date'])) value="{{ $productoffer['start_date'] }}" @else value="{{ old('start_date') }}" @endif>
                                        @error('start_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Offer Expire Date</label>
                                        <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" id="" placeholder="Enter Offer Expire Date" name="expiry_date" @if(!empty($productoffer['expiry_date'])) value="{{ $productoffer['expiry_date'] }}" @else value="{{ old('expiry_date') }}" @endif>
                                        @error('expiry_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>




@endsection

@section('script')
<script>
    $(document).ready(function() {

        $("#no_qty_buy_to_free").hide();
        $("#no_of_qty_buy").hide();
        $("#offer_per").hide();
        $("#offer_type").on("change", function() {
            //    alert("offer_type");
            if (this.value == "Offer-In(%)") {
                $("#offer_per").show();
                $("#no_of_qty_buy").hide();
                $("#no_qty_buy_to_free").hide();
            } else {
                $("#offer_per").hide();
                $("#no_of_qty_buy").show();
                $("#no_qty_buy_to_free").show();
            }
        });


    });
</script>
@endsection