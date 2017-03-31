<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tutorial/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
//Delete product
if(isset($_GET['delete'])){
  $id = sanitize($_GET['delete']);
  $db->query("UPDATE products SET deleted = 1 WHERE id = '$id'");
  header('Location: products.php');
}
if (isset($_GET['add']) || isset($_GET['edit'])) {
$brandQuery=$db->query("SELECT * FROM brand ORDER BY brand");
$parentQuery=$db->query("SELECT * FROM  categories WHERE parent = 0 ORDER BY category");
$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
$brand = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):'');
$parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):'');
$category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):'');
if(isset($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $productResults = $db->query("SELECT * FROM products WHERE id='$edit_id'");
  $product = mysqli_fetch_assoc($productResults);
  $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
  $title = ((isset($_POST['title']) && !empty($_POST['title']))?sanitize($_POST['title']):$product['title']);
  $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):$product['brand']);
  $parentQ = $db->query("SELECT * FROM categories WHERE  id='$category'");
  $parentResult = mysqli_fetch_assoc($parentQ);
  $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):$parentResult['parent']);
 }

$sizesArray=array();
if ($_POST) {

  $categories = sanitize($_POST['child']);
  $price = sanitize($_POST['price']);
  $list_price = sanitize($_POST['list_price']);
  $sizes = sanitize($_POST['sizes']);
  $description = sanitize($_POST['description']);
  $dbpath = '';
  $empty = array();
  if (!empty($_POST['sizes'])) {
     $sizeString=sanitize($_POST['sizes']);
     $sizeString = rtrim($sizeString,',');
     $sizesArray = explode(',',$sizeString);
     $sArray = array();
     $qArray = array();
     foreach ($sizesArray as $ss) {
       $s=explode(':',$ss);
       $sArray[] = $s[0];
       $qArray[] = $s[1];
     }
  }else{
    $sizesArray = array();
  }
  $required = array('title','brand','price','parent','child','sizes');
  foreach ($required as $field) {
    if ($_POST[$field] == '') {
       $errors[]= 'all fields with an * are required';
       break;
    }
  }

  if (!empty($_FILES)) {
      // used to display image content var_dump($_FILES);
     $photo = $_FILES['photo'];
     $name = $photo['name'];
     $nameArray =explode('.',$name);
     $fileName = $nameArray[0];
     $fileExt = $nameArray[1];
     $mime = explode('/',$photo['type']);
     $mimeType = $mime[0];
     $mimeExt = $mime[1];
     $tmpLoc = $photo['tmp_name'];
     $fileSize = $photo['size'];
     $allowed = array('png','jpg','jpeg','gif');
    $uploadName = md5(microtime()).'.'.$fileExt;
    $uploadPath = BASEURL.'images/products/'.$uploadName;
     $dbpath = '/tutorial/images/products/'.$uploadName;
     if ($mimeType != 'image') {
        $errors[]='the file must be an image';
     }
     if (!in_array($fileExt , $allowed)) {
       $errors[] = 'The file extention must be a png , jpg, jpeg or gif';
     }
     if ($fileSize > 15000000) {
            $errors[]= 'the file size must be under 15MB';
     }
     if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
       $errors[] = 'File extention does not match the file. ';
     }
  }
  if(!empty($errors)){
    echo display_errors($errors);
  }else{
    //update database

    //upload file and insert into database

   move_uploaded_file($tmpLoc,$uploadPath);
  $insertSql = "INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`,`description`)
   VALUES ('$title','$price','$list_price','$brand','$categories','$sizes','$dbpath','$description')";
   $db->query($insertSql);
   header('Location: products.php');
  }
}
?>
<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add a new ');?>product</h2><hr>
<form class="" action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
  <div class="form-group col-md-3">
    <label for="title">Title*:</label>
    <input type="text" name="title" class="form-control"  id="title" value="<?=$title;?>">
  </div>
  <div class="form-group col-md-3">
    <label for="brand">Brand*:</label>
    <select class="form-control" id="brand" name="brand">
      <option value=""<?=(($brand == '')?' selected':'');?>></option>
      <?php while($b=mysqli_fetch_assoc($brandQuery)):?>
        <option value="<?=$b['id'];?>"<?=(($brand == $b['id'])?' selected':'');?>><?=$b['brand'];?></option>
      <?php endwhile;?>
    </select>
  </div>
  <div class="form-group col-md-3">
     <label for="parent">Parent category*:</label>
     <select class="form-control" name="parent" id="parent">
    <option value=""<?=(( $parent == '')?' selected':'');?>></option>
    <?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
      <option value="<?=$p['id'];?>"<?=(( $parent == $p['id'])?' selected':'');?>><?=$p['category'];?></option>
    <?php endwhile; ?>
     </select>
  </div>
  <div class="form-group col-md-3">
    <label for="child">Child Category*:</label>
    <select class="form-control" id="child" name="child">
    </select>
  </div>
  <div class="form-group col-md-3">
    <label for="price">Price*:</label>
    <input type="text" name="price" class="form-control" id="price" value="<?=((isset($_POST['price']))?sanitize($_POST['price']):'');?>">
  </div>
  <div class="form-group col-md-3">
    <label for="price">List Price:</label>
    <input type="text" name="list_price" class="form-control" id="list_price" value="<?=((isset($_POST['list_price']))?sanitize($_POST['list_price']):'');?>">
  </div>
  <div class="form-group col-md-3">
    <label>Quantity & sizes*:</label>
    <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false">Quantity & Sizes</button>
  </div>
  <div class="form-group col-md-3">
    <label for="sizes">Sizes & Qty Preview</label>
    <input type="text" class="form-control" name="sizes" id="sizes" value="<?=((isset($_POST['sizes']))?$_POST['sizes']:'');?>" readonly>
  </div>
  <div class="form-group col-md-6">
    <label for="photo">Product photo:</label>
    <input type="file" name="photo" id="photo" class="form-control">
  </div>
  <div class="form-group col-md-6">
    <label for="description">Description:</label>
    <textarea name="description" id="description" rows="6" class="form-control"><?=((isset($_POST['description']))?sanitize($_POST['description']):'');?></textarea>
  </div>
  <div class="form-group pull-right">
    <a href="products.php" class="btn btn-default">Cancel</a>
  <input type="submit" name="name" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?> Product" class="btn btn-success">
