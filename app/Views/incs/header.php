<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <base href="<?= base_url('/') ?>">

    <title>ZenBlog :: <?= $title ?? ''; ?></title>
    <meta content="<?= $description ?? ''; ?>" name="description">
    <meta content="<?= $keywords ?? ''; ?>" name="keywords">

    <!-- Favicons -->
    <link rel="icon" href="<?= base_url('/images/framework.png'); ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap"
          rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url('/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/vendor/aos/aos.css') ?>" rel="stylesheet">

    <!-- Template Main CSS Files -->
    <link href="<?= base_url('/assets/css/variables.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/css/main.css') ?>" rel="stylesheet">

    <!-- =======================================================
    * Template Name: ZenBlog
    * Updated: Sep 18 2023 with Bootstrap v5.3.2
    * Template URL: https://bootstrapmade.com/zenblog-bootstrap-blog-template/
    * Author: BootstrapMade.com
    * License: https:///bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="<?= base_url('/'); ?>" class="logo d-flex align-items-center">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1>ZenBlog</h1>
        </a>

        <nav id="navbar" class="navbar">
            <?php $categories = app()->get('categories', []); ?>
            <ul>
                <li><a href="<?= base_url('/'); ?>">Blog</a></li>
                <li class="dropdown"><a><span>Categories</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <?php foreach ($categories as $category): ?>
                            <li><a href="<?= base_url("/category/{$category['slug']}")?>"><?= $category['title']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li><a href="<?= base_url('/about'); ?>">About</a></li>
                <li><a href="<?= base_url('/contact'); ?>">Contact</a></li>
                <li class="dropdown"><a><span>Cabinet</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <?php if (check_auth()): ?>
                            <li><a href="#">Hello, <?= session()->get('user')['name']; ?></a></li>
                            <li><a href="<?= base_url('/logout'); ?>">Logout</a></li>
                        <?php else: ?>
                            <li><a href="<?= base_url('/register'); ?>">Register</a></li>
                            <li><a href="<?= base_url('/login'); ?>">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li><a href="<?= base_url('/admin'); ?>">Admin</a></li>
            </ul>
        </nav><!-- .navbar -->

        <div class="position-relative">
            <a href="#" class="mx-2"><span class="bi-facebook"></span></a>
            <a href="#" class="mx-2"><span class="bi-twitter"></span></a>
            <a href="#" class="mx-2"><span class="bi-instagram"></span></a>

            <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
            <i class="bi bi-list mobile-nav-toggle"></i>

            <!-- ======= Search Form ======= -->
            <div class="search-form-wrap js-search-form-wrap">
                <form action="<?= base_url('/search'); ?>" class="search-form">
<!--                    <span class="icon bi-search"></span>-->
                    <button class="btn js-search-btn" type="submit"><span class="icon bi-search"></span></button>
                    <input name="s" type="text" placeholder="Search" class="form-control">

                    <button class="btn js-search-close"><span class="bi-x"></span></button>
                </form>
            </div><!-- End Search Form -->

        </div>

    </div>

</header><!-- End Header -->
