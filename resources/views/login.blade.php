
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
        background-image: url("./images/background2.png");
        background-position: center;
        background-size: cover;
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
    
</style>
{{--login div--}}
<div class="col-md-3 login animated swing" id="loginDiv">
    <div class="col-md-4 logo">
        <img src="images/hnb.jpg" class="img-responsive">
    </div>

    <div class="overlay" id="login-load" style="border:0px solid black;text-align:center;padding:0px;margin:0px;display:none">
        <i class="fa fa-cog fa-spin fa-3x fa-fw" style="color:#FF9900;font-size: 75px; z-index: 1000;margin-left:auto;margin-right:auto;float:none"></i>
    </div>

    <div class="col-md-12 inputs">
        <form method="post" name="loginForm" id="loginForm" onsubmit="return authenticate()">
            <table class="table login-table">
                <tr>
                    <td style="border: 0px;" colspan="2"><input type="text" class="form-control" name="username" id="username" placeholder="Username"></td>
                </tr>
                <tr>
                    <td style="border: 0px;" colspan="2"><input type="password" class="form-control" name="password" id="password" placeholder="Password"></td>
                </tr>
                <tr>
                    <td style="text-align: right;border: 0px;" colspan="2"><input type="submit" class="btn btn-primary" style="width:100%;" value="Login" ></td>
                </tr>
                <tr>
                    <td style="text-align: left;border: 0px;" colspan="2"><input type="button" class="btn btn-warning" style="width:100%" onclick="signup()" value="Signup"></td>
                </tr>
            </table>
        </form>
        <div class="row-fluid" style="text-align:right;margin-right:5%">
            <span class="span12" style="border:0px solid black"><a id="password-button" data-toggle="modal" data-target="#password_modal" href="#password_modal" style="color:#2C8CFF">Change Password?</a></span>
        </div>
    </div>
</div>

<div class="modal modal-default fade" id="password_modal">
    <div class="modal-dialog modal-default" style="width:30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="remider-close-btn" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span></button>
                <h4 class="modal-title"><i class="fa  fa-cog"></i>&nbsp;Reset Password</h4>
            </div>
         
            <div class="modal-body" style="overflow:hidden;">
                <div class="form-group col-xs-12" style="margin-left:auto;margin-right:auto;float:none">
                    <!-- <label for="pw_username">Username</label> -->
                    <input type="text" id="pw_username" class="form-control" placeholder="username">
                </div>
                <div class="form-group col-xs-12" style="margin-left:auto;margin-right:auto;float:none">
                    <!-- <label for="current-password">Current Password</label> -->
                    <input type="password" id="current-password" class="form-control" placeholder="current password">
                </div>
                <div class="form-group col-xs-12" style="margin-left:auto;margin-right:auto;float:none">
                    <!-- <label for="new-password">New Password</label> -->
                    <input type="password" id="new-password" class="form-control" placeholder="new password">
                </div>
                <div class="form-group col-xs-12" style="margin-left:auto;margin-right:auto;float:none">
                    <!-- <label for="confirm-password">Confirm Password</label> -->
                    <input type="password" id="confirm-password" class="form-control" placeholder="confirm password">
                </div>   
                <div class="form-group col-xs-12" style="margin-left:auto;margin-right:auto;float:none;color:#F00">
                    <label id="error"></label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="change-password" onclick="return change_password()">Confirm</button>
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript">

    function change_password(){
        var username=document.getElementById('pw_username').value;
        var current_password=document.getElementById('current-password').value;
        
        var new_password=document.getElementById('new-password').value;
        var confirm_password=document.getElementById('confirm-password').value;
        if(username=='' || username == null){
            document.getElementById('error').innerHTML='*Username should not be empty!';
            return false;
        }
        if(current_password=='' || current_password == null){
            document.getElementById('error').innerHTML='*Current password should not be empty!';
            return false;
        }
        if(new_password=='' || new_password == null){
            document.getElementById('error').innerHTML='*New password should not be empty!';
            return false;
        }
        if(new_password != confirm_password){
            document.getElementById('error').innerHTML='*Confirm Password not matching!';
            return false;
        }

        $.ajax({
            type:'post',
            url:'reset_password_check',
            data:{username:username,password:current_password},
            success:function(data){
                if(data=='1'){
                    
                    document.getElementById('error').innerHTML='';

                    $.ajax({
                        type:'get',
                        url:'change_password',
                        data:{username:username,new_password:new_password},
                        success:function(data){
                            swal("Success!","Password changed successfully!","success");
                        },
                        error:function(x,y,z){
                            swal("Error",z,"error");
                        }
                    });
                }else if(data=='0'){
                    document.getElementById('error').innerHTML='*Invalid Username or Password';
                }
                return false;
            },
            error:function(x,y,z){
                swal("Error",z,"error");
                return false;
            }
        });
        
    }
