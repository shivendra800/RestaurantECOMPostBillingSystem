@extends('admin.layouts.layout')

@section('title', 'Update Vendor Payment')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Update Vendor Payment</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}/admin">Home</a></li>
                    <li class="breadcrumb-item active">Update Vendor Payment</li>

                </ol>
            </div>



        </div>
    </div><!-- /.container-fluid -->
</section>


<section class="content">
    <div class="container-fluid">
        @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{Session::get('error_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> Update Vendor Payment</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ url('admin/update-vendor-payment/'.$purchase_history->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                        <div class="row">

                            <div class="col-md-3"></div>
                            <div class="col-md-6">

                                <div class="col-md-12">

                                    <div class="form-group ">
                                        <label class="control-label mb-1">Total Balance:</label>
                                        <input type="number" value="{{$purchase_history->v_wallet}}" class="form-control  @error('v_wallet') is-invalid @enderror" name="v_wallet" readonly id="v_wallet">
                                        @error('v_wallet')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
    
                                </div>
                            
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Pay Amount:</label>
                                        <input type="number" onkeyup="paymentUpdate()" id="paid_amount" value="{{old('paid_amount')}}" class="form-control  @error('paid_amount') is-invalid @enderror" name="paid_amount">
                                        @error('paid_amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Remaining Amount:</label>
                                        <input type="text" id="remaining_amount" value="{{old('remaining_amount')}}" class="form-control @error('remaining_amount') is-invalid @enderror" name="remaining_amount" readonly placeholder="Remaining Amount">
                                        @error('remaining_amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                           
                        </div>
                        <div class="col-md-3"></div>
                        <div class="text-center">
                            <button type="submit" class="btn  btn-info "> Submit </button>
                            <a href="{{url('/')}}/admin/vendor" class="btn btn-secondary">Back</a>
                        </div>
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
    function paymentUpdate() {
        var u = document.getElementById('v_wallet').value;
        var v = document.getElementById('paid_amount').value;
        var w = parseInt(u) - parseInt(v);
        document.getElementById('remaining_amount').value = w;

    }

</script>
@endsection
