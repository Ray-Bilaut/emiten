<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <?php $cache = ENVIRONMENT == 'production' ? getenv('APP_VERSION') : date('dmYHi'); ?>

  <link rel="shortcut icon" href="<?php echo base_url('assets/favicon.png') ?>" />

  <!-- <link rel="shortcut icon" href="<?php echo base_url('favicon.ico?r=' . $cache) ?>" type="image/x-icon">
  <link rel="icon" href="<?php echo base_url('favicon.ico?r=' . $cache) ?>" type="image/x-icon"> -->

  <?php if (empty($metatag)) : ?>
    <title><?= $meta_title ?></title>
    <meta name='description' content='<?= $meta_desc ?>'>
    <meta name='keyword' content='<?= $meta_keyword ?>'>
    <meta name='image' content='<?= $meta_image ?>'>
  <?php else : ?>
    <?= $metatag ?>
  <?php endif; ?>

  <?php if (isset($meta_og)) {
    echo $meta_og;
  } else { ?>
    <!-- <meta property="og:url"                content="https://emitennews.com/" />
    <meta property="og:type"               content="website" />
    <meta property="og:title"              content="Emitennews.com - Salam Market dan Update" />
    <meta property="og:description"        content="Menyajikan industri pasar modal sebagai menu utama. Bersumber dari regulator, emiten, perusahaan sekuritas, pelaku pasar, dan sumber kredibel lainnya." />
    <meta property="og:image"              content="https://emitennews.com/assets/images/logo.png" /> -->
  <?php } ?>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
  <link href="<?php echo base_url(); ?>assets/libs/slick/slick.css" rel="stylesheet" type="text/css" media="all">
  <link href="<?php echo base_url(); ?>assets/libs/slick/slick-theme.css" rel="stylesheet" type="text/css" media="all">
  <link href="<?php echo base_url(); ?>assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
  <link href="<?php echo base_url(); ?>assets/libs/material-icons/material-icons.css" rel="stylesheet" type="text/css" media="all">
  <link href="<?php echo base_url(); ?>assets/libs/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" media="all">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,700;1,100;1,300&display=swap" rel="stylesheet">
  <!-- Google Adsense Identifier  -->
  <?php if (ENVIRONMENT == 'development') : ?>
    <script data-ad-client="ca-pub-3401639475811685" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <?php else : ?>
    <script data-ad-client="ca-pub-1508023122152906" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <?php endif; ?>

  <?php if (ENVIRONMENT == 'development') : ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') . '?r=' . $cache; ?>">
  <?php else : ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.min.css') . '?r=' . $cache; ?>">
  <?php endif; ?>

  <?php echo $styles ?>

</head>

