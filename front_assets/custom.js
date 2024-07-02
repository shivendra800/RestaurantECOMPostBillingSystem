$(document).ready(function () {

      // Update Cart Item QTY
      $(document).on('click','.updateCartItem',function(){
        if($(this).hasClass('plus-a')){
         // Get Qty
         var quantity = $(this).data('qty');
         // Increase the Qty by 1
         new_qty =parseInt(quantity) + 1;
        }
        if($(this).hasClass('minus-a')){
         // Get Qty
         var quantity = $(this).data('qty');
         // Check Qty is Atleast 1
         if(quantity<=1){
             alert("Item Quantity Must Be 1 or Greater !");
             return false;
         }
         // desrease the Qty by 1
         new_qty =parseInt(quantity) - 1;
         // alert(new_qty);
        }
        var cartid = $(this).data('cartid');
        $.ajax({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
            data:{cartid:cartid,qty:new_qty},
            url:'update_cart',
            type:'post',
            success:function(resp){
              //  alert(resp.status);
                // swal(resp.status);
                setTimeout(function() { // wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1);
                // $('#myDiv').load('.quantity')
                // alert('Reloaded')
               if(resp.status==false){
                 alert(resp.message);
               }
            },error:function(){
                alert("Error");
            }
        });
      });
 
            // Delete Cart Item QTY
            $(document).on('click','.deleteCartitem',function(){
 
                var cartid=$(this).data('cartid');
               
             var result =confirm("Are You sure To Delete This Cart Item?");
              if(result){
                 $.ajax({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                        data:{cartid:cartid},
                        url:'delete_cart_item',
                        type:'post',
                        success:function(resp){
                           // alert(resp.status);
                           swal(resp.status);
                           setTimeout(function() { // wait for 5 secs(2)
                               location.reload(); // then reload the page.(3)
                           }, 100);
                        },error:function(){
                            alert("Error");
                        }
                    });
              }
 
            });
    
    
    
       // Update Cart Item QTY
       $(document).on('click','.updateMenuCartItem',function(){
        if($(this).hasClass('plus-a')){
         // Get Qty
         var quantity = $(this).data('qty');
         // Increase the Qty by 1
         new_qty =parseInt(quantity) + 1;
        }
        if($(this).hasClass('minus-a')){
         // Get Qty
         var quantity = $(this).data('qty');
         // Check Qty is Atleast 1
         if(quantity<=1){
             alert("Item Quantity Must Be 1 or Greater !");
             return false;
         }
         // desrease the Qty by 1
         new_qty =parseInt(quantity) - 1;
         // alert(new_qty);
        }
        var cartid = $(this).data('cartid');
        $.ajax({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
            data:{cartid:cartid,qty:new_qty},
            url:'cart/update',
            type:'post',
            success:function(resp){
                alert(resp.status);
                //swal(resp.status);
                setTimeout(function() { // wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1);
                // $('#myDiv').load('.quantity')
                // alert('Reloaded')
               if(resp.status==false){
                 alert(resp.message);
               }
            },error:function(){
                alert("Error");
            }
        });
       });
    
     // Delete Cart Item QTY
     $(document).on('click','.deleteMenuCartitem',function(){

        var cartid = $(this).data('cartid');
        var result =confirm("Are You sure To Delete This Cart Item?");
         if(result){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                   data:{cartid:cartid},
                   url:'cart/delete',
                   type:'post',
                   success:function(resp){
                    //    alert(resp.status);
                       swal(resp.status);
                       setTimeout(function() { // wait for 5 secs(2)
                           location.reload(); // then reload the page.(3)
                       }, 100);

                   },error:function(){
                       alert("Error");
                   }
               });
         }

     });
    
     // show loader on placing order
     $(document).on('click','#placeOrder',function(){
        $(".loader").show();
      });
    
    
    
    
      // Edit Delivery Address of user
      $(document).on('click','.editAddress',function(){
        //  $(".loader").show();
        var addressid = $(this).data("addressid");
       // alert(addressid);
       $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            data:{addressid:addressid},
            url:'/get-delivery-address',
            type:'post',
            success:function(resp){
                $("#showdifferent").removeClass("collapse");
                $("#newAddress").hide();
                $(".deliveryText").text("Edit Delivery Address");
                $('[name=delivery_id]').val(resp.address['id']);
                $('[name=delivery_name]').val(resp.address['name']);
                $('[name=delivery_address]').val(resp.address['address']);
                $('[name=delivery_email]').val(resp.address['email']);
                $('[name=delivery_state]').val(resp.address['state']);
                $('[name=delivery_city]').val(resp.address['city']);
                $('[name=delivery_area]').val(resp.address['area']);
                $('[name=delivery_pincode]').val(resp.address['pincode']);
                $('[name=delivery_mobile]').val(resp.address['mobile']);
            },error:function(){
                alert("Error");
            }
       });
  });

  //save Delivery Address
  $(document).on('submit',"#addressAddEditForm",function(){
    var formdata = $("#addressAddEditForm").serialize();
   // alert(formdata);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
         url:'/save-delivery-address',
         type:'post',
         data:formdata,
        success: function (resp) {
            // alert(data);
            if(resp.type=="error"){
                // $(".loader").hide();
                   $.each(resp.errors,function(i,error){
                          $("#delivery-"+i).attr('style','color:red');
                          $("#delivery-"+i).html(error);

                   setTimeout(function () {
                       $("#delivery-"+i).css({'display':'none'});
                     },3000);
                    });
            } else {
                alert(resp.status);
                   $("#deliveryAddresses").html(resp.view);
                 window.location.href="checkout";
               }
         },error:function(){
            alert("Error");

         }
    });
  })

  //Remove  Delivery Address
  $(document).on('click','.removeAddress',function(){
      if(confirm("Are You Sure To Remove This Delivery Address??")){
        var addressid = $(this).data("addressid");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
             url:'/remove-delivery-address',
             type:'post',
             data:{addressid:addressid},
            success: function (resp) {
                alert(resp.status);
                $("#deliveryAddresses").html(resp.view);
                window.location.href ="checkout";
             },error:function(){
                alert("Error");
             }
            });
      }
  });


      // show delivery_boy_name and Tracking Number in case of Shipping Order Status
      $("#assign_id").hide();
 
      $("#order_status").on("change", function() {
          if (this.value == "Order-Collected"||this.value == "Order-TakenBy-DeliveryBoy"||this.value == "Order-Delivered") {
              $("#assign_id").show();
          } else {
              $("#assign_id").hide();
         
          }
      });
    
    


});