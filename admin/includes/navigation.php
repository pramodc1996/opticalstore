<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="/tutorial/admin/index.php" class="navbar-brand">OpTiCo's Admin</a>
    <ul class="nav navbar-nav">
      <!--MENU ITEMS-->
      <li><a href="brands.php">Brands</a></li>
      <li><a href="categories.php">categories</a></li>
            <li><a href="products.php">products</a></li>
            <?php if(has_permission('admin')): ?>
            <li><a href="users.php">Users</a></li>
          <?php endif; ?>
          <li class="dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?=$user_data['first'];?>!
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="change_password.php">Change password</a></li>
              <li><a href="logout.php">Log out</a></li>
            </ul>
          </li>
    <!--  <li class="dropdown">
        <a href="#" class ="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category'] ?><span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
                  <li><a href="#" ></a></li>
        </ul>
     </li>-->
    </ul>
  </div>
</nav>
