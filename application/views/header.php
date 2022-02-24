<!-- Logo -->
<a href="<?=base_url()?>" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
<!--  <span class="logo-mini"><b>M</b>F</span>
   logo for regular state and mobile devices 
  <span class="logo-lg"><b>My </b>Flow</span>-->
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="<?=base_url()?>assets/css/dist/img/user-employee2.jpg" class="user-image" alt="User Image" />
          <span class="hidden-xs"><?=$this->session->userdata('realname')?> </span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img src="<?=base_url()?>assets/css/dist/img/user-employee2.jpg" class="img-circle" alt="User Image" />
            <p>
              <?=$this->session->userdata('realname')?>
              <!-- <small>Member since Jun. 2016</small> -->
            </p>
          </li>
          <!-- Menu Body -->
          <!-- <li class="user-body">
            <div class="col-xs-4 text-center">
              <a href="#">Followers</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Sales</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Friends</a>
            </div>
          </li> -->
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
               <a href="<?=base_url()?>help" class="btn btn-default btn-flat">Help</a> 
            </div>
            <div class="pull-right">
              <a href="<?=base_url()?>auth/logout" class="btn btn-default btn-flat">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>