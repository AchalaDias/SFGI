<?php
session_start();
if(isset($_SESSION['USER_TYPE'])){
    $type=$_SESSION['USER_TYPE'];
    if($type=="admin"){
        echo "<style>
                #leads{visibility: hidden}
                #leads-tab{visibility: hidden}
                #group{visibility: visible}
                #group-tab{visibility: visible}
            </style>";
    }else{
        echo "<style>
                #leads{visibility: visible}
                #leads-tab{visibility: visible}
                #group{visibility: hidden}
                #group-tab{visibility: hidden}
            </style>";
    }
}else{
    echo "<script>window.location.href=\"login\";</script>";
}
?>
@extends('master')

@section('content')

    <style>
        .rank{
            height: 140px;
            margin:20px;
            float: none;
            border:0px solid black;
            border-radius: 5px;
            padding:0px;
            padding-top: 2px;
        }
        .profile{
            margin:20px;
            float:none;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            padding-top: 20px;
            height: 140px;
            margin-right:200px;
            background-color: #00a7d0;
            border:0px solid black;
        }
        .profile span{
            color:#FFFFFF;
            clear:both;
            margin-left: 30px;
            font-size: 16px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .profile-pic{
            border:0px solid black;
            float:left;
            padding: 4px;
            margin-left:10px;
            text-align: center;
        }
        .rank h4{
            margin:0px;
            color: #FFFFFF;
            height: 20%;
            text-align: center;
        }
        .rank p{
            position: relative;
            top:10%;
            font-size: 34px;
            margin:0px;
            color: #FFFFFF;
            height:60%;
            text-align: center;

        }
    </style>

    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" >
    {{--#leads,#leads-tab{visibility: hidden;}--}}
    {{--#group,#group-tab{visibility: hidden;}--}}
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" >
    {{--<script src="js/jquery.min.js"></script>--}}
    {{--<script src="js/bootstrap.min.js"></script>--}}


    <div class="container">

        <div class="col-md-4 profile">
            <div class="col-md-4 profile-pic">
                <img src="images/user.png" width="75px" height="75px">
            </div>
            <span>Name : <?php if(isset($_SESSION['USER_NAME'])){echo $_SESSION['USER_NAME'];}  ?></span><br>
            <span>Occupation : {{$testArr['occupation']}}</span><br>
            <span>Address : {{$testArr['address']}}</span>
        </div>
        {{--rank tabs start--}}
        <div class="col-md-2 rank" style="background-color: #2d4373;width:12%">
            {{--<a href="Test">{{$testArr['destination']}}</a>--}}
            <h4>
                Rank
            </h4>
            <p>
                5
            </p>
            <h4>
                National
            </h4>
        </div>
        <div class="col-md-2 rank" style="background-color: #5b9909;width:12%">
            <h4>
                Rank
            </h4>
            <p>
                4
            </p>
            <h4>
                Zonal
            </h4>

        </div>
        <div class="col-md-2 rank" style="background-color: #7a43b6;width:12%">
            <h4>
                Rank
            </h4>
            <p>
                2
            </p>
            <h4>
                Branch
            </h4>
        </div>
        {{--rank tabs close--}}
        <style>

            .sample{
                border:0px solid red;
                height:auto;
                width: 100%;
                padding:0px;
                /*!*display:flex;*!*/
                /*justify-content: space-between;*/
                display: flex;
                flex-flow: row wrap;
                justify-content: space-around;
            }
            .charts{
                border:1px solid #DDDDDD;
                margin:10px;
                height:auto;
                padding: 5px;
                background-color: #F0F0F0;
                width:45%;
            }
            #leads,#group,#for-the-month,#cumilative{
                width:100%;
                clear: both;
            }
            #memberSelection{
                border:0px solid green;
            }
        </style>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                $('#tabs').tab();
            });
        </script>
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
            <li class="active" id="for-the-month-tab"><a href="#for-the-month" data-toggle="tab">Month</a></li>
            <li id="cumilative-tab"><a href="#cumilative" data-toggle="tab">Cumulative</a></li>
            <li id="group-tab"><a href="#group" data-toggle="tab">Group</a></li>
            <li id="leads-tab"><a href="#leads" data-toggle="tab">Lead Management</a></li>
        </ul>
        <div id="my-tab-content" class="tab-content">
            <div class="tab-pane active" id="for-the-month">
                <h1>For The Month</h1>
                <div class="col-md-12 sample">
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <table class="table table-bordered" id="myTable">
                            <caption style="text-align: center;font-weight: 600;font-size: x-large;color: #000">Motor</caption>
                            <thead>
                            <tr>
                                <th></th>
                                <th>Car</th>
                                <th>Non-Car</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>New</td>
                                <td>23232</td>
                                <td>32324</td>

                            </tr>
                            <tr>
                                <td>Renewal</td>
                                <td>32423</td>
                                <td>32131</td>

                            </tr>
                            <tr>
                                <td>Addition</td>
                                <td>32131</td>
                                <td>21313</td>

                            </tr>
                            <tr>
                                <td>PPW(-)</td>
                                <td>312312</td>
                                <td>312312</td>

                            </tr>
                            <tr>
                                <td>Cancel(-)</td>
                                <td>321312</td>
                                <td>321313</td>

                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>321313</td>
                                <td>312313</td>

                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td colspan="2">654655</td>


                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <table class="table table-bordered" id="myTable">
                            <caption style="text-align: center;font-weight: 600;font-size: x-large;color: #000">Non Motor</caption>
                            <thead>
                            <tr>
                                <th></th>
                                <th>ENG</th>
                                <th>FIR</th>
                                <th>MED</th>
                                <th>MIS</th>
                                <th>MRN</th>
                                <th>WCI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>New</td>
                                <td>34544</td>
                                <td>42123</td>
                                <td>32131</td>
                                <td>32131</td>
                                <td>31231</td>
                                <td>32131</td>

                            </tr>
                            <tr>
                                <td>Renewal</td>
                                <td>321312</td>
                                <td>32132</td>
                                <td>32131</td>
                                <td>312312</td>
                                <td>312312</td>
                                <td>32133</td>
                            </tr>
                            <tr>
                                <td>Addition</td>
                                <td>321312</td>
                                <td>321312</td>
                                <td>32131</td>
                                <td>32131</td>
                                <td>31231</td>
                                <td>312312</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>31231</td>
                                <td>321312</td>
                                <td>313221</td>
                                <td>31231</td>
                                <td>31231</td>
                                <td>312312</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center; width: 95%">

                        <table class="table table-bordered" id="myTable">

                            <thead>
                            <tr>
                                <th></th>
                                <th>Target</th>
                                <th>Achievement</th>
                                <th>%</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Motor</td>
                                <td>32131</td>
                                <td>32131</td>
                                <td>56</td>

                            </tr>
                            <tr>
                                <td>Non Motor</td>
                                <td>312312</td>
                                <td>32131</td>
                                <td>87</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>321312</td>
                                <td>312312</td>
                                <td>65</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <canvas id="chart-1" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <canvas id="chart-2" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <canvas id="chart-3" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <canvas id="chart-4" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <canvas id="chart-5" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="cumilative">
                <h1>Cumilative</h1>
                <div class="col-md-12 sample">
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <table class="table table-bordered" id="myTable">
                            <caption style="text-align: center;font-weight: 600;font-size: x-large;color: #000">Motor</caption>
                            <thead>
                            <tr>
                                <th></th>
                                <th>Car</th>
                                <th>Non-Car</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>New</td>
                                <td>23232</td>
                                <td>32324</td>

                            </tr>
                            <tr>
                                <td>Renewal</td>
                                <td>32423</td>
                                <td>32131</td>

                            </tr>
                            <tr>
                                <td>Addition</td>
                                <td>32131</td>
                                <td>21313</td>

                            </tr>
                            <tr>
                                <td>PPW(-)</td>
                                <td>312312</td>
                                <td>312312</td>

                            </tr>
                            <tr>
                                <td>Cancel(-)</td>
                                <td>321312</td>
                                <td>321313</td>

                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>321313</td>
                                <td>312313</td>

                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td colspan="2">654655</td>


                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <table class="table table-bordered" id="myTable">
                            <caption style="text-align: center;font-weight: 600;font-size: x-large;color: #000">Non Motor</caption>
                            <thead>
                            <tr>
                                <th></th>
                                <th>ENG</th>
                                <th>FIR</th>
                                <th>MED</th>
                                <th>MIS</th>
                                <th>MRN</th>
                                <th>WCI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>New</td>
                                <td>34544</td>
                                <td>42123</td>
                                <td>32131</td>
                                <td>32131</td>
                                <td>31231</td>
                                <td>32131</td>

                            </tr>
                            <tr>
                                <td>Renewal</td>
                                <td>321312</td>
                                <td>32132</td>
                                <td>32131</td>
                                <td>312312</td>
                                <td>312312</td>
                                <td>32133</td>
                            </tr>
                            <tr>
                                <td>Addition</td>
                                <td>321312</td>
                                <td>321312</td>
                                <td>32131</td>
                                <td>32131</td>
                                <td>31231</td>
                                <td>312312</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>31231</td>
                                <td>321312</td>
                                <td>313221</td>
                                <td>31231</td>
                                <td>31231</td>
                                <td>312312</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center; width: 95%">

                        <table class="table table-bordered" id="myTable">

                            <thead>
                            <tr>
                                <th></th>
                                <th>Target</th>
                                <th>Achievement</th>
                                <th>%</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Motor</td>
                                <td>32131</td>
                                <td>32131</td>
                                <td>56</td>

                            </tr>
                            <tr>
                                <td>Non Motor</td>
                                <td>312312</td>
                                <td>32131</td>
                                <td>87</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>321312</td>
                                <td>312312</td>
                                <td>65</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <canvas id="chart-9" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <canvas id="chart-10" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">

                        <table class="table table-bordered" id="myTable">
                            <caption style="text-align: center;font-weight: 600;font-size: x-large;color: #000">GWP</caption>
                            <thead>
                            <tr>
                                <th></th>
                                <th>Motor</th>
                                <th>Non Motor</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Cancelled</td>
                                <td></td>
                                <td></td>

                            </tr>
                            <tr>
                                <td>############</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5 charts" style="display: flex;align-items: center">
                        <canvas id="chart-11" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="group">

                <div class="col-md-12 sample">
                    <h1>Group</h1>
                    <div class="col-md-12" id="memberSelection">
                        <label for="testSelect">Select Employee &nbsp;</label> <select class="form-control" id="testSelect" onchange="triggerDataTables()"></select>
                    </div>
                    <div class="col-md-12" id="individualCharts" style="display: none">
                        <div class="col-md-5 charts" style="display: flex;align-items: center">
                            <canvas id="chart-12" style="border: 0px solid black;height: 100%;width: 100%"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $.ajax({
                        type: "get",
                        url: "getGroupData",

                        success:function(data){
                            console.log(data);

                            var string="<option>Select Value</option><option value="+
                                    data+
                                    ">" +
                                    data
                                    +"</option>";
                            document.getElementById('testSelect').innerHTML=string;
                        },
                        error:function(xhr, ajaxOptions, thrownError){
                            console.log("Error-----"+thrownError);

                        }
                    });
                });

                function triggerDataTables(){
//                    alert(document.getElementById('testSelect').value);
                    document.getElementById('individualCharts').style.display='block';
                }
            </script>
            <style>
                #lead-div{
                    border:0px solid black;
                    padding: 0px;
                }
                #customer-details{
                    border:0px solid black;
                    float: none;
                    margin-left: auto;
                    margin-right:auto;
                }
                #lead-details{
                    border:0px solid black;
                    float: none;
                    margin-left: auto;
                    margin-right:auto;
                }
            </style>
            <div class="tab-pane" id="leads">
                <div class="col-md-12 sample">
                    <h1>Lead Management</h1>
                        <div id="lead-div" class="col-md-12">
                            <div class="col-md-10" id="customer-details">
                                <form action="" method="get" id="form-customer-details">
                                    <label for="email">Email</label><br>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" style="width:50%">
                                </form>
                            </div>
                            <div class="col-md-10" id="lead-details">

                            </div>
                        </div>
                </div>
            </div>
        </div>


    </div>
    <script src="Chart.js-master/dist/Chart.js"></script>
    <script>
            $(document).ready(function () {
            var ctx1 = document.getElementById("chart-1");
            var ctx2 = document.getElementById("chart-2");
            var ctx3 = document.getElementById("chart-3");
            var ctx4 = document.getElementById("chart-4");
            var ctx5 = document.getElementById("chart-5");
//        var ctx6 = document.getElementById("chart-6");
//        var ctx7 = document.getElementById("chart-7");
//        var ctx8 = document.getElementById("chart-8");
            var ctx9 = document.getElementById("chart-9");
            var ctx10 = document.getElementById("chart-10");
            var ctx11 = document.getElementById("chart-11");
            var ctx12 = document.getElementById("chart-12");

            var myChart = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ["New","Renewal","Addition","Total"],
                    datasets: [
                        {
                            label: "Motor",

                            // The properties below allow an array to be specified to change the value of the item at the given index
                            // String  or array - the bar color
                            backgroundColor: "rgba(255,99,132,0.2)",

                            // String or array - bar stroke color
                            borderColor: "rgba(255,99,132,1)",

                            // Number or array - bar border width
                            borderWidth: 1,

                            // String or array - fill color when hovered
                            hoverBackgroundColor: "rgba(255,99,132,0.4)",

                            // String or array - border color when hovered
                            hoverBorderColor: "rgba(255,99,132,1)",

                            // The actual data
                            data: [65, 59, 80, 81, 56, 55, 40],

                            // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.
                            yAxisID: "y-axis-0",
                        },
                        {
                            label: "Non Motor",
                            backgroundColor: "rgba(54,162,235,0.2)",
                            borderColor: "rgba(54,162,235,1)",
                            borderWidth: 1,
                            hoverBackgroundColor: "rgba(54,162,235,0.4)",
                            hoverBorderColor: "rgba(54,162,235,1)",
                            data: [28, 48, 40, 19, 86, 27, 90]
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
            var myChart = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [{
                        label: '# of Votes',
                        data: [30, 19, 3, 5, 2, 3]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
            var myChart = new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [{
                        label: '# of Votes',
                        data: [30, 19, 3, 5, 2, 3]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
            var myChart = new Chart(ctx4, {
                type: 'doughnut',
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [{
                        label: '# of Votes',
                        data: [30, 19, 3, 5, 2, 3]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
            var myChart = new Chart(ctx5, {
                type: 'polarArea',
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [{
                        label: '# of Votes',
                        data: [10, 19, 3, 5, 2, 3]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });

//        var myChart = new Chart(ctx6, {
//            type: 'radar',
//            data: {
//                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
//                datasets: [{
//                    label: '# of Votes',
//                    data: [10, 19, 3, 5, 2, 3]
//                }]
//            },
//            options: {
//                scales: {
//                    yAxes: [{
//                        ticks: {
//                            beginAtZero:true
//                        }
//                    }]
//                }
//            }
//        });
//        var myChart = new Chart(ctx7, {
//            type: 'polarArea',
//            data: {
//                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
//                datasets: [{
//                    label: '# of Votes',
//                    data: [10, 19, 3, 5, 2, 3]
//                }]
//            },
//            options: {
//                scales: {
//                    yAxes: [{
//                        ticks: {
//                            beginAtZero:true
//                        }
//                    }]
//                }
//            }
//        });
//        var myChart = new Chart(ctx8, {
//            type: 'polarArea',
//            data: {
//                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
//                datasets: [{
//                    label: '# of Votes',
//                    data: [10, 19, 3, 5, 2, 3]
//                }]
//            },
//            options: {
//                scales: {
//                    yAxes: [{
//                        ticks: {
//                            beginAtZero:true
//                        }
//                    }]
//                }
//            }
//        });
            var myChart = new Chart(ctx9, {
                type: 'bar',
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [{
                        label: '# of Votes',
                        data: [10, 19, 3, 5, 2, 3]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
            var myChart = new Chart(ctx10, {
                type: 'doughnut',
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [{
                        label: '# of Votes',
                        data: [10, 19, 3, 5, 2, 3]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
            var myChart = new Chart(ctx11, {
                type: 'doughnut',
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [{
                        label: '# of Votes',
                        data: [10, 19, 3, 5, 2, 3]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
            var myChart = new Chart(ctx12, {
                type: 'bar',
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [{
                        label: '# of Votes',
                        data: [30, 19, 3, 5, 2, 3]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        });


    </script>

@endsection