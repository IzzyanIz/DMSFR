<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>ADMIN</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="{{ asset('template/images/fevicon.png') }}" type="image/png" />

      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}" />

      <!-- site css -->
      <link rel="stylesheet" href="{{ asset('template/style.css') }}" />

      <!-- responsive css -->
      <link rel="stylesheet" href="{{ asset('template/css/responsive.css') }}" />

      <!-- color css -->
      <link rel="stylesheet" href="{{ asset('template/css/colors.css') }}" />

      <!-- select bootstrap -->
      <link rel="stylesheet" href="{{ asset('template/css/bootstrap-select.css') }}" />

      <!-- scrollbar css -->
      <link rel="stylesheet" href="{{ asset('template/css/perfect-scrollbar.css') }}" />

      <!-- custom css -->
      <link rel="stylesheet" href="{{ asset('template/css/custom.css') }}" />

      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            @include('template/sidebarAdmin')
            <!-- right content -->
            <div id="content">
               @include('template/navbar')
               <!-- dashboard inner -->
               <div class="midde_cont">
                  <div class="container-fluid">
                  <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>@yield('title')</h2>
                           </div>
                        </div>
                     </div>
                     @yield('section')
                  </div>
               </div>
                  </div>
               </div>

            </div>
         </div>
      </div>
     <!-- jQuery -->
      <script src="{{ asset('template/js/jquery.min.js') }}"></script>
      <script src="{{ asset('template/js/popper.min.js') }}"></script>
      <script src="{{ asset('template/js/bootstrap.min.js') }}"></script>

      <!-- wow animation -->
      <script src="{{ asset('template/js/animate.js') }}"></script>

      <!-- select country -->
      <script src="{{ asset('template/js/bootstrap-select.js') }}"></script>

      <!-- owl carousel -->
      <script src="{{ asset('template/js/owl.carousel.js') }}"></script> 

      <!-- chart js -->
      <script src="{{ asset('template/js/Chart.min.js') }}"></script>
      <script src="{{ asset('template/js/Chart.bundle.min.js') }}"></script>
      <script src="{{ asset('template/js/utils.js') }}"></script>
      <script src="{{ asset('template/js/analyser.js') }}"></script>

      <!-- nice scrollbar -->
      <script src="{{ asset('template/js/perfect-scrollbar.min.js') }}"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>

      <!-- custom js -->
      <script src="{{ asset('template/js/custom.js') }}"></script>
      <script src="{{ asset('template/js/chart_custom_style1.js') }}"></script>

   </body>
</html>