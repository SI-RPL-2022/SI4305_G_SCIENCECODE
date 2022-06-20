<!DOCTYPE html>
<html lang="en"
      dir="ltr">

    
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"
              content="IE=edge">
        <meta name="viewport"
              content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ScienceCode</title>

        <!-- Prevent the demo from appearing in search engines -->
        <meta name="robots"
              content="noindex">

        <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&amp;display=swap"
              rel="stylesheet">

        <!-- Preloader -->
        <link type="text/css"
              href="/vendor/spinkit.css"
              rel="stylesheet">

        <!-- Perfect Scrollbar -->
        <link type="text/css"
              href="/vendor/perfect-scrollbar.css"
              rel="stylesheet">

        <!-- Material Design Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <!-- Font Awesome Icons -->
        <link type="text/css"
              href="/css/fontawesome.css"
              rel="stylesheet">

        <!-- Preloader -->
        <link type="text/css"
              href="/css/preloader.css"
              rel="stylesheet">

        <!-- App CSS -->
        <link type="text/css"
              href="/css/app.css"
              rel="stylesheet">
         <script src="/vendor/jquery.min.js"></script>

    </head>

    <body class="layout-sticky-subnav layout-default ">

        <div class="preloader">
            <div class="sk-chase">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>

            <!-- <div class="sk-bounce">
    <div class="sk-bounce-dot"></div>
    <div class="sk-bounce-dot"></div>
  </div> -->

            <!-- More spinner examples at https://github.com/tobiasahlin/SpinKit/blob/master/examples.html -->
        </div>

        <!-- Header Layout -->
        <div class="mdk-header-layout js-mdk-header-layout">

            <!-- Header -->

            <div id="header"
                 class="mdk-header mdk-header--bg-dark bg-dark js-mdk-header mb-0"
                 data-effects="parallax-background waterfall"
                 data-fixed
                 data-condenses>
                <div class="mdk-header__bg">
                    <div class="mdk-header__bg-front"
                         style="background-image: url(/images/photodune-4161018-group-of-students-m.jpg);"></div>
                </div>
                <div class="mdk-header__content justify-content-center">

                    <div class="navbar navbar-expand navbar-dark-pickled-bluewood bg-transparent will-fade-background"
                         id="default-navbar"
                         data-primary>

                        <!-- Navbar Brand -->
                        <a href="/"
                           class="navbar-brand mr-16pt">
                            <!-- <img class="navbar-brand-icon" src="/images/logo/white-100@2x.png" width="30" alt="ScienceCode"> -->

                            <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                                <span class="avatar-title rounded bg-primary"><img src="https://drive.google.com/uc?id=1qSAfs_ZFI2-YBvaQGfpNj-zVYv3xEUME"
                                         alt="logo"
                                         class="img-fluid" /></span>

                            </span>

                            <span class="d-none d-lg-block">ScienceCode</span>
                        </a>


                        <ul class="nav navbar-nav ml-auto mr-0">
                            @if(!session()->has('user'))
                              <li class="nav-item">
                                  <a href="/auth/login"
                                     class="nav-link"
                                     data-toggle="tooltip"
                                     data-title="Login"
                                     data-placement="bottom"
                                     data-boundary="window"><i class="material-icons">lock_open</i>
                                     Login
                                   </a>
                              </li>
                              <li class="nav-item">
                                  <a href="/auth/register"
                                     class="btn btn-outline-white">
                                       Daftar
                                     </a>
                              </li>
                            @else
                              <li class="nav-item">
                                <div class="dropdown">
                                    <a href="#"
                                       class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                       data-toggle="dropdown">{{session()->get('user')->name}}</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="/dashboard"
                                           class="dropdown-item">Dashboard</a>
                                        <a href="/auth/do_logout"
                                           class="dropdown-item">Logout</a>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>

                    @if(Route::currentRouteName() == 'home')
                      <div class="hero container page__container text-center text-md-left py-112pt">
                          <h1 class="text-white text-shadow">Learn to Code</h1>
                          <p class="lead measure-hero-lead mx-auto mx-md-0 text-white text-shadow mb-48pt">Business, Technology and Creative Skills taught by industry experts. Explore a wide range of skills with our professional tutorials.</p>

                          <a href="/course"
                             class="btn btn-lg btn-white btn--raised mb-16pt">Cari Course</a>

                      </div>
                    @endif
                </div>
            </div>

            <!-- // END Header -->

            <!-- Header Layout Content -->
            @yield('content')
            <!-- // END Header Layout Content -->

            <!-- Footer -->

            <div class="bg-white border-top-2 mt-auto">
                <div class="container page__container page-section d-flex flex-column">
                    <p class="text-70 brand mb-24pt">
                        <img class="brand-icon"
                             src="/images/logo/black-70%402x.png"
                             width="30"
                             alt="ScienceCode"> ScienceCode
                    </p>
                    <p class="measure-lead-max text-50 small mr-8pt">ScienceCode is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard, Curriculum Management, Earnings and Reporting, ERP, HR, CMS, Tasks, Projects, eCommerce and more.</p>
                    <p class="mb-8pt d-flex">
                        <a href="#"
                           class="text-70 text-underline mr-8pt small">Terms</a>
                        <a href="#"
                           class="text-70 text-underline small">Privacy policy</a>
                    </p>
                    <p class="text-50 small mt-n1 mb-0">Copyright 2019 &copy; All rights reserved.</p>
                </div>
            </div>

            <!-- // END Footer -->

        </div>
        <!-- // END Header Layout -->

        <!-- jQuery -->
       

        <!-- Bootstrap -->
        <script src="/vendor/popper.min.js"></script>
        <script src="/vendor/bootstrap.min.js"></script>

        <!-- Perfect Scrollbar -->
        <script src="/vendor/perfect-scrollbar.min.js"></script>

        <!-- DOM Factory -->
        <script src="/vendor/dom-factory.js"></script>

        <!-- MDK -->
        <script src="/vendor/material-design-kit.js"></script>

        <!-- App JS -->
        <script src="/js/app.js"></script>

        <!-- Preloader -->
        <script src="/js/preloader.js"></script>

        <script>
            (function() {
                'use strict';
                var headerNode = document.querySelector('.mdk-header')
                var layoutNode = document.querySelector('.mdk-header-layout')
                var componentNode = layoutNode ? layoutNode : headerNode
                componentNode.addEventListener('domfactory-component-upgraded', function() {
                    headerNode.mdkHeader.eventTarget.addEventListener('scroll', function() {
                        var progress = headerNode.mdkHeader.getScrollState().progress
                        var navbarNode = headerNode.querySelector('#default-navbar')
                        navbarNode.classList.toggle('bg-transparent', progress <= 0.2)
                    })
                })
            })()
        </script>

    </body>


<!-- Mirrored from ScienceCode.humatheme.com/Demos/Fixed_Layout/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 25 Apr 2022 07:00:09 GMT -->
</html>