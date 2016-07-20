<?php
if(isset($_SESSION['USER_CODE'])){
    $user_code=$_SESSION['USER_CODE'];
    $username=$_SESSION['USER_NAME'];
    $role=$_SESSION['USER_ROLE'];
    $branch=$_SESSION['USER_BRANCH'];
    
}
?>
@extends('master')


@section('css')

 <!--script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script-->
<!--script src="js/jquery-1.12.0.min.js"></script-->
<script src="js/jquery.min.js"></script>


@endsection

@section('page_title')
    Dashboard
@endsection


@section('page_header')
    <h1 style="color:#555;text-shadow: -1px -1px 0px rgba(255,255,255,0.3), 1px 1px 0px rgba(0,0,0,0.8);">
        <b>SALESFORCE</b> Dashboard
        
    </h1>

@endsection

@section('content')

<a href="#due-renewal-reminder-modal" data-toggle="modal" id="due-list"></a>
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" style="border:0px;">
                <div class="box-header bg-primary">
                    <h3 class="box-title" style="color:#FFFFFF">Filter</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>

                </div>

                <div class="box-body" style="display: block;">




                    <form class="form-horizontal" >

                        <div class="form-group">

                            <label class="col-md-1 control-label" >Zone</label>
                            <div class="col-md-3">

                                <select id="zone" <?php if(!isset($_SESSION['ZONE_LIST']) ){ echo "disabled='disabled'";} ?> class="form-control input-sm">
                                    <option value="0" selected="">None</option>

                                </select>


                            </div>

                            <label class="col-md-1 control-label">Cluster</label>
                            <div class="col-md-3">

                                <select id="cluster"  <?php if(!isset($_SESSION['CLUSTER_LIST']) ){ echo "disabled='disabled'";} ?> class="form-control input-sm">
                                    <option value="0" selected="">None</option>

                                </select>
                            </div>

                            <label class="col-md-1 control-label">Branch</label>
                            <div class="col-md-3">

                                <select id="branches-select" <?php if(!isset($_SESSION['BRANCHES_LIST']) ){ echo "disabled='disabled'";} ?> class="form-control input-sm">

                                <option value="0" selected="">None</option>

                                </select>
                            </div>


                        </div>

                        <div class="form-group">
