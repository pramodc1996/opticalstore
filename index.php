<?php
   require_once 'core/init.php';
   include 'includes/head.php';
   include 'includes/navigation.php';
   include 'includes/headerfull.php';
   include 'includes/leftbar.php';
   $sql ="SELECT * FROM products WHERE featured =1";
   $featured = $db->query($sql);
?>
<!--main Content-->
    <div  class="col-md-11">
      <div class="row" align="center">
        <h2 class="text-center"> Feature Products</h2>
        <?php while($product = mysqli_fetch_assoc($featured)): ?>
        <div class="col-md-4">
          <h4 class="text-center"><?= $product['title']; ?></h4>
          <img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>" class="img-thumb" />
          <p class="list-price text-danger">List Price: <s>$<?= $product['list_price']; ?></s></p>
          <p class="price">Our Price: $<?= $product['price']; ?></p>
          <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id']; ?>)">Details</buttton>
        </div>
      <?php endwhile; ?>
       </div>
    </div>
<?php
 include 'includes/rightbar.php';
  include 'includes/footer.php';
 ?>
