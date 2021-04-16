<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/png" sizes="16x16" href="<?php echo base_url() ?>assets/images/favicon/favicon-16x16.png">
  <title>Administrator Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/') ?>dist/css/skins/skin-red.min.css">

   <!-- JQuery UI -->
  <link href="<?php echo base_url(); ?>assets/libs/jqueryui/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all">
  <link href="<?php echo base_url(); ?>assets/libs/jqueryui/jquery-ui.theme.min.css" rel="stylesheet" type="text/css" media="all">
  <link href="<?php echo base_url(); ?>assets/libs/jqueryui/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" media="all">

  <?php echo $styles ?>
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url(ADMIN_URL) ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Ad</b>min</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b> Page</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <a href="<?php echo base_url(ADMIN_URL.'/auth/logout') ?>" alt="keluar" title="keluar"> Hi, <?php echo $user->username;?> &nbsp <i class="fa fa-sign-out"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <?php if ($user->group < 3) { ?>
        <li class="<?php echo $this->router->class=='dashboard' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php } ?>

        <?php if ($user->group < '3') { ?>
        <li class="treeview <?php echo $this->router->class=='news' || $this->router->class=='highlight' || $this->router->class=='trending' || $this->router->class=='recommendation' ? 'active' : '' ?>">
          <!-- <a href="<?php echo site_url('webadmin/setting') ?>"> -->
          <a href="<?php echo site_url(ADMIN_URL.'/news') ?>">
            <i class="fa fa-newspaper-o"></i>
            <span>News</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="<?php echo $this->router->class=='news' ? 'active' : '' ?>">
              <a href="<?php echo site_url(ADMIN_URL.'/news') ?>">
                <i class="fa fa-newspaper-o"></i> <span>All News</span>
              </a>
            </li>

            <li class="<?php echo $this->router->class=='highlight' ? 'active' : '' ?>">
              <a href="<?php echo site_url(ADMIN_URL.'/highlight') ?>">
                <i class="fa fa-flag"></i> <span>Highlight</span>
              </a>
            </li>

            <li class="<?php echo $this->router->class=='recommendation' ? 'active' : '' ?>">
              <a href="<?php echo site_url(ADMIN_URL.'/recommendation') ?>">
                <i class="fa fa-thumbs-up"></i> <span>Recommendation</span>
              </a>
            </li>

            <li class="<?php echo $this->router->class=='trending' ? 'active' : '' ?>">
              <a href="<?php echo site_url(ADMIN_URL.'/trending') ?>">
                <i class="fa fa-line-chart"></i> <span>Trending</span>
              </a>
            </li>

          </ul>
        </li>
        <?php } ?>

        <?php if ($user->group == '3' || $user->group == '4') { ?>
        <li class="<?php echo $this->router->class=='newsreporter' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/newsreporter') ?>">
            <i class="fa fa-copy"></i> <span>News</span>
          </a>
        </li>
        <?php } ?>

        <?php if ($user->group < '3') { ?>
        <li class="<?php echo $this->router->class=='infographic' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/infographic') ?>">
            <i class="fa fa-info-circle"></i> <span>Infographic</span>
          </a>
        </li>
        <?php } ?>

        <?php if ($user->group < '3') { ?>
        <li class="<?php echo $this->router->class=='podcast' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/podcast') ?>">
            <i class="fa fa-microphone"></i> <span>Podcast</span>
          </a>
        </li>
        <?php } ?>

        <?php if ($user->group < '3') { ?>
        <li class="<?php echo $this->router->class=='ads' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/ads') ?>">
            <i class="fa fa-bullhorn"></i> <span>Ads</span>
          </a>
        </li>
        <?php } ?>

        <?php if ($user->group < '3') { ?>
        <li class="<?php echo $this->router->class=='expert' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/expert') ?>">
            <i class="fa fa-users"></i> <span>Expert</span>
          </a>
        </li>
        <?php } ?>

        <!-- <?php if ($user->group < '3') { ?>
        <li class="<?php echo $this->router->class=='category' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/category') ?>">
            <i class="fa fa-list-ul"></i> <span>Category</span>
          </a>
        </li>
        <?php } ?> -->

        <!-- <?php if ($user->group < '3') { ?>
        <li class="<?php echo $this->router->class=='video' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/video') ?>">
            <i class="fa fa-youtube"></i> <span>Video</span>
          </a>
        </li>
        <?php } ?> -->

        <!-- <li class="<?php echo $this->router->class=='author' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/author') ?>">
            <i class="fa fa-pencil"></i> <span>Author</span>
          </a>
        </li> -->

        <?php if ($user->group < '3') { ?>
        <li class="<?php echo $this->router->class=='tags' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/tags') ?>">
            <i class="fa fa-tags"></i> <span>Tags</span>
          </a>
        </li>
        <?php } ?>

        <?php if ($user->group < '3') { ?>
        <li class="<?php echo $this->router->class=='comment' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/comment') ?>">
            <i class="fa fa-comments"></i> <span>Comment</span>
          </a>
        </li>
        <?php } ?>

        <?php if ($user->group < '3') { ?>
        <li class="<?php echo $this->router->class=='notification' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/notification') ?>">
            <i class="fa fa-bell"></i> <span>Notification</span>
          </a>
        </li>
        <?php } ?>

        <?php if ($user->group < '3') { ?>
        <li class="<?php echo $this->router->class=='badword' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/badword') ?>">
            <i class="fa fa-ban"></i> <span>Badword</span>
          </a>
        </li>
        <?php } ?>

        <li class="<?php echo $this->router->class=='profile' ? 'active' : '' ?>">
          <a href="<?php echo site_url(ADMIN_URL.'/profile') ?>">
            <i class="fa fa-id-card"></i> <span>Profile</span>
          </a>
        </li>

        <?php if ($user->group == '1') { ?>
        <li class="treeview <?php echo $this->router->class=='setting' || $this->router->class=='admin' ? 'active' : '' ?>">
          <a href="<?php echo site_url('webadmin/setting') ?>">
            <i class="fa fa-gear"></i>
            <span>Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <?php if($user->group!=3): ?>
              <li class="<?php echo $this->router->class=='admin' && $this->router->method=='index' ? 'active' : '' ?>"><a href="<?php echo site_url(ADMIN_URL.'/admin') ?>"><i class="fa fa-circle-o"></i> Admin</a></li>
            <?php endif; ?>

          </ul>
        </li>
        <?php } ?>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $page_title ?>
        <small><?php echo $page_subtitle ?></small>
      </h1>
      
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    
    </section>

    <!-- Main content -->
    <section class="content">
      
      <?php echo $content ?>
    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- <footer class="main-footer">
    <div class="pull-right hidden-xs"></div>
    <strong><a href="<?php echo base_url() ?>">Administrator Page</a></strong>
  </footer> -->

</div>
<!-- ./wrapper -->

<script type="text/javascript">
var baseurl = '<?php echo base_url(ADMIN_URL.'/'); ?>';
</script>

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- tinymce -->
<script src="<?php echo base_url(); ?>assets/libs/tinymce/tinymce.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/adminlte/') ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/adminlte/') ?>dist/js/adminlte.min.js"></script>

<!-- Jquery UI -->
<script src="<?php echo base_url(); ?>assets/libs/jqueryui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jqueryui/jquery-ui-timepicker-addon.js"></script>

<script src="<?php echo base_url('assets/js/webtools.js?v='.date('U')) ?>"></script>

<?php echo $scripts; ?>

</body>
</html>