<!-- 
                            <label class="col-md-1  control-label">Team Leader</label>
                            <div class="col-md-3">

                                <select id="team_leader" disabled class="form-control input-sm">

                                </select>
                            </div> -->

                            <label class="col-md-1 control-label">Agents</label>
                            <div class="col-md-3">

                                <select id="agents-select" <?php if(!isset($_SESSION['ADVISOR_TEAM_MEMBER_LIST']) && !isset($_SESSION['BRANCH_MEMBER_LIST'])  && !isset($_SESSION['ZONE_MEMBER_LIST']) ){ echo "disabled='disabled'";} ?> class="form-control input-sm">
                                    <option value="0" selected="">None</option>

                                </select>
                            </div>

                            <div class="col-md-2 col-md-offset-2">
                                <button onclick="return sortGroup()" <?php if(!isset($_SESSION['ADVISOR_TEAM_MEMBER_LIST']) && !isset($_SESSION['BRANCH_MEMBER_LIST'])  && !isset($_SESSION['ZONE_MEMBER_LIST'])  && !isset($_SESSION['BRANCHES_LIST']) && !isset($_SESSION['CLUSTER_LIST']) && !isset($_SESSION['ZONE_LIST']) ){ echo "disabled='disabled'";} ?> class="btn btn-sm btn-primary btn-block">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-black" style="display:flex;align-items:center;padding:0px;background-image: url('images/profile_back.png');background-size:cover;">
                    <div class="col-md-10" style="background-color:#FFFFFF;opacity:0.7;color:#000000;font-weight:600;margin:0px;height:80%;margin-left:10px;border:2px solid #777;box-shadow:2px 2px 4px #000;margin-left:auto;margin-right:auto;float:none">
                        <h3 class="widget-user-desc" style="text-shadow: -1px -1px 0px rgba(255,255,255,0.3), 1px 1px 0px rgba(0,0,0,0.8);"><?php echo $username; ?></h3>
                        
                        <?php 
                        if(isset($_SESSION['LEADER_CODE'])){
                            echo "<h3 style=\"text-shadow: -1px -1px 0px rgba(255,255,255,0.5), 1px 1px 0px rgba(0,0,0,0.8);\" class=\"widget-user-desc\">".$_SESSION['USER_CODE']."</h3>";
                            echo "<h5 style=\"text-shadow: -1px -1px 0px rgba(255,255,255,0.5), 1px 1px 0px rgba(0,0,0,0.8);\" class=\"widget-user-desc\">".$_SESSION['LEADER_CODE']."</h5>";
                        }else{
                            echo "<h3 style=\"text-shadow: -1px -1px 0px rgba(255,255,255,0.5), 1px 1px 0px rgba(0,0,0,0.8);\" class=\"widget-user-desc\">".$_SESSION['USER_CODE']."</h3>";
                            echo "<h5 style=\"text-shadow: -1px -1px 0px rgba(255,255,255,0.5), 1px 1px 0px rgba(0,0,0,0.8);\" class=\"widget-user-desc\">".$_SESSION['USER_ROLE']."</h5>";
                        }
                        ?>
                    </div>
                </div>
                <div class="widget-user-image" style="border:0px solid red;border-radius:50%">
                    <img class="img-circle" src="<?php if(isset($_SESSION['USER_IMAGE'])){ echo $_SESSION['USER_IMAGE']; } ?>" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <!-- <div class="rating" style="float: none;margin-left:auto;margin-right: auto;border:0px solid black;text-align:center;font-size:30px;color:#AAAAAA">
                            <span id="star1">☆</span><span id="star2">☆</span><span id="star3">☆</span><span id="star4">☆</span><spanid="star5">☆</span>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h3 class="description-header" style="font-size:180%"><?php if(isset($_SESSION['NATIONAL_RANK'])){echo $_SESSION['NATIONAL_RANK'];}else{echo "-";} ?></h3>
                                <span class="description-text">NATIONAL RANK</span>
                                <h3 class="description-header" style="font-size:90%;font-weight:400;color:#777;border:1px solid #DDD"><?php if(isset($_SESSION['NATIONAL_DIFF'])){echo "NEXT LEVEL GWP GAP   ".number_format($_SESSION['NATIONAL_DIFF']);}else{echo "";} ?></h3>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h3 class="description-header" style="font-size:180%"><?php if(isset($_SESSION['ZONAL_RANK'])){echo $_SESSION['ZONAL_RANK'];}else{echo "-";} ?></h3>
                                <span class="description-text">ZONAL RANK</span>
                                <h3 class="description-header" style="font-size:90%;font-weight:400;color:#777;border:1px solid #DDD"><?php if(isset($_SESSION['ZONE_DIFF'])){echo "NEXT LEVEL GWP GAP   ".number_format($_SESSION['ZONE_DIFF']);}else{echo "";} ?></h3>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h3 class="description-header" style="font-size:180%"><?php if(isset($_SESSION['BRANCH_RANK'])){echo $_SESSION['BRANCH_RANK'];}else{echo "-";} ?></h3>
                                <span class="description-text">BRANCH RANK</span>
                                <h3 class="description-header" style="font-size:90%;font-weight:400;color:#777;border:1px solid #DDD"><?php if(isset($_SESSION['BRANCH_DIFF'])){echo "NEXT LEVEL GWP GAP   ".number_format($_SESSION['BRANCH_DIFF']);}else{echo "";} ?></h3>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
        </div>

        <div class="col-md-7" style="padding-top:0px">

            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box bg-aqua">
                        <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text" style="font-weight:600;font-size:medium">Claim </span>
                            <span class="info-box-number" id="claim-value"></span>

                            <div class="progress">
                                <div class="progress-bar" id="claim-ratio-style"></div>
                            </div>
                        <span id="claim-ratio-value" class="progress-description" style="font-weight:600;font-size:medium">
                            
                        </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box" id="ppw-box">
                        <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text" style="font-weight:600;font-size:medium">PPW</span>
                            <span class="info-box-number" id="ppw-value"></span>

                            <div class="progress">
                                <div class="progress-bar" id="ppw-ratio-style"></div>
                            </div>
                        <span id="ppw-ratio-value" class="progress-description" style="font-weight:600;font-size:medium">
                            
                        </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
            <div class="row">
                <!-- /.col -->
                <!-- renewal retention disable -->
                <div class="col-md-6 col-sm-6 col-xs-12" style="display:none">
                    <div class="info-box bg-yellow" style="display:block">
                        <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text" style="font-weight:600;font-size:medium">Renewal Retention</span>
                            <span class="info-box-number">41,410</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
                        <span class="progress-description">
                            70% Increase in 30 Days
                        </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-6">
                    <div class="info-box bg-blue">
                        <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                        <style type="text/css">
                            .star-ratings-sprite {
                              background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/2605/star-rating-sprite.png") repeat-x;
                              font-size: 0;
                              height: 21px;
                              line-height: 0;
                              overflow: hidden;
                              text-indent: -999em;
                              width: 110px;
                              margin: 0 auto;
                            }
                            .star-ratings-sprite-rating {
                              background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/2605/star-rating-sprite.png") repeat-x;
                              background-position: 0 100%;
                              float: left;
                              height: 21px;
                              display: block;
                            }

                        </style>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-weight:600;font-size:medium">Training</span>
                            <div class="star-ratings-sprite" style="float: none;margin-left:auto;margin-right: auto;border:0px solid black;text-align:center;margin-top:5%">
                                <a href="#" data-toggle="tooltip" id="star-anchor">
                                    <span id="star-count"  class="star-ratings-sprite-rating">

                                    </span>
                                </a>

                            </div>
                            
                        </div>
                        

                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box bg-purple">
                        <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text" style="font-weight:600;font-size:medium">Profitability</span>
                            <span class="info-box-number" id="profitability-value"></span>

                            <div class="progress">
                                <div class="progress-bar" id="profitability-ratio-style"></div>
                            </div>
                        <span id="profitability-ratio-value" class="progress-description" style="font-weight:600;font-size:medium">
                            
                        </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <!-- stars for training -->
                
            </div>  

        </div>




    </div>
    <div class="row">


        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" style="background-color:#B1C4E6">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="font-size:medium">Month</a></li>
                    <li><a href="#tab_2" data-toggle="tab" aria-expanded="false" style="font-size:medium">Cumulative</a></li>
                    <li class="" style="display:none"><a href="#tab_3" id="group-button" data-toggle="tab" aria-expanded="false" style="font-size:medium">Group</a></li>
                    <li class=""><a href="#tab_4" id="lead-button" data-toggle="tab" aria-expanded="false" style="font-size:medium">Lead Management</a></li>
                    
                </ul>
            </div>
            <div class="tab-content">
                {{--month tab--}}
                <div class="tab-pane  active" id="tab_1">

                    <div class="row">

                        <div class="col-md-4 col-sm-4 col-xs-8">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-blue" style="border-bottom:0.05em solid #FFFFFF">
                                    <h2 class="box-title" style="color:#FFFFFF;font-weight:600">MOTOR</h2>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body bg-blue" style="display: flex; align-items: center;flex-flow:row wrap;justify-content: space-around;">
                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Target<br><p id="motor-target" style="font-weight:600;font-size:medium"></p></span>
                                    <span class="info-box-icon" style="border-radius: 50%;margin:5px;"><p id="motor-percentage" style="font-weight:600;font-size: 25px"></p></span>
                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Achievement<br><p id="motor-achievement" style="font-weight:600;font-size:medium"></p></span>

                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4 col-sm-4 col-xs-8">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-aqua" style="border-bottom:0.05em solid #FFFFFF">
                                    <h2 class="box-title" style="color:#FFFFFF;font-weight:600">NON MOTOR</h2>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body bg-aqua" style="display: flex; align-items: center;flex-flow:row wrap;justify-content: space-around;">
                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Target<br><p id="nonmotor-target" style="font-weight:600;font-size:medium"></p></span>
                                    <span class="info-box-icon" style="border-radius: 50%;margin:5px;"><p id="nonmotor-percentage" style="font-weight:600;font-size: 25px"></p></span>
                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Achievement<br><p id="nonmotor-achievement" style="font-weight:600;font-size:medium"></p></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-8">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-purple" style="border-bottom:0.05em solid #FFFFFF">
                                    <h2 class="box-title" style="color:#FFFFFF;font-weight:600">OVERALL</h2>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body bg-purple" style="display: flex; align-items: center;flex-flow:row wrap;justify-content: space-around;">
                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Target<br><p id="total-target" style="font-weight:600;font-size:medium"></p></span>
                                    <span class="info-box-icon" style="border-radius: 50%;margin:5px;"><p id="total-percentage" style="font-weight:600;font-size: 25px"></p></span>
                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Achievement<br><p id="total-achievement" style="font-weight:600;font-size:medium"></p></span>
                                </div>
                            </div>
                        </div>
                        <!-- class wise gwp -->
                        <div class="col-md-12">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-primary">
                                    <h3 class="box-title" style="color:#FFFFFF">Class Wise GWP</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="box-body" style="display: block;">
                                    <div class="col-xs-6" style="border:0px solid black;padding:0px">

                                        <canvas id="chartCWG" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                        <div class="overlay" id="CWGdemo-overlay-chart1-0">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-2" style="border:0px solid black;padding-bottom:5px">
                                        <div class="overlay" id="demo-overlay-table1-1" style="">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row"><div class="col-sm-12"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="class-wise-gwp" class="table table-bordered bg-aqua dataTable" role="grid" aria-describedby="example2_info">
                                                        <thead>
                                                        <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th>Class</th><th>GWP</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">MOTOR</td>
                                                            <td style="text-align: right" class="sorting_1" id="cwg-motor"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">FIRE</td>
                                                            <td style="text-align: right" class="sorting_1" id="cwg-fire"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">MISC</td>
                                                            <td style="text-align: right" class="sorting_1" id="cwg-misc"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">MED</td>
                                                            <td style="text-align: right" class="sorting_1" id="cwg-med"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">MARINE</td>
                                                            <td style="text-align: right" class="sorting_1" id="cwg-marine"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">WCI</td>
                                                            <td style="text-align: right" class="sorting_1" id="cwg-wci"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">ENG</td>
                                                            <td style="text-align: right" class="sorting_1" id="cwg-eng"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                            <td style="text-align: right" class="sorting_1" id="cwg-total"></td>
                                                        </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4" style="border:0px solid black;padding:0px;">

                                        <canvas id="chart-1-1" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                        <div class="overlay" id="demo-overlay-chart1-1">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        

                        <!-- motor gwp -->
                        <div class="col-md-12">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-primary">
                                    <h3 class="box-title" style="color:#FFFFFF">Motor GWP</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="box-body" style="display: block;">
                                    
                                    <div class="col-xs-6" style="border:0px solid black;padding:10px;">
                                        <div class="overlay" id="demo-overlay-table1" style="">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row"><div class="col-sm-12"></div><div class="col-sm-12"></div></div><div class="row"><div class="col-sm-12">
                                                    <table id="month-motor-nonmotor" class="table table-bordered dataTable" style="background-color:#5DB9EB;color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                        <thead>
                                                        <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th>Status</th><th>Car</th><th>Non Car</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">ADDITION</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-addition"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-addition"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">DELETION</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-deletion"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-deletion"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">RENEWAL</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-renewal"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-renewal"></td>

                                                        </tr>

                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">PPW-CANC</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-ppw-canc"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-ppw-canc"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">REINSTATE</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-reinstate"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-reinstate"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">CANCEL</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-cancel"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-cancel"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">NEW</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-new"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-new"></td>
                                                        </tr>

                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                            <td style="background-color:rgba(23,43,12,0.2);text-align: right" class="sorting_1" id="motor-total"></td>
                                                            <td style="background-color:rgba(23,43,12,0.2);text-align: right" class="sorting_1" id="nonmotor-total"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">GRAND TOTAL</td>

                                                            <td colspan="2" style="background-color:rgba(23,43,12,0.2);text-align: right;font-weight: 600;" class="sorting_1" id="grand-total"></td>
                                                        </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6" style="border:0px solid black;padding:0px;">

                                        <canvas id="chartMotor" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                        <div class="overlay" id="demo-overlay-chart-1-1-1">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        


                        <!-- <div class="col-md-12">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-primary">
                                    <h3 class="box-title" style="color:#FFFFFF">Non Motor GWP</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="box-body" style="display: block;">
                                    
                                    <div class="col-xs-6" style="border:0px solid black;padding:10px;">
                                        <div class="overlay" id="demo-overlay-table1" style="">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row"><div class="col-sm-12"></div><div class="col-sm-12"></div></div><div class="row"><div class="col-sm-12">
                                                    <table id="month-motor-nonmotor" class="table table-bordered dataTable" style="background-color:#5DB9EB;color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                        <thead>
                                                        <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th>Status</th><th>Car</th><th>Non Car</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">ADDITION</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-addition"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-addition"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">DELETION</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-deletion"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-deletion"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">RENEWAL</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-renewal"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-renewal"></td>

                                                        </tr>

                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">PPW-CANC</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-ppw-canc"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-ppw-canc"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">REINSTATE</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-reinstate"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-reinstate"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">CANCEL</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-cancel"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-cancel"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">NEW</td>
                                                            <td style="text-align: right" class="sorting_1" id="motor-new"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-new"></td>
                                                        </tr>

                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                            <td style="background-color:rgba(23,43,12,0.2);text-align: right" class="sorting_1" id="motor-total"></td>
                                                            <td style="background-color:rgba(23,43,12,0.2);text-align: right" class="sorting_1" id="nonmotor-total"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">GRAND TOTAL</td>

                                                            <td colspan="2" style="background-color:rgba(23,43,12,0.2);text-align: right;font-weight: 600;" class="sorting_1" id="grand-total"></td>
                                                        </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6" style="border:0px solid black;padding:0px;">

                                        <canvas id="chartMotor" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                        <div class="overlay" id="demo-overlay-chart-1-1-1">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div> -->

                        <!--non motor gwp -->
                        <div class="col-md-12">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-primary">
                                    <h3 class="box-title" style="color:#FFFFFF">Non Motor GWP</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="box-body" style="display: block;">
                                    
                                    <div class="col-xs-6" style="border:0px solid black;padding:10px;">
                                        <div class="overlay" id="nonmotor-demo-overlay-table1" style="">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row"><div class="col-sm-12"></div><div class="col-sm-12"></div></div><div class="row"><div class="col-sm-12">
                                                    <table id="month-nonmotor" class="table table-bordered dataTable" style="background-color:#5DB9EB;color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                        <thead>
                                                        <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th></th><th>MARINE</th><th>MED</th><th>MISC</th><th>ENG</th><th>FIRE</th><th>WCI</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">ADDITION</td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-addition-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-addition-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-addition-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-addition-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-addition-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-addition-wci"></td>

                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">DELETION</td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-deletion-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-deletion-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-deletion-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-deletion-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-deletion-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-deletion-wci"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">RENEWAL</td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-renewal-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-renewal-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-renewal-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-renewal-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-renewal-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-renewal-wci"></td>

                                                        </tr>

                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">PPW-CANC</td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-ppwcancel-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-ppwcancel-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-ppwcancel-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-ppwcancel-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-ppwcancel-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-ppwcancel-wci"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">REINSTATE</td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-reinstate-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-reinstate-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-reinstate-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-reinstate-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-reinstate-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-reinstate-wci"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">CANCEL</td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-cancel-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-cancel-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-cancel-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-cancel-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-cancel-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-cancel-wci"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">NEW</td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-new-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-new-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-new-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-new-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-new-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-new-wci"></td>
                                                        </tr>

                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-total-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-total-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-total-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-total-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-total-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="nonmotor-total-wci"></td>
                                                        </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6" style="border:0px solid black;padding:0px;">

                                        <canvas id="chartNonMotor" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                        <div class="overlay" id="NonMotor-demo-overlay-chart-1-1-1">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>


                        <!-- policy -->

                        <div class="col-md-12">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-primary">
                                    <h3 class="box-title" style="color:#FFFFFF">Policy</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                                    </div>
                                </div>
                                <div class="box-body">
                                    
                                    <div class="col-xs-6">
                                        <div class="overlay" id="demo-overlay-table2">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                                                    <table id="month-motor-nonmotor-gwp" class="table table-bordered dataTable" style="background-color:rgba(0,156,240,0.6);color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                        <thead>
                                                        <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th >Department</th><th >GWP</th><th>NOP</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">Motor New</td>
                                                            <td style="text-align: right" id="motor-new-gwp"></td>
                                                            <td style="text-align: right" id="motor-new-nop"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">Motor Renewal</td>
                                                            <td style="text-align: right" id="motor-renewal-gwp"></td>
                                                            <td style="text-align: right" id="motor-renewal-nop"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">Non Motor New</td>
                                                            <td style="text-align: right" id="nonmotor-new-gwp"></td>
                                                            <td style="text-align: right" id="nonmotor-new-nop"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">Non Motor Renewal</td>
                                                            <td style="text-align: right" id="nonmotor-renewal-gwp"></td>
                                                            <td style="text-align: right" id="nonmotor-renewal-nop"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">Total</td>
                                                            <td style="background-color:rgba(23,43,12,0.2);text-align: right" id="total-gwp"></td>
                                                            <td style="background-color:rgba(23,43,12,0.2);text-align: right" id="total-nop"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        
                        
                    </div>
                </div>
                <!-- /.tab-pane -->
                {{--cumulative tab--}}
                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <!-- target achievement -->

                        <div class="col-md-12">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-primary">
                                    <h3 class="box-title" style="color:#FFFFFF">Target Achievement</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body" style="display: block;">
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-8">
                                                <div class="box-header bg-green" style="border-bottom:0.05em solid #FFFFFF">
                                                    <h2 class="box-title" style="color:#FFFFFF;font-weight:600">MOTOR</h2>
                                                </div>
                                                <div class="info-box bg-green" style="display: flex; align-items: center;flex-flow:row wrap;justify-content: space-around;">
                                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Target<br><p id="cm-motor-target" style="font-weight:600;font-size:medium"></p></span>
                                                    <span class="info-box-icon" style="border-radius: 50%;margin:5px;"><p id="cm-motor-percentage" style="font-weight:600;font-size: 25px"></p></span>
                                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Achievement<br><p id="cm-motor-achievement" style="font-weight:600;font-size:medium"></p></span>

                                                </div>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-4 col-sm-4 col-xs-8">
                                                <div class="box-header" style="border-bottom:0.05em solid #FFFFFF;background-color:#00C465;color:#FFFFFF">
                                                    <h2 class="box-title" style="color:#FFFFFF;font-weight:600">NON MOTOR</h2>
                                                </div>
                                                <div class="info-box" style="background-color:#00C465;color:#FFFFFF;display: flex; align-items: center;flex-flow:row wrap;justify-content: space-around;">
                                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Target<br><p id="cm-nonmotor-target" style="font-weight:600;font-size:medium"></p></span>
                                                    <span class="info-box-icon" style="border-radius: 50%;margin:5px;"><p id="cm-nonmotor-percentage" style="font-weight:600;font-size: 25px"></p></span>
                                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Achievement<br><p id="cm-nonmotor-achievement" style="font-weight:600;font-size:medium"></p></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-8">
                                                <div class="box-header bg-olive" style="border-bottom:0.05em solid #FFFFFF">
                                                    <h2 class="box-title" style="color:#FFFFFF;font-weight:600">OVERALL</h2>
                                                </div>
                                                <div class="info-box bg-olive" style="display: flex; align-items: center;flex-flow:row wrap;justify-content: space-around;">
                                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Target<br><p id="cm-total-target" style="font-weight:600;font-size:medium"></p></span>
                                                    <span class="info-box-icon" style="border-radius: 50%;margin:5px;"><p id="cm-total-percentage" style="font-weight:600;font-size: 25px"></p></span>
                                                    <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Achievement<br><p id="cm-total-achievement" style="font-weight:600;font-size:medium"></p></span>
                                                </div>
                                            </div>
                                        </div>
                                                <!-- /.box -->
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- class wise gwp -->
                        <div class="col-md-12">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-primary">
                                    <h3 class="box-title" style="color:#FFFFFF">Class Wise GWP</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="box-body" style="display: block;">
                                    <div class="col-xs-6" style="border:0px solid black;padding:0px">

                                        <canvas id="cmchartCWG" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                        <div class="overlay" id="cmCWGdemo-overlay-chart1-0">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-2" style="border:0px solid black;padding-bottom:5px">
                                        <div class="overlay" id="spinner-cm-cwg-table" style="">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row"><div class="col-sm-12"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="cm-class-wise-gwp" class="table table-bordered bg-aqua dataTable" role="grid" aria-describedby="example2_info">
                                                        <thead>
                                                        <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th>Class</th><th>GWP</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">MOTOR</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-cwg-motor"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">FIRE</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-cwg-fire"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">MISC</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-cwg-misc"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">MED</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-cwg-med"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">MARINE</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-cwg-marine"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">WCI</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-cwg-wci"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">ENG</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-cwg-eng"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-cwg-total"></td>
                                                        </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4" style="border:0px solid black;padding:0px;">

                                        <canvas id="cm-cwg-chart" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                        <div class="overlay" id="spinner-cm-cwg-chart">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        

                        <!-- motor gwp -->
                        <div class="col-md-12">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-primary">
                                    <h3 class="box-title" style="color:#FFFFFF">Motor GWP</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="box-body" style="display: block;">
                                    
                                    <div class="col-xs-6" style="border:0px solid black;padding:10px;">
                                        <div class="overlay" id="spinner-cm-motor-table" style="">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row"><div class="col-sm-12"></div><div class="col-sm-12"></div></div><div class="row"><div class="col-sm-12">
                                                    <table id="month-motor-nonmotor" class="table table-bordered dataTable" style="background-color:#5DB9EB;color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                        <thead>
                                                        <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th>Status</th><th>Car</th><th>Non Car</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">ADDITION</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-motor-addition"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-addition"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">DELETION</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-motor-deletion"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-deletion"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">RENEWAL</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-motor-renewal"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-renewal"></td>

                                                        </tr>

                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">PPW-CANC</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-motor-ppw-canc"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-ppw-canc"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">REINSTATE</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-motor-reinstate"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-reinstate"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">CANCEL</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-motor-cancel"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-cancel"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">NEW</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-motor-new"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-new"></td>
                                                        </tr>

                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                            <td style="background-color:rgba(23,43,12,0.2);text-align: right" class="sorting_1" id="cm-motor-total"></td>
                                                            <td style="background-color:rgba(23,43,12,0.2);text-align: right" class="sorting_1" id="cm-nonmotor-total"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">GRAND TOTAL</td>

                                                            <td colspan="2" style="background-color:rgba(23,43,12,0.2);text-align: right;font-weight: 600;" class="sorting_1" id="cm-grand-total"></td>
                                                        </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6" style="border:0px solid black;padding:0px;">

                                        <canvas id="cm-motor-chart" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                        <div class="overlay" id="spinner-cm-motor-chart">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!--non motor gwp -->
                        <div class="col-md-12">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-primary">
                                    <h3 class="box-title" style="color:#FFFFFF">Non Motor GWP</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="box-body" style="display: block;">
                                    
                                    <div class="col-xs-6" style="border:0px solid black;padding:10px;">
                                        <div class="overlay" id="cm-nonmotor-demo-overlay-table1" style="">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row"><div class="col-sm-12"></div><div class="col-sm-12"></div></div><div class="row"><div class="col-sm-12">
                                                    <table id="month-nonmotor" class="table table-bordered dataTable" style="background-color:#5DB9EB;color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                        <thead>
                                                        <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th></th><th>MARINE</th><th>MED</th><th>MISC</th><th>ENG</th><th>FIRE</th><th>WCI</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">ADDITION</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-addition-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-addition-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-addition-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-addition-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-addition-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-addition-wci"></td>

                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">DELETION</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-deletion-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-deletion-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-deletion-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-deletion-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-deletion-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-deletion-wci"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">RENEWAL</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-renewal-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-renewal-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-renewal-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-renewal-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-renewal-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-renewal-wci"></td>

                                                        </tr>

                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">PPW-CANC</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-ppwcancel-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-ppwcancel-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-ppwcancel-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-ppwcancel-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-ppwcancel-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-ppwcancel-wci"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">REINSTATE</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-reinstate-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-reinstate-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-reinstate-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-reinstate-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-reinstate-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-reinstate-wci"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">CANCEL</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-cancel-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-cancel-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-cancel-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-cancel-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-cancel-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-cancel-wci"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">NEW</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-new-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-new-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-new-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-new-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-new-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-new-wci"></td>
                                                        </tr>

                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-total-mrn"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-total-med"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-total-mis"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-total-eng"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-total-fir"></td>
                                                            <td style="text-align: right" class="sorting_1" id="cm-nonmotor-total-wci"></td>
                                                        </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6" style="border:0px solid black;padding:0px;">

                                        <canvas id="cm-chartNonMotor" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                        <div class="overlay" id="cm-NonMotor-demo-overlay-chart-1-1-1">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>



                        <!-- policy -->

                        <div class="col-md-12">
                            <div class="box box-default" style="border:0px;">
                                <div class="box-header bg-primary">
                                    <h3 class="box-title" style="color:#FFFFFF">Policy</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                                    </div>
                                </div>
                                <div class="box-body">
                                    
                                    <div class="col-xs-6">
                                        <div class="overlay" id="spinner-cm-policy-table">
                                            <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                        </div>
                                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                                                    <table id="cm-month-motor-nonmotor-gwp" class="table table-bordered dataTable" style="background-color:rgba(0,156,240,0.6);color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                        <thead>
                                                        <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th >Department</th><th >GWP</th><th>NOP</th></tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">Motor New</td>
                                                            <td style="text-align: right" id="cm-motor-new-gwp"></td>
                                                            <td style="text-align: right" id="cm-motor-new-nop"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">Motor Renewal</td>
                                                            <td style="text-align: right" id="cm-motor-renewal-gwp"></td>
                                                            <td style="text-align: right" id="cm-motor-renewal-nop"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">Non Motor New</td>
                                                            <td style="text-align: right" id="cm-nonmotor-new-gwp"></td>
                                                            <td style="text-align: right" id="cm-nonmotor-new-nop"></td>
                                                        </tr>
                                                        <tr role="row" class="even">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">Non Motor Renewal</td>
                                                            <td style="text-align: right" id="cm-nonmotor-renewal-gwp"></td>
                                                            <td style="text-align: right" id="cm-nonmotor-renewal-nop"></td>
                                                        </tr>
                                                        <tr role="row" class="odd">
                                                            <td style="background-color:rgba(23,43,12,0.4)" class="">Total</td>
                                                            <td style="background-color:rgba(23,43,12,0.2);text-align: right" id="cm-total-gwp"></td>
                                                            <td style="background-color:rgba(23,43,12,0.2);text-align: right" id="cm-total-nop"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <!-- group tab -->
                    <div class="col-md-6">
                        <div class="box box-info">
                        <!-- /.box-header -->
                            <div class="box-body">
                                <span class="info-box-text" id="group-code" style="margin:3%;"></span>
                                <span class="info-box-text" id="group-name" style="margin:3%;"></span>
                                <span class="info-box-text" id="group-branch" style="margin:3%;"></span>
                            </div>
                        <!-- /.box-body -->
                        </div>
                      <!-- /.box -->
                    </div>

                    <div class="nav-tabs-custom col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#sub_1_group" data-toggle="tab">Month</a></li>
                            <li><a href="#sub_2_group" data-toggle="tab">Cumulative</a></li>
                            <li><a href="#sub_3_group" data-toggle="tab">Details</a></li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="sub_1_group">
                                <div class="col-md-12">
                                    <div class="box box-info">
                                    <!-- /.box-header -->
                                        <div class="box-body">
                                           <div class="row">
                                


                                    <div class="col-md-4 col-sm-4 col-xs-8">
                                        <div class="box box-default" style="border:0px;">
                                            <div class="box-header bg-blue" style="border-bottom:0.05em solid #FFFFFF">
                                                <h2 class="box-title" style="color:#FFFFFF;font-weight:600">MOTOR</h2>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="box-body bg-blue" style="display: flex; align-items: center;flex-flow:row wrap;justify-content: space-around;">
                                                <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Target<br><p id="motor-target_group" style="font-weight:600;font-size:medium"></p></span>
                                                <span class="info-box-icon" style="border-radius: 50%;margin:5px;"><p id="motor-percentage_group" style="font-weight:600;font-size: 25px"></p></span>
                                                <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Achievement<br><p id="motor-achievement_group" style="font-weight:600;font-size:medium"></p></span>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4 col-sm-4 col-xs-8">
                                        <div class="box box-default" style="border:0px;">
                                            <div class="box-header bg-aqua" style="border-bottom:0.05em solid #FFFFFF">
                                                <h2 class="box-title" style="color:#FFFFFF;font-weight:600">NON MOTOR</h2>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="box-body bg-aqua" style="display: flex; align-items: center;flex-flow:row wrap;justify-content: space-around;">
                                                <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Target<br><p id="nonmotor-target_group" style="font-weight:600;font-size:medium"></p></span>
                                                <span class="info-box-icon" style="border-radius: 50%;margin:5px;"><p id="nonmotor-percentage_group" style="font-weight:600;font-size: 25px"></p></span>
                                                <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Achievement<br><p id="nonmotor-achievement_group" style="font-weight:600;font-size:medium"></p></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-8">
                                        <div class="box box-default" style="border:0px;">
                                            <div class="box-header bg-purple" style="border-bottom:0.05em solid #FFFFFF">
                                                <h2 class="box-title" style="color:#FFFFFF;font-weight:600">OVERALL</h2>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="box-body bg-purple" style="display: flex; align-items: center;flex-flow:row wrap;justify-content: space-around;">
                                                <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Target<br><p id="total-target_group" style="font-weight:600;font-size:medium"></p></span>
                                                <span class="info-box-icon" style="border-radius: 50%;margin:5px;"><p id="total-percentage_group" style="font-weight:600;font-size: 25px"></p></span>
                                                <span class="info-box-text" style="margin:5px;text-align: center;font-size:large">Achievement<br><p id="total-achievement_group" style="font-weight:600;font-size:medium"></p></span>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <!-- class wise gwp -->
                                    <div class="col-md-12">
                                        <div class="box box-default" style="border:0px;">
                                            <div class="box-header bg-primary">
                                                <h3 class="box-title" style="color:#FFFFFF">Class Wise GWP</h3>

                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div>

                                            </div>

                                            <div class="box-body" style="display: block;">
                                                <div class="col-xs-6" style="border:0px solid black;padding:0px">
                                                    <div id="chartCWG_group-div">
                                                        <canvas id="chartCWG_group" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                                    </div>
                                                    <div class="overlay" id="CWGdemo-overlay-chart1-0_group">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-xs-2" style="border:0px solid black;padding-bottom:5px">
                                                    <div class="overlay" id="demo-overlay-table1-1_group" style="">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                                        <div class="row"><div class="col-sm-12"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="class-wise-gwp" class="table table-bordered bg-aqua dataTable" role="grid" aria-describedby="example2_info">
                                                                    <thead>
                                                                    <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th>Class</th><th>GWP</th></tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">ENG</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cwg-eng_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">FIRE</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cwg-fire_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">MARINE</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cwg-marine_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">MED</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cwg-med_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">MISC</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cwg-misc_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">MOTOR</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cwg-motor_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">WCI</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cwg-wci_group"></td>
                                                                    </tr>
                                                                    
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cwg-total_group"></td>
                                                                    </tr>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4" style="border:0px solid black;padding:0px;">
                                                    <div id="chart-1-1_group-div">
                                                        <canvas id="chart-1-1_group" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                                    </div>
                                                    <canvas id="chart-1-1_group" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                                    <div class="overlay" id="demo-overlay-chart1-1_group">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    

                                    <!-- motor gwp -->
                                    <div class="col-md-12">
                                        <div class="box box-default" style="border:0px;">
                                            <div class="box-header bg-primary">
                                                <h3 class="box-title" style="color:#FFFFFF">Motor GWP</h3>

                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div>

                                            </div>

                                            <div class="box-body" style="display: block;">
                                                
                                                <div class="col-xs-6" style="border:0px solid black;padding:10px;">
                                                    <div class="overlay" id="demo-overlay-table1_group" style="">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                                        <div class="row"><div class="col-sm-12"></div><div class="col-sm-12"></div></div><div class="row"><div class="col-sm-12">
                                                                <table id="month-motor-nonmotor" class="table table-bordered dataTable" style="background-color:#5DB9EB;color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                                    <thead>
                                                                    <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th>Status</th><th>Car</th><th>Non Car</th></tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">ADDITION</td>
                                                                        <td style="text-align: right" class="sorting_1" id="motor-addition_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="nonmotor-addition_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">DELETION</td>
                                                                        <td style="text-align: right" class="sorting_1" id="motor-deletion_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="nonmotor-deletion_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">RENEWAL</td>
                                                                        <td style="text-align: right" class="sorting_1" id="motor-renewal_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="nonmotor-renewal_group"></td>

                                                                    </tr>

                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">PPW-CANC</td>
                                                                        <td style="text-align: right" class="sorting_1" id="motor-ppw-canc_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="nonmotor-ppw-canc_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">REINSTATE</td>
                                                                        <td style="text-align: right" class="sorting_1" id="motor-reinstate_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="nonmotor-reinstate_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">CANCEL</td>
                                                                        <td style="text-align: right" class="sorting_1" id="motor-cancel_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="nonmotor-cancel_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">NEW</td>
                                                                        <td style="text-align: right" class="sorting_1" id="motor-new_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="nonmotor-new_group"></td>
                                                                    </tr>

                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                                        <td style="background-color:rgba(23,43,12,0.2);text-align: right" class="sorting_1" id="motor-total_group"></td>
                                                                        <td style="background-color:rgba(23,43,12,0.2);text-align: right" class="sorting_1" id="nonmotor-total_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">GRAND TOTAL</td>

                                                                        <td colspan="2" style="background-color:rgba(23,43,12,0.2);text-align: right;font-weight: 600;" class="sorting_1" id="grand-total_group"></td>
                                                                    </tr>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6" style="border:0px solid black;padding:0px;">
                                                    <div id="chartMotor_group-div">
                                                        <canvas id="chartMotor_group" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                                    </div>
                                                    
                                                    <div class="overlay" id="demo-overlay-chart-1-1-1_group">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- policy -->

                                    <div class="col-md-12">
                                        <div class="box box-default" style="border:0px;">
                                            <div class="box-header bg-primary">
                                                <h3 class="box-title" style="color:#FFFFFF">Policy</h3>

                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                    {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                
                                                <div class="col-xs-6">
                                                    <div class="overlay" id="demo-overlay-table2_group">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                                        <div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                                                                <table id="month-motor-nonmotor-gwp" class="table table-bordered dataTable" style="background-color:rgba(0,156,240,0.6);color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                                    <thead>
                                                                    <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th >Department</th><th >GWP</th><th>NOP</th></tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">Motor New</td>
                                                                        <td style="text-align: right" id="motor-new-gwp_group"></td>
                                                                        <td style="text-align: right" id="motor-new-nop_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">Motor Renewal</td>
                                                                        <td style="text-align: right" id="motor-renewal-gwp_group"></td>
                                                                        <td style="text-align: right" id="motor-renewal-nop_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">Non Motor New</td>
                                                                        <td style="text-align: right" id="nonmotor-new-gwp_group"></td>
                                                                        <td style="text-align: right" id="nonmotor-new-nop_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">Non Motor Renewal</td>
                                                                        <td style="text-align: right" id="nonmotor-renewal-gwp_group"></td>
                                                                        <td style="text-align: right" id="nonmotor-renewal-nop_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">Total</td>
                                                                        <td style="background-color:rgba(23,43,12,0.2);text-align: right" id="total-gwp_group"></td>
                                                                        <td style="background-color:rgba(23,43,12,0.2);text-align: right" id="total-nop_group"></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                    </div>
                                    
                                            </div> 
                                        </div>
                                    <!-- /.box-body -->
                                    </div>
                                  <!-- /.box -->
                                </div>
                            </div>
                            
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="sub_2_group" >
                                <div class="col-md-12">
                                    <div class="box box-info">
                                    <!-- /.box-header -->
                                        <div class="box-body">
                                           <div class="row">
                                


                                    <!-- class wise gwp -->
                                    <div class="col-md-12">
                                        <div class="box box-default" style="border:0px;">
                                            <div class="box-header bg-primary">
                                                <h3 class="box-title" style="color:#FFFFFF">Class Wise GWP</h3>

                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div>

                                            </div>

                                            <div class="box-body" style="display: block;">
                                                <div class="col-xs-6" style="border:0px solid black;padding:0px">
                                                    <div id="cmchartCWG_group-div">
                                                        <canvas id="cmchartCWG_group" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                                    </div>
                                                    
                                                    <div class="overlay" id="cmCWGdemo-overlay-chart1-0_group">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-xs-2" style="border:0px solid black;padding-bottom:5px">
                                                    <div class="overlay" id="cm-demo-overlay-table1-1_group" style="">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                                        <div class="row"><div class="col-sm-12"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="class-wise-gwp" class="table table-bordered bg-aqua dataTable" role="grid" aria-describedby="example2_info">
                                                                    <thead>
                                                                    <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th>Class</th><th>GWP</th></tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">ENG</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-cwg-eng_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">FIRE</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-cwg-fire_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">MARINE</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-cwg-marine_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">MED</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-cwg-med_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">MISC</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-cwg-misc_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">MOTOR</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-cwg-motor_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">WCI</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-cwg-wci_group"></td>
                                                                    </tr>
                                                                    
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-cwg-total_group"></td>
                                                                    </tr>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4" style="border:0px solid black;padding:0px;">
                                                    <div id="cm-chart-1-1_group-div">
                                                        <canvas id="cm-chart-1-1_group" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                                    </div>
                                                    <div class="overlay" id="cm-demo-overlay-chart1-1_group">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    

                                    <!-- motor gwp -->
                                    <div class="col-md-12">
                                        <div class="box box-default" style="border:0px;">
                                            <div class="box-header bg-primary">
                                                <h3 class="box-title" style="color:#FFFFFF">Motor GWP</h3>

                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div>

                                            </div>

                                            <div class="box-body" style="display: block;">
                                                
                                                <div class="col-xs-6" style="border:0px solid black;padding:10px;">
                                                    <div class="overlay" id="cm-demo-overlay-table1_group" style="">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                                        <div class="row"><div class="col-sm-12"></div><div class="col-sm-12"></div></div><div class="row"><div class="col-sm-12">
                                                                <table id="month-motor-nonmotor" class="table table-bordered dataTable" style="background-color:#5DB9EB;color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                                    <thead>
                                                                    <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th>Status</th><th>Car</th><th>Non Car</th></tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">ADDITION</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-motor-addition_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-nonmotor-addition_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">DELETION</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-motor-deletion_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-nonmotor-deletion_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">RENEWAL</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-motor-renewal_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-nonmotor-renewal_group"></td>

                                                                    </tr>

                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">PPW-CANC</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-motor-ppw-canc_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-nonmotor-ppw-canc_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">REINSTATE</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-motor-reinstate_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-nonmotor-reinstate_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">CANCEL</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-motor-cancel_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-nonmotor-cancel_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">NEW</td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-motor-new_group"></td>
                                                                        <td style="text-align: right" class="sorting_1" id="cm-nonmotor-new_group"></td>
                                                                    </tr>

                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">TOTAL</td>
                                                                        <td style="background-color:rgba(23,43,12,0.2);text-align: right" class="sorting_1" id="cm-motor-total_group"></td>
                                                                        <td style="background-color:rgba(23,43,12,0.2);text-align: right" class="sorting_1" id="cm-nonmotor-total_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">GRAND TOTAL</td>

                                                                        <td colspan="2" style="background-color:rgba(23,43,12,0.2);text-align: right;font-weight: 600;" class="sorting_1" id="cm-grand-total_group"></td>
                                                                    </tr>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6" style="border:0px solid black;padding:0px;">
                                                    <div id="cm-chartMotor_group-div">
                                                        <canvas id="cm-chartMotor_group" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                                                    </div>
                                                    
                                                    <div class="overlay" id="cm-demo-overlay-chart-1-1-1_group">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- policy -->

                                    <div class="col-md-12">
                                        <div class="box box-default" style="border:0px;">
                                            <div class="box-header bg-primary">
                                                <h3 class="box-title" style="color:#FFFFFF">Policy</h3>

                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                    {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                
                                                <div class="col-xs-6">
                                                    <div class="overlay" id="cm-demo-overlay-table2_group">
                                                        <i class="fa fa-spinner fa-spin" style="color:#D5D5D5;font-size: 55px;position:absolute; z-index: 2;"></i>
                                                    </div>
                                                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                                        <div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                                                                <table id="month-motor-nonmotor-gwp" class="table table-bordered dataTable" style="background-color:rgba(0,156,240,0.6);color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                                                    <thead>
                                                                    <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th >Department</th><th >GWP</th><th>NOP</th></tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">Motor New</td>
                                                                        <td style="text-align: right" id="cm-motor-new-gwp_group"></td>
                                                                        <td style="text-align: right" id="cm-motor-new-nop_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">Motor Renewal</td>
                                                                        <td style="text-align: right" id="cm-motor-renewal-gwp_group"></td>
                                                                        <td style="text-align: right" id="cm-motor-renewal-nop_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">Non Motor New</td>
                                                                        <td style="text-align: right" id="cm-nonmotor-new-gwp_group"></td>
                                                                        <td style="text-align: right" id="cm-nonmotor-new-nop_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="even">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">Non Motor Renewal</td>
                                                                        <td style="text-align: right" id="cm-nonmotor-renewal-gwp_group"></td>
                                                                        <td style="text-align: right" id="cm-nonmotor-renewal-nop_group"></td>
                                                                    </tr>
                                                                    <tr role="row" class="odd">
                                                                        <td style="background-color:rgba(23,43,12,0.4)" class="">Total</td>
                                                                        <td style="background-color:rgba(23,43,12,0.2);text-align: right" id="cm-total-gwp_group"></td>
                                                                        <td style="background-color:rgba(23,43,12,0.2);text-align: right" id="cm-total-nop_group"></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                    </div>
                                    
                                            </div> 
                                        </div>
                                    <!-- /.box-body -->
                                    </div>
                                  <!-- /.box -->
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="sub_3_group">
                               <!-- group details tab -->

                               <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title"></h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table id="group_details_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" style="width: 181px;">Lead No</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 224px;">Customer</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 197px;">Address</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 154px;">Agent</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 112px;">Date</th>
                                                            <th rowspan="1" style="width: 112px;"></th>
                                                            <th rowspan="1" style="width: 112px;"></th>
                                                            <th rowspan="1" style="width: 112px;"></th>

                                                        </tr>
                                                        </thead>
                                                        <tbody id="leads-table_group">
                                                        
                                                        </tbody>
                                                        <tfoot>

                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-7">
                                                    <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                                        <ul class="pagination">
                                                            <li class="paginate_button previous disabled" id="example1_previous">
                                                                <a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a>
                                                            </li>
                                                            <li class="paginate_button active">
                                                                <a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a>
                                                            </li>
                                                            <li class="paginate_button ">
                                                                <a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a>
                                                            </li>
                                                            <li class="paginate_button ">
                                                                <a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a>
                                                            </li>
                                                            <li class="paginate_button ">
                                                                <a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
                                    </div>
                                    <script>

                                    </script>
                                    <!-- /.box-body -->
                                </div>



                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>



                    
                </div>

                <script>
                    function sortGroup(){


                          document.getElementById('claim-value').innerHTML = '';
                          document.getElementById("claim-ratio-style").style.width = "";
                          document.getElementById('claim-ratio-value').innerHTML="";

                          document.getElementById('profitability-value').innerHTML='';
                          document.getElementById("profitability-ratio-style").style.width = '';
                          document.getElementById('profitability-ratio-value').innerHTML='';

                           document.getElementById("ppw-ratio-style").style.width = "";
                           document.getElementById('ppw-ratio-value').innerHTML="";
                        
                        var zone=document.getElementById('zone').value;
                        var cluster=document.getElementById('cluster').value;
                        var region=document.getElementById('branches-select').value;
                        var agents_select=document.getElementById('agents-select').value;


                        if(cluster != '0' && region != '0' && agents_select != '0' && zone != '0'){

                            alert(cluster+"::::::::"+region+":::::::::"+agents_select+"::::::::"+zone); 
                            alert("Please select only one filed for search 1!");
                            return false;
                        }
                        if(cluster != '0' && region != '0' && zone != '0'){


                            alert("Please select only one filed for search !");
                             return false;
                        }
                        if(cluster != '0' && zone != '0'){


                            alert("Please select only one filed for search !");
                             return false;
                        }
                        if(cluster != '0'  && agents_select != '0'){


                            alert("Please select only one filed for search !");
                             return false;
                        }
                        if(region != '0' && agents_select != '0' && zone != '0'){


                            alert("Please select only one filed for search !");
                             return false;  
                        }
                        if(region != '0' && zone != '0'){


                            alert("Please select only one filed for search !");
                             return false;  
                        }
                        if(agents_select != '0' && zone != '0'){


                            alert("Please select only one filed for search !");
                             return false;  
                        }



                      
                        if(agents_select!=null ){
                            if(agents_select!='ALL'){
                                // alert(agents_select);
                                $.ajax({
                                    type:'get',
                                    url:'advisor_details',
                                    data:{key:agents_select},
                                    success:function(data){
                                        if(data.length!=2){
                                            member_data=jQuery.parseJSON(data);
                                            console.log(member_data[0].user_code);
                                            document.getElementById('group-code').innerHTML="Code : <strong>"+member_data[0].user_code+"</strong>";
                                            document.getElementById('group-name').innerHTML="Name : <strong>"+member_data[0].user_name+"</strong>";
                                            document.getElementById('group-branch').innerHTML="Branch : <strong>"+member_data[0].branch+"</strong>";

                                            // var ctx1_0_group = document.getElementById("chart-1-0_group");
                                            $('#group_details_table').DataTable( {
                                                "bDestroy":true,
                                                responsive: true,
                                                "ajax": {
                                                    "type":"get",
                                                    "url": "retrieve_leads_group",
                                                    "data":{key:agents_select},

                                                },
                                                "pageLength": 100,


                                                columns: [
                                                    { "data": "lead_no" },
                                                    { "data": "customer_name" },
                                                    { "data": "address" },
                                                    { "data": "agent_code" },
                                                    { "data": "proposal_date" },
                                                    
                                                    {"data" : null,
                                                        "mRender": function(data, type, full) {


                                                            return '<a class="btn btn-success btn-block btn-sm" onclick="set_details_group(\''+data.lead_no+'\')" data-toggle="modal" href="#details-modal" style=" text-decoration: none;">' + 'Details' + '</a>';
                                                        }
                                                    }
                                                ]



                                            } );


                                                  $.ajax({
                                                   type:'get',
                                                   url:'ppwRatio_search_user',
                                                   data:{key:agents_select},
                                                   success:function(data){
                                                       ppwData=jQuery.parseJSON(data);
                                                       document.getElementById('ppw-value').innerHTML=formatNumber(parseFloat(ppwData[0].ppw).toFixed(2));
                                   
                                                           var ratio=((parseFloat(ppwData[0].ppw)/parseFloat(ppwData[0].gwp))*100).toFixed(2);
                                                       if(ratio<=10){
                                                               document.getElementById("ppw-box").style.backgroundColor="#00AC08";
                                                           document.getElementById("ppw-box").style.color="white";
                                                       }else{
                                                           document.getElementById("ppw-box").style.backgroundColor="#A70000";
                                                           document.getElementById("ppw-box").style.color="white";
                                                           }
                                                       document.getElementById("ppw-ratio-style").style.width = ratio+"%";
                                                       document.getElementById('ppw-ratio-value').innerHTML="PPW RATIO : "+ratio+" %";
                                                       },
                                                   error:function(x,y,thrown){
                                                       console.log(thrown);
                                                   }
                                               });
                                                 $.ajax({
                                                     type:'get',
                                                     url:'claimRatio_search_user',
                                                     data:{key:agents_select},
                                                     success:function(data){
                                                         console.log("claim ratio");
                                                         data=jQuery.parseJSON(data);
                                                         console.log(data);
                                                         // calculations
                                                         var NWP=parseFloat(convertToZero(data[0].xol))+parseFloat(convertToZero(data[0].gwp))+parseFloat(convertToZero(data[0].ri));
                                                         var NEP=parseFloat(convertToZero(data[0].xol))+parseFloat(convertToZero(data[0].ri))+parseFloat(convertToZero(data[0].gwp))+                                     parseFloat(convertToZero(data[0].title_trf))+parseFloat(convertToZero(data[0].uep));
                                                         var CLAIM_OS=(parseFloat(convertToZero(data[0].claim_os_fmt))-parseFloat(convertToZero(data[0].claim_os_lst)));
                                                         var RI_ONCLAIM_OS=(parseFloat(convertToZero(data[0].claim_os_ri_fmt))-parseFloat(convertToZero(data[0].claim_os_ri_lst)));
                                                         var NET_CLAIM_INCU=parseFloat(convertToZero(data[0].claim_paid_cost))+(parseFloat(convertToZero(data[0].claim_os_fmt))-                                     parseFloat(convertToZero(data[0].claim_os_lst)))+parseFloat(convertToZero(data[0].ri_claim_paid))+(parseFloat(convertToZero(data[0].claim_os_ri_fmt))-parseFloat(convertToZero(data[0].claim_os_ri_lst)));
                                                                                              
                                                         var NEPdifNET_CLAIM_INCU=parseFloat(NEP)-parseFloat(NET_CLAIM_INCU);
                                     
                                                        var DAC=(parseFloat(convertToZero(data[0].claim_paid_cost))-parseFloat(convertToZero(data[0].dac_ri_comm)));
                                                         var TOTAL=parseFloat(convertToZero(data[0].commission_paid))+parseFloat(convertToZero(data[0].sales_promo))+parseFloat(convertToZero(data[0].ri_comm_income))+parseFloat(convertToZero(data[0].dac))-parseFloat(convertToZero(data[0].dac_ri_comm))                                     ;

                                     
                                                      var OPERATING=((parseFloat(NEP))-(parseFloat(NET_CLAIM_INCU)))-(parseFloat(TOTAL));

                                     
                                                  var CLAIM_RATIO=((parseFloat(NET_CLAIM_INCU))/(parseFloat(NEP))*100).toFixed(2);
                                     
                                                      var EXP_RATIO=((parseFloat(TOTAL))/(parseFloat(NEP))*100).toFixed(2);
                                     


                                                         document.getElementById('claim-value').innerHTML=formatNumber(parseFloat(convertToZero(data[0].claim_paid_cost)).toFixed(2));
                                                         document.getElementById("claim-ratio-style").style.width = CLAIM_RATIO+"%";
                                                         document.getElementById('claim-ratio-value').innerHTML="CLAIM RATIO : "+CLAIM_RATIO+" %";

                                                         document.getElementById('profitability-value').innerHTML=formatNumber(parseFloat(OPERATING).toFixed(2));
                                                         document.getElementById("profitability-ratio-style").style.width = EXP_RATIO+"%";
                                                         document.getElementById('profitability-ratio-value').innerHTML="EXPENSE RATIO : "+EXP_RATIO+" %";
                                     


                                                         console.log(NWP+" "+NEP+" "+CLAIM_OS+" "+NEPdifNET_CLAIM_INCU+" "+TOTAL+" "+OPERATING+" "+CLAIM_RATIO);


                                                    // end of calculations






    
                                                         console.log(data);
                                                  },
                                                            error:function(x,y,thrown){
                                                            console.log(thrown);
                                                 }
                                                 });


                                                  $.ajax({
                                                 type:'get',
                                                 url:'training_star_count_serach_user',
                                                 data:{key:agents_select},
                                                 success:function(data){
                                 

                                                     starData=jQuery.parseJSON(data);
                                                    console.log("Star details::::::::::::::::::::::::::"+tarData);
                                                     console.log("stars percentage: --------------------------------"+starData[0].percentage);
                                 
                                                     alert(data);
                                 
                                                     var starCount=starData[0].percentage;
                                                     document.getElementById('star-count').style.width=''+starCount+'%';
                                                     document.getElementById('star-anchor').title="Training Percentage : "+starCount+'%';
                                                     // if(starCount>0 && starCount<=10){
                                                     //     document.getElementById('star1').style.width='50%';
                                                     // }else if(starCount>10 && starCount<=20){
                                                     //     document.getElementById('star1').style.width='50%';
                                                     // }else if(starCount>20 && starCount<=30){
                                                     // }else if(starCount>30 && starCount<=40){
                                                     // }else if(starCount>40 && starCount<=50){
                                                     // }else if(starCount>50 && starCount<=60){
                                                     // }else if(starCount>60 && starCount<=70){
                                                     // }else if(starCount>70 && starCount<=80){
                                                     // }else if(starCount>80 && starCount<=90){
                                                     // }else if(starCount>90 && starCount<=100){
                                                     // }
                                 
                                                 },
                                                 error:function(x,y,thrown){
                                                     console.log(thrown);
                                                 }
                                             });




                                            
                                            
                                            //fmt group
                                            $.ajax({
                                                type:'get',
                                                url:'chart1_0_1data_group',
                                                data:{key:agents_select},
                                                success:function(data){
                                                    nonmotorP=0;
                                                    motorP=0;
                                                    cols=[];
                                                    gwp=[];
                                                    axData=jQuery.parseJSON(data);

                                                    document.getElementById('cwg-fire_group').innerHTML='';
                                                    document.getElementById('cwg-misc_group').innerHTML='';
                                                    document.getElementById('cwg-motor_group').innerHTML='';
                                                    document.getElementById('cwg-wci_group').innerHTML='';
                                                    document.getElementById('cwg-eng_group').innerHTML='';
                                                    document.getElementById('cwg-marine_group').innerHTML='';
                                                    document.getElementById('cwg-med_group').innerHTML='';

                                                    for(x=0 ; x<axData.length ; x++){
                                                        cols[x]=axData[x].dept_new;
                                                        gwp[x]=axData[x].gwp;


                                                        if(cols[x]=='FIRE'){
                                                            document.getElementById('cwg-fire_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MISC'){
                                                            document.getElementById('cwg-misc_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                           nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MOTOR'){
                                                            document.getElementById('cwg-motor_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            motorP+=(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='WCI'){
                                                            document.getElementById('cwg-wci_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='ENGG') {
                                                            document.getElementById('cwg-eng_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MARINE') {
                                                            document.getElementById('cwg-marine_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MED') {
                                                            document.getElementById('cwg-med_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }
                                                    }
                                                
                                                    document.getElementById('cwg-total_group').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));

                                                    document.getElementById('demo-overlay-table1-1_group').style.display='none';
                                                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                                                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);

                                                    motorPercent=((parseFloat(motorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                                                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                                                    for(x=0;x<7;x++){

                                                        if(cols[x]==null || cols[x]=='undefined'){
                                                            cols[x]='';
                                                            gwp[x]=0;
                                                        }
                                                    }
                                                    document.getElementById('chartCWG_group-div').innerHTML='';
                                                    document.getElementById('chartCWG_group-div').innerHTML="<canvas id=\"chartCWG_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    
                                                    var chartCWG_group = document.getElementById("chartCWG_group");
                                                    


                                                    var myChart = new Chart(chartCWG_group, {
                                                    
                                                        type: 'bar',
                                                        data: {
                                                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                                                    // for(x=0;x<cols.length;x++){
                                                                    //     cols[x];    
                                                                    // }
                                                                    


                                                                ],
                                                            datasets: [
                                                                {
                                                                    label: "GWP",

                                                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                                                    // String  or array - the bar color
                                                                    backgroundColor: "rgba(0,121,235,0.4)",

                                                                    // String or array - bar stroke color
                                                                    borderColor: "rgba(0,121,235,1)",

                                                                    // Number or array - bar border width
                                                                    borderWidth: 1,

                                                                    // String or array - fill color when hovered
                                                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                                                    // String or array - border color when hovered
                                                                    hoverBorderColor: "rgba(0,121,235,1)",

                                                                    // The actual data
                                                                    data: [
                                                                        // for(x=0;x<cols.length;x++){
                                                                        //     gwp[x];    
                                                                        // }
                                                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                                                    ],

                                                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                                                },

                                                            ]
                                                        },
                                                        options: {
                                                            animateScale: true
                                                        }
                                                    });
                                                    document.getElementById('CWGdemo-overlay-chart1-0_group').style.display='none';

                                                    document.getElementById('chart-1-1_group-div').innerHTML='';
                                                    document.getElementById('chart-1-1_group-div').innerHTML="<canvas id=\"chart-1-1_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var ctx1_1_group = document.getElementById("chart-1-1_group");
                                                    var myChart = new Chart(ctx1_1_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Motor "+convertToZero(motorPercent)+"%","Non Motor "+convertToZero(nonmotorPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(motorPercent),convertToZero(nonmotorPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('demo-overlay-chart1-1_group').style.display='none';

                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });


                                            //ajax to get data for chart 1 and table1
                                            $.ajax({
                                                type:'get',
                                                url:'chart1data_group',
                                                data:{key:agents_select},
                                                success:function(data){
                                                    cols=[];
                                                    motor=[];
                                                    noncar=[];
                                                    aaData=jQuery.parseJSON(data);
                                                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);

                                                    document.getElementById('motor-addition_group').innerHTML='';
                                                    document.getElementById('nonmotor-addition_group').innerHTML='';
                                                    document.getElementById('motor-deletion_group').innerHTML='';
                                                    document.getElementById('nonmotor-deletion_group').innerHTML='';
                                                    document.getElementById('motor-renewal_group').innerHTML='';
                                                    document.getElementById('nonmotor-renewal_group').innerHTML='';
                                                    document.getElementById('motor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('nonmotor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('motor-reinstate_group').innerHTML='';
                                                    document.getElementById('nonmotor-reinstate_group').innerHTML='';
                                                    document.getElementById('motor-new_group').innerHTML='';
                                                    document.getElementById('nonmotor-new_group').innerHTML='';
                                                    document.getElementById('motor-cancel_group').innerHTML='';
                                                    document.getElementById('nonmotor-cancel_group').innerHTML='';

                                                    for(x=0 ; x<aaData.length ; x++){
                                                        cols[x]=aaData[x].pol_status;
                                                        motor[x]=aaData[x].motor_car_gwp;
                                                        noncar[x]=aaData[x].motor_noncar_gwp;

                                                        if(cols[x]=='ADDITION'){
                                                            console.log("Addition");
                                                            document.getElementById('motor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='DELETION'){
                                                            console.log("DELETION");
                                                            document.getElementById('motor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='RENEWAL'){
                                                            console.log("Renewal");
                                                            document.getElementById('motor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='PPW-CANC'){
                                                            console.log("PPW-CANC");
                                                            document.getElementById('motor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='REINSTATE') {
                                                            console.log("REINSTATE");
                                                            document.getElementById('motor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='NEW') {
                                                            console.log("NEW");
                                                            document.getElementById('motor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='CANCEL') {
                                                            console.log("CANCEL");
                                                            document.getElementById('motor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }
                                                    }


                                                    document.getElementById('motor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));
                                                    document.getElementById('nonmotor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2));
                                                    document.getElementById('grand-total_group').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6])))).toFixed(2));
                                                    document.getElementById('demo-overlay-table1_group').style.display='none';
                                                    carP=0;
                                                    noncarP=0;
                                                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                                                    noncarP=(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2);

                                                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);

                                                    document.getElementById('chartMotor_group-div').innerHTML='';
                                                    document.getElementById('chartMotor_group-div').innerHTML="<canvas id=\"chartMotor_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var ctxMotor_group = document.getElementById("chartMotor_group");
                                                    var myChart = new Chart(ctxMotor_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Car "+convertToZero(carPercent)+"%","Non Car "+convertToZero(noncarPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(carPercent),convertToZero(noncarPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('demo-overlay-chart-1-1-1_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            //get data for chart2 and table
                                            $.ajax({
                                                type:'get',
                                                url:'chart2data_group',
                                                data:{key:agents_select},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    abData=jQuery.parseJSON(data);

                                                    cols=[];
                                                    gwp=[];
                                                    nop=[];
                                                    var t_gwp=0;
                                                    var t_nop=0;
                                                    for(x=0 ; x<abData.length ; x++){
                                                        cols[x]=abData[x].type;
                                                        gwp[x]=abData[x].gwp;
                                                        nop[x]=abData[x].nop;

                                                        t_gwp+=parseFloat(gwp[x]);
                                                        t_nop+=parseFloat(nop[x]);
                                                    }
                                                    document.getElementById('motor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                                                    document.getElementById('motor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                                                    document.getElementById('motor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                                                    document.getElementById('motor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                                                    document.getElementById('nonmotor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                                                    document.getElementById('nonmotor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                                                    document.getElementById('nonmotor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                                                    document.getElementById('nonmotor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                                                    document.getElementById('total-gwp_group').innerHTML=formatNumber((convertToZero(t_gwp.toFixed(2))));
                                                    document.getElementById('total-nop_group').innerHTML=formatNumber((convertToZero(t_nop)));
                                                    document.getElementById('demo-overlay-table2_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });
                                            

                                            //cumulative group
                                            $.ajax({
                                                type:'get',
                                                url:'cumulative_cwg_group',
                                                data:{key:agents_select},
                                                success:function(data){
                                                    nonmotorP=0;
                                                    motorP=0;
                                                    cols=[];
                                                    gwp=[];
                                                    axData=jQuery.parseJSON(data);
                                                    document.getElementById('cm-cwg-fire_group').innerHTML='';
                                                    document.getElementById('cm-cwg-misc_group').innerHTML='';
                                                    document.getElementById('cm-cwg-motor_group').innerHTML='';
                                                    document.getElementById('cm-cwg-wci_group').innerHTML='';
                                                    document.getElementById('cm-cwg-eng_group').innerHTML='';
                                                    document.getElementById('cm-cwg-marine_group').innerHTML='';
                                                    document.getElementById('cm-cwg-med_group').innerHTML='';

                                                    for(x=0 ; x<axData.length ; x++){
                                                        cols[x]=axData[x].dept_new;
                                                        gwp[x]=axData[x].gwp;

                                                        if(cols[x]=='FIRE'){
                                                            document.getElementById('cm-cwg-fire_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                             nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MISC'){
                                                            document.getElementById('cm-cwg-misc_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                             nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MOTOR'){
                                                            document.getElementById('cm-cwg-motor_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            motorP+=(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='WCI'){
                                                            document.getElementById('cm-cwg-wci_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                             nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='ENGG') {
                                                            document.getElementById('cm-cwg-eng_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                             nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MARINE') {
                                                            document.getElementById('cm-cwg-marine_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                             nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MED') {
                                                            document.getElementById('cm-cwg-med_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                           nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }
                                                    }
                                                
                                                    document.getElementById('cm-cwg-total_group').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));

                                                    document.getElementById('cm-demo-overlay-table1-1_group').style.display='none';
                                                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                                                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);
                                                    for(x=0;x<7;x++){

                                                        if(cols[x]==null || cols[x]=='undefined'){
                                                            cols[x]='';
                                                            gwp[x]=0;
                                                        }
                                                    }
                                                    motorPercent=((parseFloat(motorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                                                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);

                                                    document.getElementById('cmchartCWG_group-div').innerHTML='';
                                                    document.getElementById('cmchartCWG_group-div').innerHTML="<canvas id=\"cmchartCWG_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";

                                                    var cmchartCWG_group = document.getElementById("cmchartCWG_group");
                                                    var myChart = new Chart(cmchartCWG_group, {
                                                        type: 'bar',
                                                        data: {
                                                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                                                    // for(x=0;x<cols.length;x++){
                                                                    //     cols[x];    
                                                                    // }
                                                                    


                                                                ],
                                                            datasets: [
                                                                {
                                                                    label: "GWP",

                                                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                                                    // String  or array - the bar color
                                                                    backgroundColor: "rgba(0,121,235,0.4)",

                                                                    // String or array - bar stroke color
                                                                    borderColor: "rgba(0,121,235,1)",

                                                                    // Number or array - bar border width
                                                                    borderWidth: 1,

                                                                    // String or array - fill color when hovered
                                                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                                                    // String or array - border color when hovered
                                                                    hoverBorderColor: "rgba(0,121,235,1)",

                                                                    // The actual data
                                                                    data: [
                                                                        // for(x=0;x<cols.length;x++){
                                                                        //     gwp[x];    
                                                                        // }
                                                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                                                    ],

                                                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cmCWGdemo-overlay-chart1-0_group').style.display='none';
                                                    
                                                    document.getElementById('cm-chart-1-1_group-div').innerHTML='';
                                                    document.getElementById('cm-chart-1-1_group-div').innerHTML="<canvas id=\"cm-chart-1-1_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var cm_ctx1_1_group = document.getElementById("cm-chart-1-1_group");
                                                    var myChart = new Chart(cm_ctx1_1_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Motor "+convertToZero(motorPercent)+"%","Non Motor "+convertToZero(nonmotorPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(motorPercent),convertToZero(nonmotorPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cm-demo-overlay-chart1-1_group').style.display='none';

                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            $.ajax({
                                                type:'get',
                                                url:'chart4data_group',
                                                data:{key:agents_select},
                                                success:function(data){
                                                    cols=[];
                                                    motor=[];
                                                    noncar=[];
                                                    aaData=jQuery.parseJSON(data);
                                                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);
                                                    document.getElementById('cm-motor-addition_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-addition_group').innerHTML='';
                                                    document.getElementById('cm-motor-deletion_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-deletion_group').innerHTML='';
                                                    document.getElementById('cm-motor-renewal_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-renewal_group').innerHTML='';
                                                    document.getElementById('cm-motor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('cm-motor-reinstate_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-reinstate_group').innerHTML='';
                                                    document.getElementById('cm-motor-new_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-new_group').innerHTML='';
                                                    document.getElementById('cm-motor-cancel_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-cancel_group').innerHTML='';
                                                    for(x=0 ; x<aaData.length ; x++){
                                                        cols[x]=aaData[x].pol_status;
                                                        motor[x]=aaData[x].motor_car_gwp;
                                                        noncar[x]=aaData[x].motor_noncar_gwp;

                                                        if(cols[x]=='ADDITION'){
                                                            console.log("Addition");
                                                            document.getElementById('cm-motor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='DELETION'){
                                                            console.log("DELETION");
                                                            document.getElementById('cm-motor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='RENEWAL'){
                                                            console.log("Renewal");
                                                            document.getElementById('cm-motor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='PPW-CANC'){
                                                            console.log("PPW-CANC");
                                                            document.getElementById('cm-motor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='REINSTATE') {
                                                            console.log("REINSTATE");
                                                            document.getElementById('cm-motor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='NEW') {
                                                            console.log("NEW");
                                                            document.getElementById('cm-motor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='CANCEL') {
                                                            console.log("CANCEL");
                                                            document.getElementById('cm-motor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }
                                                    }


                                                    document.getElementById('cm-motor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));
                                                    document.getElementById('cm-nonmotor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2));
                                                    document.getElementById('cm-grand-total_group').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6])))).toFixed(2));
                                                    document.getElementById('cm-demo-overlay-table1_group').style.display='none';
                                                    carP=0;
                                                    noncarP=0;
                                                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                                                    noncarP=(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2);

                                                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    
                                                    document.getElementById('cm-chartMotor_group-div').innerHTML='';
                                                    document.getElementById('cm-chartMotor_group-div').innerHTML="<canvas id=\"cm-chartMotor_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var cm_ctxMotor_group = document.getElementById("cm-chartMotor_group");
                                                    var myChart = new Chart(cm_ctxMotor_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Car "+convertToZero(carPercent)+"%","Non Car "+convertToZero(noncarPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(carPercent),convertToZero(noncarPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cm-demo-overlay-chart-1-1-1_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });


                                            $.ajax({
                                                type:'get',
                                                url:'CMNOP_group',
                                                data:{key:agents_select},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    abData=jQuery.parseJSON(data);

                                                    cols=[];
                                                    gwp=[];
                                                    nop=[];
                                                    var t_gwp=0;
                                                    var t_nop=0;
                                                    for(x=0 ; x<abData.length ; x++){
                                                        cols[x]=abData[x].type;
                                                        gwp[x]=abData[x].gwp;
                                                        nop[x]=abData[x].nop;

                                                        t_gwp+=parseFloat(gwp[x]);
                                                        t_nop+=parseFloat(nop[x]);
                                                    }
                                                    document.getElementById('cm-motor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                                                    document.getElementById('cm-motor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                                                    document.getElementById('cm-motor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                                                    document.getElementById('cm-motor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                                                    document.getElementById('cm-nonmotor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                                                    document.getElementById('cm-nonmotor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                                                    document.getElementById('cm-nonmotor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                                                    document.getElementById('cm-nonmotor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                                                    document.getElementById('cm-total-gwp_group').innerHTML=formatNumber((convertToZero(t_gwp.toFixed(2))));
                                                    document.getElementById('cm-total-nop_group').innerHTML=formatNumber((convertToZero(t_nop)));
                                                    document.getElementById('cm-demo-overlay-table2_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            $.ajax({

                                                type:'get',
                                                url:'chart3data_group',
                                                data:{key:agents_select},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    acData=jQuery.parseJSON(data);
                                                    // console.log("ahas"+acData);
                                                    // cols=[];
                                                    // target=[];
                                                    // achievement=[];
                                                    var t_target=0;
                                                    var t_achievement=0;
                                                    // for(x=0 ; x<acData.length ; x++){
                                                    //     cols[x]=acData[x].type;
                                                    //     target[x]=acData[x].target_amount;
                                                    //     achievement[x]=acData[x].achievement_amt;

                                                        t_target=parseFloat(convertToZero(acData.motor_target))+parseFloat(convertToZero(acData.nonmotor_target));
                                                        t_achievement=parseFloat(convertToZero(acData.motor_achievement))+parseFloat(convertToZero(acData.nonmotor_achievement));
                                                    // }
                                                    console.log("motor tar: "+t_target);
                                                    console.log("motor ach: "+t_achievement);

                                                    document.getElementById('motor-target_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_target)).toFixed(2));
                                                    document.getElementById('motor-achievement_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_achievement)).toFixed(2));
                                                    document.getElementById('motor-percentage_group').innerHTML=((parseFloat(convertToZero(acData.motor_achievement))/parseFloat(convertToZero(acData.motor_target)))*100).toFixed(2)+'%';//%
                                                    document.getElementById('nonmotor-target_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_target)).toFixed(2));
                                                    document.getElementById('nonmotor-achievement_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_achievement)).toFixed(2));
                                                    document.getElementById('nonmotor-percentage_group').innerHTML=((parseFloat(convertToZero(acData.nonmotor_achievement))/parseFloat(convertToZero(acData.nonmotor_target)))*100).toFixed(2)+'%';
                                                    document.getElementById('total-target_group').innerHTML=formatNumber(convertToZero(t_target).toFixed(2));
                                                    document.getElementById('total-achievement_group').innerHTML=formatNumber(convertToZero(t_achievement).toFixed(2));
                                                    document.getElementById('total-percentage_group').innerHTML=((convertToZero(t_achievement)/convertToZero(t_target))*100).toFixed(2)+'%';

                                                    // document.getElementById('demo-overlay-table3_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });

               

                                            



                                            //ajax to get data for table cumulative-non-motor
                                            

                                            document.getElementById('group-button').click();
                                        }else{
                                            console.log("no data");
                                            return false;
                                        }
                                    },
                                    error:function(x,y,thrown){
                                        console.log(thrown);
                                    }
                                });
                            }else if(agents_select=='ALL'){
                                // alert('all selected');
                                // var ctx1_0_group = document.getElementById("chart-1-0_group");
                                            
                                            
                                            
                                            
                                            // var ctx4_group = document.getElementById("chart-4_group");
                                            // var cm_ctx4_group = document.getElementById("cm-chart-4_group");
                                            // var ctx4_1_group = document.getElementById("chart-4-1_group");
                                            // var cm_ctx4_1_group = document.getElementById("cm-chart-4-1_group");
                                            var goi='group';
                                            $('#group_details_table').DataTable( {
                                                "bDestroy":true,
                                                responsive: true,
                                                "ajax": {
                                                    "type":"get",
                                                    "url": "retrieve_leads_group",
                                                    "data":{key:goi},
                                                    
                                                },
                                                "pageLength": 100,


                                                columns: [
                                                    { "data": "lead_no" },
                                                    { "data": "customer_name" },
                                                    { "data": "address" },
                                                    { "data": "agent_code" },
                                                    { "data": "proposal_date" },
                                                    
                                                    {"data" : null,
                                                        "mRender": function(data, type, full) {


                                                            return '<a class="btn btn-success btn-block btn-sm" onclick="set_details_group(\''+data.lead_no+'\')" data-toggle="modal" href="#details-modal" style=" text-decoration: none;">' + 'Details' + '</a>';
                                                        }
                                                    }
                                                ]



                                            } );
                                            
                                            
                                            //fmt group
                                            $.ajax({
                                                type:'get',
                                                url:'chart1_0_1data_group',
                                                data:{key:goi},
                                                success:function(data){
                                                    nonmotorP=0;
                                                    motorP=0;
                                                    cols=[];
                                                    gwp=[];
                                                    axData=jQuery.parseJSON(data);
                                                    document.getElementById('cwg-fire_group').innerHTML='';
                                                    document.getElementById('cwg-misc_group').innerHTML='';
                                                    document.getElementById('cwg-motor_group').innerHTML='';
                                                    document.getElementById('cwg-wci_group').innerHTML='';
                                                    document.getElementById('cwg-eng_group').innerHTML='';
                                                    document.getElementById('cwg-marine_group').innerHTML='';
                                                    document.getElementById('cwg-med_group').innerHTML='';
                                                    for(x=0 ; x<axData.length ; x++){
                                                        cols[x]=axData[x].dept_new;
                                                        gwp[x]=axData[x].gwp;

                                                        if(cols[x]=='FIRE'){
                                                            document.getElementById('cwg-fire_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='MISC'){
                                                            document.getElementById('cwg-misc_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='MOTOR'){
                                                            document.getElementById('cwg-motor_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            motorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='WCI'){
                                                            document.getElementById('cwg-wci_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if (cols[x]=='ENGG') {
                                                            document.getElementById('cwg-eng_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if (cols[x]=='MARINE') {
                                                            document.getElementById('cwg-marine_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if (cols[x]=='MED') {
                                                            document.getElementById('cwg-med_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }
                                                    }
                                                
                                                    document.getElementById('cwg-total_group').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));

                                                    document.getElementById('demo-overlay-table1-1_group').style.display='none';
                                                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                                                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);

                                                    motorPercent=((parseFloat(motorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                                                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                                                    for(x=0;x<7;x++){

                                                        if(cols[x]==null || cols[x]=='undefined'){
                                                            cols[x]='';
                                                            gwp[x]=0;
                                                        }
                                                    }

                                                    document.getElementById('chartCWG_group-div').innerHTML='';
                                                    document.getElementById('chartCWG_group-div').innerHTML="<canvas id=\"chartCWG_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";

                                                    var chartCWG_group = document.getElementById("chartCWG_group");
                                                    var myChart = new Chart(chartCWG_group, {
                                                        type: 'bar',
                                                        data: {
                                                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                                                    // for(x=0;x<cols.length;x++){
                                                                    //     cols[x];    
                                                                    // }
                                                                    


                                                                ],
                                                            datasets: [
                                                                {
                                                                    label: "GWP",

                                                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                                                    // String  or array - the bar color
                                                                    backgroundColor: "rgba(0,121,235,0.4)",

                                                                    // String or array - bar stroke color
                                                                    borderColor: "rgba(0,121,235,1)",

                                                                    // Number or array - bar border width
                                                                    borderWidth: 1,

                                                                    // String or array - fill color when hovered
                                                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                                                    // String or array - border color when hovered
                                                                    hoverBorderColor: "rgba(0,121,235,1)",

                                                                    // The actual data
                                                                    data: [
                                                                        // for(x=0;x<cols.length;x++){
                                                                        //     gwp[x];    
                                                                        // }
                                                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                                                    ],

                                                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('CWGdemo-overlay-chart1-0_group').style.display='none';

                                                    document.getElementById('chart-1-1_group-div').innerHTML='';
                                                    document.getElementById('chart-1-1_group-div').innerHTML="<canvas id=\"chart-1-1_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var ctx1_1_group = document.getElementById("chart-1-1_group");
                                                    var myChart = new Chart(ctx1_1_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Motor "+convertToZero(motorPercent)+"%","Non Motor "+convertToZero(nonmotorPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(motorPercent),convertToZero(nonmotorPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('demo-overlay-chart1-1_group').style.display='none';

                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });


                                            //ajax to get data for chart 1 and table1
                                            $.ajax({
                                                type:'get',
                                                url:'chart1data_group',
                                                data:{key:goi},
                                                success:function(data){
                                                    cols=[];
                                                    motor=[];
                                                    noncar=[];
                                                    aaData=jQuery.parseJSON(data);
                                                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);
                                                    document.getElementById('motor-addition_group').innerHTML='';
                                                    document.getElementById('nonmotor-addition_group').innerHTML='';
                                                    document.getElementById('motor-deletion_group').innerHTML='';
                                                    document.getElementById('nonmotor-deletion_group').innerHTML='';
                                                    document.getElementById('motor-renewal_group').innerHTML='';
                                                    document.getElementById('nonmotor-renewal_group').innerHTML='';
                                                    document.getElementById('motor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('nonmotor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('motor-reinstate_group').innerHTML='';
                                                    document.getElementById('nonmotor-reinstate_group').innerHTML='';
                                                    document.getElementById('motor-new_group').innerHTML='';
                                                    document.getElementById('nonmotor-new_group').innerHTML='';
                                                    document.getElementById('motor-cancel_group').innerHTML='';
                                                    document.getElementById('nonmotor-cancel_group').innerHTML='';
                                                    for(x=0 ; x<aaData.length ; x++){
                                                        cols[x]=aaData[x].pol_status;
                                                        motor[x]=aaData[x].motor_car_gwp;
                                                        noncar[x]=aaData[x].motor_noncar_gwp;

                                                        if(cols[x]=='ADDITION'){
                                                            console.log("Addition");
                                                            document.getElementById('motor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='DELETION'){
                                                            console.log("DELETION");
                                                            document.getElementById('motor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='RENEWAL'){
                                                            console.log("Renewal");
                                                            document.getElementById('motor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='PPW-CANC'){
                                                            console.log("PPW-CANC");
                                                            document.getElementById('motor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='REINSTATE') {
                                                            console.log("REINSTATE");
                                                            document.getElementById('motor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='NEW') {
                                                            console.log("NEW");
                                                            document.getElementById('motor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='CANCEL') {
                                                            console.log("CANCEL");
                                                            document.getElementById('motor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }
                                                    }


                                                    document.getElementById('motor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));
                                                    document.getElementById('nonmotor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2));
                                                    document.getElementById('grand-total_group').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6])))).toFixed(2));
                                                    document.getElementById('demo-overlay-table1_group').style.display='none';
                                                    carP=0;
                                                    noncarP=0;
                                                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                                                    noncarP=(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2);

                                                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    
                                                    document.getElementById('chartMotor_group-div').innerHTML='';
                                                    document.getElementById('chartMotor_group-div').innerHTML="<canvas id=\"chartMotor_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var ctxMotor_group = document.getElementById("chartMotor_group");
                                                    var myChart = new Chart(ctxMotor_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Car "+convertToZero(carPercent)+"%","Non Car "+convertToZero(noncarPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(carPercent),convertToZero(noncarPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('demo-overlay-chart-1-1-1_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            //get data for chart2 and table
                                            $.ajax({
                                                type:'get',
                                                url:'chart2data_group',
                                                data:{key:goi},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    abData=jQuery.parseJSON(data);

                                                    cols=[];
                                                    gwp=[];
                                                    nop=[];
                                                    var t_gwp=0;
                                                    var t_nop=0;
                                                    for(x=0 ; x<abData.length ; x++){
                                                        cols[x]=abData[x].type;
                                                        gwp[x]=abData[x].gwp;
                                                        nop[x]=abData[x].nop;

                                                        t_gwp+=parseFloat(gwp[x]);
                                                        t_nop+=parseFloat(nop[x]);
                                                    }
                                                    document.getElementById('motor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                                                    document.getElementById('motor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                                                    document.getElementById('motor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                                                    document.getElementById('motor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                                                    document.getElementById('nonmotor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                                                    document.getElementById('nonmotor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                                                    document.getElementById('nonmotor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                                                    document.getElementById('nonmotor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                                                    document.getElementById('total-gwp_group').innerHTML=formatNumber((convertToZero(t_gwp.toFixed(2))));
                                                    document.getElementById('total-nop_group').innerHTML=formatNumber((convertToZero(t_nop)));
                                                    document.getElementById('demo-overlay-table2_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });
                                            

                                            //cumulative group
                                            $.ajax({
                                                type:'get',
                                                url:'cumulative_cwg_group',
                                                data:{key:goi},
                                                success:function(data){
                                                    nonmotorP=0;
                                                    motorP=0;
                                                    cols=[];
                                                    gwp=[];
                                                    axData=jQuery.parseJSON(data);
                                                    document.getElementById('cm-cwg-fire_group').innerHTML='';
                                                    document.getElementById('cm-cwg-misc_group').innerHTML='';
                                                    document.getElementById('cm-cwg-motor_group').innerHTML='';
                                                    document.getElementById('cm-cwg-wci_group').innerHTML='';
                                                    document.getElementById('cm-cwg-eng_group').innerHTML='';
                                                    document.getElementById('cm-cwg-marine_group').innerHTML='';
                                                    document.getElementById('cm-cwg-med_group').innerHTML='';
                                                    for(x=0 ; x<axData.length ; x++){
                                                        cols[x]=axData[x].dept_new;
                                                        gwp[x]=axData[x].gwp;

                                                        if(cols[x]=='FIRE'){
                                                            document.getElementById('cm-cwg-fire_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='MISC'){
                                                            document.getElementById('cm-cwg-misc_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='MOTOR'){
                                                            document.getElementById('cm-cwg-motor_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            motorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='WCI'){
                                                            document.getElementById('cm-cwg-wci_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if (cols[x]=='ENGG') {
                                                            document.getElementById('cm-cwg-eng_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if (cols[x]=='MARINE') {
                                                            document.getElementById('cm-cwg-marine_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if (cols[x]=='MED') {
                                                            document.getElementById('cm-cwg-med_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }
                                                    }
                                                
                                                    document.getElementById('cm-cwg-total_group').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));

                                                    document.getElementById('cm-demo-overlay-table1-1_group').style.display='none';
                                                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                                                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);
                                                    for(x=0;x<7;x++){

                                                        if(cols[x]==null || cols[x]=='undefined'){
                                                            cols[x]='';
                                                            gwp[x]=0;
                                                        }
                                                    }
                                                    motorPercent=((parseFloat(motorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                                                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);

                                                    document.getElementById('cmchartCWG_group-div').innerHTML='';
                                                    document.getElementById('cmchartCWG_group-div').innerHTML="<canvas id=\"cmchartCWG_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    


                                                    var cmchartCWG_group = document.getElementById("cmchartCWG_group");
                                                    var myChart = new Chart(cmchartCWG_group, {
                                                        type: 'bar',
                                                        data: {
                                                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                                                    // for(x=0;x<cols.length;x++){
                                                                    //     cols[x];    
                                                                    // }
                                                                    


                                                                ],
                                                            datasets: [
                                                                {
                                                                    label: "GWP",

                                                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                                                    // String  or array - the bar color
                                                                    backgroundColor: "rgba(0,121,235,0.4)",

                                                                    // String or array - bar stroke color
                                                                    borderColor: "rgba(0,121,235,1)",

                                                                    // Number or array - bar border width
                                                                    borderWidth: 1,

                                                                    // String or array - fill color when hovered
                                                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                                                    // String or array - border color when hovered
                                                                    hoverBorderColor: "rgba(0,121,235,1)",

                                                                    // The actual data
                                                                    data: [
                                                                        // for(x=0;x<cols.length;x++){
                                                                        //     gwp[x];    
                                                                        // }
                                                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                                                    ],

                                                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cmCWGdemo-overlay-chart1-0_group').style.display='none';

                                                    document.getElementById('cm-chart-1-1_group-div').innerHTML='';
                                                    document.getElementById('cm-chart-1-1_group-div').innerHTML="<canvas id=\"cm-chart-1-1_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var cm_ctx1_1_group = document.getElementById("cm-chart-1-1_group");
                                                    var myChart = new Chart(cm_ctx1_1_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Motor "+convertToZero(motorPercent)+"%","Non Motor "+convertToZero(nonmotorPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(motorPercent),convertToZero(nonmotorPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cm-demo-overlay-chart1-1_group').style.display='none';

                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            $.ajax({
                                                type:'get',
                                                url:'chart4data_group',
                                                data:{key:goi},
                                                success:function(data){
                                                    cols=[];
                                                    motor=[];
                                                    noncar=[];
                                                    aaData=jQuery.parseJSON(data);
                                                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);
                                                    document.getElementById('cm-motor-addition_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-addition_group').innerHTML='';
                                                    document.getElementById('cm-motor-deletion_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-deletion_group').innerHTML='';
                                                    document.getElementById('cm-motor-renewal_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-renewal_group').innerHTML='';
                                                    document.getElementById('cm-motor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('cm-motor-reinstate_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-reinstate_group').innerHTML='';
                                                    document.getElementById('cm-motor-new_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-new_group').innerHTML='';
                                                    document.getElementById('cm-motor-cancel_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-cancel_group').innerHTML='';
                                                    for(x=0 ; x<aaData.length ; x++){
                                                        cols[x]=aaData[x].pol_status;
                                                        motor[x]=aaData[x].motor_car_gwp;
                                                        noncar[x]=aaData[x].motor_noncar_gwp;

                                                        if(cols[x]=='ADDITION'){
                                                            console.log("Addition");
                                                            document.getElementById('cm-motor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='DELETION'){
                                                            console.log("DELETION");
                                                            document.getElementById('cm-motor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='RENEWAL'){
                                                            console.log("Renewal");
                                                            document.getElementById('cm-motor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='PPW-CANC'){
                                                            console.log("PPW-CANC");
                                                            document.getElementById('cm-motor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='REINSTATE') {
                                                            console.log("REINSTATE");
                                                            document.getElementById('cm-motor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='NEW') {
                                                            console.log("NEW");
                                                            document.getElementById('cm-motor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='CANCEL') {
                                                            console.log("CANCEL");
                                                            document.getElementById('cm-motor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }
                                                    }


                                                    document.getElementById('cm-motor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));
                                                    document.getElementById('cm-nonmotor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2));
                                                    document.getElementById('cm-grand-total_group').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6])))).toFixed(2));
                                                    document.getElementById('cm-demo-overlay-table1_group').style.display='none';
                                                    carP=0;
                                                    noncarP=0;
                                                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                                                    noncarP=(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2);

                                                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    
                                                    document.getElementById('cm-chartMotor_group-div').innerHTML='';
                                                    document.getElementById('cm-chartMotor_group-div').innerHTML="<canvas id=\"cm-chartMotor_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var cm_ctxMotor_group = document.getElementById("cm-chartMotor_group");
                                                    var myChart = new Chart(cm_ctxMotor_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Car "+convertToZero(carPercent)+"%","Non Car "+convertToZero(noncarPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(carPercent),convertToZero(noncarPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cm-demo-overlay-chart-1-1-1_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });


                                            $.ajax({
                                                type:'get',
                                                url:'CMNOP_group',
                                                data:{key:goi},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    abData=jQuery.parseJSON(data);

                                                    cols=[];
                                                    gwp=[];
                                                    nop=[];
                                                    var t_gwp=0;
                                                    var t_nop=0;
                                                    for(x=0 ; x<abData.length ; x++){
                                                        cols[x]=abData[x].type;
                                                        gwp[x]=abData[x].gwp;
                                                        nop[x]=abData[x].nop;

                                                        t_gwp+=parseFloat(gwp[x]);
                                                        t_nop+=parseFloat(nop[x]);
                                                    }
                                                    document.getElementById('cm-motor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                                                    document.getElementById('cm-motor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                                                    document.getElementById('cm-motor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                                                    document.getElementById('cm-motor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                                                    document.getElementById('cm-nonmotor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                                                    document.getElementById('cm-nonmotor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                                                    document.getElementById('cm-nonmotor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                                                    document.getElementById('cm-nonmotor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                                                    document.getElementById('cm-total-gwp_group').innerHTML=formatNumber((convertToZero(t_gwp.toFixed(2))));
                                                    document.getElementById('cm-total-nop_group').innerHTML=formatNumber((convertToZero(t_nop)));
                                                    document.getElementById('cm-demo-overlay-table2_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            $.ajax({

                                                type:'get',
                                                url:'chart3data_group',
                                                data:{key:goi},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    acData=jQuery.parseJSON(data);
                                                    // console.log("ahas"+acData);
                                                    // cols=[];
                                                    // target=[];
                                                    // achievement=[];
                                                    var t_target=0;
                                                    var t_achievement=0;
                                                    // for(x=0 ; x<acData.length ; x++){
                                                    //     cols[x]=acData[x].type;
                                                    //     target[x]=acData[x].target_amount;
                                                    //     achievement[x]=acData[x].achievement_amt;

                                                        t_target=parseFloat(convertToZero(acData.motor_target))+parseFloat(convertToZero(acData.nonmotor_target));
                                                        t_achievement=parseFloat(convertToZero(acData.motor_achievement))+parseFloat(convertToZero(acData.nonmotor_achievement));
                                                    // }
                                                    console.log("motor tar: "+t_target);
                                                    console.log("motor ach: "+t_achievement);

                                                    document.getElementById('motor-target_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_target)).toFixed(2));
                                                    document.getElementById('motor-achievement_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_achievement)).toFixed(2));
                                                    document.getElementById('motor-percentage_group').innerHTML=((parseFloat(convertToZero(acData.motor_achievement))/parseFloat(convertToZero(acData.motor_target)))*100).toFixed(2)+'%';//%
                                                    document.getElementById('nonmotor-target_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_target)).toFixed(2));
                                                    document.getElementById('nonmotor-achievement_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_achievement)).toFixed(2));
                                                    document.getElementById('nonmotor-percentage_group').innerHTML=((parseFloat(convertToZero(acData.nonmotor_achievement))/parseFloat(convertToZero(acData.nonmotor_target)))*100).toFixed(2)+'%';
                                                    document.getElementById('total-target_group').innerHTML=formatNumber(convertToZero(t_target).toFixed(2));
                                                    document.getElementById('total-achievement_group').innerHTML=formatNumber(convertToZero(t_achievement).toFixed(2));
                                                    document.getElementById('total-percentage_group').innerHTML=((convertToZero(t_achievement)/convertToZero(t_target))*100).toFixed(2)+'%';

                                                    // document.getElementById('demo-overlay-table3_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });

               

                                            

                                            //ajax to get data for table cumulative-non-motor
                                            

                                            document.getElementById('group-button').click();
                            }
                        } 
                        if(region!=null || region != " "){

                          document.getElementById('claim-value').innerHTML = '';
                          document.getElementById("claim-ratio-style").style.width = "";
                          document.getElementById('claim-ratio-value').innerHTML="";

                          document.getElementById('profitability-value').innerHTML='';
                          document.getElementById("profitability-ratio-style").style.width = '';
                          document.getElementById('profitability-ratio-value').innerHTML='';

                           document.getElementById("ppw-ratio-style").style.width = "";
                           document.getElementById('ppw-ratio-value').innerHTML="";
                            document.getElementById('ppw-value').innerHTML = "";

                         
                             // branch detials loader
                                $.ajax({
                                    type:'get',
                                    url:'Branch_details',
                                    data:{key:region},
                                    success:function(data){



                                        if(data.length!=2){
                                            member_data=jQuery.parseJSON(data);
                                            console.log(member_data[0].user_code);
                                            document.getElementById('group-code').innerHTML="Code : <strong>"+member_data[0].user_code+"</strong>";
                                            document.getElementById('group-name').innerHTML="Branch Manager Name : <strong>"+member_data[0].user_name+"</strong>";
                                            document.getElementById('group-branch').innerHTML="Branch : <strong>"+member_data[0].branch+"</strong>";

                                        
                                            
                                            
                                            //fmt group
                                            $.ajax({
                                                type:'get',
                                                url:'chart1_0_1data_group_branch',
                                                data:{key:region},
                                                success:function(data){
                                                    nonmotorP=0;
                                                    motorP=0;
                                                    cols=[];
                                                    gwp=[];
                                                    axData=jQuery.parseJSON(data);

                                                    document.getElementById('cwg-fire_group').innerHTML='';
                                                    document.getElementById('cwg-misc_group').innerHTML='';
                                                    document.getElementById('cwg-motor_group').innerHTML='';
                                                    document.getElementById('cwg-wci_group').innerHTML='';
                                                    document.getElementById('cwg-eng_group').innerHTML='';
                                                    document.getElementById('cwg-marine_group').innerHTML='';
                                                    document.getElementById('cwg-med_group').innerHTML='';

                                                    for(x=0 ; x<axData.length ; x++){
                                                        cols[x]=axData[x].dept_new;
                                                        gwp[x]=axData[x].gwp;


                                                        if(cols[x]=='FIRE'){
                                                            document.getElementById('cwg-fire_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MISC'){
                                                            document.getElementById('cwg-misc_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MOTOR'){
                                                            document.getElementById('cwg-motor_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            motorP+=(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='WCI'){
                                                            document.getElementById('cwg-wci_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='ENGG') {
                                                            document.getElementById('cwg-eng_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MARINE') {
                                                            document.getElementById('cwg-marine_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MED') {
                                                            document.getElementById('cwg-med_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }
                                                    }

                                                    

                                                var total = (parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);

                                                    document.getElementById('cwg-total_group').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));
                                                    



                                                    document.getElementById('demo-overlay-table1-1_group').style.display='none';
                                                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                                                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);

                                                    motorPercent=((parseFloat(motorP)/(parseFloat(total)))*100).toFixed(2);
                                                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(total)))*100).toFixed(2);
                                                    for(x=0;x<7;x++){

                                                        if(cols[x]==null || cols[x]=='undefined'){
                                                            cols[x]='';
                                                            gwp[x]=0;
                                                        }
                                                    }
                                                    document.getElementById('chartCWG_group-div').innerHTML='';
                                                    document.getElementById('chartCWG_group-div').innerHTML="<canvas id=\"chartCWG_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    
                                                    var chartCWG_group = document.getElementById("chartCWG_group");
                                                    


                                                    var myChart = new Chart(chartCWG_group, {
                                                    
                                                        type: 'bar',
                                                        data: {
                                                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                                                    // for(x=0;x<cols.length;x++){
                                                                    //     cols[x];    
                                                                    // }
                                                                    


                                                                ],
                                                            datasets: [
                                                                {
                                                                    label: "GWP",

                                                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                                                    // String  or array - the bar color
                                                                    backgroundColor: "rgba(0,121,235,0.4)",

                                                                    // String or array - bar stroke color
                                                                    borderColor: "rgba(0,121,235,1)",

                                                                    // Number or array - bar border width
                                                                    borderWidth: 1,

                                                                    // String or array - fill color when hovered
                                                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                                                    // String or array - border color when hovered
                                                                    hoverBorderColor: "rgba(0,121,235,1)",

                                                                    // The actual data
                                                                    data: [
                                                                        // for(x=0;x<cols.length;x++){
                                                                        //     gwp[x];    
                                                                        // }
                                                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                                                    ],

                                                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                                                },

                                                            ]
                                                        },
                                                        options: {
                                                            animateScale: true
                                                        }
                                                    });
                                                    document.getElementById('CWGdemo-overlay-chart1-0_group').style.display='none';

                                                    document.getElementById('chart-1-1_group-div').innerHTML='';
                                                    document.getElementById('chart-1-1_group-div').innerHTML="<canvas id=\"chart-1-1_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var ctx1_1_group = document.getElementById("chart-1-1_group");
                                                    var myChart = new Chart(ctx1_1_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Motor "+convertToZero(motorPercent)+"%","Non Motor "+convertToZero(nonmotorPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(motorPercent),convertToZero(nonmotorPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('demo-overlay-chart1-1_group').style.display='none';

                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });


                                            //ajax to get data for chart 1 and table1
                                            $.ajax({
                                                type:'get',
                                                url:'chart1data_group_branch',
                                                data:{key:region},
                                                success:function(data){
                                                    cols=[];
                                                    motor=[];
                                                    noncar=[];
                                                    aaData=jQuery.parseJSON(data);
                                                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);

                                                    document.getElementById('motor-addition_group').innerHTML='';
                                                    document.getElementById('nonmotor-addition_group').innerHTML='';
                                                    document.getElementById('motor-deletion_group').innerHTML='';
                                                    document.getElementById('nonmotor-deletion_group').innerHTML='';
                                                    document.getElementById('motor-renewal_group').innerHTML='';
                                                    document.getElementById('nonmotor-renewal_group').innerHTML='';
                                                    document.getElementById('motor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('nonmotor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('motor-reinstate_group').innerHTML='';
                                                    document.getElementById('nonmotor-reinstate_group').innerHTML='';
                                                    document.getElementById('motor-new_group').innerHTML='';
                                                    document.getElementById('nonmotor-new_group').innerHTML='';
                                                    document.getElementById('motor-cancel_group').innerHTML='';
                                                    document.getElementById('nonmotor-cancel_group').innerHTML='';

                                                    for(x=0 ; x<aaData.length ; x++){
                                                        cols[x]=aaData[x].pol_status;
                                                        motor[x]=aaData[x].motor_car_gwp;
                                                        noncar[x]=aaData[x].motor_noncar_gwp;

                                                        if(cols[x]=='ADDITION'){
                                                            console.log("Addition");
                                                            document.getElementById('motor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='DELETION'){
                                                            console.log("DELETION");
                                                            document.getElementById('motor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='RENEWAL'){
                                                            console.log("Renewal");
                                                            document.getElementById('motor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='PPW-CANC'){
                                                            console.log("PPW-CANC");
                                                            document.getElementById('motor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='REINSTATE') {
                                                            console.log("REINSTATE");
                                                            document.getElementById('motor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='NEW') {
                                                            console.log("NEW");
                                                            document.getElementById('motor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='CANCEL') {
                                                            console.log("CANCEL");
                                                            document.getElementById('motor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }
                                                    }


                                                    document.getElementById('motor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));
                                                    document.getElementById('nonmotor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2));
                                                    document.getElementById('grand-total_group').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6])))).toFixed(2));
                                                    document.getElementById('demo-overlay-table1_group').style.display='none';
                                                    carP=0;
                                                    noncarP=0;
                                                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                                                    noncarP=(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2);

                                                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);

                                                    document.getElementById('chartMotor_group-div').innerHTML='';
                                                    document.getElementById('chartMotor_group-div').innerHTML="<canvas id=\"chartMotor_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var ctxMotor_group = document.getElementById("chartMotor_group");
                                                    var myChart = new Chart(ctxMotor_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Car "+convertToZero(carPercent)+"%","Non Car "+convertToZero(noncarPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(carPercent),convertToZero(noncarPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('demo-overlay-chart-1-1-1_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            //get data for chart2 and table
                                            $.ajax({
                                                type:'get',
                                                url:'chart2data_group_branch',
                                                data:{key:region},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    abData=jQuery.parseJSON(data);

                                                    cols=[];
                                                    gwp=[];
                                                    nop=[];
                                                    var t_gwp=0;
                                                    var t_nop=0;
                                                    for(x=0 ; x<abData.length ; x++){
                                                        cols[x]=abData[x].type;
                                                        gwp[x]=abData[x].gwp;
                                                        nop[x]=abData[x].nop;

                                                        t_gwp+=parseFloat(gwp[x]);
                                                        t_nop+=parseFloat(nop[x]);
                                                    }
                                                    document.getElementById('motor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                                                    document.getElementById('motor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                                                    document.getElementById('motor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                                                    document.getElementById('motor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                                                    document.getElementById('nonmotor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                                                    document.getElementById('nonmotor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                                                    document.getElementById('nonmotor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                                                    document.getElementById('nonmotor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                                                    document.getElementById('total-gwp_group').innerHTML=formatNumber((convertToZero(t_gwp.toFixed(2))));
                                                    document.getElementById('total-nop_group').innerHTML=formatNumber((convertToZero(t_nop)));
                                                    document.getElementById('demo-overlay-table2_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });
                                            

                                            //cumulative group
                                            $.ajax({
                                                type:'get',
                                                url:'cumulative_cwg_group_branch',
                                                data:{key:region},
                                                success:function(data){
                                                    nonmotorP=0;
                                                    motorP=0;
                                                    cols=[];
                                                    gwp=[];
                                                    axData=jQuery.parseJSON(data);
                                                    document.getElementById('cm-cwg-fire_group').innerHTML='';
                                                    document.getElementById('cm-cwg-misc_group').innerHTML='';
                                                    document.getElementById('cm-cwg-motor_group').innerHTML='';
                                                    document.getElementById('cm-cwg-wci_group').innerHTML='';
                                                    document.getElementById('cm-cwg-eng_group').innerHTML='';
                                                    document.getElementById('cm-cwg-marine_group').innerHTML='';
                                                    document.getElementById('cm-cwg-med_group').innerHTML='';

                                                    for(x=0 ; x<axData.length ; x++){
                                                        cols[x]=axData[x].dept_new;
                                                        gwp[x]=axData[x].gwp;

                                                        if(cols[x]=='FIRE'){
                                                            document.getElementById('cm-cwg-fire_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='MISC'){
                                                            document.getElementById('cm-cwg-misc_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='MOTOR'){
                                                            document.getElementById('cm-cwg-motor_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            motorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='WCI'){
                                                            document.getElementById('cm-cwg-wci_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if (cols[x]=='ENGG') {
                                                            document.getElementById('cm-cwg-eng_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if (cols[x]=='MARINE') {
                                                            document.getElementById('cm-cwg-marine_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if (cols[x]=='MED') {
                                                            document.getElementById('cm-cwg-med_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP+=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }
                                                    }
                                                
                                                    document.getElementById('cm-cwg-total_group').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));

                                                    document.getElementById('cm-demo-overlay-table1-1_group').style.display='none';
                                                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                                                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);
                                                    for(x=0;x<7;x++){

                                                        if(cols[x]==null || cols[x]=='undefined'){
                                                            cols[x]='';
                                                            gwp[x]=0;
                                                        }
                                                    }
                                                    motorPercent=((parseFloat(motorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                                                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);

                                                    document.getElementById('cmchartCWG_group-div').innerHTML='';
                                                    document.getElementById('cmchartCWG_group-div').innerHTML="<canvas id=\"cmchartCWG_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";

                                                    var cmchartCWG_group = document.getElementById("cmchartCWG_group");
                                                    var myChart = new Chart(cmchartCWG_group, {
                                                        type: 'bar',
                                                        data: {
                                                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                                                    // for(x=0;x<cols.length;x++){
                                                                    //     cols[x];    
                                                                    // }
                                                                    


                                                                ],
                                                            datasets: [
                                                                {
                                                                    label: "GWP",

                                                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                                                    // String  or array - the bar color
                                                                    backgroundColor: "rgba(0,121,235,0.4)",

                                                                    // String or array - bar stroke color
                                                                    borderColor: "rgba(0,121,235,1)",

                                                                    // Number or array - bar border width
                                                                    borderWidth: 1,

                                                                    // String or array - fill color when hovered
                                                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                                                    // String or array - border color when hovered
                                                                    hoverBorderColor: "rgba(0,121,235,1)",

                                                                    // The actual data
                                                                    data: [
                                                                        // for(x=0;x<cols.length;x++){
                                                                        //     gwp[x];    
                                                                        // }
                                                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                                                    ],

                                                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cmCWGdemo-overlay-chart1-0_group').style.display='none';
                                                    
                                                    document.getElementById('cm-chart-1-1_group-div').innerHTML='';
                                                    document.getElementById('cm-chart-1-1_group-div').innerHTML="<canvas id=\"cm-chart-1-1_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var cm_ctx1_1_group = document.getElementById("cm-chart-1-1_group");
                                                    var myChart = new Chart(cm_ctx1_1_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Motor "+convertToZero(motorPercent)+"%","Non Motor "+convertToZero(nonmotorPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(motorPercent),convertToZero(nonmotorPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cm-demo-overlay-chart1-1_group').style.display='none';

                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            $.ajax({
                                                type:'get',
                                                url:'chart4data_group_branch',
                                                data:{key:region},
                                                success:function(data){
                                                    cols=[];
                                                    motor=[];
                                                    noncar=[];
                                                    aaData=jQuery.parseJSON(data);
                                                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);
                                                    document.getElementById('cm-motor-addition_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-addition_group').innerHTML='';
                                                    document.getElementById('cm-motor-deletion_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-deletion_group').innerHTML='';
                                                    document.getElementById('cm-motor-renewal_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-renewal_group').innerHTML='';
                                                    document.getElementById('cm-motor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('cm-motor-reinstate_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-reinstate_group').innerHTML='';
                                                    document.getElementById('cm-motor-new_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-new_group').innerHTML='';
                                                    document.getElementById('cm-motor-cancel_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-cancel_group').innerHTML='';
                                                    for(x=0 ; x<aaData.length ; x++){
                                                        cols[x]=aaData[x].pol_status;
                                                        motor[x]=aaData[x].motor_car_gwp;
                                                        noncar[x]=aaData[x].motor_noncar_gwp;

                                                        if(cols[x]=='ADDITION'){
                                                            console.log("Addition");
                                                            document.getElementById('cm-motor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='DELETION'){
                                                            console.log("DELETION");
                                                            document.getElementById('cm-motor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='RENEWAL'){
                                                            console.log("Renewal");
                                                            document.getElementById('cm-motor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='PPW-CANC'){
                                                            console.log("PPW-CANC");
                                                            document.getElementById('cm-motor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='REINSTATE') {
                                                            console.log("REINSTATE");
                                                            document.getElementById('cm-motor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='NEW') {
                                                            console.log("NEW");
                                                            document.getElementById('cm-motor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='CANCEL') {
                                                            console.log("CANCEL");
                                                            document.getElementById('cm-motor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }
                                                    }


                                                    document.getElementById('cm-motor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));
                                                    document.getElementById('cm-nonmotor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2));
                                                    document.getElementById('cm-grand-total_group').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6])))).toFixed(2));
                                                    document.getElementById('cm-demo-overlay-table1_group').style.display='none';
                                                    carP=0;
                                                    noncarP=0;
                                                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                                                    noncarP=(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2);

                                                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    
                                                    document.getElementById('cm-chartMotor_group-div').innerHTML='';
                                                    document.getElementById('cm-chartMotor_group-div').innerHTML="<canvas id=\"cm-chartMotor_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var cm_ctxMotor_group = document.getElementById("cm-chartMotor_group");
                                                    var myChart = new Chart(cm_ctxMotor_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Car "+convertToZero(carPercent)+"%","Non Car "+convertToZero(noncarPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(carPercent),convertToZero(noncarPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cm-demo-overlay-chart-1-1-1_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });


                                            $.ajax({
                                                type:'get',
                                                url:'CMNOP_group_branch',
                                                data:{key:region},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    abData=jQuery.parseJSON(data);

                                                    cols=[];
                                                    gwp=[];
                                                    nop=[];
                                                    var t_gwp=0;
                                                    var t_nop=0;
                                                    for(x=0 ; x<abData.length ; x++){
                                                        cols[x]=abData[x].type;
                                                        gwp[x]=abData[x].gwp;
                                                        nop[x]=abData[x].nop;

                                                        t_gwp+=parseFloat(gwp[x]);
                                                        t_nop+=parseFloat(nop[x]);
                                                    }
                                                    document.getElementById('cm-motor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                                                    document.getElementById('cm-motor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                                                    document.getElementById('cm-motor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                                                    document.getElementById('cm-motor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                                                    document.getElementById('cm-nonmotor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                                                    document.getElementById('cm-nonmotor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                                                    document.getElementById('cm-nonmotor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                                                    document.getElementById('cm-nonmotor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                                                    document.getElementById('cm-total-gwp_group').innerHTML=formatNumber((convertToZero(t_gwp.toFixed(2))));
                                                    document.getElementById('cm-total-nop_group').innerHTML=formatNumber((convertToZero(t_nop)));
                                                    document.getElementById('cm-demo-overlay-table2_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            $.ajax({

                                                type:'get',
                                                url:'chart3data_group_branch',
                                                data:{key:region},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    acData=jQuery.parseJSON(data);
                                                    // console.log("ahas"+acData);
                                                    // cols=[];
                                                    // target=[];
                                                    // achievement=[];
                                                    var t_target=0;
                                                    var t_achievement=0;
                                                    // for(x=0 ; x<acData.length ; x++){
                                                    //     cols[x]=acData[x].type;
                                                    //     target[x]=acData[x].target_amount;
                                                    //     achievement[x]=acData[x].achievement_amt;

                                                        t_target=parseFloat(convertToZero(acData.motor_target))+parseFloat(convertToZero(acData.nonmotor_target));
                                                        t_achievement=parseFloat(convertToZero(acData.motor_achievement))+parseFloat(convertToZero(acData.nonmotor_achievement));
                                                    // }
                                                    console.log("motor tar: "+t_target);
                                                    console.log("motor ach: "+t_achievement);

                                                    document.getElementById('motor-target_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_target)).toFixed(2));
                                                    document.getElementById('motor-achievement_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_achievement)).toFixed(2));
                                                    document.getElementById('motor-percentage_group').innerHTML=((parseFloat(convertToZero(acData.motor_achievement))/parseFloat(convertToZero(acData.motor_target)))*100).toFixed(2)+'%';//%
                                                    document.getElementById('nonmotor-target_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_target)).toFixed(2));
                                                    document.getElementById('nonmotor-achievement_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_achievement)).toFixed(2));
                                                    document.getElementById('nonmotor-percentage_group').innerHTML=((parseFloat(convertToZero(acData.nonmotor_achievement))/parseFloat(convertToZero(acData.nonmotor_target)))*100).toFixed(2)+'%';
                                                    document.getElementById('total-target_group').innerHTML=formatNumber(convertToZero(t_target).toFixed(2));
                                                    document.getElementById('total-achievement_group').innerHTML=formatNumber(convertToZero(t_achievement).toFixed(2));
                                                    document.getElementById('total-percentage_group').innerHTML=((convertToZero(t_achievement)/convertToZero(t_target))*100).toFixed(2)+'%';

                                                    // document.getElementById('demo-overlay-table3_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });

               

                                            



                                            //ajax to get data for table cumulative-non-motor
                                            

                                            document.getElementById('group-button').click();
                                        }else{
                                            console.log("no data");
                                            return false;
                                        }
                                    },
                                    error:function(x,y,thrown){
                                        console.log(thrown);
                                    }
                                });

                        }
                        if(cluster!=null || cluster != " "){

                          document.getElementById('claim-value').innerHTML = '';
                          document.getElementById("claim-ratio-style").style.width = "";
                          document.getElementById('claim-ratio-value').innerHTML="";

                          document.getElementById('profitability-value').innerHTML='';
                          document.getElementById("profitability-ratio-style").style.width = '';
                          document.getElementById('profitability-ratio-value').innerHTML='';

                           document.getElementById("ppw-ratio-style").style.width = "";
                           document.getElementById('ppw-ratio-value').innerHTML="";
                            document.getElementById('ppw-value').innerHTML = "";
                     
                             // branch detials loader
                                $.ajax({
                                    type:'get',
                                    url:'region_details',
                                    data:{key:cluster},
                                    success:function(data){



                                        if(data.length!=2){
                                            member_data=jQuery.parseJSON(data);
                                            console.log(member_data[0].user_code);
                                            document.getElementById('group-code').innerHTML="Code : <strong>"+member_data[0].user_code+"</strong>";
                                            document.getElementById('group-name').innerHTML="Cluster Manager Name : <strong>"+member_data[0].user_name+"</strong>";
                                            document.getElementById('group-branch').innerHTML="Cluster : <strong>"+member_data[0].region+"</strong>";

                                        
                                            
                                            
                                            //fmt group
                                            $.ajax({
                                                type:'get',
                                                url:'chart1_0_1data_group_region',
                                                data:{key:cluster},
                                                success:function(data){
                                                    nonmotorP=0;
                                                    motorP=0;
                                                    cols=[];
                                                    gwp=[];
                                                    axData=jQuery.parseJSON(data);

                                                    document.getElementById('cwg-fire_group').innerHTML='';
                                                    document.getElementById('cwg-misc_group').innerHTML='';
                                                    document.getElementById('cwg-motor_group').innerHTML='';
                                                    document.getElementById('cwg-wci_group').innerHTML='';
                                                    document.getElementById('cwg-eng_group').innerHTML='';
                                                    document.getElementById('cwg-marine_group').innerHTML='';
                                                    document.getElementById('cwg-med_group').innerHTML='';

                                                    for(x=0 ; x<axData.length ; x++){
                                                        cols[x]=axData[x].dept_new;
                                                        gwp[x]=axData[x].gwp;


                                                        if(cols[x]=='FIRE'){
                                                            document.getElementById('cwg-fire_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MISC'){
                                                            document.getElementById('cwg-misc_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MOTOR'){
                                                            document.getElementById('cwg-motor_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            motorP+=(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='WCI'){
                                                            document.getElementById('cwg-wci_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='ENGG') {
                                                            document.getElementById('cwg-eng_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MARINE') {
                                                            document.getElementById('cwg-marine_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MED') {
                                                            document.getElementById('cwg-med_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }
                                                    }

                                                    

                                                var total = (parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);

                                                    document.getElementById('cwg-total_group').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));
                                                    



                                                    document.getElementById('demo-overlay-table1-1_group').style.display='none';
                                                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                                                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);

                                                    motorPercent=((parseFloat(motorP)/(parseFloat(total)))*100).toFixed(2);
                                                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(total)))*100).toFixed(2);
                                                    for(x=0;x<7;x++){

                                                        if(cols[x]==null || cols[x]=='undefined'){
                                                            cols[x]='';
                                                            gwp[x]=0;
                                                        }
                                                    }
                                                    document.getElementById('chartCWG_group-div').innerHTML='';
                                                    document.getElementById('chartCWG_group-div').innerHTML="<canvas id=\"chartCWG_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    
                                                    var chartCWG_group = document.getElementById("chartCWG_group");
                                                    


                                                    var myChart = new Chart(chartCWG_group, {
                                                    
                                                        type: 'bar',
                                                        data: {
                                                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                                                    // for(x=0;x<cols.length;x++){
                                                                    //     cols[x];    
                                                                    // }
                                                                    


                                                                ],
                                                            datasets: [
                                                                {
                                                                    label: "GWP",

                                                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                                                    // String  or array - the bar color
                                                                    backgroundColor: "rgba(0,121,235,0.4)",

                                                                    // String or array - bar stroke color
                                                                    borderColor: "rgba(0,121,235,1)",

                                                                    // Number or array - bar border width
                                                                    borderWidth: 1,

                                                                    // String or array - fill color when hovered
                                                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                                                    // String or array - border color when hovered
                                                                    hoverBorderColor: "rgba(0,121,235,1)",

                                                                    // The actual data
                                                                    data: [
                                                                        // for(x=0;x<cols.length;x++){
                                                                        //     gwp[x];    
                                                                        // }
                                                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                                                    ],

                                                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                                                },

                                                            ]
                                                        },
                                                        options: {
                                                            animateScale: true
                                                        }
                                                    });
                                                    document.getElementById('CWGdemo-overlay-chart1-0_group').style.display='none';

                                                    document.getElementById('chart-1-1_group-div').innerHTML='';
                                                    document.getElementById('chart-1-1_group-div').innerHTML="<canvas id=\"chart-1-1_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var ctx1_1_group = document.getElementById("chart-1-1_group");
                                                    var myChart = new Chart(ctx1_1_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Motor "+convertToZero(motorPercent)+"%","Non Motor "+convertToZero(nonmotorPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(motorPercent),convertToZero(nonmotorPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('demo-overlay-chart1-1_group').style.display='none';

                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });


                                            //ajax to get data for chart 1 and table1
                                            $.ajax({
                                                type:'get',
                                                url:'chart1data_group_region',
                                                data:{key:cluster},
                                                success:function(data){
                                                    cols=[];
                                                    motor=[];
                                                    noncar=[];
                                                    aaData=jQuery.parseJSON(data);
                                                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);

                                                    document.getElementById('motor-addition_group').innerHTML='';
                                                    document.getElementById('nonmotor-addition_group').innerHTML='';
                                                    document.getElementById('motor-deletion_group').innerHTML='';
                                                    document.getElementById('nonmotor-deletion_group').innerHTML='';
                                                    document.getElementById('motor-renewal_group').innerHTML='';
                                                    document.getElementById('nonmotor-renewal_group').innerHTML='';
                                                    document.getElementById('motor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('nonmotor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('motor-reinstate_group').innerHTML='';
                                                    document.getElementById('nonmotor-reinstate_group').innerHTML='';
                                                    document.getElementById('motor-new_group').innerHTML='';
                                                    document.getElementById('nonmotor-new_group').innerHTML='';
                                                    document.getElementById('motor-cancel_group').innerHTML='';
                                                    document.getElementById('nonmotor-cancel_group').innerHTML='';

                                                    for(x=0 ; x<aaData.length ; x++){
                                                        cols[x]=aaData[x].pol_status;
                                                        motor[x]=aaData[x].motor_car_gwp;
                                                        noncar[x]=aaData[x].motor_noncar_gwp;

                                                        if(cols[x]=='ADDITION'){
                                                            console.log("Addition");
                                                            document.getElementById('motor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='DELETION'){
                                                            console.log("DELETION");
                                                            document.getElementById('motor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='RENEWAL'){
                                                            console.log("Renewal");
                                                            document.getElementById('motor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='PPW-CANC'){
                                                            console.log("PPW-CANC");
                                                            document.getElementById('motor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='REINSTATE') {
                                                            console.log("REINSTATE");
                                                            document.getElementById('motor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='NEW') {
                                                            console.log("NEW");
                                                            document.getElementById('motor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='CANCEL') {
                                                            console.log("CANCEL");
                                                            document.getElementById('motor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }
                                                    }


                                                    document.getElementById('motor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));
                                                    document.getElementById('nonmotor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2));
                                                    document.getElementById('grand-total_group').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6])))).toFixed(2));
                                                    document.getElementById('demo-overlay-table1_group').style.display='none';
                                                    carP=0;
                                                    noncarP=0;
                                                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                                                    noncarP=(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2);

                                                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);

                                                    document.getElementById('chartMotor_group-div').innerHTML='';
                                                    document.getElementById('chartMotor_group-div').innerHTML="<canvas id=\"chartMotor_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var ctxMotor_group = document.getElementById("chartMotor_group");
                                                    var myChart = new Chart(ctxMotor_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Car "+convertToZero(carPercent)+"%","Non Car "+convertToZero(noncarPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(carPercent),convertToZero(noncarPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('demo-overlay-chart-1-1-1_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            //get data for chart2 and table
                                            $.ajax({
                                                type:'get',
                                                url:'chart2data_group_region',
                                                data:{key:cluster},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    abData=jQuery.parseJSON(data);

                                                    cols=[];
                                                    gwp=[];
                                                    nop=[];
                                                    var t_gwp=0;
                                                    var t_nop=0;
                                                    for(x=0 ; x<abData.length ; x++){
                                                        cols[x]=abData[x].type;
                                                        gwp[x]=abData[x].gwp;
                                                        nop[x]=abData[x].nop;

                                                        t_gwp+=parseFloat(gwp[x]);
                                                        t_nop+=parseFloat(nop[x]);
                                                    }
                                                    document.getElementById('motor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                                                    document.getElementById('motor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                                                    document.getElementById('motor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                                                    document.getElementById('motor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                                                    document.getElementById('nonmotor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                                                    document.getElementById('nonmotor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                                                    document.getElementById('nonmotor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                                                    document.getElementById('nonmotor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                                                    document.getElementById('total-gwp_group').innerHTML=formatNumber((convertToZero(t_gwp.toFixed(2))));
                                                    document.getElementById('total-nop_group').innerHTML=formatNumber((convertToZero(t_nop)));
                                                    document.getElementById('demo-overlay-table2_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });
                                            

                                            //cumulative group
                                            $.ajax({
                                                type:'get',
                                                url:'cumulative_cwg_group_region',
                                                data:{key:cluster},
                                                success:function(data){
                                                    nonmotorP=0;
                                                    motorP=0;
                                                    cols=[];
                                                    gwp=[];
                                                    axData=jQuery.parseJSON(data);
                                                    document.getElementById('cm-cwg-fire_group').innerHTML='';
                                                    document.getElementById('cm-cwg-misc_group').innerHTML='';
                                                    document.getElementById('cm-cwg-motor_group').innerHTML='';
                                                    document.getElementById('cm-cwg-wci_group').innerHTML='';
                                                    document.getElementById('cm-cwg-eng_group').innerHTML='';
                                                    document.getElementById('cm-cwg-marine_group').innerHTML='';
                                                    document.getElementById('cm-cwg-med_group').innerHTML='';

                                                    for(x=0 ; x<axData.length ; x++){
                                                        cols[x]=axData[x].dept_new;
                                                        gwp[x]=axData[x].gwp;

                                                        if(cols[x]=='FIRE'){
                                                            document.getElementById('cm-cwg-fire_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                           nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MISC'){
                                                            document.getElementById('cm-cwg-misc_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MOTOR'){
                                                            document.getElementById('cm-cwg-motor_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            motorP+=(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='WCI'){
                                                            document.getElementById('cm-cwg-wci_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='ENGG') {
                                                            document.getElementById('cm-cwg-eng_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MARINE') {
                                                            document.getElementById('cm-cwg-marine_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                           nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MED') {
                                                            document.getElementById('cm-cwg-med_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                           nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }
                                                    }
                                                
                                                    document.getElementById('cm-cwg-total_group').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));

                                                    document.getElementById('cm-demo-overlay-table1-1_group').style.display='none';
                                                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                                                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);
                                                    for(x=0;x<7;x++){

                                                        if(cols[x]==null || cols[x]=='undefined'){
                                                            cols[x]='';
                                                            gwp[x]=0;
                                                        }
                                                    }
                                                    motorPercent=((parseFloat(motorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                                                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);

                                                    document.getElementById('cmchartCWG_group-div').innerHTML='';
                                                    document.getElementById('cmchartCWG_group-div').innerHTML="<canvas id=\"cmchartCWG_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";

                                                    var cmchartCWG_group = document.getElementById("cmchartCWG_group");
                                                    var myChart = new Chart(cmchartCWG_group, {
                                                        type: 'bar',
                                                        data: {
                                                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                                                    // for(x=0;x<cols.length;x++){
                                                                    //     cols[x];    
                                                                    // }
                                                                    


                                                                ],
                                                            datasets: [
                                                                {
                                                                    label: "GWP",

                                                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                                                    // String  or array - the bar color
                                                                    backgroundColor: "rgba(0,121,235,0.4)",

                                                                    // String or array - bar stroke color
                                                                    borderColor: "rgba(0,121,235,1)",

                                                                    // Number or array - bar border width
                                                                    borderWidth: 1,

                                                                    // String or array - fill color when hovered
                                                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                                                    // String or array - border color when hovered
                                                                    hoverBorderColor: "rgba(0,121,235,1)",

                                                                    // The actual data
                                                                    data: [
                                                                        // for(x=0;x<cols.length;x++){
                                                                        //     gwp[x];    
                                                                        // }
                                                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                                                    ],

                                                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cmCWGdemo-overlay-chart1-0_group').style.display='none';
                                                    
                                                    document.getElementById('cm-chart-1-1_group-div').innerHTML='';
                                                    document.getElementById('cm-chart-1-1_group-div').innerHTML="<canvas id=\"cm-chart-1-1_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var cm_ctx1_1_group = document.getElementById("cm-chart-1-1_group");
                                                    var myChart = new Chart(cm_ctx1_1_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Motor "+convertToZero(motorPercent)+"%","Non Motor "+convertToZero(nonmotorPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(motorPercent),convertToZero(nonmotorPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cm-demo-overlay-chart1-1_group').style.display='none';

                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            $.ajax({
                                                type:'get',
                                                url:'chart4data_group_region',
                                                data:{key:cluster},
                                                success:function(data){
                                                    cols=[];
                                                    motor=[];
                                                    noncar=[];
                                                    aaData=jQuery.parseJSON(data);
                                                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);
                                                    document.getElementById('cm-motor-addition_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-addition_group').innerHTML='';
                                                    document.getElementById('cm-motor-deletion_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-deletion_group').innerHTML='';
                                                    document.getElementById('cm-motor-renewal_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-renewal_group').innerHTML='';
                                                    document.getElementById('cm-motor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('cm-motor-reinstate_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-reinstate_group').innerHTML='';
                                                    document.getElementById('cm-motor-new_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-new_group').innerHTML='';
                                                    document.getElementById('cm-motor-cancel_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-cancel_group').innerHTML='';
                                                    for(x=0 ; x<aaData.length ; x++){
                                                        cols[x]=aaData[x].pol_status;
                                                        motor[x]=aaData[x].motor_car_gwp;
                                                        noncar[x]=aaData[x].motor_noncar_gwp;

                                                        if(cols[x]=='ADDITION'){
                                                            console.log("Addition");
                                                            document.getElementById('cm-motor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='DELETION'){
                                                            console.log("DELETION");
                                                            document.getElementById('cm-motor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='RENEWAL'){
                                                            console.log("Renewal");
                                                            document.getElementById('cm-motor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='PPW-CANC'){
                                                            console.log("PPW-CANC");
                                                            document.getElementById('cm-motor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='REINSTATE') {
                                                            console.log("REINSTATE");
                                                            document.getElementById('cm-motor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='NEW') {
                                                            console.log("NEW");
                                                            document.getElementById('cm-motor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='CANCEL') {
                                                            console.log("CANCEL");
                                                            document.getElementById('cm-motor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }
                                                    }


                                                    document.getElementById('cm-motor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));
                                                    document.getElementById('cm-nonmotor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2));
                                                    document.getElementById('cm-grand-total_group').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6])))).toFixed(2));
                                                    document.getElementById('cm-demo-overlay-table1_group').style.display='none';
                                                    carP=0;
                                                    noncarP=0;
                                                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                                                    noncarP=(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2);

                                                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    
                                                    document.getElementById('cm-chartMotor_group-div').innerHTML='';
                                                    document.getElementById('cm-chartMotor_group-div').innerHTML="<canvas id=\"cm-chartMotor_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var cm_ctxMotor_group = document.getElementById("cm-chartMotor_group");
                                                    var myChart = new Chart(cm_ctxMotor_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Car "+convertToZero(carPercent)+"%","Non Car "+convertToZero(noncarPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(carPercent),convertToZero(noncarPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cm-demo-overlay-chart-1-1-1_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });


                                            $.ajax({
                                                type:'get',
                                                url:'CMNOP_group_region',
                                                data:{key:cluster},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    abData=jQuery.parseJSON(data);

                                                    cols=[];
                                                    gwp=[];
                                                    nop=[];
                                                    var t_gwp=0;
                                                    var t_nop=0;
                                                    for(x=0 ; x<abData.length ; x++){
                                                        cols[x]=abData[x].type;
                                                        gwp[x]=abData[x].gwp;
                                                        nop[x]=abData[x].nop;

                                                        t_gwp+=parseFloat(gwp[x]);
                                                        t_nop+=parseFloat(nop[x]);
                                                    }
                                                    document.getElementById('cm-motor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                                                    document.getElementById('cm-motor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                                                    document.getElementById('cm-motor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                                                    document.getElementById('cm-motor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                                                    document.getElementById('cm-nonmotor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                                                    document.getElementById('cm-nonmotor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                                                    document.getElementById('cm-nonmotor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                                                    document.getElementById('cm-nonmotor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                                                    document.getElementById('cm-total-gwp_group').innerHTML=formatNumber((convertToZero(t_gwp.toFixed(2))));
                                                    document.getElementById('cm-total-nop_group').innerHTML=formatNumber((convertToZero(t_nop)));
                                                    document.getElementById('cm-demo-overlay-table2_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            $.ajax({

                                                type:'get',
                                                url:'chart3data_group_region',
                                                data:{key:cluster},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    acData=jQuery.parseJSON(data);
                                                    // console.log("ahas"+acData);
                                                    // cols=[];
                                                    // target=[];
                                                    // achievement=[];
                                                    var t_target=0;
                                                    var t_achievement=0;
                                                    // for(x=0 ; x<acData.length ; x++){
                                                    //     cols[x]=acData[x].type;
                                                    //     target[x]=acData[x].target_amount;
                                                    //     achievement[x]=acData[x].achievement_amt;

                                                        t_target=parseFloat(convertToZero(acData.motor_target))+parseFloat(convertToZero(acData.nonmotor_target));
                                                        t_achievement=parseFloat(convertToZero(acData.motor_achievement))+parseFloat(convertToZero(acData.nonmotor_achievement));
                                                    // }
                                                    console.log("motor tar: "+t_target);
                                                    console.log("motor ach: "+t_achievement);

                                                    document.getElementById('motor-target_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_target)).toFixed(2));
                                                    document.getElementById('motor-achievement_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_achievement)).toFixed(2));
                                                    document.getElementById('motor-percentage_group').innerHTML=((parseFloat(convertToZero(acData.motor_achievement))/parseFloat(convertToZero(acData.motor_target)))*100).toFixed(2)+'%';//%
                                                    document.getElementById('nonmotor-target_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_target)).toFixed(2));
                                                    document.getElementById('nonmotor-achievement_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_achievement)).toFixed(2));
                                                    document.getElementById('nonmotor-percentage_group').innerHTML=((parseFloat(convertToZero(acData.nonmotor_achievement))/parseFloat(convertToZero(acData.nonmotor_target)))*100).toFixed(2)+'%';
                                                    document.getElementById('total-target_group').innerHTML=formatNumber(convertToZero(t_target).toFixed(2));
                                                    document.getElementById('total-achievement_group').innerHTML=formatNumber(convertToZero(t_achievement).toFixed(2));
                                                    document.getElementById('total-percentage_group').innerHTML=((convertToZero(t_achievement)/convertToZero(t_target))*100).toFixed(2)+'%';

                                                    // document.getElementById('demo-overlay-table3_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });

               

                                            



                                            //ajax to get data for table cumulative-non-motor
                                            

                                            document.getElementById('group-button').click();
                                        }else{
                                            console.log("no data");
                                            return false;
                                        }
                                    },
                                    error:function(x,y,thrown){
                                        console.log(thrown);
                                    }
                                });

                        }
                        if(zone!=null || zone != " "){

                          document.getElementById('claim-value').innerHTML = '';
                          document.getElementById("claim-ratio-style").style.width = "";
                          document.getElementById('claim-ratio-value').innerHTML="";

                          document.getElementById('profitability-value').innerHTML='';
                          document.getElementById("profitability-ratio-style").style.width = '';
                          document.getElementById('profitability-ratio-value').innerHTML='';

                           document.getElementById("ppw-ratio-style").style.width = "";
                           document.getElementById('ppw-ratio-value').innerHTML="";
                           document.getElementById('ppw-value').innerHTML = "";
                     
                             // branch detials loader

                    
                                $.ajax({
                                    type:'get',
                                    url:'zone_details',
                                    data:{key:zone},
                                    success:function(data){



                                        if(data.length!=2){
                                            member_data=jQuery.parseJSON(data);
                                            console.log(member_data[0].user_code);
                                            document.getElementById('group-code').innerHTML="Code : <strong>"+member_data[0].user_code+"</strong>";
                                            document.getElementById('group-name').innerHTML="Zonal Manager Name : <strong>"+member_data[0].user_name+"</strong>";
                                            document.getElementById('group-branch').innerHTML="ZONE : <strong>"+member_data[0].zone+"</strong>";

                                        
                                            
                                            
                                            //fmt group
                                            $.ajax({
                                                type:'get',
                                                url:'chart1_0_1data_group_zone',
                                                data:{key:zone},
                                                success:function(data){
                                                    nonmotorP=0;
                                                    motorP=0;
                                                    cols=[];
                                                    gwp=[];
                                                    axData=jQuery.parseJSON(data);

                                                    document.getElementById('cwg-fire_group').innerHTML='';
                                                    document.getElementById('cwg-misc_group').innerHTML='';
                                                    document.getElementById('cwg-motor_group').innerHTML='';
                                                    document.getElementById('cwg-wci_group').innerHTML='';
                                                    document.getElementById('cwg-eng_group').innerHTML='';
                                                    document.getElementById('cwg-marine_group').innerHTML='';
                                                    document.getElementById('cwg-med_group').innerHTML='';

                                                    for(x=0 ; x<axData.length ; x++){
                                                        cols[x]=axData[x].dept_new;
                                                        gwp[x]=axData[x].gwp;


                                                        if(cols[x]=='FIRE'){
                                                            document.getElementById('cwg-fire_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MISC'){
                                                            document.getElementById('cwg-misc_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MOTOR'){
                                                            document.getElementById('cwg-motor_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            motorP+=(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='WCI'){
                                                            document.getElementById('cwg-wci_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='ENGG') {
                                                            document.getElementById('cwg-eng_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MARINE') {
                                                            document.getElementById('cwg-marine_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MED') {
                                                            document.getElementById('cwg-med_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }
                                                    }

                                                    

                                                var total = (parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);

                                                    document.getElementById('cwg-total_group').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));
                                                    



                                                    document.getElementById('demo-overlay-table1-1_group').style.display='none';
                                                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                                                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);

                                                    motorPercent=((parseFloat(motorP)/(parseFloat(total)))*100).toFixed(2);
                                                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(total)))*100).toFixed(2);
                                                    for(x=0;x<7;x++){

                                                        if(cols[x]==null || cols[x]=='undefined'){
                                                            cols[x]='';
                                                            gwp[x]=0;
                                                        }
                                                    }
                                                    document.getElementById('chartCWG_group-div').innerHTML='';
                                                    document.getElementById('chartCWG_group-div').innerHTML="<canvas id=\"chartCWG_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    
                                                    var chartCWG_group = document.getElementById("chartCWG_group");
                                                    


                                                    var myChart = new Chart(chartCWG_group, {
                                                    
                                                        type: 'bar',
                                                        data: {
                                                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                                                    // for(x=0;x<cols.length;x++){
                                                                    //     cols[x];    
                                                                    // }
                                                                    


                                                                ],
                                                            datasets: [
                                                                {
                                                                    label: "GWP",

                                                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                                                    // String  or array - the bar color
                                                                    backgroundColor: "rgba(0,121,235,0.4)",

                                                                    // String or array - bar stroke color
                                                                    borderColor: "rgba(0,121,235,1)",

                                                                    // Number or array - bar border width
                                                                    borderWidth: 1,

                                                                    // String or array - fill color when hovered
                                                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                                                    // String or array - border color when hovered
                                                                    hoverBorderColor: "rgba(0,121,235,1)",

                                                                    // The actual data
                                                                    data: [
                                                                        // for(x=0;x<cols.length;x++){
                                                                        //     gwp[x];    
                                                                        // }
                                                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                                                    ],

                                                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                                                },

                                                            ]
                                                        },
                                                        options: {
                                                            animateScale: true
                                                        }
                                                    });
                                                    document.getElementById('CWGdemo-overlay-chart1-0_group').style.display='none';

                                                    document.getElementById('chart-1-1_group-div').innerHTML='';
                                                    document.getElementById('chart-1-1_group-div').innerHTML="<canvas id=\"chart-1-1_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var ctx1_1_group = document.getElementById("chart-1-1_group");
                                                    var myChart = new Chart(ctx1_1_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Motor "+convertToZero(motorPercent)+"%","Non Motor "+convertToZero(nonmotorPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(motorPercent),convertToZero(nonmotorPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('demo-overlay-chart1-1_group').style.display='none';

                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });


                                            //ajax to get data for chart 1 and table1
                                            $.ajax({
                                                type:'get',
                                                url:'chart1data_group_zone',
                                                data:{key:zone},
                                                success:function(data){
                                                    cols=[];
                                                    motor=[];
                                                    noncar=[];
                                                    aaData=jQuery.parseJSON(data);
                                                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);

                                                    document.getElementById('motor-addition_group').innerHTML='';
                                                    document.getElementById('nonmotor-addition_group').innerHTML='';
                                                    document.getElementById('motor-deletion_group').innerHTML='';
                                                    document.getElementById('nonmotor-deletion_group').innerHTML='';
                                                    document.getElementById('motor-renewal_group').innerHTML='';
                                                    document.getElementById('nonmotor-renewal_group').innerHTML='';
                                                    document.getElementById('motor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('nonmotor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('motor-reinstate_group').innerHTML='';
                                                    document.getElementById('nonmotor-reinstate_group').innerHTML='';
                                                    document.getElementById('motor-new_group').innerHTML='';
                                                    document.getElementById('nonmotor-new_group').innerHTML='';
                                                    document.getElementById('motor-cancel_group').innerHTML='';
                                                    document.getElementById('nonmotor-cancel_group').innerHTML='';

                                                    for(x=0 ; x<aaData.length ; x++){
                                                        cols[x]=aaData[x].pol_status;
                                                        motor[x]=aaData[x].motor_car_gwp;
                                                        noncar[x]=aaData[x].motor_noncar_gwp;

                                                        if(cols[x]=='ADDITION'){
                                                            console.log("Addition");
                                                            document.getElementById('motor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='DELETION'){
                                                            console.log("DELETION");
                                                            document.getElementById('motor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='RENEWAL'){
                                                            console.log("Renewal");
                                                            document.getElementById('motor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='PPW-CANC'){
                                                            console.log("PPW-CANC");
                                                            document.getElementById('motor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='REINSTATE') {
                                                            console.log("REINSTATE");
                                                            document.getElementById('motor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='NEW') {
                                                            console.log("NEW");
                                                            document.getElementById('motor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='CANCEL') {
                                                            console.log("CANCEL");
                                                            document.getElementById('motor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('nonmotor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }
                                                    }


                                                    document.getElementById('motor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));
                                                    document.getElementById('nonmotor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2));
                                                    document.getElementById('grand-total_group').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6])))).toFixed(2));
                                                    document.getElementById('demo-overlay-table1_group').style.display='none';
                                                    carP=0;
                                                    noncarP=0;
                                                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                                                    noncarP=(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2);

                                                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);

                                                    document.getElementById('chartMotor_group-div').innerHTML='';
                                                    document.getElementById('chartMotor_group-div').innerHTML="<canvas id=\"chartMotor_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var ctxMotor_group = document.getElementById("chartMotor_group");
                                                    var myChart = new Chart(ctxMotor_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Car "+convertToZero(carPercent)+"%","Non Car "+convertToZero(noncarPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(carPercent),convertToZero(noncarPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('demo-overlay-chart-1-1-1_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            //get data for chart2 and table
                                            $.ajax({
                                                type:'get',
                                                url:'chart2data_group_zone',
                                                data:{key:zone},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    abData=jQuery.parseJSON(data);

                                                    cols=[];
                                                    gwp=[];
                                                    nop=[];
                                                    var t_gwp=0;
                                                    var t_nop=0;
                                                    for(x=0 ; x<abData.length ; x++){
                                                        cols[x]=abData[x].type;
                                                        gwp[x]=abData[x].gwp;
                                                        nop[x]=abData[x].nop;

                                                        t_gwp+=parseFloat(gwp[x]);
                                                        t_nop+=parseFloat(nop[x]);
                                                    }
                                                    document.getElementById('motor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                                                    document.getElementById('motor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                                                    document.getElementById('motor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                                                    document.getElementById('motor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                                                    document.getElementById('nonmotor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                                                    document.getElementById('nonmotor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                                                    document.getElementById('nonmotor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                                                    document.getElementById('nonmotor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                                                    document.getElementById('total-gwp_group').innerHTML=formatNumber((convertToZero(t_gwp.toFixed(2))));
                                                    document.getElementById('total-nop_group').innerHTML=formatNumber((convertToZero(t_nop)));
                                                    document.getElementById('demo-overlay-table2_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });
                                            

                                            //cumulative group
                                            $.ajax({
                                                type:'get',
                                                url:'cumulative_cwg_group_zone',
                                                data:{key:zone},
                                                success:function(data){
                                                    nonmotorP=0;
                                                    motorP=0;
                                                    cols=[];
                                                    gwp=[];
                                                    axData=jQuery.parseJSON(data);
                                                    document.getElementById('cm-cwg-fire_group').innerHTML='';
                                                    document.getElementById('cm-cwg-misc_group').innerHTML='';
                                                    document.getElementById('cm-cwg-motor_group').innerHTML='';
                                                    document.getElementById('cm-cwg-wci_group').innerHTML='';
                                                    document.getElementById('cm-cwg-eng_group').innerHTML='';
                                                    document.getElementById('cm-cwg-marine_group').innerHTML='';
                                                    document.getElementById('cm-cwg-med_group').innerHTML='';

                                                    for(x=0 ; x<axData.length ; x++){
                                                        cols[x]=axData[x].dept_new;
                                                        gwp[x]=axData[x].gwp;

                                                        if(cols[x]=='FIRE'){
                                                            document.getElementById('cm-cwg-fire_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                           nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MISC'){
                                                            document.getElementById('cm-cwg-misc_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if(cols[x]=='MOTOR'){
                                                            document.getElementById('cm-cwg-motor_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            motorP+=(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                        }else if(cols[x]=='WCI'){
                                                            document.getElementById('cm-cwg-wci_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='ENGG') {
                                                            document.getElementById('cm-cwg-eng_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MARINE') {
                                                            document.getElementById('cm-cwg-marine_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                           nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }else if (cols[x]=='MED') {
                                                            document.getElementById('cm-cwg-med_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                                                           nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                                                        }
                                                    }
                                                
                                                    document.getElementById('cm-cwg-total_group').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));

                                                    document.getElementById('cm-demo-overlay-table1-1_group').style.display='none';
                                                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                                                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);
                                                    for(x=0;x<7;x++){

                                                        if(cols[x]==null || cols[x]=='undefined'){
                                                            cols[x]='';
                                                            gwp[x]=0;
                                                        }
                                                    }
                                                    motorPercent=((parseFloat(motorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                                                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);

                                                    document.getElementById('cmchartCWG_group-div').innerHTML='';
                                                    document.getElementById('cmchartCWG_group-div').innerHTML="<canvas id=\"cmchartCWG_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";

                                                    var cmchartCWG_group = document.getElementById("cmchartCWG_group");
                                                    var myChart = new Chart(cmchartCWG_group, {
                                                        type: 'bar',
                                                        data: {
                                                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                                                    // for(x=0;x<cols.length;x++){
                                                                    //     cols[x];    
                                                                    // }
                                                                    


                                                                ],
                                                            datasets: [
                                                                {
                                                                    label: "GWP",

                                                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                                                    // String  or array - the bar color
                                                                    backgroundColor: "rgba(0,121,235,0.4)",

                                                                    // String or array - bar stroke color
                                                                    borderColor: "rgba(0,121,235,1)",

                                                                    // Number or array - bar border width
                                                                    borderWidth: 1,

                                                                    // String or array - fill color when hovered
                                                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                                                    // String or array - border color when hovered
                                                                    hoverBorderColor: "rgba(0,121,235,1)",

                                                                    // The actual data
                                                                    data: [
                                                                        // for(x=0;x<cols.length;x++){
                                                                        //     gwp[x];    
                                                                        // }
                                                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                                                    ],

                                                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cmCWGdemo-overlay-chart1-0_group').style.display='none';
                                                    
                                                    document.getElementById('cm-chart-1-1_group-div').innerHTML='';
                                                    document.getElementById('cm-chart-1-1_group-div').innerHTML="<canvas id=\"cm-chart-1-1_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var cm_ctx1_1_group = document.getElementById("cm-chart-1-1_group");
                                                    var myChart = new Chart(cm_ctx1_1_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Motor "+convertToZero(motorPercent)+"%","Non Motor "+convertToZero(nonmotorPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(motorPercent),convertToZero(nonmotorPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cm-demo-overlay-chart1-1_group').style.display='none';

                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            $.ajax({
                                                type:'get',
                                                url:'chart4data_group_zone',
                                                data:{key:zone},
                                                success:function(data){
                                                    cols=[];
                                                    motor=[];
                                                    noncar=[];
                                                    aaData=jQuery.parseJSON(data);
                                                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);
                                                    document.getElementById('cm-motor-addition_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-addition_group').innerHTML='';
                                                    document.getElementById('cm-motor-deletion_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-deletion_group').innerHTML='';
                                                    document.getElementById('cm-motor-renewal_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-renewal_group').innerHTML='';
                                                    document.getElementById('cm-motor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-ppw-canc_group').innerHTML='';
                                                    document.getElementById('cm-motor-reinstate_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-reinstate_group').innerHTML='';
                                                    document.getElementById('cm-motor-new_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-new_group').innerHTML='';
                                                    document.getElementById('cm-motor-cancel_group').innerHTML='';
                                                    document.getElementById('cm-nonmotor-cancel_group').innerHTML='';
                                                    for(x=0 ; x<aaData.length ; x++){
                                                        cols[x]=aaData[x].pol_status;
                                                        motor[x]=aaData[x].motor_car_gwp;
                                                        noncar[x]=aaData[x].motor_noncar_gwp;

                                                        if(cols[x]=='ADDITION'){
                                                            console.log("Addition");
                                                            document.getElementById('cm-motor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-addition_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='DELETION'){
                                                            console.log("DELETION");
                                                            document.getElementById('cm-motor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-deletion_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='RENEWAL'){
                                                            console.log("Renewal");
                                                            document.getElementById('cm-motor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-renewal_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if(cols[x]=='PPW-CANC'){
                                                            console.log("PPW-CANC");
                                                            document.getElementById('cm-motor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-ppw-canc_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='REINSTATE') {
                                                            console.log("REINSTATE");
                                                            document.getElementById('cm-motor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-reinstate_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='NEW') {
                                                            console.log("NEW");
                                                            document.getElementById('cm-motor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-new_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }else if (cols[x]=='CANCEL') {
                                                            console.log("CANCEL");
                                                            document.getElementById('cm-motor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                                                            document.getElementById('cm-nonmotor-cancel_group').innerHTML=formatNumber(parseFloat(convertToZero(noncar[x])).toFixed(2));
                                                        }
                                                    }


                                                    document.getElementById('cm-motor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));
                                                    document.getElementById('cm-nonmotor-total_group').innerHTML=formatNumber((parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2));
                                                    document.getElementById('cm-grand-total_group').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6])))).toFixed(2));
                                                    document.getElementById('cm-demo-overlay-table1_group').style.display='none';
                                                    carP=0;
                                                    noncarP=0;
                                                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                                                    noncarP=(parseFloat(convertToZero(noncar[0]))+parseFloat(convertToZero(noncar[1]))+parseFloat(convertToZero(noncar[2]))+parseFloat(convertToZero(noncar[3]))+parseFloat(convertToZero(noncar[4]))+parseFloat(convertToZero(noncar[5]))+parseFloat(convertToZero(noncar[6]))).toFixed(2);

                                                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                                                    
                                                    document.getElementById('cm-chartMotor_group-div').innerHTML='';
                                                    document.getElementById('cm-chartMotor_group-div').innerHTML="<canvas id=\"cm-chartMotor_group\" style=\"border: 0px solid black;height: 100%;width: 100%\"></canvas>";
                                                    var cm_ctxMotor_group = document.getElementById("cm-chartMotor_group");
                                                    var myChart = new Chart(cm_ctxMotor_group, {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Car "+convertToZero(carPercent)+"%","Non Car "+convertToZero(noncarPercent)+"%"],
                                                            datasets: [
                                                                {
                                                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                                                    // The actual data
                                                                    data: [convertToZero(carPercent),convertToZero(noncarPercent)],

                                                                },

                                                            ]
                                                        },
                                                        options: {

                                                        }
                                                    });
                                                    document.getElementById('cm-demo-overlay-chart-1-1-1_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });


                                            $.ajax({
                                                type:'get',
                                                url:'CMNOP_group_zone',
                                                data:{key:zone},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    abData=jQuery.parseJSON(data);

                                                    cols=[];
                                                    gwp=[];
                                                    nop=[];
                                                    var t_gwp=0;
                                                    var t_nop=0;
                                                    for(x=0 ; x<abData.length ; x++){
                                                        cols[x]=abData[x].type;
                                                        gwp[x]=abData[x].gwp;
                                                        nop[x]=abData[x].nop;

                                                        t_gwp+=parseFloat(gwp[x]);
                                                        t_nop+=parseFloat(nop[x]);
                                                    }
                                                    document.getElementById('cm-motor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                                                    document.getElementById('cm-motor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                                                    document.getElementById('cm-motor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                                                    document.getElementById('cm-motor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                                                    document.getElementById('cm-nonmotor-new-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                                                    document.getElementById('cm-nonmotor-new-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                                                    document.getElementById('cm-nonmotor-renewal-gwp_group').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                                                    document.getElementById('cm-nonmotor-renewal-nop_group').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                                                    document.getElementById('cm-total-gwp_group').innerHTML=formatNumber((convertToZero(t_gwp.toFixed(2))));
                                                    document.getElementById('cm-total-nop_group').innerHTML=formatNumber((convertToZero(t_nop)));
                                                    document.getElementById('cm-demo-overlay-table2_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });



                                            $.ajax({

                                                type:'get',
                                                url:'chart3data_group_zone',
                                                data:{key:zone},
                                                success:function(data){
                                                    console.log(jQuery.parseJSON(data));
                                                    acData=jQuery.parseJSON(data);
                                                    // console.log("ahas"+acData);
                                                    // cols=[];
                                                    // target=[];
                                                    // achievement=[];
                                                    var t_target=0;
                                                    var t_achievement=0;
                                                    // for(x=0 ; x<acData.length ; x++){
                                                    //     cols[x]=acData[x].type;
                                                    //     target[x]=acData[x].target_amount;
                                                    //     achievement[x]=acData[x].achievement_amt;

                                                        t_target=parseFloat(convertToZero(acData.motor_target))+parseFloat(convertToZero(acData.nonmotor_target));
                                                        t_achievement=parseFloat(convertToZero(acData.motor_achievement))+parseFloat(convertToZero(acData.nonmotor_achievement));
                                                    // }
                                                    console.log("motor tar: "+t_target);
                                                    console.log("motor ach: "+t_achievement);

                                                    document.getElementById('motor-target_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_target)).toFixed(2));
                                                    document.getElementById('motor-achievement_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_achievement)).toFixed(2));
                                                    document.getElementById('motor-percentage_group').innerHTML=((parseFloat(convertToZero(acData.motor_achievement))/parseFloat(convertToZero(acData.motor_target)))*100).toFixed(2)+'%';//%
                                                    document.getElementById('nonmotor-target_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_target)).toFixed(2));
                                                    document.getElementById('nonmotor-achievement_group').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_achievement)).toFixed(2));
                                                    document.getElementById('nonmotor-percentage_group').innerHTML=((parseFloat(convertToZero(acData.nonmotor_achievement))/parseFloat(convertToZero(acData.nonmotor_target)))*100).toFixed(2)+'%';
                                                    document.getElementById('total-target_group').innerHTML=formatNumber(convertToZero(t_target).toFixed(2));
                                                    document.getElementById('total-achievement_group').innerHTML=formatNumber(convertToZero(t_achievement).toFixed(2));
                                                    document.getElementById('total-percentage_group').innerHTML=((convertToZero(t_achievement)/convertToZero(t_target))*100).toFixed(2)+'%';

                                                    // document.getElementById('demo-overlay-table3_group').style.display='none';
                                                },
                                                error:function(x,y,z){
                                                    console.log(z);
                                                }
                                            });

               

                                            



                                            //ajax to get data for table cumulative-non-motor
                                            

                                            document.getElementById('group-button').click();
                                        }else{
                                            console.log("no data");
                                            return false;
                                        }
                                    },
                                    error:function(x,y,thrown){
                                        console.log(thrown);
                                    }
                                });

                        }




                        return false;
                    }
                </script>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_4">

                    {{--lead tabs--}}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#sub_1" data-toggle="tab">Add Leads</a></li>
                            <li><a href="#sub_2" data-toggle="tab" onclick="">Search Leads</a></li>
                            <li><a href="#sub_3" id="viewleads-button" data-toggle="tab">View Leads</a></li>
                            
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="sub_1">
                                <div class="row">
                                    <div class="col-xs-12" id="customer-details">
                                        <div class="box box-widget">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Customer Details</h3>
                                            </div>
                                            <!-- /.box-header -->
                                            <!-- form start -->
                                            <div class="box-body">
                                                <div class="form-group col-xs-6">
                                                    <label>Title</label>
                                                    <select id="title" class="form-control">
                                                        
                                                    </select>
                                                </div>
                                                <div class="form-group col-xs-6">
                                                    <label for="customer-name">Customer Name</label>
                                                    <input type="text" class="form-control" id="customer-name" placeholder="Customer Name">
                                                </div>
                                                <div class="form-group col-xs-6">
                                                    <label>Customer address</label>
                                                    <textarea class="form-control" rows="4" id="customer-address" placeholder="Enter customer address"></textarea>
                                                </div>
                                                <div class="form-group col-xs-6">
                                                    <label for="customer-mobile">Mobile</label>
                                                    <input type="text" class="form-control" id="customer-mobile" placeholder="Customer Mobile No.">
                                                </div>

                                                <div class="form-group col-xs-6">
                                                    <label for="customer-home">Home</label>
                                                    <input type="text" class="form-control" id="customer-home" placeholder="Customer Home No.">
                                                </div>
                                                <div class="form-group col-xs-6">
                                                    <label for="customer-town">Town</label>
                                                    <input type="text" class="form-control" id="customer-town" placeholder="Customer town">
                                                </div>
                                                <div class="form-group col-xs-6">
                                                    <label for="customer-nic">NIC</label>
                                                    <input type="text" class="form-control" id="customer-nic" placeholder="NIC No.">
                                                </div>
                                                <div class="form-group col-xs-6">
                                                    <label>Risk location address</label>
                                                    <textarea class="form-control" rows="4" id="risk-address" placeholder="Enter risk location address"></textarea>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    </div>
                                    <div class="col-xs-12" id="lead-details">
                                        <div class="box box-widget">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Lead Details</h3>
                                            </div>
                                            <!-- /.box-header -->
                                            <!-- form start -->

                                            <div class="box-body" style="display: flex; flex-flow: row wrap; justify-content: space-between">
                                                <div class="form-group col-xs-6">
                                                    <label>Product</label>
                                                    <select id="product" class="form-control" onchange="change_product()">
                                                        
                                                    </select>
                                                </div>

                                                <script type="text/javascript">
                                                    function change_product(){
                                                        var product=document.getElementById('product').value;
                                                        if(product=='NON MOTOR'){
                                                            document.getElementById('vehicle-no').disabled=true;
                                                            document.getElementById('status').disabled=true;
                                                        }else{
                                                            document.getElementById('vehicle-no').disabled=false;
                                                            document.getElementById('status').disabled=false;
                                                        }
                                                    }
                                                </script>
                                                <!-- validation -->
                                <script type="text/javascript">
                                    function lead_validation(){
                                        var customer_name=document.getElementById('customer-name').value;
                                        var customer_address=document.getElementById('customer-address').value;
                                        var customer_mobile=document.getElementById('customer-mobile').value;
                                        var customer_home=document.getElementById('customer-home').value;
                                        var customer_town=document.getElementById('customer-town').value;
                                        var customer_nic=document.getElementById('customer-nic').value;
                                        var risk_address=document.getElementById('risk-address').value;

                                        var validate_status=true;

                                        var product=document.getElementById('product').value;
                                        if(product=='MOTOR'){
                                            var vehicle_no=document.getElementById('vehicle-no').value;
                                            var status=document.getElementById('status').value;

                                            if(vehicle_no==null || vehicle_no==''){
                                                document.getElementById('vehicle-no').style.borderWidth="2px";
                                                document.getElementById('vehicle-no').style.borderColor="red";
                                                swal("Error!","Vehicle No is empty!","error");
                                                return false;
                                            }else{
                                                document.getElementById('vehicle-no').style.borderColor="";
                                                
                                            }
                                        }
                                        var date=document.getElementById('datepicker').value;

                                        if(customer_name==null || customer_name==''){
                                            document.getElementById('customer-name').style.borderWidth="2px";
                                            document.getElementById('customer-name').style.borderColor="red";
                                            swal("Error!","Customer name is empty!","error");
                                            return false;
                                        }else{
                                            document.getElementById('customer-name').style.borderColor="";
                                            if($.isNumeric(customer_name)){
                                                swal("Error!","Customer name cannot contain numbers!","error");        
                                            }
                                                
                                        }
                                        if(customer_address==null || customer_address==''){
                                            document.getElementById('customer-address').style.borderWidth="2px";
                                            document.getElementById('customer-address').style.borderColor="red";
                                            swal("Error!","Customer address is empty!","error");
                                            return false;
                                        }else{
                                                document.getElementById('customer-address').style.borderColor="";
                                                
                                            }
                                        if(customer_mobile==null || customer_mobile==''){
                                            document.getElementById('customer-mobile').style.borderWidth="2px";
                                            document.getElementById('customer-mobile').style.borderColor="red";
                                            swal("Error!","Customer mobile is empty!","error");
                                            return false;
                                        }else{
                                                if(customer_mobile.length!=10){
                                                    swal("Error!","Mobile no should be 10 digits!","error");
                                                    return false;
                                                }else if(customer_mobile.search(/[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]/i)==-1){
                                                    swal("Error!","Mobile no cannot contain letters!","error");
                                                    return false;
                                                }
                                                document.getElementById('customer-mobile').style.borderColor="";
                                                
                                            }
                                        if(customer_home==null || customer_home==''){
                                            document.getElementById('customer-home').style.borderWidth="2px";
                                            document.getElementById('customer-home').style.borderColor="red";
                                            swal("Error!","Customer home contact no is empty!","error");
                                            return false;
                                        }else{
                                                if(customer_home.length!=10){
                                                    swal("Error!","Home no should be 10 digits!","error");
                                                    return false;
                                                }else if(customer_home.search(/[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]/i)==-1){
                                                    swal("Error!","Home no cannot contain letters!","error");
                                                    return false;
                                                }
                                                document.getElementById('customer-home').style.borderColor="";
                                                
                                            }
                                        if(customer_town==null || customer_town==''){
                                            document.getElementById('customer-town').style.borderWidth="2px";
                                            document.getElementById('customer-town').style.borderColor="red";
                                            swal("Error!","Customer town is empty!","error");
                                            return false;
                                        }else{
                                                document.getElementById('customer-town').style.borderColor="";
                                                
                                            }
                                        if(customer_nic==null || customer_nic==''){
                                            document.getElementById('customer-nic').style.borderWidth="2px";
                                            document.getElementById('customer-nic').style.borderColor="red";
                                            swal("Error!","Customer NIC no. is empty!","error");
                                            return false;
                                        }else{
                                                if(customer_nic.length!=10){
                                                    swal("Error!","NIC number should be 10 characters!","error");
                                                    return false;
                                                }else{
                                                    if(customer_nic.search(/[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][V]/i)==-1){
                                                        swal("Error!","NIC number should be 9 digits and V as last character!","error");
                                                        return false;  
                                                    }
                                                }
                                                document.getElementById('customer-nic').style.borderColor="";
                                                
                                            }
                                        if(risk_address==null || risk_address==''){
                                            document.getElementById('risk-address').style.borderWidth="2px";
                                            document.getElementById('risk-address').style.borderColor="red";
                                            swal("Error!","Risk address is empty!","error");
                                            return false;
                                        }else{
                                                document.getElementById('risk-address').style.borderColor="";
                                                
                                            }
                                        if(datepicker==null || datepicker==''){
                                                document.getElementById('datepicker').style.borderWidth="2px";
                                                document.getElementById('datepicker').style.borderColor="red";
                                                
                                            }

                                        ajaxLeadAdd();
                                    }
                                </script>
                                <!-- end of validation -->
                                                <div class="form-group col-xs-6">
                                                    <label for="vehicle-no">Vehicle No.</label>
                                                    <input type="text" class="form-control" id="vehicle-no" placeholder="Vehicle No.">
                                                </div>
                                                <div class="form-group col-xs-6">
                                                    <label>Status</label>
                                                    <select id="status" class="form-control">
                                                        
                                                    </select>
                                                </div>

                                                <div class="form-group col-xs-6">

                                                    <label>Date</label>

                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" id="datepicker">
                                                    </div>
                                                </div>

                                                <div class="form-group col-xs-6">
                                                    <label>Occupation</label>
                                                    <select id="occupation" class="form-control">
                                                        
                                                    </select>
                                                </div>
                                                <div class="form-group col-xs-6">
                                                    <label>Business Party</label>
                                                    <select id="bp" class="form-control">
                                                        
                                                    </select>
                                                </div>
                                                <div class="form-group col-xs-6">
                                                    <label>Remarks</label>
                                                    <textarea class="form-control" rows="4" id="remarks" placeholder="Enter remarks"></textarea>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->

                                            <div class="box-footer">
                                                <!-- ajaxLeadAdd() -->
                                                <button type="button" onclick="return lead_validation()" class="btn btn-twitter" style="margin:5px; float: right"><i class="fa fa-save"></i>&nbsp;Save</button>
                                                {{--data-toggle="modal" data-target="#reminder-modal"--}}
                                                <a href="#reminder-modal" id="hidden-reminder-button" data-toggle="modal" hidden>click</a>
                                            </div>

                                            {{--reminder modal begin--}}
                                            <div class="modal modal-info" id="reminder-modal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" id="remider-close-btn" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">x</span></button>
                                                            <h4 class="modal-title"><i class="fa  fa-bell-o"></i>&nbsp;Reminder</h4>
                                                        </div>
                                                        <div class="modal-body" style="overflow: hidden">
                                                            <div class="form-group col-xs-12">
                                                                <label for="reminder-lead-no">Lead No</label>
                                                                <input type="text" id="reminder-lead-no" class="form-control" disabled="disabled">
                                                            </div>
                                                            <div class="form-group col-xs-12">
                                                                <label for="reminder-customer-name">Customer Name</label>
                                                                <input type="text" id="reminder-customer-name" class="form-control" disabled="disabled">
                                                            </div>
                                                            <div class="form-group col-xs-6">
                                                                <label for="reminder-contact-no">Contact No</label>
                                                                <input type="text" id="reminder-contact-no" class="form-control" placeholder="Mobile No">
                                                            </div>
                                                            <div class="form-group col-xs-6">
                                                                <label for="reminder-email">Email</label>
                                                                <input type="text" id="reminder-email" class="form-control" placeholder="Email Address">
                                                            </div>
                                                            <div class="form-group col-xs-6">
                                                                <label for="reminder-notification">Notification</label>
                                                                <textarea class="form-control" rows="4" id="notification" placeholder="Notification"></textarea>
                                                            </div>

                                                            <div class="form-group" class="col-xs-12">

                                                                <span><label>SMS</label>&nbsp;<input type="checkbox" id="sms-chbx" value="SMS"></span>&nbsp;&nbsp;&nbsp;
                                                                <span><label>EMAIL</label>&nbsp;<input type="checkbox" id="email-chbx" value="EMAIL"></span>
                                                            </div>
                                                            <style>
                                                                .datepicker{z-index:1151 !important;}
                                                            </style>
                                                            <script type="text/javascript">
                                                                function get_notification_type(){
                                                                    var sms=document.getElementById('sms-chbx');
                                                                    var email=document.getElementById('email-chbx');

                                                                    if(sms.checked && email.checked){
                                                                        return "both";
                                                                    }else if(sms.checked){
                                                                        return "sms";
                                                                    }else if(email.checked){
                                                                        return "email";
                                                                    }else{
                                                                        return false;
                                                                    }
                                                                }
                                                            </script>
                                                            <div class="form-group col-xs-12">
                                                                <label>Date</label>

                                                                <div class="input-group date">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control pull-right datepicker" placeholder="mm/dd/yyyy" id="datepicker-reminder">
                                                                </div>
                                                                <!-- /.input group -->
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Not Now</button>
                                                            <button type="button" class="btn btn-success" id="set-reminder" onclick="set_reminder()">Set Reminder</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            {{--modal end--}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function ajaxLeadAdd() {

                                    var details=[];
                                    details[0]=document.getElementById('title').value;
                                    details[1]=document.getElementById('customer-name').value;
                                    details[2]=document.getElementById('customer-address').value;
                                    details[3]=document.getElementById('customer-mobile').value;
                                    details[4]=document.getElementById('customer-home').value;
                                    details[5]=document.getElementById('customer-town').value;
                                    details[6]=document.getElementById('customer-nic').value;
                                    details[7]=document.getElementById('risk-address').value;

                                    details[8]=document.getElementById('product').value;
                                    details[9]=document.getElementById('vehicle-no').value;
                                    details[10]=document.getElementById('status').value;
                                    details[11]=document.getElementById('datepicker').value;
                                    details[12]=document.getElementById('remarks').value;
                                    details[13]=document.getElementById('occupation').value;

                                    var bp=document.getElementById('bp');
                                    var selectedBPValue = bp.options[bp.selectedIndex].value;
                                    var selectedBPText = bp.options[bp.selectedIndex].text;

                                    details[14]=selectedBPValue;
                                    details[15]=selectedBPText;

                                    details[16]="<?php echo date("Ymd").$user_code.date("his"); ?>";
                                    if(document.getElementById('product').value=='NON MOTOR'){
                                        details[9]=null;
                                        details[10]=null;
                                    }
                                    $.ajax({
                                        type:'get',
                                        url:'enter_lead',
                                        data:{detailsArray:details},
                                        success:function(data){
                                            console.log("done"+data);
                                            document.getElementById('product').value='';
                                            document.getElementById('vehicle-no').value='';
                                            document.getElementById('status').value='';
                                            document.getElementById('datepicker').value='';
                                            document.getElementById('remarks').value='';
                                            document.getElementById('occupation').value='';
                                            document.getElementById('bp').value='';
                                            document.getElementById('reminder-customer-name').value=details[1];
                                            document.getElementById('reminder-lead-no').value=details[16];


                                            document.getElementById("hidden-reminder-button").click();
                                            $('#example1').DataTable( {
                                                    "bDestroy":true,
                                                    responsive: true,
                                                    "ajax": {
                                                        "type":"get",
                                                        "url": "retrieve_leads",


                                                    },
                                                    "pageLength": 100,


                                                    columns: [
                                                        { "data": "lead_no" },
                                                        { "data": "customer_name" },
                                                        { "data": "address" },
                                                        { "data": "agent_code" },
                                                        { "data": "proposal_date" },
                                                        {"data" : null,
                                                            "mRender": function(data, type, full) {


                                                                return '<a class="btn btn-warning btn-block btn-sm" onclick="set_status(\''+data.lead_no+'\')" data-toggle="modal" href="#status-modal" style=" text-decoration: none;">' + 'Notify' + '</a>';
                                                            }
                                                        },
                                                        {"data" : null,
                                                            "mRender": function(data, type, full) {


                                                                return '<a class="btn btn-success btn-block btn-sm" onclick="set_details(\''+data.lead_no+'\')" data-toggle="modal" href="#details-modal" style=" text-decoration: none;">' + 'Details' + '</a>';
                                                            }
                                                        },
                                                        {"data" : null,
                                                            "mRender": function(data, type, full) {


                                                                return '<a class="btn btn-info btn-block btn-sm" onclick="set_quotation(\''+data.lead_no+'\')" href="#" style=" text-decoration: none;">' + ' Quotation' + '</a>';
                                                            }
                                                        }
                                                    ]



                                                } );
                                        },
                                        error:function(y,x,thrown){
                                            console.log(thrown);
                                            location.reload();
                                        }

                                    });
                                }

                            </script>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="sub_2" >
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title"></h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" style="width: 181px;">Lead No</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 224px;">Customer</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 197px;">Address</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 154px;">Agent</th>
                                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 112px;">Date</th>
                                                            <th rowspan="1" style="width: 112px;"></th>
                                                            <th rowspan="1" style="width: 112px;"></th>
                                                            <th rowspan="1" style="width: 112px;"></th>

                                                        </tr>
                                                        </thead>
                                                        <tbody id="leads-table">
                                                        
                                                        </tbody>
                                                        <tfoot>

                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-7">
                                                    <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                                        <ul class="pagination">
                                                            <li class="paginate_button previous disabled" id="example1_previous">
                                                                <a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a>
                                                            </li>
                                                            <li class="paginate_button active">
                                                                <a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a>
                                                            </li>
                                                            <li class="paginate_button ">
                                                                <a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a>
                                                            </li>
                                                            <li class="paginate_button ">
                                                                <a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a>
                                                            </li>
                                                            <li class="paginate_button ">
                                                                <a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
                                    </div>
                                    <script>

                                    </script>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="sub_3">
                                <div class="row" style="display: flex; flex-flow: row wrap; justify-content: space-between">
                                    <div class="col-xs-4 input-group input-group-sm" style="margin-left: auto;margin-right:auto;float: none">
                                        <input type="text" id="search-lead" class="form-control" placeholder="LEAD NO/PHONE NO/AGENT NO/NIC" onchange="viewLead()">
                                        <a href="#search-result-modal" id="hidden-search-button" data-toggle="modal" hidden></a>
                                    </div>


                                    <div class="box-body">
                                        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row">
                                                <div class="col-xs-12" style="float: none;margin-left: auto;margin-right: auto;">
                                                    <table id="viewTable" class="table table-bordered table-striped dataTable"  role="grid" aria-describedby="example1_info">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="sorting_asc" tabindex="0" aria-controls="viewTable" rowspan="1" colspan="1" aria-sort="ascending" style="width: 181px;">Lead No</th>
                                                            <th class="sorting" tabindex="0" aria-controls="viewTable" rowspan="1" colspan="1" style="width: 224px;">Customer</th>
                                                            <th class="sorting" tabindex="0" aria-controls="viewTable" rowspan="1" colspan="1" style="width: 197px;">Address</th>
                                                            <th class="sorting" tabindex="0" aria-controls="viewTable" rowspan="1" colspan="1" style="width: 154px;">Agent</th>
                                                            <th class="sorting" tabindex="0" aria-controls="viewTable" rowspan="1" colspan="1" style="width: 112px;">Date</th>
                                                            <th rowspan="1" style="width: 112px;"></th>

                                                        </tr>
                                                        </thead>
                                                        <tbody id="view-leads-table">
                                                        {{--<tr role="row" class="odd">--}}
                                                        {{--<td class="sorting_1">Gecko</td>--}}
                                                        {{--<td>Firefox 1.0</td>--}}
                                                        {{--<td>Win 98+ / OSX.2+</td>--}}
                                                        {{--<td>1.7</td>--}}
                                                        {{--<td>A</td>--}}
                                                        {{--</tr>--}}
                                                        </tbody>
                                                        <tfoot>

                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-7">
                                                    <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                                        <ul class="pagination">
                                                            <li class="paginate_button previous disabled" id="example1_previous">
                                                                <a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a>
                                                            </li>
                                                            <li class="paginate_button active">
                                                                <a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a>
                                                            </li>
                                                            <li class="paginate_button ">
                                                                <a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a>
                                                            </li>
                                                            <li class="paginate_button ">
                                                                <a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a>
                                                            </li>
                                                            <li class="paginate_button ">
                                                                <a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
                                    </div>



                                    <div class="modal modal-info" id="search-result-modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" id="edit-lead-close-btn" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">x</span></button>
                                                    <h4 class="modal-title"><i class="fa  fa-bell-o"></i>&nbsp;Lead</h4><h5 id="lead_no" style="text-indent: 5px;font-weight: 600"></h5>
                                                </div>
                                                <div class="modal-body" style="overflow: hidden">
                                                    <div class="col-xs-12" id="customer-details-view">
                                                        <div class="box box-widget">
                                                            <div class="box-header with-border">
                                                                <h3 class="box-title">Customer Details</h3>
                                                            </div>

                                                            <!-- /.box-header -->
                                                            <!-- form start -->
                                                            <div class="box-body" style="color:#3c3c3c">
                                                                <div class="col-xs-6">
                                                                    <label>Customer Name:&nbsp;</label>
                                                                    <label id="c_name"></label>
                                                                </div>

                                                                <div class="form-group col-xs-6">
                                                                    <label>Address:&nbsp;</label>
                                                                    <label id="c_address"></label>
                                                                </div>
                                                                <div class="form-group col-xs-6">
                                                                    <label>Mobile:&nbsp;</label>
                                                                    <label id="c_mobile"></label>
                                                                </div>

                                                                <div class="form-group col-xs-6">
                                                                    <label>Home:&nbsp;</label>
                                                                    <label id="c_home"></label>
                                                                </div>
                                                                <div class="form-group col-xs-6">
                                                                    <label>Town:&nbsp;</label>
                                                                    <label id="c_town"></label>
                                                                </div>
                                                                <div class="form-group col-xs-6">
                                                                    <label>NIC:&nbsp;</label>
                                                                    <label id="c_nic"></label>
                                                                </div>
                                                                <div class="form-group col-xs-6">
                                                                    <label>Risk Location Address:&nbsp;</label>
                                                                    <label id="c_risk"></label>
                                                                </div>
                                                            </div>
                                                            <!-- /.box-body -->
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12" id="lead-followup-details-view">
                                                        <div class="box box-widget">
                                                            <div class="box-header with-border">
                                                                <h3 class="box-title">Lead Details</h3>
                                                            </div>
                                                            <!-- /.box-header -->
                                                            <!-- form start -->

                                                            <div class="box-body" style="color:#3c3c3c">
                                                                <div class="form-group col-xs-12">
                                                                    <table style="width:90%" class="table table-bordered table-striped " role="grid" aria-describedby="example1_info">
                                                                        <thead>
                                                                        <tr role="row">
                                                                            <th >STATUS</th>
                                                                            <th >DATE</th>
                                                                            <th >REMARK</th>
                                                                            <!-- <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 154px;">Agent</th>
                                                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 112px;">Date</th> -->
                                                                            <!-- <th rowspan="1" style="width: 112px;"></th>
                                                                            <th rowspan="1" style="width: 112px;"></th>
                                                                            <th rowspan="1" style="width: 112px;"></th> -->

                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="lead_followup_table">
                                                                        
                                                                        </tbody>
                                                                        <tfoot>

                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- /.box-body -->

                                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12" id="lead-details-view">
                                                        <div class="box box-widget">
                                                            <div class="box-header with-border">
                                                                <h3 class="box-title">Lead Followup</h3>
                                                            </div>
                                                            <!-- /.box-header -->
                                                            <!-- form start -->

                                                            <div class="box-body" style="color:#3c3c3c">
                                                                <div class="form-group col-xs-6">
                                                                    <label>Status</label>
                                                                    <select id="status-update" class="form-control">
                                                                        
                                                                    </select>
                                                                </div>

                                                                <div class="form-group col-xs-6">

                                                                    <label>Date</label>

                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text" class="form-control pull-right" id="datepicker-lastupdate">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-xs-12">
                                                                    <label>Remarks</label>
                                                                    <textarea class="form-control" rows="4" id="remarks-update" placeholder="Enter remarks"></textarea>
                                                                </div>
                                                            </div>
                                                            <!-- /.box-body -->

                                                            <div class="box-footer">

                                                                <button type="button" class="btn btn-success" id="update-lead" onclick="update()" style="margin:5px; float: right"><i class="fa fa-save"></i>&nbsp;Update</button>
                                                                {{--<button type="button" onclick="" class="btn btn-twitter" style="margin:5px; float: right"><i class="fa fa-save"></i>&nbsp;Save</button>--}}
                                                                {{--data-toggle="modal" data-target="#reminder-modal"--}}
                                                                {{--<a href="#reminder-modal" id="hidden-reminder-button" data-toggle="modal" hidden>click</a>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    {{--modal begin--}}

                                    {{--modal end--}}

                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>

                    {{--end of lead tabs--}}
                </div>
                
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->

            <!-- nav-tabs-custom -->
        </div>




    </div>


    {{--status modal begin--}}
    <div class="modal modal-info" id="status-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="status-reminder-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span></button>
                    <h4 class="modal-title"><i class="fa  fa-bell-o"></i>&nbsp;Status</h4>
                </div>
                <div class="modal-body" style="overflow: hidden">
                    <div class="form-group col-xs-12">
                        <label for="status-lead-no">Lead No</label>
                        <input type="text" id="status-lead-no" class="form-control" disabled="disabled">
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="status-customer-name">Customer Name</label>
                        <input type="text" id="status-customer-name" class="form-control" disabled="disabled">
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="status-contact-no">Contact No</label>
                        <input type="text" id="status-contact-no" class="form-control" placeholder="Mobile No">
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="status-email">Email</label>
                        <input type="text" id="status-email" class="form-control" placeholder="Email Address">
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="status-notification">Notification</label>
                        <textarea class="form-control" rows="4" id="status-notification" placeholder="Notification"></textarea>
                    </div>
                    <div class="col-xs-6">
                        <span><label>SMS</label>&nbsp;<input type="checkbox" id="status-sms-chbx" value="SMS"></span>&nbsp;&nbsp;&nbsp;
                        <span><label>EMAIL</label>&nbsp;<input type="checkbox" id="status-email-chbx" value="EMAIL"></span>
                    </div>
                    <style>
                        .datepicker{z-index:1151 !important;}
                    </style>
                    <script type="text/javascript">
                        function get_status_notification_type(){
                            var sms=document.getElementById('status-sms-chbx');
                            var email=document.getElementById('status-email-chbx');

                            if(sms.checked && email.checked){
                                return "both";
                            }else if(sms.checked){
                                return "sms";
                            }else if(email.checked){
                                return "email";
                            }else{
                                return false;
                            }
                        }
                    </script>
                    <div class="form-group col-xs-12">
                        <label>Date</label>

                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker" placeholder="mm/dd/yyyy" id="datepicker-status-reminder">
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Not Now</button>
                    <button type="button" class="btn btn-success" id="set-reminder" onclick="set_status_reminder()">Set Reminder</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--modal end--}}




    {{--renewal notification modal begin--}}
    <div class="modal modal-info" id="due-renewal-reminder-modal" style="border:0px solid red;">
        <div class="modal-dialog" style="width:90%">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" id="remider-close-btn" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span></button>
                    <h4 class="modal-title"><i class="fa  fa-bell-o"></i>&nbsp;Due Renewals</h4>
                </div>
                <div class="modal-body" style="overflow: auto">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row"><div class="col-sm-12"></div><div class="col-sm-12"></div></div><div class="row"><div class="col-sm-12">
                                <table class="table table-bordered dataTable" style="background-color:#5DB9EB;color:#FFFFFF" role="grid" aria-describedby="example2_info">
                                    <thead>
                                        <tr style="background-color:rgba(23,43,12,0.4)" role="row"><th>Policy No</th><th>Product No</th><th>Client</th><th>End Date</th><th>Telephone</th><th>Status</th></tr>
                                    </thead>
                                    <tbody id="renewal-tbody">
                                        
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Got It!</button>
                    <!-- <button type="button" class="btn btn-success" id="set-reminder" onclick="set_reminder()">Set Reminder</button> -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--renewal notification modal end--}}












    <script>
        function set_status(lead){
//            alert(lead);
            document.getElementById('status-lead-no').value=lead;
            $.ajax({
                type:'get',
                url:'get_lead_data',
                data:{key:lead},
                success:function(data){
                    jsonData=jQuery.parseJSON(data);
//                    console.log("Data:: "+jsonData[0].lead_no);
                    document.getElementById('status-customer-name').value=jsonData[0].customer_name;
                    //document.getElementById('status-contact-no').value=jsonData[0].mobile_no;
                },
                error:function(x,y,thrown){
                    console.log(thrown);
                    swal("Error!",thrown,"error");
                }
            });

        }
        function set_details(lead){
            document.getElementById('search-lead').value=lead;
            viewLead();
            document.getElementById('lead-details-view').style.display="block";
            document.getElementById('viewleads-button').click();
        }
        function set_details_group(lead){
            document.getElementById('search-lead').value=lead;
            viewLead_group();
            document.getElementById('lead-details-view').style.display="none";
            document.getElementById('lead-button').click();
            document.getElementById('viewleads-button').click();
        }
        function set_quotation(lead){
            // alert(lead);
            $.ajax({
                type:'get',
                url:'get_lead_data',
                data:{key:lead},
                success:function(data){
                    jsonData=jQuery.parseJSON(data);

                    if((jsonData[0].product)=="MOTOR"){
                        window.location.href="quotaion";            
                    }else{

                    }
                    //document.getElementById('status-contact-no').value=jsonData[0].mobile_no;
                },
                error:function(x,y,thrown){
                    console.log(thrown);
                    swal("Error!",thrown,"error");
                }
            });
            
        }

    </script>

@endsection

@section('js')

    <script>
        function set_status_reminder(){
            var notification_type=get_status_notification_type();
            // alert(notification_type);
            if(!notification_type){
                swal("Error!","Choose SMS/EMAIL as the notification type!","error");
                return false;
            }
            var lead_no_reminder=document.getElementById("status-lead-no").value;
            var customer_name_reminder=document.getElementById("status-customer-name").value;
            var contact_no=document.getElementById("status-contact-no").value;
            var email=document.getElementById("status-email").value;
            alert(contact_no+" "+email);
            var notification=document.getElementById("status-notification").value;
            var reminder_date=document.getElementById("datepicker-status-reminder").value;
            var agent_code="<?php echo $user_code; ?>";
            // $.ajax({
            //     type:'get',
            //     url:'reminder',
            //     data:{
            //         lead_no:lead_no_reminder,
            //         customer:customer_name_reminder,
            //         contact_no:contact_no,
            //         email:email,
            //         type:notification_type,
            //         notification:notification,
            //         reminder_date:reminder_date,
            //         agent_code:agent_code
            //     },
            //     success:function(data){
            //         swal("Success!","Reminder added successfully!","success");
            //         document.getElementById('status-reminder-close').click();

            //     },
            //     error:function(y,x,thrown){
            //         swal("Error!","Error in set reminder! (Error::)"+thrown,"error");
            //         document.getElementById('status-reminder-close').click();
            //         console.log(thrown);
            //     }
            // });
        }
        function set_reminder(){
            var notification_type=get_notification_type();
            // alert(notification_type);
            if(!notification_type){
                swal("Error!","Choose SMS/EMAIL as the notification type!","error");
                return false;
            }
            var lead_no_reminder=document.getElementById("reminder-lead-no").value;
            var customer_name_reminder=document.getElementById("reminder-customer-name").value;
            var contact_no=document.getElementById("reminder-contact-no").value;
            var email=document.getElementById("reminder-email").value;
            var notification=document.getElementById("notification").value;
            var reminder_date=document.getElementById("datepicker-reminder").value;
            var agent_code="<?php echo $user_code; ?>";
            $.ajax({
                type:'get',
                url:'reminder',
                data:{
                    lead_no:lead_no_reminder,
                    customer:customer_name_reminder,
                    contact_no:contact_no,
                    email:email,
                    type:notification_type,
                    notification:notification,
                    reminder_date:reminder_date,
                    agent_code:agent_code
                },
                success:function(data){
                    swal("Success!","Reminder added successfully!","success");
                    document.getElementById('remider-close-btn').click();

                },
                error:function(y,x,thrown){
                    swal("Error!","Error in set reminder! (Error::)"+thrown,"error");
                    document.getElementById('remider-close-btn').click();
                    console.log(thrown);
                }
            });
        }
        function update(){
            var lead_no_update=document.getElementById("lead_no").innerHTML;
            var status_update=document.getElementById("status-update").value;
            var remarks_update=document.getElementById("remarks-update").value;
            var last_update=document.getElementById("datepicker-lastupdate").value;

            $.ajax({
                type:'get',
                url:'update_lead_followup',
                data:{
                    lead_no:lead_no_update,
                    status:status_update,
                    last_update:last_update,
                    remarks:remarks_update
                },
                success:function(data){
                    swal("Success!","Lead updated successfully!","success");
                    document.getElementById('edit-lead-close-btn').click();

                },
                error:function(y,x,thrown){
                    swal("Error!","Error in updation! (Error::)"+thrown,"error");
                    document.getElementById('edit-lead-close-btn').click();
                    console.log(thrown);
                }
            });

        }
        function editLead(leadNo){

            $.ajax({
                type:'get',
                url:'search_indiv_lead',
                data:{key:leadNo},
                success:function(data){
                    var d=$.parseJSON(data);
                    document.getElementById("lead_no").innerHTML=d[0].lead_no;
                    document.getElementById("c_name").innerHTML=d[0].customer_name;
                    document.getElementById("c_address").innerHTML=d[0].address;
                    document.getElementById("c_mobile").innerHTML=d[0].mobile_no;
                    document.getElementById("c_home").innerHTML=d[0].conatct_no;
                    document.getElementById("c_town").innerHTML=d[0].town;
                    document.getElementById("c_risk").innerHTML=d[0].risk_address;
                    document.getElementById("c_nic").innerHTML=d[0].nic;

                    document.getElementById("status-update").value=d[0].status;
                    document.getElementById("remarks-update").value=d[0].remarks;

                    $.ajax({
                        type:'get',
                        url:'get_followup_details',
                        data:{key:leadNo},
                        success:function(data){
                            //followup details

                            console.log("-------lead followup--------");
                            var details=$.parseJSON(data);
                            var tableString='';
                            if(details[0]!=null){
                                for(var x=0;x<details.length;x++){
                                    tableString=tableString+"<tr><td>"+details[x].followup_status+"</td><td>"+details[x].event_date+"</td><td>"+details[x].remarks+"</td></tr>";
                                    console.log(details[x].lead_no);
                                    console.log(details[x].remarks);
                                    console.log(details[x].followup_status);
                                }

                                document.getElementById('lead_followup_table').innerHTML=tableString;
                            }
                        },
                        error:function(x,y,z){
                            console.log(z);
                        }
                    });


                    document.getElementById("hidden-search-button").click();
                },
                error:function(y,x,thrown){
                    console.log(thrown);
                }
            });
        }
        function viewLead_group(){
            var lead_search_key=document.getElementById('search-lead').value;
            // console.log(lead_search_key);

            $('#viewTable').DataTable( {
                "bDestroy":true,
                "sPaginationType": "full_numbers",
                responsive: true,
                "ajax": {
                    "type":"get",
                    "url": "search_lead_group?key="+lead_search_key,


                },
                "pageLength": 100,


                columns: [
                    { "data": "lead_no" },
                    { "data": "customer_name" },
                    { "data": "address" },
                    { "data": "agent_code" },
                    { "data": "proposal_date" },
                    {"data" : null,
                        "mRender": function(data, type, full) {
                            return '<button type="button" id="lead-edit-btn" class="btn btn-info btn-block btn-sm" onclick="editLead(\''+data.lead_no+'\')" style=" text-decoration: none;">'+'Edit'+'</button>';
                        }
                    }
                ]



            } );
        }
        function viewLead(){
            var lead_search_key=document.getElementById('search-lead').value;
            console.log(lead_search_key);

            $('#viewTable').DataTable( {
                "bDestroy":true,
                "sPaginationType": "full_numbers",
                responsive: true,
                "ajax": {
                    "type":"get",
                    "url": "search_lead?key="+lead_search_key,


                },
                "pageLength": 100,


                columns: [
                    { "data": "lead_no" },
                    { "data": "customer_name" },
                    { "data": "address" },
                    { "data": "agent_code" },
                    { "data": "proposal_date" },
                    {"data" : null,
                        "mRender": function(data, type, full) {
                            return '<button type="button" id="lead-edit-btn" class="btn btn-info btn-block btn-sm" onclick="editLead(\''+data.lead_no+'\')" style=" text-decoration: none;">'+'Edit'+'</button>';
                        }
                    }
                ]



            } );
        }

    </script>

    <script src="Chart.js-master/dist/Chart.js"></script>
    <script src="Chart.js-master/dist/Chart.min.js"></script>

    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    
    <script>

        $('document').ready(function () {
 <?php
    if(isset($_SESSION['ADVISOR_TEAM_MEMBER_LIST'])){
        $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));



        $string="<option value='0'>NONE</option>";
        foreach($data as $y){
            for($x=0;$x<sizeof($y);$x++){
                //        var_dump($x[1]->code);
                $string=$string."<option value='".$y[$x]->code."'>".$y[$x]->code."</option>";
            }
        }
?>
    document.getElementById('group-button').style.display="block";
    document.getElementById('agents-select').innerHTML="<?php echo $string; ?>";
<?php
    }else if(isset($_SESSION['BRANCH_MEMBER_LIST'])){
        $data=Array(json_decode($_SESSION['BRANCH_MEMBER_LIST']));



        $string="<option value='0'>NONE</option>";
        foreach($data as $y){
            for($x=0;$x<sizeof($y);$x++){
                //        var_dump($x[1]->code);
                $string=$string."<option value='".$y[$x]->user_code."'>".$y[$x]->user_code."</option>";
            }
        }
        ?>
    document.getElementById('group-button').style.display="block";
    document.getElementById('agents-select').innerHTML="<?php echo $string; ?>";
<?php
    }else if(isset($_SESSION['ZONE_MEMBER_LIST'])){

         $data=Array(json_decode($_SESSION['ZONE_MEMBER_LIST']));



        $string="<option value='0'  selected>NONE</option>";
        foreach($data as $y){
            for($x=0;$x<sizeof($y);$x++){
                //        var_dump($x[1]->code);
                $string=$string."<option value='".$y[$x]->user_code."'>".$y[$x]->user_code."</option>";
            }
        }


        ?>
     document.getElementById('group-button').style.display="block";
     document.getElementById('agents-select').innerHTML="<?php echo $string; ?>";

 <?php

    } if(isset($_SESSION['BRANCHES_LIST'])){
 $data=Array(json_decode($_SESSION['BRANCHES_LIST']));



        $string="<option value='0'  selected>NONE</option>";
        foreach($data as $y){
            for($x=0;$x<sizeof($y);$x++){
                //        var_dump($x[1]->code);
                $string=$string."<option value='".$y[$x]->branch_code."'>".$y[$x]->branch_name."</option>";
            }
        }


        ?>
     document.getElementById('group-button').style.display="block";
     document.getElementById('branches-select').innerHTML="<?php echo $string; ?>";

 <?php

    }if(isset($_SESSION['CLUSTER_LIST'])){

$data=Array(json_decode($_SESSION['CLUSTER_LIST']));
         $string="<option value='0'  selected>NONE</option>";
        foreach($data as $y){
            for($x=0;$x<sizeof($y);$x++){
                //        var_dump($x[1]->code);
                $string=$string."<option value='".$y[$x]->region."'>".$y[$x]->region."</option>";
            }
        }


        ?>
     document.getElementById('group-button').style.display="block";
     document.getElementById('cluster').innerHTML="<?php echo $string; ?>";

 <?php


    }
    if(isset($_SESSION['ZONE_LIST'])){

        $data=Array(json_decode($_SESSION['ZONE_LIST']));
          $string="<option value='0'  selected>NONE</option>";
        foreach($data as $y){
            for($x=0;$x<sizeof($y);$x++){
                //        var_dump($x[1]->code);
                $string=$string."<option value='".$y[$x]->zone."'>".$y[$x]->zone."</option>";
            }
        }


        ?>
     document.getElementById('group-button').style.display="block";
     document.getElementById('zone').innerHTML="<?php echo $string; ?>";

 <?php

    }else{
?>
    document.getElementById('group-button').style.display="none";
<?php
    }
?>           
            $.ajax({
                type:'get',
                url:'title_select',
                success:function(data){
                    aData=jQuery.parseJSON(data);
                    string="";
                    for(var x=0;x<aData.length;x++){
                        string+="<option value='"+aData[x].title+"'>"+aData[x].title+"</option>";
                    }
                    document.getElementById('title').innerHTML=string;
                },
                error:function(x,y,thrown){
                    console.log(thrown);
                }
            });

            $.ajax({
                type:'get',
                url:'product_select',
                success:function(data){
                    aData=jQuery.parseJSON(data);
                    string="";
                    for(var x=0;x<aData.length;x++){
                        string+="<option value='"+aData[x].product+"'>"+aData[x].product+"</option>";
                    }
                    document.getElementById('product').innerHTML=string;
                },
                error:function(x,y,thrown){
                    console.log(thrown);
                }
            });

            $.ajax({
                type:'get',
                url:'vehicle_status_select',
                success:function(data){
                    aData=jQuery.parseJSON(data);
                    string="";
                    for(var x=0;x<aData.length;x++){
                        string+="<option value='"+aData[x].vehicle_status+"'>"+aData[x].vehicle_status+"</option>";
                    }
                    document.getElementById('status').innerHTML=string;
                },
                error:function(x,y,thrown){
                    console.log(thrown);
                }
            });

            $.ajax({
                type:'get',
                url:'occupation_select',
                success:function(data){
                    aData=jQuery.parseJSON(data);
                    string="";
                    for(var x=0;x<aData.length;x++){
                        string+="<option value='"+aData[x].occupation+"'>"+aData[x].occupation+"</option>";
                    }
                    document.getElementById('occupation').innerHTML=string;
                },
                error:function(x,y,thrown){
                    console.log(thrown);
                }
            });

            $.ajax({
                type:'get',
                url:'businessparty_select',
                success:function(data){
                    aData=jQuery.parseJSON(data);
                    string="";
                    for(var x=0;x<aData.length;x++){
                        string+="<option value='"+aData[x].party+"'>"+aData[x].party+"</option>";
                    }
                    document.getElementById('bp').innerHTML=string;
                },
                error:function(x,y,thrown){
                    console.log(thrown);
                }
            });
            $.ajax({
                type:'get',
                url:'leadstatus_select',
                success:function(data){
                    aData=jQuery.parseJSON(data);
                    string="<option value='null'>Select Status</option>";
                    for(var x=0;x<aData.length;x++){
                        string+="<option value='"+aData[x].lead_status+"'>"+aData[x].lead_status+"</option>";
                    }
                    document.getElementById('status-update').innerHTML=string;
                },
                error:function(x,y,thrown){
                    console.log(thrown);
                }
            });


            $.ajax({
                type:'get',
                url:'ppwRatio',
                success:function(data){
                    ppwData=jQuery.parseJSON(data);
                    document.getElementById('ppw-value').innerHTML=formatNumber(parseFloat(ppwData[0].ppw).toFixed(2));

                    var ratio=((parseFloat(ppwData[0].ppw)/parseFloat(ppwData[0].gwp))*100).toFixed(2);
                    if(ratio<=10){
                        document.getElementById("ppw-box").style.backgroundColor="#00AC08";
                        document.getElementById("ppw-box").style.color="white";
                    }else{
                        document.getElementById("ppw-box").style.backgroundColor="#A70000";
                        document.getElementById("ppw-box").style.color="white";
                    }
                    document.getElementById("ppw-ratio-style").style.width = ratio+"%";
                    document.getElementById('ppw-ratio-value').innerHTML="PPW RATIO : "+ratio+" %";
                },
                error:function(x,y,thrown){
                    console.log(thrown);
                }
            });
            $.ajax({
                type:'get',
                url:'claimRatio',
                success:function(data){
                    console.log("claim ratio");
                    data=jQuery.parseJSON(data);
                    console.log(data);
                    // calculations
                    var NWP=parseFloat(convertToZero(data[0].xol))+parseFloat(convertToZero(data[0].gwp))+parseFloat(convertToZero(data[0].ri));
                    var NEP=parseFloat(convertToZero(data[0].xol))+parseFloat(convertToZero(data[0].ri))+parseFloat(convertToZero(data[0].gwp))+parseFloat(convertToZero(data[0].title_trf))+parseFloat(convertToZero(data[0].uep));
                    var CLAIM_OS=(parseFloat(convertToZero(data[0].claim_os_fmt))-parseFloat(convertToZero(data[0].claim_os_lst)));
                    var RI_ONCLAIM_OS=(parseFloat(convertToZero(data[0].claim_os_ri_fmt))-parseFloat(convertToZero(data[0].claim_os_ri_lst)));
                    var NET_CLAIM_INCU=parseFloat(convertToZero(data[0].claim_paid_cost))+(parseFloat(convertToZero(data[0].claim_os_fmt))-parseFloat(convertToZero(data[0].claim_os_lst)))+parseFloat(convertToZero(data[0].ri_claim_paid))+(parseFloat(convertToZero(data[0].claim_os_ri_fmt))-parseFloat(convertToZero(data[0].claim_os_ri_lst)));
                    
                    var NEPdifNET_CLAIM_INCU=parseFloat(NEP)-parseFloat(NET_CLAIM_INCU);

                    var DAC=(parseFloat(convertToZero(data[0].claim_paid_cost))-parseFloat(convertToZero(data[0].dac_ri_comm)));
                    var TOTAL=parseFloat(convertToZero(data[0].commission_paid))+parseFloat(convertToZero(data[0].sales_promo))+parseFloat(convertToZero(data[0].ri_comm_income))+parseFloat(convertToZero(data[0].dac))-parseFloat(convertToZero(data[0].dac_ri_comm));


                    var OPERATING=((parseFloat(NEP))-(parseFloat(NET_CLAIM_INCU)))-(parseFloat(TOTAL));


                    var CLAIM_RATIO=((parseFloat(NET_CLAIM_INCU))/(parseFloat(NEP))*100).toFixed(2);

                    var EXP_RATIO=((parseFloat(TOTAL))/(parseFloat(NEP))*100).toFixed(2);



                    document.getElementById('claim-value').innerHTML=formatNumber(parseFloat(convertToZero(data[0].claim_paid_cost)).toFixed(2));
                    document.getElementById("claim-ratio-style").style.width = CLAIM_RATIO+"%";
                    document.getElementById('claim-ratio-value').innerHTML="CLAIM RATIO : "+CLAIM_RATIO+" %";

                    document.getElementById('profitability-value').innerHTML=formatNumber(parseFloat(OPERATING).toFixed(2));
                    document.getElementById("profitability-ratio-style").style.width = EXP_RATIO+"%";
                    document.getElementById('profitability-ratio-value').innerHTML="EXPENSE RATIO : "+EXP_RATIO+" %";



                    console.log(NWP+" "+NEP+" "+CLAIM_OS+" "+NEPdifNET_CLAIM_INCU+" "+TOTAL+" "+OPERATING+" "+CLAIM_RATIO);


                    // end of calculations







                    console.log(data);
                },
                error:function(x,y,thrown){
                    console.log(thrown);
                }
            });
            $.ajax({
                type:'get',
                url:'training_star_count',
                success:function(data){
                    starData=jQuery.parseJSON(data);
                    console.log(starData);
                    console.log("stars percentage: --------------------------------"+starData[0].percentage);

                    var starCount=starData[0].percentage;
                    document.getElementById('star-count').style.width=''+starCount+'%';
                    document.getElementById('star-anchor').title="Training Percentage : "+starCount+'%';
                    // if(starCount>0 && starCount<=10){
                    //     document.getElementById('star1').style.width='50%';
                    // }else if(starCount>10 && starCount<=20){
                    //     document.getElementById('star1').style.width='50%';
                    // }else if(starCount>20 && starCount<=30){
                    // }else if(starCount>30 && starCount<=40){
                    // }else if(starCount>40 && starCount<=50){
                    // }else if(starCount>50 && starCount<=60){
                    // }else if(starCount>60 && starCount<=70){
                    // }else if(starCount>70 && starCount<=80){
                    // }else if(starCount>80 && starCount<=90){
                    // }else if(starCount>90 && starCount<=100){
                    // }

                },
                error:function(x,y,thrown){
                    console.log(thrown);
                }
            });


    





<?php
    if(isset($_SESSION['RENEWAL_LIST'])){
        $data=Array(json_decode($_SESSION['RENEWAL_LIST']));
        

        // echo "session available";
        
        unset($_SESSION['RENEWAL_LIST']);
        $str="";
        foreach($data as $y){
            for($x=0;$x<sizeof($y);$x++){
                //        var_dump($x[1]->code);
                $str=$str."<tr><td>".$y[$x]->pol_no."</td><td>".$y[$x]->pro_no."</td><td>".$y[$x]->pol_client."</td><td>".$y[$x]->pol_end_date."</td><td>".$y[$x]->pol_tel."</td><td>".$y[$x]->pol_status."</td></tr>";
                // $str=$str."<tr><td></td><td></td><td></td><td></td></tr>";
                
            }
        }
?>
    document.getElementById('renewal-tbody').innerHTML="<?php echo $str; ?>";
    document.getElementById('due-list').click();
<?php
    }
?>
//team leader end
    $('#example1').DataTable( {

                responsive: true,
                "ajax": {
                    "type":"get",
                    "url": "retrieve_leads",


                },
                "pageLength": 100,


                columns: [
                    { "data": "lead_no" },
                    { "data": "customer_name" },
                    { "data": "address" },
                    { "data": "agent_code" },
                    { "data": "proposal_date" },
                    {"data" : null,
                        "mRender": function(data, type, full) {


                            return '<a class="btn btn-warning btn-block btn-sm" onclick="set_status(\''+data.lead_no+'\')" data-toggle="modal" href="#status-modal" style=" text-decoration: none;">' + 'Notify' + '</a>';
                        }
                    },
                    {"data" : null,
                        "mRender": function(data, type, full) {


                            return '<a class="btn btn-success btn-block btn-sm" onclick="set_details(\''+data.lead_no+'\')" data-toggle="modal" href="#details-modal" style=" text-decoration: none;">' + 'Details' + '</a>';
                        }
                    },
                    {"data" : null,
                        "mRender": function(data, type, full) {


                            return '<a class="btn btn-info btn-block btn-sm" onclick="set_quotation(\''+data.lead_no+'\')" href="#" style=" text-decoration: none;">' + ' Quotation' + '</a>';
                        }
                    }
                ]



            } );


            $('#datepicker').datepicker({
                autoclose: true

            });
            $('#datepicker-lastupdate').datepicker({
                autoclose: true

            });

            $('#datepicker-reminder').datepicker({
                autoclose: true

            });
            $('#datepicker-status-reminder').datepicker({
                autoclose: true,


            });
            

            // var ctx1_0 = document.getElementById("chart-1-0");
            var ctx1_1 = document.getElementById("chart-1-1");
            var ctxMotor = document.getElementById("chartMotor");

            var ctx4 = document.getElementById("chart-4");
            var ctx4_1 = document.getElementById("chart-4-1");
            var nonMotorChart = document.getElementById("chartNonMotor");
            var cm_nonMotorChart = document.getElementById("cm-chartNonMotor");


            var chartCWG = document.getElementById("chartCWG");
            
            var cmchartCWG = document.getElementById("cmchartCWG");

            //ajax to get data for chart 1-0 & 1-1 and table1-1
            $.ajax({
                type:'get',
                url:'chart1_0_1data',
                success:function(data){

                    cols=[];
                    gwp=[];
                    var motorP=0;
                    var nonmotorP=0;
                    axData=jQuery.parseJSON(data);
                    for(x=0 ; x<axData.length ; x++){
                        cols[x]=axData[x].dept_new;
                        gwp[x]=axData[x].gwp;

                        if(cols[x]=='FIRE'){
                            document.getElementById('cwg-fire').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }else if(cols[x]=='MISC'){
                            document.getElementById('cwg-misc').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }else if(cols[x]=='MOTOR'){
                            document.getElementById('cwg-motor').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            motorP=parseFloat(convertToZero(motorP))+parseFloat(convertToZero(gwp[x]));
                        }else if(cols[x]=='WCI'){
                            document.getElementById('cwg-wci').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }else if (cols[x]=='ENGG') {
                            document.getElementById('cwg-eng').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }else if (cols[x]=='MARINE') {
                            document.getElementById('cwg-marine').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }else if (cols[x]=='MED') {
                            document.getElementById('cwg-med').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }
                    }
                    document.getElementById('cwg-total').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));

                    document.getElementById('demo-overlay-table1-1').style.display='none';
                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                    // motor=parseFloat(convertToZero(gwp[5])).toFixed(2);

                    motorPercent=((parseFloat(motorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);


                    for(x=0;x<7;x++){

                        if(cols[x]==null || cols[x]=='undefined'){
                            cols[x]='';
                            gwp[x]=0;
                        }
                    }
                    var myChart = new Chart(chartCWG, {
                        type: 'bar',
                        data: {
                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                    // for(x=0;x<cols.length;x++){
                                    //     cols[x];    
                                    // }
                                    


                                ],
                            datasets: [
                                {
                                    label: "GWP",

                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                    // String  or array - the bar color
                                    backgroundColor: "rgba(0,121,235,0.4)",

                                    // String or array - bar stroke color
                                    borderColor: "rgba(0,121,235,1)",

                                    // Number or array - bar border width
                                    borderWidth: 1,

                                    // String or array - fill color when hovered
                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                    // String or array - border color when hovered
                                    hoverBorderColor: "rgba(0,121,235,1)",

                                    // The actual data
                                    data: [
                                        // for(x=0;x<cols.length;x++){
                                        //     gwp[x];    
                                        // }
                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                    ],

                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                },

                            ]
                        },
                        options: {

                        }
                    });
                    document.getElementById('CWGdemo-overlay-chart1-0').style.display='none';
                    var myChart = new Chart(ctx1_1, {
                        type: 'doughnut',
                        data: {
                            labels: ["Motor "+motorPercent+"%","Non Motor "+nonmotorPercent+"%"],
                            datasets: [
                                {
                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                    // The actual data
                                    data: [motorPercent,nonmotorPercent],

                                },

                            ]
                        },
                        options: {

                        }
                    });
                    document.getElementById('demo-overlay-chart1-1').style.display='none';

                },
                error:function(x,y,z){
                    console.log(z);
                }
            });


            //ajax to get data for chart 1 and table1
            $.ajax({
                type:'get',
                url:'chart1data',
                success:function(data){
                    cols=[];
                    motor=[];
                    nonmotor=[];
                    aaData=jQuery.parseJSON(data);
                    //console.log("working"+aaData[0].pol_status+" length "+aaData.length);
                    for(x=0 ; x<aaData.length ; x++){
                        cols[x]=aaData[x].pol_status;
                        motor[x]=aaData[x].motor_car_gwp;
                        nonmotor[x]=aaData[x].motor_noncar_gwp;

                        if(cols[x]=='ADDITION'){
                            console.log("Addition");
                            document.getElementById('motor-addition').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('nonmotor-addition').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if(cols[x]=='DELETION'){
                            console.log("DELETION");
                            document.getElementById('motor-deletion').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('nonmotor-deletion').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if(cols[x]=='RENEWAL'){
                            console.log("Renewal");
                            document.getElementById('motor-renewal').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('nonmotor-renewal').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if(cols[x]=='PPW-CANC'){
                            console.log("PPW-CANC");
                            document.getElementById('motor-ppw-canc').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('nonmotor-ppw-canc').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if (cols[x]=='REINSTATE') {
                            console.log("REINSTATE");
                            document.getElementById('motor-reinstate').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('nonmotor-reinstate').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if (cols[x]=='NEW') {
                            console.log("NEW");
                            document.getElementById('motor-new').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('nonmotor-new').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if (cols[x]=='CANCEL') {
                            console.log("CANCEL");
                            document.getElementById('motor-cancel').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('nonmotor-cancel').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }
                    }



                    document.getElementById('motor-total').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2));

                    document.getElementById('nonmotor-total').innerHTML=formatNumber((parseFloat(convertToZero(nonmotor[0]))+parseFloat(convertToZero(nonmotor[1]))+parseFloat(convertToZero(nonmotor[2]))+parseFloat(convertToZero(nonmotor[3]))+parseFloat(convertToZero(nonmotor[4]))+parseFloat(convertToZero(nonmotor[5]))+parseFloat(convertToZero(nonmotor[6]))).toFixed(2));

                    document.getElementById('grand-total').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(nonmotor[0]))+parseFloat(convertToZero(nonmotor[1]))+parseFloat(convertToZero(nonmotor[2]))+parseFloat(convertToZero(nonmotor[3]))+parseFloat(convertToZero(nonmotor[4]))+parseFloat(convertToZero(nonmotor[5]))+parseFloat(convertToZero(nonmotor[6])))).toFixed(2));
                    document.getElementById('demo-overlay-table1').style.display='none';
                    car=0;
                    noncar=0;
                    carP=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                    noncarP=(parseFloat(convertToZero(nonmotor[0]))+parseFloat(convertToZero(nonmotor[1]))+parseFloat(convertToZero(nonmotor[2]))+parseFloat(convertToZero(nonmotor[3]))+parseFloat(convertToZero(nonmotor[4]))+parseFloat(convertToZero(nonmotor[5]))+parseFloat(convertToZero(nonmotor[6]))).toFixed(2);
                    if(car<0){
                        car=0;
                    }else if(noncar<0){
                        noncar=0;
                    }
                    carPercent=((parseFloat(carP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);
                    noncarPercent=((parseFloat(noncarP)/(parseFloat(carP)+parseFloat(noncarP)))*100).toFixed(2);

                    if(carPercent<0){
                        carPercent=0;
                    }else if(noncarPercent<0){
                        noncarPercent=0;
                    }
                    
                    var myChart = new Chart(ctxMotor, {
                        type: 'doughnut',
                        data: {
                            labels: ["Car "+carPercent+"%","Non Car "+noncarPercent+"%"],
                            datasets: [
                                {
                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                    // The actual data
                                    data: [carPercent,noncarPercent],

                                },

                            ]
                        },
                        options: {

                        }
                    });
                    document.getElementById('demo-overlay-chart-1-1-1').style.display='none';
                },
                error:function(x,y,z){
                    console.log(z);
                }
            });

            //ajax to get data for nonmotor chart-fmt
            $.ajax({
                type:'get',
                url:'FMTNONMOTOR',
                success:function(data){
                    cols=[];
                    mrn=[];
                    med=[];
                    mis=[];
                    eng=[];
                    fir=[];
                    wci=[];
                    
                    mrnT=0;
                    medT=0;
                    misT=0;
                    engT=0;
                    firT=0;
                    wciT=0;

                    aaData=jQuery.parseJSON(data);
                                        console.log("NON MOTOR CLASS WISE"+aaData[0]);

                    // console.log(aaData[1].new_policy);
                    for(x=0 ; x<aaData.length ; x++){
                        cols[x]=aaData[x].new_policy;
                        mrn[x]=aaData[x].mrn;
                        med[x]=aaData[x].med;
                        mis[x]=aaData[x].mis;
                        eng[x]=aaData[x].eng;
                        fir[x]=aaData[x].fir;
                        wci[x]=aaData[x].wci;
                        console.log(cols[x]+" "+mrn[x]+" "+med[x]+" "+mis[x]+" "+eng[x]+" "+fir[x]+" "+wci[x]);

                        if(cols[x]=='ADDITION'){
                            document.getElementById('nonmotor-addition-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('nonmotor-addition-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('nonmotor-addition-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('nonmotor-addition-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('nonmotor-addition-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('nonmotor-addition-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                            
                        }else if(cols[x]=='DELETION'){
                            document.getElementById('nonmotor-deletion-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('nonmotor-deletion-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('nonmotor-deletion-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('nonmotor-deletion-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('nonmotor-deletion-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('nonmotor-deletion-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));

                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                            
                        }else if(cols[x]=='RENEWAL'){
                            document.getElementById('nonmotor-renewal-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('nonmotor-renewal-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('nonmotor-renewal-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('nonmotor-renewal-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('nonmotor-renewal-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('nonmotor-renewal-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                           
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                        }else if(cols[x]=='PPW-CANC'){
                            document.getElementById('nonmotor-ppwcancel-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('nonmotor-ppwcancel-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('nonmotor-ppwcancel-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('nonmotor-ppwcancel-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('nonmotor-ppwcancel-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('nonmotor-ppwcancel-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                            
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                        }else if (cols[x]=='REINSTATE') {
                            document.getElementById('nonmotor-reinstate-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('nonmotor-reinstate-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('nonmotor-reinstate-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('nonmotor-reinstate-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('nonmotor-reinstate-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('nonmotor-reinstate-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                        }else if (cols[x]=='NEW') {
                            document.getElementById('nonmotor-new-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('nonmotor-new-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('nonmotor-new-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('nonmotor-new-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('nonmotor-new-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('nonmotor-new-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                        }else if (cols[x]=='CANCEL') {
                            document.getElementById('nonmotor-cancel-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('nonmotor-cancel-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('nonmotor-cancel-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('nonmotor-cancel-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('nonmotor-cancel-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('nonmotor-cancel-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                        }
                    }
                    console.log("total: "+" "+mrnT+" "+medT+" "+misT+" "+engT+" "+firT+" "+wciT);
                    document.getElementById('nonmotor-total-mrn').innerHTML=formatNumber(mrnT.toFixed(2));
                    document.getElementById('nonmotor-total-med').innerHTML=formatNumber(medT.toFixed(2));
                    document.getElementById('nonmotor-total-mis').innerHTML=formatNumber(misT.toFixed(2));
                    document.getElementById('nonmotor-total-eng').innerHTML=formatNumber(engT.toFixed(2));
                    document.getElementById('nonmotor-total-fir').innerHTML=formatNumber(firT.toFixed(2));
                    document.getElementById('nonmotor-total-wci').innerHTML=formatNumber(wciT.toFixed(2));
                    // total=0;
                    // total=formatNumber(convertToZero(parseFloat(mrnT))+convertToZero(parseFloat(medT))+convertToZero(parseFloat(misT))+convertToZero(parseFloat(engT))+convertToZero(parseFloat(firT))+convertToZero(parseFloat(wciT)));
                    // console.log("total nonmotor: "+total);
                    mrnP=((parseFloat(mrnT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);
                    // console.log("MRN nonmotor: "+mrnP);
                    medP=((parseFloat(medT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);
                    misP=((parseFloat(misT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);
                    engP=((parseFloat(engT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);
                    firP=((parseFloat(firT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);
                    wciP=((parseFloat(wciT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);


                    document.getElementById('nonmotor-demo-overlay-table1').style.display='none';
                    
                    var myChart = new Chart(nonMotorChart, {
                        type: 'doughnut',
                        data: {
                            labels: ["MRN","MED","MISC","ENG","FIRE","WCI"],
                            datasets: [
                                {
                                    backgroundColor:['#810587','#003c86','#bb7d00','#576c8c','#8c6d2f','#00badb'],

                                    // The actual data
                                    data: [mrnP,medP,misP,engP,firP,wciP],
                                    // data: [10,20,30,20,5,15],

                                },

                            ]
                        },
                        options: {

                        }
                    });
                    document.getElementById('NonMotor-demo-overlay-chart-1-1-1').style.display='none';
                },
                error:function(x,y,z){
                    console.log(z);
                }
            });
            //get data for chart2 and table
            $.ajax({
                type:'get',
                url:'chart2data',
                success:function(data){
                    console.log(jQuery.parseJSON(data));
                    abData=jQuery.parseJSON(data);

                    cols=[];
                    gwp=[];
                    nop=[];
                    var t_gwp=0;
                    var t_nop=0;
                    for(x=0 ; x<abData.length ; x++){
                        cols[x]=abData[x].type;
                        gwp[x]=abData[x].gwp;
                        nop[x]=abData[x].nop;

                        t_gwp+=parseFloat(gwp[x]);
                        t_nop+=parseFloat(nop[x]);
                    }
                    document.getElementById('motor-new-gwp').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                    document.getElementById('motor-new-nop').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                    document.getElementById('motor-renewal-gwp').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                    document.getElementById('motor-renewal-nop').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                    document.getElementById('nonmotor-new-gwp').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                    document.getElementById('nonmotor-new-nop').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                    document.getElementById('nonmotor-renewal-gwp').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                    document.getElementById('nonmotor-renewal-nop').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                    document.getElementById('total-gwp').innerHTML=formatNumber((convertToZero(t_gwp).toFixed(2)));
                    document.getElementById('total-nop').innerHTML=formatNumber((convertToZero(t_nop)));
                    document.getElementById('demo-overlay-table2').style.display='none';
                },
                error:function(x,y,z){
                    console.log(z);
                }
            });






            // cumulative non motor
            $.ajax({
                type:'get',
                url:'cumulativeNONMOTOR',
                success:function(data){
                    cols=[];
                    mrn=[];
                    med=[];
                    mis=[];
                    eng=[];
                    fir=[];
                    wci=[];
                    
                    mrnT=0;
                    medT=0;
                    misT=0;
                    engT=0;
                    firT=0;
                    wciT=0;

                    aaData=jQuery.parseJSON(data);
                                        console.log("cumulative NON MOTOR CLASS WISE"+aaData[0]);

                    // console.log(aaData[1].new_policy);
                    for(x=0 ; x<aaData.length ; x++){
                        if(aaData==null){
                            break;
                        }
                        cols[x]=aaData[x].new_policy;
                        mrn[x]=aaData[x].mrn;
                        med[x]=aaData[x].med;
                        mis[x]=aaData[x].mis;
                        eng[x]=aaData[x].eng;
                        fir[x]=aaData[x].fir;
                        wci[x]=aaData[x].wci;
                        console.log(cols[x]+" "+mrn[x]+" "+med[x]+" "+mis[x]+" "+eng[x]+" "+fir[x]+" "+wci[x]);

                        if(cols[x]=='ADDITION'){
                            document.getElementById('cm-nonmotor-addition-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-addition-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-addition-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-addition-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-addition-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-addition-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                            
                        }else if(cols[x]=='DELETION'){
                            document.getElementById('cm-nonmotor-deletion-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-deletion-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-deletion-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-deletion-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-deletion-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-deletion-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));

                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                            
                        }else if(cols[x]=='RENEWAL'){
                            document.getElementById('cm-nonmotor-renewal-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-renewal-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-renewal-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-renewal-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-renewal-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-renewal-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                           
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                        }else if(cols[x]=='PPW-CANC'){
                            document.getElementById('cm-nonmotor-ppwcancel-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-ppwcancel-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-ppwcancel-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-ppwcancel-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-ppwcancel-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-ppwcancel-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                            
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                        }else if (cols[x]=='REINSTATE') {
                            document.getElementById('cm-nonmotor-reinstate-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-reinstate-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-reinstate-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-reinstate-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-reinstate-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-reinstate-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                        }else if (cols[x]=='NEW') {
                            document.getElementById('cm-nonmotor-new-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-new-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-new-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-new-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-new-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-new-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                        }else if (cols[x]=='CANCEL') {
                            document.getElementById('cm-nonmotor-cancel-mrn').innerHTML=formatNumber(parseFloat(convertToZero(mrn[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-cancel-med').innerHTML=formatNumber(parseFloat(convertToZero(med[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-cancel-mis').innerHTML=formatNumber(parseFloat(convertToZero(mis[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-cancel-eng').innerHTML=formatNumber(parseFloat(convertToZero(eng[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-cancel-fir').innerHTML=formatNumber(parseFloat(convertToZero(fir[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-cancel-wci').innerHTML=formatNumber(parseFloat(convertToZero(wci[x])).toFixed(2));
                            mrnT=parseFloat(convertToZero(mrnT))+parseFloat(convertToZero(mrn[x]));
                            medT=parseFloat(convertToZero(medT))+parseFloat(convertToZero(med[x]));
                            misT=parseFloat(convertToZero(misT))+parseFloat(convertToZero(mis[x]));
                            engT=parseFloat(convertToZero(engT))+parseFloat(convertToZero(eng[x]));
                            firT=parseFloat(convertToZero(firT))+parseFloat(convertToZero(fir[x]));
                            wciT=parseFloat(convertToZero(wciT))+parseFloat(convertToZero(wci[x]));
                        }
                    }
                    console.log("total: "+" "+mrnT+" "+medT+" "+misT+" "+engT+" "+firT+" "+wciT);
                    document.getElementById('cm-nonmotor-total-mrn').innerHTML=formatNumber(mrnT.toFixed(2));
                    document.getElementById('cm-nonmotor-total-med').innerHTML=formatNumber(medT.toFixed(2));
                    document.getElementById('cm-nonmotor-total-mis').innerHTML=formatNumber(misT.toFixed(2));
                    document.getElementById('cm-nonmotor-total-eng').innerHTML=formatNumber(engT.toFixed(2));
                    document.getElementById('cm-nonmotor-total-fir').innerHTML=formatNumber(firT.toFixed(2));
                    document.getElementById('cm-nonmotor-total-wci').innerHTML=formatNumber(wciT.toFixed(2));
                    // total=0;
                    // total=formatNumber(convertToZero(parseFloat(mrnT))+convertToZero(parseFloat(medT))+convertToZero(parseFloat(misT))+convertToZero(parseFloat(engT))+convertToZero(parseFloat(firT))+convertToZero(parseFloat(wciT)));
                    // console.log("total nonmotor: "+total);
                    mrnP=((parseFloat(mrnT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);
                    // console.log("MRN nonmotor: "+mrnP);
                    medP=((parseFloat(medT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);
                    misP=((parseFloat(misT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);
                    engP=((parseFloat(engT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);
                    firP=((parseFloat(firT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);
                    wciP=((parseFloat(wciT)/(parseFloat(mrnT)+parseFloat(medT)+parseFloat(misT)+parseFloat(engT)+parseFloat(firT)+parseFloat(wciT)))*100).toFixed(2);


                    document.getElementById('cm-nonmotor-demo-overlay-table1').style.display='none';
                    
                    var myChart = new Chart(cm_nonMotorChart, {
                        type: 'doughnut',
                        data: {
                            labels: ["MRN","MED","MISC","ENG","FIRE","WCI"],
                            datasets: [
                                {
                                    backgroundColor:['#810587','#003c86','#bb7d00','#576c8c','#8c6d2f','#00badb'],

                                    // The actual data
                                    data: [mrnP,medP,misP,engP,firP,wciP],
                                    // data: [10,20,30,20,5,15],

                                },

                            ]
                        },
                        options: {

                        }
                    });
                    document.getElementById('cm-NonMotor-demo-overlay-chart-1-1-1').style.display='none';
                },
                error:function(x,y,z){
                    console.log(z);
                }
            });

//            get data for chart 3(target achievement)
            $.ajax({
                type:'get',
                url:'chart3data',
                success:function(data){
                    console.log(jQuery.parseJSON(data));
                    acData=jQuery.parseJSON(data);
                    console.log("ahas"+acData.motor_target);
                    // cols=[];
                    // target=[];
                    // achievement=[];
                    // var t_target=0;
                    // var t_achievement=0;
                    // for(x=0 ; x<acData.length ; x++){
                    //     cols[x]=acData[x].type;
                    //     target[x]=acData[x].target_amount;
                    //     achievement[x]=acData[x].achievement_amt;

                        t_target=parseFloat(acData.motor_target)+parseFloat(acData.nonmotor_target);
                        t_achievement=parseFloat(acData.motor_achievement)+parseFloat(acData.nonmotor_achievement);
                    // }

                    document.getElementById('motor-target').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_target)).toFixed(2));
                    document.getElementById('motor-achievement').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_achievement)).toFixed(2));
                    document.getElementById('motor-percentage').innerHTML=((parseFloat(convertToZero(acData.motor_achievement))/parseFloat(convertToZero(acData.motor_target)))*100).toFixed(2)+'%';//%
                    document.getElementById('nonmotor-target').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_target)).toFixed(2));
                    document.getElementById('nonmotor-achievement').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_achievement)).toFixed(2));
                    document.getElementById('nonmotor-percentage').innerHTML=((parseFloat(convertToZero(acData.nonmotor_achievement))/parseFloat(convertToZero(acData.nonmotor_target)))*100).toFixed(2)+'%';
                    document.getElementById('total-target').innerHTML=formatNumber(convertToZero(t_target).toFixed(2));
                    document.getElementById('total-achievement').innerHTML=formatNumber(convertToZero(t_achievement).toFixed(2));
                    document.getElementById('total-percentage').innerHTML=((convertToZero(t_achievement)/convertToZero(t_target))*100).toFixed(2)+'%';

                    // document.getElementById('demo-overlay-table3').style.display='none';
                },
                error:function(x,y,z){
                    console.log(z);
                }
            });





            $.ajax({
                type:'get',
                url:'cumulative_target_achievement',
                success:function(data){
                    console.log(jQuery.parseJSON(data));
                    acData=jQuery.parseJSON(data);
                    console.log("cumulative data"+acData.motor_achievement);
                    // cols=[];
                    // target=[];
                    // achievement=[];
                    // var t_target=0;
                    // var t_achievement=0;
                    // for(x=0 ; x<acData.length ; x++){
                    //     cols[x]=acData[x].type;
                    //     target[x]=acData[x].target_amount;
                    //     achievement[x]=acData[x].achievement_amt;

                        t_target=parseFloat(acData.motor_target)+parseFloat(acData.nonmotor_target);
                        t_achievement=parseFloat(acData.motor_achievement)+parseFloat(acData.nonmotor_achievement);
                    // }

                    document.getElementById('cm-motor-target').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_target)).toFixed(2));
                    document.getElementById('cm-motor-achievement').innerHTML=formatNumber(parseFloat(convertToZero(acData.motor_achievement)).toFixed(2));
                    document.getElementById('cm-motor-percentage').innerHTML=((parseFloat(convertToZero(acData.motor_achievement))/parseFloat(convertToZero(acData.motor_target)))*100).toFixed(2)+'%';//%
                    document.getElementById('cm-nonmotor-target').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_target)).toFixed(2));
                    document.getElementById('cm-nonmotor-achievement').innerHTML=formatNumber(parseFloat(convertToZero(acData.nonmotor_achievement)).toFixed(2));
                    document.getElementById('cm-nonmotor-percentage').innerHTML=((parseFloat(convertToZero(acData.nonmotor_achievement))/parseFloat(convertToZero(acData.nonmotor_target)))*100).toFixed(2)+'%';
                    document.getElementById('cm-total-target').innerHTML=formatNumber(convertToZero(t_target).toFixed(2));
                    document.getElementById('cm-total-achievement').innerHTML=formatNumber(convertToZero(t_achievement).toFixed(2));
                    document.getElementById('cm-total-percentage').innerHTML=((convertToZero(t_achievement)/convertToZero(t_target))*100).toFixed(2)+'%';

                    // document.getElementById('demo-overlay-table3').style.display='none';
                },
                error:function(x,y,z){
                    console.log(z);
                }
            });
            var cm_cwg = document.getElementById("cm-cwg-chart");
            var cm_motor = document.getElementById("cm-motor-chart");
            $.ajax({
                type:'get',
                url:'cumulativeCWG',
                success:function(data){
                    var nonmotorP=0;
                    var motorP=0;
                    cols=[];
                    gwp=[];
                    axData=jQuery.parseJSON(data);
                    for(x=0 ; x<axData.length ; x++){
                        cols[x]=axData[x].dept_new;
                        gwp[x]=axData[x].gwp;

                        if(cols[x]=='FIRE'){
                            document.getElementById('cm-cwg-fire').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }else if(cols[x]=='MISC'){
                            document.getElementById('cm-cwg-misc').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }else if(cols[x]=='MOTOR'){
                            document.getElementById('cm-cwg-motor').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            motorP=parseFloat(convertToZero(motorP))+parseFloat(convertToZero(gwp[x]));
                        }else if(cols[x]=='WCI'){
                            document.getElementById('cm-cwg-wci').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }else if (cols[x]=='ENGG') {
                            document.getElementById('cm-cwg-eng').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }else if (cols[x]=='MARINE') {
                            document.getElementById('cm-cwg-marine').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }else if (cols[x]=='MED') {
                            document.getElementById('cm-cwg-med').innerHTML=formatNumber(parseFloat(convertToZero(gwp[x])).toFixed(2));
                            nonmotorP=parseFloat(convertToZero(nonmotorP))+parseFloat(convertToZero(gwp[x]));
                        }

                    }
                    
                    document.getElementById('cm-cwg-total').innerHTML=formatNumber((parseFloat(convertToZero(gwp[0]))+parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2));

                    document.getElementById('spinner-cm-cwg-table').style.display='none';
                    // nonmotor=(parseFloat(convertToZero(gwp[1]))+parseFloat(convertToZero(gwp[2]))+parseFloat(convertToZero(gwp[3]))+parseFloat(convertToZero(gwp[4]))+parseFloat(convertToZero(gwp[5]))+parseFloat(convertToZero(gwp[6]))).toFixed(2);
                    // motor=parseFloat(convertToZero(gwp[0])).toFixed(2);
                    motorPercent=0;
                    nonmotorPercent=0;
                    motorPercent=((parseFloat(motorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);
                    nonmotorPercent=((parseFloat(nonmotorP)/(parseFloat(motorP)+parseFloat(nonmotorP)))*100).toFixed(2);

                    console.log("----------error data: "+motorP+" "+nonmotorP+" "+motorPercent+" "+nonmotorPercent);
                    for(x=0;x<7;x++){

                        if(cols[x]==null || cols[x]=='undefined'){
                            cols[x]='';
                            gwp[x]=0;
                        }
                    }
                    var myChart = new Chart(cmchartCWG, {
                        type: 'bar',
                        data: {
                            labels: [cols[0],cols[1],cols[2],cols[3],cols[4],cols[5],cols[6]

                                    // for(x=0;x<cols.length;x++){
                                    //     cols[x];    
                                    // }
                                    


                                ],
                            datasets: [
                                {
                                    label: "GWP",

                                    // The properties below allow an array to be specified to change the value of the item at the given index
                                    // String  or array - the bar color
                                    backgroundColor: "rgba(0,121,235,0.4)",

                                    // String or array - bar stroke color
                                    borderColor: "rgba(0,121,235,1)",

                                    // Number or array - bar border width
                                    borderWidth: 1,

                                    // String or array - fill color when hovered
                                    hoverBackgroundColor: "rgba(0,121,235,0.6)",

                                    // String or array - border color when hovered
                                    hoverBorderColor: "rgba(0,121,235,1)",

                                    // The actual data
                                    data: [
                                        // for(x=0;x<cols.length;x++){
                                        //     gwp[x];    
                                        // }
                                        gwp[0],gwp[1],gwp[2],gwp[3],gwp[4],gwp[5],gwp[6]

                                    ],

                                    // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.

                                },

                            ]
                        },
                        options: {

                        }
                    });
                    document.getElementById('cmCWGdemo-overlay-chart1-0').style.display='none';


                    var myChart = new Chart(cm_cwg, {
                        type: 'doughnut',
                        data: {
                            labels: ["Motor "+motorPercent+"%","Non Motor "+nonmotorPercent+"%"],
                            datasets: [
                                {
                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                    // The actual data
                                    data: [motorPercent,nonmotorPercent],

                                },

                            ]
                        },
                        options: {

                        }
                    });
                    document.getElementById('spinner-cm-cwg-chart').style.display='none';

                },
                error:function(x,y,z){
                    console.log(z);
                }
            }); 

        
            $.ajax({
                type:'get',
                url:'cumulativeMOTOR',
                success:function(data){
                    cols=[];
                    motor=[];
                    nonmotor=[];
                    aaData=jQuery.parseJSON(data);
                    console.log("working------cumuative");
                    console.log(aaData);
                    for(x=0 ; x<aaData.length ; x++){
                        cols[x]=aaData[x].pol_status;
                        motor[x]=aaData[x].motor_car_gwp;
                        nonmotor[x]=aaData[x].motor_noncar_gwp;


                        if(cols[x]=='ADDITION'){
                            console.log("Addition");
                            document.getElementById('cm-motor-addition').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-addition').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if(cols[x]=='DELETION'){
                            console.log("DELETION");
                            document.getElementById('cm-motor-deletion').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-deletion').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if(cols[x]=='RENEWAL'){
                            console.log("Renewal");
                            document.getElementById('cm-motor-renewal').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-renewal').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if(cols[x]=='PPW-CANC'){
                            console.log("PPW-CANC");
                            document.getElementById('cm-motor-ppw-canc').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-ppw-canc').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if (cols[x]=='REINSTATE') {
                            console.log("REINSTATE");
                            document.getElementById('cm-motor-reinstate').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-reinstate').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if (cols[x]=='NEW') {
                            console.log("NEW");
                            document.getElementById('cm-motor-new').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-new').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }else if (cols[x]=='CANCEL') {
                            console.log("CANCEL");
                            document.getElementById('cm-motor-cancel').innerHTML=formatNumber(parseFloat(convertToZero(motor[x])).toFixed(2));
                            document.getElementById('cm-nonmotor-cancel').innerHTML=formatNumber(parseFloat(convertToZero(nonmotor[x])).toFixed(2));
                        }
                    }
                    document.getElementById('cm-motor-total').innerHTML=formatNumber((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2)); 
                    document.getElementById('cm-nonmotor-total').innerHTML=formatNumber((parseFloat(convertToZero(nonmotor[0]))+parseFloat(convertToZero(nonmotor[1]))+parseFloat(convertToZero(nonmotor[2]))+parseFloat(convertToZero(nonmotor[3]))+parseFloat(convertToZero(nonmotor[4]))+parseFloat(convertToZero(nonmotor[5]))+parseFloat(convertToZero(nonmotor[6]))).toFixed(2));

                    document.getElementById('cm-grand-total').innerHTML=formatNumber(((parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6])))+(parseFloat(convertToZero(nonmotor[0]))+parseFloat(convertToZero(nonmotor[1]))+parseFloat(convertToZero(nonmotor[2]))+parseFloat(convertToZero(nonmotor[3]))+parseFloat(convertToZero(nonmotor[4]))+parseFloat(convertToZero(nonmotor[5]))+parseFloat(convertToZero(nonmotor[6])))).toFixed(2));
                    document.getElementById('spinner-cm-motor-table').style.display='none';

                    noncar=(parseFloat(convertToZero(motor[0]))+parseFloat(convertToZero(motor[1]))+parseFloat(convertToZero(motor[2]))+parseFloat(convertToZero(motor[3]))+parseFloat(convertToZero(motor[4]))+parseFloat(convertToZero(motor[5]))+parseFloat(convertToZero(motor[6]))).toFixed(2);
                    car=(parseFloat(convertToZero(nonmotor[0]))+parseFloat(convertToZero(nonmotor[1]))+parseFloat(convertToZero(nonmotor[2]))+parseFloat(convertToZero(nonmotor[3]))+parseFloat(convertToZero(nonmotor[4]))+parseFloat(convertToZero(nonmotor[5]))+parseFloat(convertToZero(nonmotor[6]))).toFixed(2);
                    if(car<0){
                        car=0;
                    }else if(noncar<0){
                        noncar=0;
                    }
                    carPercent=((parseFloat(car)/(parseFloat(car)+parseFloat(noncar)))*100).toFixed(2);
                    noncarPercent=((parseFloat(noncar)/(parseFloat(car)+parseFloat(noncar)))*100).toFixed(2);

                    if(carPercent<0){
                        carPercent=0;
                    }else if(noncarPercent<0){
                        noncarPercent=0;
                    }
                    
                    var myChart = new Chart(cm_motor, {
                        type: 'doughnut',
                        data: {
                            labels: ["Car "+carPercent+"%","Non Car "+noncarPercent+"%"],
                            datasets: [
                                {
                                    backgroundColor:['#1C9DE3','#FFDD00'],

                                    // The actual data
                                    data: [carPercent,noncarPercent],

                                },

                            ]
                        },
                        options: {

                        }
                    });
                    document.getElementById('spinner-cm-motor-chart').style.display='none';
                },
                error:function(x,y,z){
                    console.log(z);
                }
            });
            
            $.ajax({
                type:'get',
                url:'cumulativePOLICY',
                success:function(data){
                    console.log(jQuery.parseJSON(data));
                    abData=jQuery.parseJSON(data);

                    cols=[];
                    gwp=[];
                    nop=[];
                    var t_gwp=0;
                    var t_nop=0;
                    for(x=0 ; x<abData.length ; x++){
                        cols[x]=abData[x].type;
                        gwp[x]=abData[x].gwp;
                        nop[x]=abData[x].nop;
                        t_gwp=parseFloat(convertToZero(t_gwp))+parseFloat(convertToZero(gwp[x]));
                        t_nop=parseFloat(convertToZero(t_nop))+parseFloat(convertToZero(nop[x]));
                        // t_gwp+=parseFloat(gwp[x]);
                        // t_nop+=parseFloat(nop[x]);
                    }
                    document.getElementById('cm-motor-new-gwp').innerHTML=formatNumber(parseFloat(convertToZero(gwp[1])).toFixed(2));
                    document.getElementById('cm-motor-new-nop').innerHTML=formatNumber(parseFloat(convertToZero(nop[1])));
                    document.getElementById('cm-motor-renewal-gwp').innerHTML=formatNumber(parseFloat(convertToZero(gwp[0])).toFixed(2));
                    document.getElementById('cm-motor-renewal-nop').innerHTML=formatNumber(parseFloat(convertToZero(nop[0])));
                    document.getElementById('cm-nonmotor-new-gwp').innerHTML=formatNumber(parseFloat(convertToZero(gwp[2])).toFixed(2));
                    document.getElementById('cm-nonmotor-new-nop').innerHTML=formatNumber(parseFloat(convertToZero(nop[2])));
                    document.getElementById('cm-nonmotor-renewal-gwp').innerHTML=formatNumber(parseFloat(convertToZero(gwp[3])).toFixed(2));
                    document.getElementById('cm-nonmotor-renewal-nop').innerHTML=formatNumber(parseFloat(convertToZero(nop[3])));
                    document.getElementById('cm-total-gwp').innerHTML=formatNumber((convertToZero(t_gwp).toFixed(2)));
                    document.getElementById('cm-total-nop').innerHTML=formatNumber((convertToZero(t_nop)));
                    document.getElementById('spinner-cm-policy-table').style.display='none';
                },
                error:function(x,y,z){
                    console.log(z);
                }
            });
        });

        function formatNumber (num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
        }
    </script>
    <script type="text/javascript">
        function convertToZero(num_check){
            // alert(num_check);
            if(num_check==undefined || isNaN(num_check)){
                // alert("Not an number "+ num_check);
                return 0;
            }else{
                // alert("not working");
                return num_check;
            }
        }
    </script>

@endsection