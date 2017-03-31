<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';

if($cart_id != ''){
  $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
  $result = mysqli_fetch_assoc($cartQ);
  $items = json_decode($result['items'],true);
  $i = 1;
  $sub_total = 0;
  $item_count = 0;

}

 ?>

<div class="col-md-12">
  <div class="row">
    <h2 class="text-center">My Shopping Cart</h2><hr>
    <?php if($cart_id == ''): ?>
      <div class="bg-danger">
        <p class="text-center text-danger">
           Your shopping cart is empty!!!
        </p>
      </div>
    <?php else: ?>
       <table class="table table-bordered table-condensed table-striped">
         <thead><th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub Total</th></thead>
         <tbody>
           <?php
            foreach((array)$items as $item){
             $product_id = $item['id'];
             $productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
             $product = mysqli_fetch_assoc($productQ);
             $sArray = explode(',',$product['sizes']);
             foreach($sArray as $sizeString){
               $s = explode(':',$sizeString);
               if($s[0] == $item['size']){
                 $available = $s[1];
               }
             }
             ?>
             <tr>
               <td><?=$i;?></td>
               <td><?=$product['title'];?></td>
               <td><?=money($product['price']);?></td>
               <td>
                <?=$item['quantity'];?>
                <?php if($item['quantity'] >= $available): ?>
              <span class="text-danger">Max</span>
              <?php endif; ?>
              </td>
               <td><?=$item['size'];?></td>
               <td><?=money($item['quantity'] * $product['price']);?></td>
             </tr>
             <?php
           $i++;
           $item_count += $item['quantity'];
           $sub_total += ($product['price'] * $item['quantity']);
           }
           $tax = TAXRATE * $sub_total;
           $tax = number_format($tax,2);
           $grand_total = $tax + $sub_total ;
           ?>
         </tbody>
       </table>
       <table class="table table-bordered table-condensed text-right">
         <legend>Totals</legend>
         <thead class="totals-table-header"><th>Total items</th><th>Sub Total</th><th>Tax</th><th>Grand_total</th></thead>
         <tbody>
        <tr>
          <td><?=$item_count;?></td>
          <td><?=money($sub_total);?></td>
          <td><?=money($tax);?></td>
          <td class="bg-success"><?=money($grand_total);?></td>
        </tr>
         </tbody>
       </table>
       <!-- check out button -->
<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
  <span class="glyphicon glyphicon-shopping-cart"></span> Check Out >>
</button>

<!-- Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="checkoutModalLabel">Shipping Address</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <form action="thankYou.php" method="post" id="payment-form">
          <span class="bg-danger" id="payment-errors"></span>
          <div id="step1" style="display:block;">
           <div class="form-group col-md-6">
             <label for="full_name">Full Name :</label>
             <input type="text" name="full_name" class="form-control" id="full_name">
           </div>
           <div class="form-group col-md-6">
             <label for="email">Email :</label>
             <input type="email" name="email" class="form-control" id="email">
           </div>
           <div class="form-group col-md-6">
             <label for="street">Street Address :</label>
             <input type="text" name="street" class="form-control" id="street">
           </div>
           <div class="form-group col-md-6">
             <label for="street2">Street Address 2 :</label>
             <input type="text" name="street2" class="form-control" id="street2">
           </div>
           <div class="form-group col-md-6">
             <label for="city">City :</label>
             <input type="text" name="city" class="form-control" id="city">
           </div>
           <div class="form-group col-md-6">
             <label for="state">State :</label>
             <input type="text" name="state"  class="form-control" id="state">
           </div>
           <div class="form-group col-md-6">
             <label for="zip_code">Zip Code :</label>
             <input type="text" name="zip_code"  class="form-control" id="zip_code">
           </div>
           <div class="form-group col-md-6">
             <label for="country">Country :</label>
             <input type="text" name="country" class="form-control" id="country">
           </div>
          </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Next >></button>
        </form>
      </div>
    </div>
  </div>
</div>
    <?php endif; ?>
  </div>
</div>
 <?php include 'includes/footer.php';  ?>
