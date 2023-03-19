<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

   {{-- Favicon --}}
   <link rel="icon" type="image/png" href="{{asset('favicon.png')}}">
   <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon" >

  {{-- CSS Header --}}
  @include('backoffice.inc.cssheader')
  {{--- End CSS Header --}}

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  {{-- ======= Header ======= --}}
  <header id="header" class="header fixed-top d-flex align-items-center">

    {{-- header logo --}}
     @include('backoffice.inc.headerlogo')
    {{--- End Header logo --}}

    {{-- search bar  --}}
    @include('backoffice.inc.search')
    {{-- End Search Bar --}}

    {{-- Nav Bar Menu   --}}
    @include('backoffice.inc.navbarmenu')
    {{-- End Nav Bar Menu --}}

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('backoffice.inc.sidebarmenu')
  <!-- End Sidebar-->

  <main id="main" class="main">
        {{--  Page Title --}}
        @include('backoffice.inc.pagetitle') 
        {{-- End Page Title --}}
        {{--  Page Contents --}}
        @yield('contents')
        {{--  End Page Contents --}}
    
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
       @include('backoffice.inc.footer') 
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  {{-- Vendor JS Footer Files --}}
      @include('backoffice.inc.jsfooter') 
  {{--  End Js footer --}}
</body>

</html>