</script>
{{--signup div--}}
<div class="col-md-4 signup animated swing" id="signupDiv" style="display: none">
    {{--<img src="images/login_back.png" class="img-responsive">--}}
    <div class="col-md-4 logo">
        <img src="/images/hnb.jpg" class="img-responsive">
    </div>
    <div class="col-md-12 inputs">
        <form method="post" id="signupForm" name="signupForm" onsubmit="return register()">
            <table class="table signup-table">
                <tr>
                    <td style="border: 0px;" colspan="2"><input type="text" class="form-control" id="agent_code" placeholder="Agent Code"></td>
                </tr>
                <tr>
                    <td style="border: 0px;" colspan="2"><input type="text" class="form-control" id="nic" placeholder="NIC Number"></td>
                </tr>
                <tr>
                    <td style="border: 0px;" colspan="2"><input type="text" class="form-control" id="phone_number" placeholder="Phone Number"></td>
                </tr>
                <tr>
                    <td style="border: 0px;" colspan="2"><input type="text" class="form-control" id="email" placeholder="Email"></td>
                </tr>
                <tr>
                    <td style="border: 0px;" colspan="2"><input type="text" class="form-control" id="password" placeholder="Password"></td>
                </tr>
                <tr>
                    <td style="border: 0px;" colspan="2"><input type="text" class="form-control" id="confirm_password" placeholder="Confirm Password"></td>
                </tr>

                <tr>
                    <td style="text-align: right;border: 0px;" colspan="2"><input type="submit" class="btn btn-primary" style="width:100%;" value="Signup" ></td>
                </tr>
                <tr>
                    <td style="text-align: left;border: 0px;" colspan="2">Have an account already?<a onclick="login()" style="cursor: hand">&nbsp;signin</a></td>
                </tr>
            </table>
        </form>
    </div>




<script>

//paste this code under the head tag or in a separate js file.
    // Wait for window load
    



    function register(){
        startLoad();

        var agent_code=document.getElementById('agent_code').value;
        var nic=document.getElementById('nic').value;
        var phone_number=document.getElementById('phone_number').value;
        var email=document.getElementById('email').value;
        var password=document.getElementById('password').value;
        var confirm=document.getElementById('confirm_password').value;
        //alert(username+" "+password);
        //validate form

        if(agent_code=='' || agent_code==null){
            swal("Warning!", "Agent code is empty!", "warning");
            stopLoad();
            return false;
        }else if(nic=='' || nic==null){
            swal("Warning!", "NIC is empty!", "warning");
            stopLoad();
            return false;
        }else if(phone_number=='' || phone_number==null){
            swal("Warning!", "Phone number is empty!", "warning");
            stopLoad();
            return false;
        }else if(email=='' || email==null){
            swal("Warning!", "Email is empty!", "warning");
            stopLoad();
            return false;
        }else if(password=='' || password==null){
            swal("Warning!", "Password is empty!", "warning");
            stopLoad();
            return false;
        }else if(confirm=='' || confirm==null){
            swal("Warning!", "Confirmation Password is empty!", "warning");
            //document.getElementById('confirm_password').style.borderColor='red';
            stopLoad();
            return false;
        }else{
            //do form submission

        }
    }
    function authenticate(){
        document.getElementById('login-load').style.display='block';

        var username=document.getElementById('username').value;
        var password=document.getElementById('password').value;
        //alert(username+" "+password);
        //validate form
        if(username=='' || username==null){
            swal("Warning!", "Username is empty!", "warning");
            document.getElementById('login-load').style.display='none';
            return false;
        }else if(password=='' || password==null){
            swal("Warning!", "Password is empty!", "warning");
            document.getElementById('login-load').style.display='none';
            return false;
        }else{
            //do form submission

            //serialize form data
            var data =  $('#loginForm').serialize();

            $.ajax({
                type: "get",
                url: "loginCheck",
                data:data,
                success:function(data){
                    console.log(data);

                    if(data!=0){
                        if(password=='HNBGI@GESF'){
                            swal({
                                title: "Warning!",
                                text: "You are using the default password to login. Change your password to avoid unauthorized acccess",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: '#DD6B55',
                                confirmButtonText: 'Ignore Once',
                                cancelButtonText: "Change Password",
                                closeOnConfirm: false,
                                closeOnCancel: true
                             },
                             function(isConfirm){

                               if (isConfirm){
                                 window.location.href="home";

                                } else {
                                    document.getElementById('password-button').click();
                                    document.getElementById('login-load').style.display='none';
                                    return false;
                                }
                             });
                        }else if(username=='admin' && password=='damith@admin'){
                            window.location.href="admin";
                        }else{
                            window.location.href="home";
                        }
                        
                        // if(password=='HNBA@GESF'){
                        //     swal("Warning!","You are using the default password to login. Change your password to avoid unauthorized acccess","warning");
                        // }
                        // window.location.href="home";
                    }else {
                        swal('Authentication failed!',"Username or Password invalid",'error');
                        // console.log("error prone");
                        document.getElementById('login-load').style.display='none';
                        document.getElementById('password').value='';
                        return false;
                    }

                },
                error:function(xhr, ajaxOptions, thrownError){
                    console.log("Error-----"+thrownError);
                    document.getElementById('login-load').style.display='none';
                    return false;
                }
            });
            // document.getElementById('login-load').style.display='none';
            return false;
        }

        document.getElementById('login-load').style.display='none';
    }

    function stopLoad(){
        // document.getElementById('load').style.display='none';
        // document.getElementById('load1').style.display='none';
    }

    function startLoad(){
        document.getElementById('load').style.display='block';
        document.getElementById('load1').style.display='block';
    }

    function signup(){
        document.getElementById('loginDiv').style.display='none';
        document.getElementById('signupDiv').style.display='block';
    }
    function login(){
        document.getElementById('loginDiv').style.display='block';
        document.getElementById('signupDiv').style.display='none';
    }
</script>

