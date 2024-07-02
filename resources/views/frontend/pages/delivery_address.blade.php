<div class="card mb-4 border shadow-0">
    <div class="p-4 d-flex justify-content-between">
      <div class="">
         <h4 class="section-h4 deliveryText"> Add New Delivery Address</h4>
  <div class="u-s-m-b-24">
      <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse" data-target="#showdifferent">
      @if(count($deliveryAddresses)>0)
      <label class="label-text" id="newAddress" for="ship-to-different-address">Ship to a different address?</label>
      @else
      <label class="label-text" id="newAddress" for="ship-to-different-address">Check To Add Delivery address?</label>
      @endif
  </div>
      </div>
    </div>
  </div>


<div class="collapse" id="showdifferent">
  <!-- Checkout -->
  <div class="card shadow-0 border">
    <div class="p-4">
      <h5 class="card-title mb-3">Guest checkout</h5>
      <form id="addressAddEditForm" action="javascript:;" method="post">@csrf
        <input type="hidden"  name="delivery_id">
      <div class="row">
        <div class="col-6 mb-3">
          <p class="mb-0">Name</p>
          <div class="form-outline">
            <input type="text" name="delivery_name" id="delivery-name" class="form-control">
            <p id="delivery-delivery_name"></p>
          </div>
        </div>

        <div class="col-6">
          <p class="mb-0">Phone</p>
          <div class="form-outline">
            <input type="text" name="delivery_mobile" id="delivery-mobile" class="form-control">
            <p id="delivery-delivery_mobile"></p>
          </div>
        </div>

        <div class="col-6 mb-3">
          <p class="mb-0">Postal code</p>
          <div class="form-outline">
            <input type="text" name="delivery_pincode" id="delivery-pincode" class="form-control">
        <p id="delivery-delivery_pincode"></p>
          </div>
        </div>

        <div class="col-6 mb-3">
          <p class="mb-0">Email</p>
          <div class="form-outline">
            <input type="email" id="typeEmail"  name="delivery_email" id="delivery-email" placeholder="example@gmail.com" class="form-control" />
            <p id="delivery-delivery_email"></p>
        </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 mb-4">
          <p class="mb-0">Address</p>
          <div class="form-outline">
            <textarea class="form-control" name="delivery_address" id="delivery-address" rows="3"></textarea>
            <p id="delivery-delivery_address"></p>
          </div>
        </div>

        {{-- <div class="col-sm-4 mb-3">
          <p class="mb-0">City</p>
          <select class="form-select">
            <option value="1">New York</option>
            <option value="2">Moscow</option>
            <option value="3">Samarqand</option>
          </select>
        </div> --}}

        <div class="col-sm-4 mb-3">
          <p class="mb-0">State </p>
          <div class="form-outline">
            <input type="text" name="delivery_state" id="delivery-state" class="form-control">
        <p id="delivery-delivery_state"></p>
          </div>
        </div>

        <div class="col-sm-4 col-6 mb-3">
          <p class="mb-0">City</p>
          <div class="form-outline">
            <input type="text" name="delivery_city" id="delivery-city" class="form-control">
        <p id="delivery-delivery_city"></p>
          </div>
        </div>

        <div class="col-sm-4 col-6 mb-3">
          <p class="mb-0">Area</p>
          <div class="form-outline">
            <input type="text"  name="delivery_area" id="delivery-area"  class="form-control" />
            <p id="delivery-delivery_area"></p>
          </div>
        </div>
      </div>

      {{-- <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" />
        <label class="form-check-label" for="flexCheckDefault1">Save this address</label>
      </div> --}}


      <div class="float-end">
        {{-- <button class="btn btn-light border">Cancel</button> --}}
        {{-- <button class="btn btn-success shadow-0 border">Continue</button> --}}
        <button style="width: 100%;" type="submit" class="button button-outline-secondary">Save</button>
      </div>
      </form>
    </div>
  </div>
  <!-- Checkout -->
</div>