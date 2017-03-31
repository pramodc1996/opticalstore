<?php
$cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
$price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
$min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
$max_price = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');
$b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
$brandQ = $db->query("SELECT * From brand ORDER BY brand");

 ?>
<h3 class="text-center">Search By :</h3>
<h4 class="text-center">Price :</h4>
<form  action="search.php" method="post">
  <input type="hidden" name="cat" value="<?=$cat_id;?>">
  <input type="hidden" name="price_sort" value="0">
  <input type="radio" name="price_sort" value="low"<?=(($price_sort == 'low')?' checked':'');?>>Low To High<br>
  <input type="radio" name="price_sort" value="high"<?=(($price_sort == 'high')?' checked':'');?>>High To Low<br>
  <input type="text" name="min_price" value="<?=$min_price;?>" class="price-range"  placeholder="Min $" >
  <br>To<br>
  <input type="text" name="max_price" value="<?=$max_price;?>" class="price-range" placeholder="Max $"><br><br>
  <h4 class="text-center">Brand</h4>
  <input type="radio" name="brand" value="" <?=(($b == '')?' checked':'');?>>All<br>
  <?php while($brand = mysqli_fetch_assoc($brandQ)): ?>
   <input type="radio" name="brand" value="<?=$brand['id'];?>"<?=(($b == $brand['id'])?' checked':'');?>><?=$brand['brand'];?><br>
  <?php endwhile; ?>
  <input type="submit"  value="Search" class="btn btn-xs btn-primary">
</form>
