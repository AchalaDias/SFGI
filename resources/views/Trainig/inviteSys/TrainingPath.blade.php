 @extends('master')



@section('page_title')
Training module
@endsection


@section('content')


 
<div class="row">



    <div class="     ">


        <div class="   ">


            <div class="nav-tabs-horizontal"> 


                <div class="panel" style="margin-bottom:0cm">

                    <div   >       <ul class="nav nav-tabs"  data-plugin="nav-tabs" role="tablist">


                        <li role="presentation " class="text-uppercase active  " ><a data-toggle="tab" href="#exampleTabsLineTwo" aria-controls="exampleTabsLineTwo" role="tab" aria-expanded="true"> <b>  Advisor Path </b></a></li>

                        <li class="text-uppercase " role="presentation"><a data-toggle="tab" href="#exampleTabsLineOne" aria-controls="exampleTabsLineOne" role="tab" aria-expanded="false"> <b>  Leader Path </b></a></li>

                   
                        <!--  <li role="presentation" class="text-uppercase" hidden="true"> <a data-toggle="tab" href="#suggestions" aria-controls="suggestions" role="tab" aria-expanded="false"> <b> Lead Bank</b></a></li>  -->


                        </ul>
                    </div>


                </div>  








                <div class="tab-content ">
                    <div class="tab-pane   " id="exampleTabsLineOne" role="tabpanel">
                        <div class="panel" >
                            <div class="panel-body" >



                    <!-- Example Pricing List2 -->
          <div class="example-wrap" >
            <h4 class="example-title" >Programs-List</h4>
            <div class="example">
              <div class="row">


                                 <?php 
        for($i=0;$i<sizeof($leaders);$i++){
        ?>
                                     <div class="col-md-4">
                                         <div class="box box-warning with-border">
                                             <div class="box-header with-border bg-yellow">
                                                 <div class="">{{$leaders[$i]->program}}</div>
                                             </div>
                                             <div class="box-body ">
                                                 <span class="">{{$leaders[$i]->short_name}}</span>
                                                 <p class="">Program Code : {{$leaders[$i]->id}}</p>
                                                 <div class="box-tools pull-right">
                                                     <a href="viewProgramInvitaion?id={{$leaders[$i]->id}}" class="btn btn-warning btn-md"> Invite</a>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

          <!-- End Example Pricing List2 -->
   <?php 
       }

        ?>



              </div>
            </div>
          </div>

                            </div>
                        </div>


                    </div>




                    <div class="tab-pane active " id="exampleTabsLineTwo" role="tabpanel">
                    
                        <div class="panel">
                            <div class="panel-body" style="">


   <div class="example-wrap">
            <h4 class="example-title">Programs-List</h4>
            <div class="example">
              <div class="row">





        <?php 
        for($i=0;$i<sizeof($advisors);$i++){
        ?>
            <div class="col-md-4">
                <div class="box box-default with-border">
                    <div class="box-header with-border bg-aqua">
                        <div class="">{{$advisors[$i]->program}}</div>
                    </div>
                    <div class="box-body ">
                        <span class="">{{$advisors[$i]->short_name}}</span>
                        <p class="">Program Code : {{$advisors[$i]->id}}</p>
                        <div class="box-tools pull-right">
                            <a href="viewProgramInvitaion?id={{$advisors[$i]->id}}" class="btn btn-info btn-md"> Invite</a>
                        </div>
                    </div>
                </div>
            </div>





      
          <!-- End Example Pricing List2 -->


   <?php 
       }

        ?>
              </div>
        </div>
        </div>
        </div>





          </div>


                            </div>
                        </div>

                    </div>



                    <div class="tab-pane" id="suggestions" role="tabpanel">





                

                        <br>
                        <br>
                        <br>     






                    </div>

                </div>
            </div>




        </div>
    </div>




</div>
 @endsection