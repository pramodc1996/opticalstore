<?php
require_once '../core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
if(!has_permission('admin')){
  permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
if(isset($_GET['delete'])){
  $delete_id = sanitize($_GET['delete']);
  $db->query("DELETE FROM users WHERE id = '$delete_id'");
  $_SESSION['success_flash'] = 'user deleted';
  header('Location: users.php');
}
if(isset($_GET['add'])){
  $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
  $errors = array();
  if($_POST){
    $emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
    $emailCount = mysqli_num_rows($emailQuery);

    if($emailCount !=0 ){
      $errors[] = 'That email already exists';
    }

    $required = array('name','email','password','confirm','permissions');
    foreach ($required as $f) {
     if(empty($_POST[$f])){
       $errors[]= 'all fields compulsory';
       break;
     }
    }
    if(strlen($password) < 6){
      $errors[] = 'password must be atleast 6 characters';
    }

  if($password != $confirm){
    $errors[] = 'passwords do not match';
  }

  if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $errors[] = 'enter a valid email';
  }

    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      // add user to database
    $hashed = password_hash($password,PASSWORD_DEFAULT);
    $db->query("INSERT INTO users (full_name,email,password,permissions) Values ('$name','$email','$hashed','$permissions')");
     $_SESSION['success_flash'] = 'Users has been added';
      header('Location: users.php');
    }
  }
   ?>
    <h2 class="text-center">Add a New User</h2><hr>
    <form action="users.php?add=1" method="post">
      <div class="form-group col-md-6">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
      </div>
      <div class="form-group col-md-6">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
      </div>
      <div class="form-group col-md-6">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
      </div>
      <div class="form-group col-md-6">
        <label for="confirm">Confirm Password:</label>
        <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
      </div>
      <div class="form-group col-md-6">
        <label for="name">Permissions: </label>
        <select class="form-control" name="permissions">
            <option value=""<?=(($permissions == '')?' selected':'');?>></option>
            <option value="editor"<?=(($permissions == 'editor')?' selected':'');?>>Editor</option>
            <option value="admin,editor"<?=(($permissions == 'admin,editor')?' selected':'');?>>Admin</option>
        </select>
      </div>
      <div class="form-group col-md-6 text-right" style="margin-top:25px;">
        <a href="users.php" class="btn btn-default">Cancel</a>
        <input type="submit" value="Add User" class="btn btn-primary">
      </div>
    </form>
   <?php
}else {

$userQuery = $db->query("SELECT * FROM users ORDER BY full_name");
//echo $_SESSION['SBUser'];
?>
<h2>Users</h2>
<a href="users.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add new user</a>
<hr>
<table class="table table-bordered table-striped table-condensed">
  <thead><th></th><th>Name</th><th>Email</th><th>Join Date</th><th>Last Login</th><th>Permissions</th></thead>
  <tbody>
    <?php while($user = mysqli_fetch_assoc($userQuery)):?>
    <tr>
     <td>
      <?php if($user['id'] != $user_data['id']): ?>
        <a href="users.php?delete=<?=$user['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
      <?php endif;?>
     </td>
     <td><?=$user['full_name'];?></td>
     <td><?=$user['email'];?></td>
     <td><?=pretty_date($user['join_date']);?></td>
     <td><?=(($user['last_login'] == '0000-00-00 00:00:00')?'Never':pretty_date($user['last_login']));?></td>
     <td><?=$user['permissions'];?></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<?php }
include 'includes/footer.php';
 ?>
