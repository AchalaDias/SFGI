
<link rel="stylesheet" href="animate.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
{{--<!-- Font Awesome -->--}}
<link rel="stylesheet" href="css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!-- iCheck -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="upgraded_theme/bootstrap/js/bootstrap.min.js"></script>
<!-- <script src="{{URL::asset('upgraded_theme/bootstrap/js/bootstrap.min.js')}}"></script> -->
<link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
<!-- Morris chart -->
<link rel="stylesheet" href="plugins/morris/morris.css">
<!-- jvectormap -->
<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<!-- Date Picker -->
<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
 
{{--sweet alerts--}}
<link rel="stylesheet" type="text/css" href="bootstrap-sweetalert-master/lib/sweet-alert.css">
<script type="text/javascript" src="bootstrap-sweetalert-master/lib/sweet-alert.min.js"></script>
<style>
    body{
        /*-webkit-filter: blur(5px);*/
        /*-moz-filter: blur(5px);*/
        /*-o-filter: blur(5px);*/
        /*-ms-filter: blur(5px);*/
        /*filter: blur(5px);*/
        display: flex;
        align-items: center;
        background-image: url("./images/admin_back.jpg");
        background-position: center;
        background-size: 100% 100%;
    }
    .login,.signup{
        padding: 10px;
        -webkit-border-radius:5px;
        -moz-border-radius:5px;
        border-radius:5px;
        background-color: #FFFFFF;
        -webkit-box-shadow: 0px 0px 42px -3px rgba(84,84,84,0.88);
        -moz-box-shadow: 0px 0px 42px -3px rgba(84,84,84,0.88);
        box-shadow: 0px 0px 42px -3px rgba(84,84,84,0.88);
        float: none;
        margin-left: auto;
        margin-right: auto;
    }
    .logo{
        margin-bottom:15px;
        float: none;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 0px;
        width:125px;
        height:125px;
        border:1px solid #EEEEEE;
    }

    .form-control{
        text-align: center;
    }
    .btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
</style>
{{--login div--}}
<div class="col-md-4 login animated swing" id="loginDiv" >
    <!-- <div class="col-md-4 logo">
        <img src="images/hnb.jpg" class="img-responsive">
    </div> -->
    <h4 style="text-align:center">Agent Image Uploader</h4>
    <div class="col-md-8" style="border:0px solid black">
        <form action="{{ URL::to('test_image_upload') }}" method="POST" enctype="multipart/form-data">
            
            <span class="btn btn-default btn-file" style="width:100%">
                Browse Image <input onchange="getImage(event)" type="file" class="" name="file" id="file" >
            </span>
            <!-- <input type="file" class="" name="file" id="file"> -->
            <input type="submit" class="btn btn-primary btn-sm pull-right" value="Submit" name="submit" style="margin-top:2%">
            <input type="hidden" value="{{ csrf_token() }}" name="_token">
        </form>
    </div>
    <div class="col-md-4 " style="background-color:#DDDDDD;width:110px;height:110px;padding:0px;border-radius:50%;border:0.05em solid #ccc">
        <img src="User_Images/default.png" id="image_preview" width="100%" height="100%" class="img-circle">
    </div>
</div>


<script type="text/javascript">
    function getImage(event){
        var selectedFile = event.target.files[0];
        var reader = new FileReader();

        var imgtag = document.getElementById("image_preview");
        imgtag.title = selectedFile.name;

        reader.onload = function(event) {
            imgtag.src = event.target.result;
        };

        reader.readAsDataURL(selectedFile);
    }
</script>