</div><div class="clearfix"></div>
</form>

<!-- Modal -->

<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModalLabel">Size & Quantity</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
        <?php for($i = 1;$i <= 6;$i++): ?>
          <div class="form-group col-md-4">
            <label for="size<?=$i;?>">Size</label>
            <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
          </div>
          <div class="form-group col-md-2">
            <label for="qty<?=$i;?>">Quantity:</label>
            <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
          </div>
      <?php endfor; ?>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php }else{
$sql = "SELECT * FROM products WHERE deleted=0 ";
$presults=$db->query($sql);
if (isset($_GET['featured'])) {
$id=(int)$_GET['id'];
$featured=(int)$_GET['featured'];
$fsql="UPDATE products SET featured='$featured' WHERE id= '$id'";
$db->query($fsql);
header('Location: products.php');
}
 ?>
<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
<thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
<tbody>
<?php while($product =mysqli_fetch_assoc($presults)):
 $childID = $product['categories'];
 $csql="SELECT * FROM  categories WHERE id='$childID'";
 $result = $db->query($csql);
  $child=mysqli_fetch_assoc($result);
  $parentID = $child['parent'];
  $psql = "SELECT * FROM categories WHERE id='$parentID'";
  $presult=$db->query($psql);
  $parent=mysqli_fetch_assoc($presult);
  $category=$parent['category'].'~'.$child['category'];
   ?>
<tr>
<td>
 <a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
</td>

<td> <?=$product['title'];?> </td>
<td> <?=money($product['price']);?> </td>
<td> <?=$category;?></td>
<td> <a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id']?>" class="btn btn-xs btn-default">
  <span class="glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus');?>"></span>
</a>&nbsp <?=(($product['featured']==1)?'Featured Product':'');?></td>
<td>0</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
 <?php } include 'includes/footer.php';
  ?>