<body class="dual-theme">

  <header>

    <div class="content-index-header">
      <marquee behavior="scroll" direction="left" scrollamount="5" loop="10">
        <div class="list-index-header">
          <?php for ($i = 0; $i < count($stocks); $i++) : ?>
            <div class="item-index-header">
              <h1 class="<?php echo $stocks[$i]->colorstatus ?>"><?php echo $stocks[$i]->name ?></h1>
              <p class="<?php echo $stocks[$i]->colorstatus ?>"><i class="<?php echo $stocks[$i]->icon ?>"></i> &nbsp;<?php echo $stocks[$i]->change_percent_formatted ?>%</p>
            </div>
          <?php endfor; ?>
        </div>
      </marquee>
    </div>

    <div class="menu-container dual-theme">
      <div class="row-header">
        <?php if (!$login) { ?>
          <div class="header-register"><a class="analytic-listener" data-label="register_tap" href="<?php echo site_url('register') ?>">Register</a></div>
          <div class="header-login"><a class="analytic-listener" data-label="login_tap" href="<?php echo site_url('login') ?>">Login </a></div>
        <?php } else { ?>
          <div class="header-register"><a class="analytic-listener" data-label="profile_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo site_url('profile') ?>">Hai, <?php echo $user->name ?></a></div>
          <div class="header-login"><a class="analytic-listener" data-label="logout_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo site_url('login/logout') ?>"> Logout </a></div>
        <?php } ?>
      </div>

      <button class="toggle-mobile" type="button"><i class="fa fa-bars"></i></button>

      <ul class="menu-top dual-theme">
        <li class="<?php if ($this->uri->segment(1) == "podcast") {
                      echo "active";
                    } ?> item-menu-top"><a class="analytic-listener" data-label="stolk_podcast_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo site_url('podcast') ?>">Stolk Podcast</a></li>
        <li class="<?php if ($this->uri->segment(1) == "tag/emiten-academy") {
                      echo "active";
                    } ?> disabled item-menu-top"><a class="analytic-listener" data-label="emiten_academy_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('tag/emiten-academy') ?>">Emiten Academy</a><span>Soon</span></li>
        <div class="logo only-desktop dual-theme">
          <a class="analytic-listener" data-label="emitennews_logo_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo site_url('') ?>">
            <img src="<?php echo base_url('assets/images/logo.png') ?>" alt="emitennews-logo">
          </a>
        </div>

        <li class="<?php if ($this->uri->segment(1) == "expert") {
                      echo "active";
                    } ?> item-menu-top"><a class="analytic-listener" data-label="expert_views_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo site_url('expert') ?>">Expert Views</a></li>
        <li class="<?php if ($this->uri->segment(1) == "tag/literasi-keuangan") {
                      echo "active";
                    } ?> disabled item-menu-top"><a class="analytic-listener" data-label="financial_literacy_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('tag/literasi-keuangan') ?>">Financial Literacy</a><span>Soon</span></li>
        <li>
          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-secondary" id="btn-dark" onclick="setDarkMode(true)">
              <input type="radio" name="options" id="dark-mode-on" autocomplete="off"> Dark
            </label>
            <label class="btn btn-outline-secondary" id="btn-light" onclick="setDarkMode(false)">
              <input type="radio" name="options" id="dark-mode-off" autocomplete="off"> Light
            </label>
          </div>
        </li>
        <!-- <li><button onclick="myFunction()">Toggle dark mode</button></li> -->
      </ul>

      <div class="logo only-mobile">
        <a class="analytic-listener" data-label="emitennews_logo_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo site_url('') ?>">
          <img src="<?php echo base_url('assets/images/logo.png') ?>" alt="emitennews-logo">
        </a>
      </div>
      <!-- <div class="search-mobile dual-theme only-mobile">
          <form class="form-search" method="POST">
            <input type="text" name="keyword" placeholder="Cari Berita">
            <button><i class="fa fa-search"></i></button>
          </form>
        </div> -->
      <div class="menu-list dual-theme">
        <ul class="menu">
          <li class="<?php if ($this->uri->segment(1) == '') {
                        echo "active";
                      } ?> item-menu-down"><a class="analytic-listener" data-label="home_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo site_url('') ?>"><i class="fas fa-home"></i>&nbsp; Beranda</a></li>
          <?php foreach ($menus as $menu) : ?>
            <li class="<?php if ($this->uri->segment(2) == $menu->slug_url) {
                          echo "active";
                        } ?> item-menu-down"><a class="analytic-listener" data-label="category_tap" data-attr="{'user_name':'<?php echo empty($user->name) ? '' : $user->name ?>', 'category_title':'<?php echo $menu->title ?>'}" href="<?php echo site_url('category/' . $menu->slug_url) ?>"><?php echo $menu->title ?></a></li>
          <?php endforeach; ?>
          <li class="item-menu-down">
            <form class="form-search" method="POST">
              <input type="text" name="keyword" placeholder="Cari Berita">
              <button id="search-button"><i class="fa fa-search"></i></button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </header>

  <div class="container">
    <section id="body">
      <div class="body-content dual-theme">
        <?php echo $content ?>
      </div>
      <div id="bgblack" class="bgblack">
        <div id="close-popup" class="btn-close"><i class="fas fa-times"></i></div>
      </div>
    </section>
  </div>

  <footer class="dual-theme">
    <div class="container-footer">

      <!-- PARTNER -->
      <div class="logo-footer">
        <img src="<?php echo base_url('assets/images/logo.png') ?>" alt="emitennews-logo">

        <div class="logo-partner">
          <small><strong>Partner kami :</strong></small>
          <div class="image-partner">
            <a class="analytic-listener" data-label="kemenkeu_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="https://www.kemenkeu.go.id/" target="_BLANK">
              <img src="<?php echo base_url('assets/images/kementrian-keuangan.png') ?>" alt="kementrian-keuangan">
            </a>
          </div>
          <div class="image-partner">
            <a class="analytic-listener" data-label="bi_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="https://www.bi.go.id/id/default.aspx" target="_BLANK">
              <img src="<?php echo base_url('assets/images/bank-indonesia.png') ?>" alt="bank-indonesia">
            </a>
          </div>
          <div class="image-partner">
            <a class="analytic-listener" data-label="ojk_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="https://www.ojk.go.id/id/Default.aspx" target="_BLANK">
              <img src="<?php echo base_url('assets/images/ojk.png') ?>" alt="ojk">
            </a>
          </div>
          <!-- <div class="image-partner">
              <img src="<?php echo base_url('assets/images/dewan-pers.png') ?>" alt="dewan-pers">
            </div> -->

          <div class="image-partner">
            <a class="analytic-listener" data-label="idx_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="https://idx.co.id/" target="_BLANK">
              <img src="<?php echo base_url('assets/images/bursa-efek.png') ?>" alt="bursa-efek">
            </a>
          </div>
          <div class="image-partner">
            <a class="analytic-listener" data-label="kpei_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="https://www.kpei.co.id/" target="_BLANK">
              <img src="<?php echo base_url('assets/images/kpei_new.png') ?>" alt="kpei">
            </a>
          </div>
          <div class="image-partner">
            <a class="analytic-listener" data-label="ksei_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="https://www.ksei.co.id/" target="_BLANK">
              <img src="<?php echo base_url('assets/images/ksei-1.png') ?>" alt="ksei">
            </a>
          </div>
        </div>
      </div>
      <!-- END PARTNER -->

      <div class="row-footers">
        <div class="list-footer dual-theme">
          <h1>Emiten News</h1>
          <p><a href="<?php echo site_url('podcast') ?>">Stolk Podcast</a></p>
          <p><a>Emiten Academy</a><span>Soon</span></p>
          <p><a href="<?php echo site_url('expert') ?>">Expert Views</a></p>
          <p><a>Financial Literacy</a><span>Soon</span></p>
        </div>
        <div class="list-footer dual-theme">
          <h1>Rubrikasi</h1>
          <?php foreach ($menus as $menu) : ?>
            <p><a href="<?php echo site_url('category/' . $menu->slug_url) ?>"><?php echo $menu->title ?></a></p>
          <?php endforeach; ?>
        </div>
        <div class="list-footer dual-theme">
          <h1>Info</h1>
          <p><a href="<?php echo site_url('aboutus') ?>">Tentang Kami</a></p>
          <p><a href="<?php echo site_url('ourteam') ?>">Tim Kami</a></p>
          <p><a href="<?php echo site_url('mediaguide') ?>">Pedoman Media Siber</a></p>
          <p><a href="<?php echo site_url('adinfo') ?>">Info Iklan</a></p>
        </div>
        <div class="list-footer dual-theme">
          <h1>Sosial Media</h1>
          <div class="row-footer">
            <div class="footer-media">
              <a href="https://www.instagram.com/emitennews/" target="_BLANK">
                <img src="<?php echo base_url('assets/images/instagram.png') ?>" alt="">
              </a>
            </div>
            <div class="footer-media">
              <a href="https://twitter.com/emitennews" target="_BLANK">
                <img src="<?php echo base_url('assets/images/twitter.png') ?>" alt="">
              </a>
            </div>
            <div class="footer-media">
              <a href="https://www.facebook.com/Emiten-News-1015422588659117" target="_BLANK">
                <img src="<?php echo base_url('assets/images/facebook.png') ?>" alt="">
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $subscribe_bottom ?>

    <div class="copyright dual-theme">
      <p>Copyright 2017 - <?= date('Y') ?> &copy;<a href="http://emitennews.com"> EmitenNews.com</a></p>
      <p>All Right Reserved</p>
    </div>
  </footer>

  <script type="text/javascript">
    var baseurl = '<?php echo base_url() ?>';
    var debug = <?php echo ENVIRONMENT == 'production' ? 0 : 1 ?>;
  </script>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
  <script src="<?php echo base_url(); ?>assets/libs/slick/slick.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/libs/sweetalert/sweetalert.js"></script>

  <!-- The core Firebase JS SDK is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js"></script>

  <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-messaging.js"></script>

  <!-- TODO: Add SDKs for Firebase products that you want to use
      https://firebase.google.com/docs/web/setup#available-libraries -->
  <script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-analytics.js"></script>

  <?php if (ENVIRONMENT == 'development') : ?>
    <script src="<?php echo base_url('assets/js/firebase-setup-dev.js') . '?r=' . $cache; ?>"></script>
    <script src="<?php echo base_url('assets/js/fcm.js') . '?r=' . $cache; ?>"></script>
    <script src="<?php echo base_url('assets/js/script.js') . '?r=' . $cache; ?>"></script>
  <?php else : ?>
    <script src="<?php echo base_url('assets/js/firebase-setup-prod.min.js') . '?r=' . $cache; ?>"></script>
    <script src="<?php echo base_url('assets/js/fcm.min.js') . '?r=' . $cache; ?>"></script>
    <script src="<?php echo base_url('assets/js/script.min.js') . '?r=' . $cache; ?>"></script>
  <?php endif; ?>


  <?php echo $scripts ?>

  <?php if (ENVIRONMENT == 'production') : ?>

    <!-- Google Tag Manager -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-192009872-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());

      gtag('config', 'UA-192009872-1');
    </script>


  <?php endif; ?>

</body>

</html>