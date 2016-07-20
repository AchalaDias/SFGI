<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="refresh" content="600">

        <link rel="icon" href="images\hnb.jpg">

        <title>@yield('page_title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
         <!-- <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}">   -->
         <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
      <!--  <link rel="stylesheet" href="https://bootswatch.com/flatly/bootstrap.css"> -->
        <!-- Font Awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="css/ionicons.min.css">
        <!-- jvectormap -->
        <!-- <link rel="stylesheet" href="{{URL::asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}"> -->
        <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- <link rel="stylesheet" href="{{URL::asset('plugins/datatables/dataTables.bootstrap.css')}}"> -->
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <!-- Theme style -->
        <!-- <link rel="stylesheet" href="{{URL::asset('dist/css/AdminLTE.min.css')}}"> -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- <link rel="stylesheet" href="{{URL::asset('Chart.js-master/chart.css')}}"> -->
        <link rel="stylesheet" href="Chart.js-master/chart.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
folder instead of downloading all of them to reduce the load. -->
        <!-- <link rel="stylesheet" href="{{URL::asset('dist/css/skins/_all-skins.min.css')}}"> -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <!-- <link rel="stylesheet" href="{{URL::asset('plugins/datepicker/datepicker3.css')}}"> -->
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
        @yield('css')
 
    </head>
    <body class="hold-transition skin-blue sidebar-collapse">
        <div class="wrapper">

            <header class="main-header">

                <!-- Logo -->
                <a href="home" class="logo" style="background-color: white">
                    <!-- mini logo for sidebar mini 50x50 pixels -->

                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg" style="color:#000000;">
                        <img src="images/logo.png" class="" style="">
                    </span>
                </a>
                
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">


                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li style="border:0px solid black;padding:10px;">
                                <button type="button" onclick="home()" class="btn btn-block btn-info btn-sm" style=""><i class="fa fa-home" aria-hidden="true" style="font-size:13px">&nbsp;Home</i></button>
                            </li>
                            <li style="border:0px solid black;padding:10px;">
                                <!-- <input type="button" onclick="training()" class="btn btn-block btn-info btn-md" style="margin:10%" value="Training"> -->
                                <button id="training-button" type="button" onclick="training()" class="btn btn-block btn-info btn-sm" style=""><i class="fa fa-certificate" aria-hidden="true" style="font-size:13px">&nbsp;Training</i></button>
                            </li>
                            <li style="border:0px solid black;padding:10px;">
                                <button type="button" onclick="logout()" class="btn btn-block btn-danger btn-sm"><i class="fa fa-sign-out" aria-hidden="true" style="font-size:13px">&nbsp;logout</i></button>
                            </li>
                        </ul>
                        <!-- <ul class="nav navbar-nav"> -->
                            <!-- <li style="border:0px solid black;padding:10px;"> -->
                                <!-- <button type="button" onclick="logout()" class="btn btn-block btn-info btn-sm">Sign out</button> -->
                            <!-- </li> -->
                            <!-- <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="images/user.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><b><?php //echo $_SESSION['USER_ROLE'];?></b></span>
                                </a>
                                <ul class="dropdown-menu">
                                    
                                    <li class="user-footer">
                                        
                                        <div class="pull-right">
                                            <a href="#" onclick="logout()" class="btn btn-primary btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li> -->
                        <!-- </ul> -->
                    </div>

                </nav>

            </header>
            <script>
            <?php
    if(isset($_SESSION['USER_ROLE'])){

        if($_SESSION['USER_ROLE']=="ADVISOR"){
?>
     
            document.getElementById('training-button').style.display='block';
            
<?php
        }else if($_SESSION['USER_ROLE']!="ADVISOR"){
?>
          
            document.getElementById('training-button').style.display='block';
        
<?php
        }
    }
?>
                function training(){
                    window.location.href="trainingcategory";
                }
                function home(){
                    window.location.href="home";
                }
            </script>
            <!-- Left side column. contains the logo and sidebar -->

<script>
    function logout(){
        $.ajax({
            type:'get',
            url:'logout',
            success:function(data){
                // console.log(data);
                // alert(data);
                window.location.href="login";
            },
            error:function(x,y,z){
                console.log(z);
            }

        });

    }
</script>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">

                    @yield('page_header')
                    <!--<h1>
                            Dashboard
                                <small>Version 2.0</small> 
                        </h1> -->

                </section>

                <!-- Main content -->
                <section class="content">
                    
                    @yield('content')
             
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                 
                </div>
                <strong>Copyright &copy; {{date('Y')}} <a href="http://sf.hnbgeneral.com/">HNBGI IT DIVISION</a>.</strong> All rights
                reserved.
            </footer>

            <!-- Control Sidebar -->
             <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>

        </div>
        <!-- ./wrapper -->

        <!-- jQuery 2.2.0 -->


        <script src="upgraded_theme/plugins/chartjs/Chart.js"></script>


        <script src="upgraded_theme/plugins/jQuery/jQuery-2.2.0.min.js"></script>

        <!-- Bootstrap 3.3.6 -->
        

        <script src="upgraded_theme/bootstrap/js/bootstrap.min.js"></script>

        <!-- FastClick -->
        

        <script src="upgraded_theme/plugins/fastclick/fastclick.js"></script>

        <!-- AdminLTE App -->
        

        <script src="upgraded_theme/dist/js/app.min.js"></script>

        <!-- Sparkline -->
        

        <script src="upgraded_theme/plugins/sparkline/jquery.sparkline.min.js"></script>

        <!-- jvectormap -->
        

        <script src="upgraded_theme/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>

        

        <script src="upgraded_theme/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

        <!-- SlimScroll 1.3.0 -->
        

        <script src="upgraded_theme/plugins/slimScroll/jquery.slimscroll.min.js"></script>

        <!-- ChartJS 1.0.1 -->
        

        <script src="upgraded_theme/plugins/chartjs/Chart.min.js"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

        <script src="upgraded_theme/dist/js/pages/dashboard2.js"></script>

        <!-- AdminLTE for demo purposes -->
       

        <script src="upgraded_theme/dist/js/demo.js"></script>


        @yield('js')
        <link rel="stylesheet" type="text/css" href="bootstrap-sweetalert-master/lib/sweet-alert.css">
        <script type="text/javascript" src="bootstrap-sweetalert-master/lib/sweet-alert.min.js"></script>
    </body>
</html>
