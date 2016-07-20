 @extends('master')



@section('page_title')
Training module
@endsection


@section('content')

    <link rel="stylesheet" href="{{URL::asset('plugins/datepicker/datepicker3.css')}}">
<body onload="loadPro()">

<div class="row">
    <div class="     ">
        <div class="   ">
            <div class="nav-tabs-horizontal"> 
                <div class="panel" style="margin-bottom:0cm">
                    <div   >       <ul class="nav nav-tabs nav-tabs-line  "  data-plugin="nav-tabs" role="tablist">
                        <li role="presentation " class="text-uppercase active  " ><a data-toggle="tab" href="#exampleTabsLineTwo" aria-controls="exampleTabsLineTwo" role="tab" aria-expanded="false"> <b> New Invitation </b></a></li>   

                        <li class="text-uppercase " role="presentation"><a data-toggle="tab" href="#exampleTabsLineOne" aria-controls="exampleTabsLineOne" role="tab" aria-expanded="false"> <b>  Attempts  </b></a></li>
                        </ul>
                    </div>
                </div>  
      <div class="tab-content ">
          <div class="tab-pane  active " id="exampleTabsLineTwo" role="tabpanel">
              <br>
              <br>
                          <!-- <div class="clearfix visible-lg-block"></div> -->

        <div class="col-md-6 col-xs-12">
          <!-- Panel Last threads -->

            <div class="col-md-12">
                <div class="box box-info with-border">

                    <div class="box-body ">
                        <h3 class="panel-title" style="margin:5%; font-weight: 600">Program Name : <span class="label label-round label-info " style="font-size:90%;margin-left:1%"> {{$progrm[0]->program}}</span></h3>
                        <h3 class="panel-title" style="margin:5%;font-weight: 600">Program Code : <span class="label label-round label-info " style="font-size:90%;margin-left:1%"> {{$progrm[0]->id}}</span></h3>
                        <ul class="list-group list-group-dividered list-group-full">
                            <input type="text" value="{{$progrm[0]->id}}" hidden="" id="programID">
                        </ul>
                    </div>
                </div>
            </div>






          <!-- End Panel Last threads -->
        </div>





        <div class="col-md-6 col-xs-12 masonry-item">

            <div class="col-md-12">
                <div class="box box-info with-border">
                    <div class="box-header with-border bg-aqua">
                        <h3 class="panel-title"><i class="panel-title-icon icon wb-chat-group" aria-hidden="true"></i>Filters</h3>
                    </div>
                    <div class="box-body ">
                        <ul class="list-group list-group-dividered list-group-full">
                            <div class="col-md-12 col-xs-12" style="padding-right:3%">
                                <div class="form-group  ">
                                    <label class="control-label" for="zone" > <b>Zone </b></label>
                                    <select class="col-md-12 form-control"  id="zone" name="zone" required onchange="getRegions(this.options[this.selectedIndex].text,this.value)">
                                        <option value="0">None </option>
                                        @foreach($zones as $z)
                                            <option value="{{$z->zonal_code}}"> {{$z->zonal_name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12"  >
                                <div class="form-group  ">
                                    <label class="control-label" for="region" > <b>Region </b></label>
                                    <select class="col-md-12 form-control"  id="region" name="region" required onchange="getBranches(this.options[this.selectedIndex].text,this.value)" >
                                        <option value="0" selected> All </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12" style="padding-right:3%">
                                <div class="form-group ">
                                    <label class="control-label" for="branch" > <b>Branch </b></label>
                                    <select class="col-md-12 form-control"  id="branch" name="branch" required  >
                                        <option value="0" selected>All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                @if($lable == 'O')
                                    <button onclick="return ds()" class="btn btn-info pull-right btn-md" style="margin:5%;">Find</button>
                                @else
                                    <button onclick="return ds()" class="btn btn-info pull-right btn-md" style="margin:5%;">Find</button>
                                @endif
                            </div>
                        </ul>
                    </div>
                </div>
            </div>

          <!-- Panel Last threads -->

          <!-- End Panel Last threads -->
        </div>





 <!-- <div class="clearfix visible-lg-block"></div> -->





    <div class="row">

        <div class="col-md-6">
            <div class="box box-aqua with-border">
                <div class="box-header with-border bg-aqua">
                    <h3 class="panel-title">Advisors</h3>
                </div>
                <div class="box-body ">
                        <table class="table table-hover dataTable" id="dd" data-plugin="dataTable">
                            <thead>
                            <th  class="info" style="border-right:1px solid #fff"></th>
                            <th  class="info" style="border-right:1px solid #fff">Profile Details</th>
                            <th  class="info" style="border-right:1px solid #fff"></th>
                            </thead>
                            <tbody id="setC">
                            </tbody>
                        </table>
                </div>
            </div>
        </div>






        <div class="col-md-6">
            <div class="box box-aqua with-border">
                <div class="box-header with-border bg-aqua">
                    <h3 class="panel-title"> List</h3>
                </div>
                <div class="box-body ">
                        <table class="table table-hover dataTable" id="dd2" data-plugin="dataTable">
                            <thead>
                            <th  class="info" style="border-right:1px solid #fff" ></th>
                            <th  class="info" style="border-right:1px solid #fff" >Profile Details</th>
                            <th  class="info" style="border-right:1px solid #fff" ></th>
                            </thead>
                            <tbody id="setC">
                            </tbody>
                        </table>
                </div>
                <div class="box-footer ">
                    <button class="btn btn-success pull-right" data-target="#addProjectForm" data-toggle="modal" type="button">
                        Invitation
                    </button>
                </div>
            </div>
        </div>




      </div>






   <div class="modal fade" id="addProjectForm" aria-hidden="true" aria-labelledby="addProjectForm"
  role="dialog" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">

      


        <div class="modal-header">
          <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
          <h4 class="modal-title">New Invitation</h4>
        <span class="label label-round label-info " style="font-size:80%;margin-left:1%">YEAR : <?php echo date("Y"); ?></span>
        </div>
        <div class="alert alert-alt alert-success  alert-dismissible" style="margin:1%" hidden="" id="sussessMSG">
                 <a class="alert-link" href="javascript:void(0)" id="sussessContent"></a>
        </div>
         <div class="alert alert-alt alert-danger  alert-dismissible" style="margin:1%" hidden="" id="errorMSG">
                 <a class="alert-link" href="javascript:void(0)" id="errorContent"></a>
        </div>
        <div class="modal-body">
           <form action="#" method="post" role="form">
            <div class="form-group">
              <label class="control-label margin-bottom-15" for="name">Event name:</label>
              <input type="text" class="form-control" id="Ename" name="Ename" placeholder="Event name">
            </div>
            <div class="form-group">
              <label class="control-label margin-bottom-15" for="name">Event description:</label>
              <textarea class="maxlength-textarea form-control mb-sm" placeholder=" Description."
              rows="4" maxlength="225" data-plugin="maxlength" id="Edescription"></textarea>
            </div>

              <div class="form-group">
                <label class="control-label" for="date"><b>Event Date </b></label>
                <input type="text" class="form-control" id="date" readonly="" ="" name="date"    value=""  required >
               </div>

                 <div class="form-group">
                <label class="control-label" for="date"><b>Remind Date </b></label>
                <input type="text" class="form-control" id="date2" readonly="" name="date2"    value=""  required >
               </div>
           </form>
          </div>
          <div class="modal-footer text-left">
          <button class="btn btn-primary"  type="button" onclick="return sss()">Creat</button>
          <a class="btn btn-sm btn-white" data-dismiss="modal" href="javascript:void(0)">Cancel</a>
        </div>
      </div>
    </div>
  </div>
 </div>



    <div class="tab-pane  " id="exampleTabsLineOne" role="tabpanel">
<br>
<br>
    <!-- <div class="clearfix visible-lg-block"></div> -->

        <div class="col-md-6 col-xs-12">
          <!-- Panel Last threads -->

            <div class="col-md-12">
                <div class="box box-info with-border">

                    <div class="box-body ">
                        <h3 class="panel-title" style="margin:5%; font-weight: 600">Program Name : <span class="label label-round label-info " style="font-size:90%;margin-left:1%"> {{$progrm[0]->program}}</span></h3>
                        <h3 class="panel-title" style="margin:5%;font-weight: 600">Program Code : <span class="label label-round label-info " style="font-size:90%;margin-left:1%"> {{$progrm[0]->id}}</span></h3>
                        <ul class="list-group list-group-dividered list-group-full">
                            <input type="text" value="{{$progrm[0]->id}}" hidden="" id="programID">
                        </ul>
                    </div>
                </div>
            </div>




          <!-- End Panel Last threads -->
        </div>

        <div class="col-md-6 col-xs-12">
          <!-- Panel Last threads -->

            <div class="col-md-12">
                <div class="box box-info with-border">

                    <div class="box-header bg-aqua">
                        <h3 class="panel-title"><i class="panel-title-icon icon wb-chat-group" aria-hidden="true"></i>Finishing</h3>
                    </div>
                    <div class="box-body ">
                        <ul class="list-group list-group-dividered list-group-full">

                            <div class="pricing-footer text-center bg-orange-grey-100">

                                @if($lable == 'O')
                                    <button   onclick="finishing()" class="btn btn-warning btn-md">Finish</button>
                                @else
                                    <button  onclick="finishing()" class="btn btn-info btn-md">Finish</button>
                                @endif

                            </div>
                        </ul>
                    </div>
                </div>
            </div>



          <!-- End Panel Last threads -->
        </div>





 <!-- <div class="clearfix visible-lg-block"></div> -->





    <div class="row">
      <div class="col-md-6 col-xs-6" >
          <!-- Panel Last threads -->
          <div class="col-md-12">
              <div class="box box-info with-border">

                  <div class="box-header bg-aqua">
                      <h3 class="panel-title">Program List</h3>
                  </div>
                  <div class="box-body ">
                      <ul class="list-group list-group-dividered list-group-full">

                          @if($lable == 'O')



                              <table class="table table-hover table-condensed dataTable table-striped width-full table" id="dd3" data-plugin="dataTable">
                                  <thead>
                                  <th  class="warning" style="border-right:1px solid #fff"  >Event Date</th>
                                  <th  class="warning" style="border-right:1px solid #fff"  >Event Name</th>
                                  <th  class="warning" style="border-right:1px solid #fff"  ></th>
                                  </thead>
                                  <tbody id="setC">
                                  </tbody>
                              </table>

                          @else


                              <table class="table table-hover table-condensed dataTable table-striped width-full table" id="dd3" data-plugin="dataTable">
                                  <thead>
                                  <th  class="info" style="border-right:1px solid #fff"  >Event Date</th>
                                  <th  class="info" style="border-right:1px solid #fff"  >Event Name</th>
                                  <th  class="info" style="border-right:1px solid #fff"  ></th>
                                  </thead>
                                  <tbody id="setC">
                                  </tbody>
                              </table>


                          @endif
                      </ul>
                  </div>
              </div>
          </div>

          <!-- End Panel Last threads -->
        </div>





        <div class="col-md-6 col-xs-6" >
          <!-- Panel Last threads -->
          <div class="panel"  >
            <div class="panel-heading">
              <h3 class="panel-title">Invited List</h3>
            </div> 
            <div class="panel-body" >
              <ul class="list-group list-group-dividered list-group-full">
                     <table class="table table-hover table-condensed dataTable table-striped width-full table" id="dd4" data-plugin="dataTable">
                                   <thead>
                                        <th  class="info" style="border-right:1px solid #fff"  ></th>
                                        <th  class="info" style="border-right:1px solid #fff"  >Profile Details</th>
                                        <th  class="info" style="border-right:1px solid #fff"  ></th>
                                   </thead>
                                   <tbody id="setC">
                                   </tbody>
                      </table>
              </ul>
            </div>
          </div>
          <!-- End Panel Last threads -->
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<input type="text" id="eventID" hidden="">


</body>
@endsection
 @section('js')
     <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

     <script>
         $(document).ready(function() {



             $("#zone").select();
             $("#branch").select();
             $("#region").select();
             $('#date').datepicker({
                 startDate: new Date()
             });
             $('#date2').datepicker({

                 startDate: new Date()
             });


         });


     </script>


     <script type="text/javascript">



         function ViewClan(code,date,id){


             document.getElementById("eventID").value = id;




             var x =   $('#dd4').DataTable();
             x.destroy();

             var t =  $('#dd4').DataTable( {
                 responsive: true,
                 "ajax": {
                     "type":"get",
                     "url": "LoadProgramClan?proID="+code+"&date="+date+"&id="+id,



                 },
                 "pageLength": 100,
                 "columns": [

                     {"data" : null,
                         "mRender": function(data, type, full) {



                             return '<div class="media-left"><a class="avatar avatar-online" href="javascript:void(0)"><img src="assets/portraits/15.jpg" alt=""></a></div>';
                         }
                     },

                     {"data" : null,
                         "mRender": function(data, type, full) {


                             return '<div class="media-body"><h4 class="media-heading">'+data.user_name+'</h4><small>CODE : <a  title="">'+data.user_code+'</a></small></div>';
                         }
                     },



                     {"data" : null,
                         "mRender": function(data, type, full) {

                             var code  = "'"+data.user_code+"'";


                             //return '<button type="button" onclick="fillTable('+code+')" class="btn btn-outline btn-primary">ADD</button>';

                             return '<div id="c_b"><input type="checkbox" name="checkcode" id="checkcode" value="'+data.user_code+'"></div>';

                         }
                     }

                 ]

             });







         }




         function finishing(){

             var eventID = document.getElementById("eventID").value;

             var allVals = [];
             $('#c_b :checked').each(function() {
                 allVals.push($(this).val());

             });



             swal({
                 title: "Do you want finish this?",
                 text: "",
                 type: "info",
                 showCancelButton: true,
                 closeOnConfirm: false,
                 showLoaderOnConfirm: true
             }, function () {
                 setTimeout(function () {


                     $.ajax({
                         type: "get",
                         url: "FinishEventAttempt",
                         data:{

                             eventID : eventID,
                             allVals  :allVals

                         },
                         success: function (data) {


                             console.log(data);
                             if(data == 1){
                                 swal("Successfull!");
                             }else{

                                 swal("Fail!");
                             }



                         },
                         error: function (xhr, ajaxOptions, thrownError) {

                             console.log(thrownError);

                         }
                     });


                 }, 2000);
             });




         }













         function loadPro(){



             var proID = document.getElementById("programID").value;



             var x =   $('#dd3').DataTable();
             x.destroy();

             var t =  $('#dd3').DataTable( {
                 responsive: true,
                 "ajax": {
                     "type":"get",
                     "url": "LoadTrainPrograms?proID="+proID,



                 },
                 "pageLength": 100,
                 "columns": [

                     {"data" : null,
                         "mRender": function(data, type, full) {


                             return '<div class="media-body"><h4 class="media-heading">'+data.event_date.substring(0, 10)+'</h4></div>';
                         }
                     },

                     {"data" : null,
                         "mRender": function(data, type, full) {


                             return '<div class="media-body"><h4 class="media-heading">'+data.event_name+'</h4></div>';
                         }
                     },



                     {"data" : null,
                         "mRender": function(data, type, full) {

                             var code   = "'"+data.program_id+"'";
                             var date   = "'"+data.event_date+"'";
                             var id     = "'"+data.event_id+"'";



                             return '<button type="button" onclick="ViewClan('+code+','+date+','+id+')" class="btn btn-outline btn-primary">View</button>';

                         }
                     }

                 ]

             });







         }




     </script>

     <script type="text/javascript">

         function sss(){
             $("#errorMSG").hide();
             $("#successMSG").hide();

             var name  = document.getElementById("Ename").value;
             var des   = document.getElementById("Edescription").value;
             var Edate = document.getElementById("date").value;
             var Rdate = document.getElementById("date2").value;
             var proID = document.getElementById("programID").value;

             if(name == ""){

                 document.getElementById("errorContent").innerHTML = "Event name is empty!";
                 $("#errorMSG").removeAttr("hidden");
                 $("#errorMSG").show();

                 return true;

             }
//             if(Edate == ""){ document.getElementById("errorContent").innerHTML = "Event date is empty!!";
//                 $("#errorMSG").removeAttr("hidden");
//                 $("#errorMSG").show();
//                 return false;
//             }
//             if(Rdate == ""){ document.getElementById("errorContent").innerHTML = "Plese set a reminde date!";
//                 $("#errorMSG").removeAttr("hidden");
//                 $("#errorMSG").show();
//                 return false;
//             }


             $.ajax({
                 type: "get",
                 url: "CreateEvent",
                 data:{

                     name : name,
                     des  :des,
                     Edate : Edate,
                     Rdate : Rdate,
                     proID  :proID

                 },
                 success: function (data) {


                     console.log(data);


                     if(data == 1){

                         $("#errorMSG").hide();
                         document.getElementById("sussessContent").innerHTML = "Event Submition Successfull!";
                         $("#sussessMSG").removeAttr("hidden");
                         $("#sussessMSG").show();


                     }else
                     {

                         document.getElementById("errorContent").innerHTML = data;
                         $("#errorMSG").removeAttr("hidden");
                         $("#errorMSG").show();

                     }

                 },
                 error: function (xhr, ajaxOptions, thrownError) {

                     console.log(thrownError);

                 }
             });




         }


     </script>

     <script type="text/javascript">


         function ds(){

             document.getElementById("setC").innerHTML = "";

             var rcode = document.getElementById("region").value;
             var bcode = document.getElementById("branch").value;



             var x =   $('#dd').DataTable();
             x.destroy();

             var t =  $('#dd').DataTable( {
                 responsive: true,
                 "ajax": {
                     "type":"get",
                     "url": "Training_pepole?rcode="+rcode+"&bcode="+bcode,
                 },
                 "pageLength": 100,
                 "columns": [

                     {"data" : null,
                         "mRender": function(data, type, full) {


                             return '<div class="media-left"><a class="avatar avatar-online" href="javascript:void(0)"><img src="assets/portraits/15.jpg" alt=""></a></div>';
                         }
                     },

                     {"data" : null,
                         "mRender": function(data, type, full) {


                             return '<div class="media-body"><h5 class="media-heading" style="font-weight:600">'+data.user_name+'</h5><small>CODE : <a  title="">'+data.user_code+'</a></small></div>';
                         }
                     },



                     {"data" : null,
                         "mRender": function(data, type, full) {

                             var code  = "'"+data.user_code+"'";

                             return '<button type="button" onclick="fillTable('+code+')" class="btn btn-info">ADD</button>';

                         }
                     }

                 ]

             });






             return false;

         }







         function fillTable(code){



             var x =   $('#dd2').DataTable();
             x.destroy();

             var t =  $('#dd2').DataTable( {
                 responsive: true,
                 "ajax": {
                     "type":"get",
                     "url": "addOrRemove?code="+code,



                 },
                 "pageLength": 100,
                 "columns": [

                     {"data" : null,
                         "mRender": function(data, type, full) {


                             return '<div class="media-left"><a class="avatar avatar-online" href="javascript:void(0)"><img src="assets/portraits/15.jpg" alt=""></a></div>';
                         }
                     },

                     {"data" : null,
                         "mRender": function(data, type, full) {


                             return '<div class="media-body"><h5 class="media-heading" style="font-weight:600">'+data.user_name+'</h5><small>CODE : <a  title="">'+data.user_code+'</a></small></div>';
                         }
                     },



                     {"data" : null,
                         "mRender": function(data, type, full) {

                             var code  = "'"+data.user_code+"'";

                             return '<button type="button" onclick="fillTable('+code+')" class="btn btn-danger">REMOVE</button>';

                         }
                     }

                 ]

             });



             ds();


             return false;

         }











         function addPepole(k){





             $.ajax({
                 type: "get",
                 url: "addOrRemove",
                 data:{

                     code : k

                 },
                 success: function (data) {


                     console.log(data);

                 },
                 error: function (xhr, ajaxOptions, thrownError) {

                     console.log(thrownError);

                 }
             });




         }




         function getBranches(name,code){



             $.ajax({
                 type: "get",
                 url: "sales-plan-get_branches",
                 data:{

                     region : code

                 },
                 success: function (data) {



                     var options ="<option value='0' selected> All </option>";
                     for(var i =0; i<data.length;i++){

                         options += "<option value='"+data[i].branch_code+"'>"+data[i].branch_name+"</option>";


                     }

                     document.getElementById("branch").innerHTML = options;
                     $("#branch").select2();


                     console.log("success");

                 },
                 error: function (xhr, ajaxOptions, thrownError) {
                     // document.getElementById("svbtn").removeAttribute("hidden",false);
                     console.log(thrownError);

                 }
             });









         }


         function getRegions(name,code){




             var zone = document.getElementById("zone").value;

             $.ajax({
                 type: "get",
                 url: "sales-plan-get_regions",
                 data:{

                     zone : code

                 },
                 success: function (data) {



                     var options ="<option value='0' selected> All </option>";
                     for(var i =0; i<data.length;i++){

                         options += "<option value='"+data[i].region_code+"'>"+data[i].region_name+"</option>";


                     }
                     document.getElementById("region").innerHTML = options;
                     $("#region").select2();


                     console.log("success");

                 },
                 error: function (xhr, ajaxOptions, thrownError) {
                     // document.getElementById("svbtn").removeAttribute("hidden",false);
                     console.log(thrownError);

                 }
             });









         }



     </script>
     <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
     <script src="plugins/datatables/jquery.dataTables.min.js"></script>
 @endsection