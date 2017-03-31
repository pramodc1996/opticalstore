<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tutorial/core/init.php';
include 'includes/head.php';
// $p = 'pramod14';
// $hashed = password_hash($p,PASSWORD_DEFAULT);
// echo $hashed;
$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();
?>

<style>
  body{
    background-image: url("/tutorial/images/headerlogo/glass2.jpg");
    background-size: 100vw 100vh ;
    background-attachment: fixed;
  }
</style>
<div id="login-form">
  <div>
  <?php
    if($_POST){
      //from validation
      if(empty($_POST['email']) || empty($_POST['password'])){
        $errors[] = 'all fields are compulsory';
      }

     // validate email
     if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
       $errors[]='enter a valid email';
     }

    //password is more than 6 charcters

    if(strlen($password) < 6){
      $errors[]='password must be atleast 6 charcters.';
    }

     // check if email exists in database
    $query = $db->query("SELECT * FROM users WHERE email='$email' ");
    $user = mysqli_fetch_assoc($query);
    $userCount = mysqli_num_rows($query);
    if($userCount < 1){
      $errors[]='email doesnt exist in our database';
    }

    if(!password_verify($password,$user['password'])){
      $errors[] = 'incorrect password please try again';
    }
      //check for errors
      if(!empty($errors)){
        echo display_errors($errors);
      }else{
        //to log user in
        $user_id=$user['id'];
       login($user_id);
      }
    }
   ?>
  </div>
  <h2 class="text-center">Login</h2><hr>
  <form action="login.php" method="post">
    <div class="from-group">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
    </div>
    <br>
    <div class="from-group">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
    </div><br>
    <div class="from-group">
      <input type="submit" class="btn btn-primary" value="Login">
    </div>
  </form>
  <p class="text-right"><a href="/tutorial/index.php" alt="home">Visit Site</a></p>
</div>

<?php include 'includes/footer.php';?>
