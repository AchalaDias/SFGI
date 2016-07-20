<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use App\Http\Requests;

class TrainingController extends Controller
{
    public function SendDataToPage(Request $request){



        $branch   = $request->session()->get('USERBRANCH');
        $zone     = $request->session()->get('USERZONE');
        $userRole = $request->session()->get('USERROLE');





        //$programs = DB::select("select short_name,id from sf_training_programs where train_category = 'ADVISOR'");


        $allBranches = DB::select("Select * from sf_branches X where X.zonal_code = '$zone'");
        $alldata = DB::select("select * from sfms_agent_details where agt_branch_code  IN (Select X.branch_code from sf_branches X where X.ZONAL_CODE = '$zone') AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and agt_sub_code is null");

//this is only for zonal trainner
        /*$filteredData = DB::select("select * from sfms_agent_details where agt_branch_code  IN (Select X.branch_code from sf_branches X where X.ZONAL_CODE = '$zone') AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and agt_sub_code is null");*/


        // and X.branch_code = 'ANP'
        $AdvisorAllDetails = DB::select("
select distinct B.agt_code,B.agt_branch_code,B.agt_first_name,B.agt_last_name,B.agt_appoint_date,A.LIST_NUMBER
from sfms_agent_details B LEFT outer JOIN sf_training_details A on B.agt_code = A.Code
where B.agt_branch_code  IN (Select X.branch_code
                           from sf_branches X
                            where X.ZONAL_CODE = '$zone' ) 
                                
                                  AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and B.agt_sub_code is null
                                  order by A.LIST_NUMBER ASC ");



        $leaderAllDetails = DB::select("select distinct B.agt_code,B.agt_branch_code,B.agt_first_name,B.agt_last_name,B.agt_appoint_date,A.LIST_NUMBER
from sfms_agent_details B LEFT outer JOIN sf_training_details A on B.agt_code = A.Code
where B.agt_branch_code  IN (Select X.branch_code
                           from sf_branches X
                            where X.ZONAL_CODE = '$zone') 
                                
                                  AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and B.agt_sub_code is not null
                                  order by A.LIST_NUMBER ASC ");


        return view('Trainig.training')->with('branches',$allBranches)->with('all',$AdvisorAllDetails)->with('alllead',$leaderAllDetails);
    }







    public function filter(Request $request){

        $filter_branch = $_REQUEST['key'];


        $branch   = $request->session()->get('USERBRANCH');
        $zone     = $request->session()->get('USERZONE');
        $userRole = $request->session()->get('USERROLE');
        // $programs = DB::select("select short_name,id from sf_training_programs where train_category = 'ADVISOR'");


        $allBranches = DB::select("Select * from sf_branches X where X.zonal_code = '$zone'");
        /* $filteredData = DB::select("select * from sfms_agent_details where agt_branch_code  IN (Select X.branch_code from sf_branches X where X.ZONAL_CODE = 'CEZ' and X.branch_code = '$filter_branch') AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and agt_sub_code is null");*/

        $AdvisorAllDetails = DB::select("
select distinct B.agt_code,B.agt_branch_code,B.agt_first_name,B.agt_last_name,B.agt_appoint_date,A.LIST_NUMBER
from sfms_agent_details B LEFT outer JOIN sf_training_details A on B.agt_code = A.Code
where B.agt_branch_code  IN (Select X.branch_code
                           from sf_branches X
                            where X.ZONAL_CODE = '$zone' and X.branch_code = '$filter_branch') 
                           
                                  AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and B.agt_sub_code is null
                                  order by A.LIST_NUMBER ASC ");



        $leaderAllDetails = DB::select("select distinct B.agt_code,B.agt_branch_code,B.agt_first_name,B.agt_last_name,B.agt_appoint_date,A.LIST_NUMBER
from sfms_agent_details B LEFT outer JOIN sf_training_details A on B.agt_code = A.Code
where B.agt_branch_code  IN (Select X.branch_code
                           from sf_branches X
                            where X.ZONAL_CODE = '$zone') 
                                
                                  AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and B.agt_sub_code is not null
                                  order by A.LIST_NUMBER ASC ");


        return view('Trainig.training')->with('branches',$allBranches)->with('all',$AdvisorAllDetails)->with('alllead',$leaderAllDetails);





    }





    public function  loadModelPrograms(){


        $code = $_REQUEST['code'];

        $programs  = DB::select("select A.completed_date,A.status,B.PROGRAM,A.list_number from  sf_training_details A,sf_training_programs B where A.program_id = B.Id and A.code = '$code'");

        $selectPrograms = DB::select("select  B.PROGRAM,B.id 
    from  sf_training_programs B,sf_training_details A
    where B.id not in (select program_id  from sf_training_details  where code = '$code') and B.Train_Category = 'ADVISOR'
    group by B.PROGRAM,B.id");

        if(empty($programs[0]->list_number)){

            $msg = "1";
        }
        else{
            $msg = "0";
        }

        return response()->json(['data' => $programs,'msg'=>$msg,'Sprograms'=>$selectPrograms]);


    }



    public function updateTrainingDataAgent(Request $request){




        $zone     = $request->session()->get('USERZONE');
        $region   = $request->session()->get('USERREGION');


        $program  = $_REQUEST['program'];
        $date     = $_REQUEST['date'];
        $status   = $_REQUEST['status'];
        $number   = $_REQUEST['number'];
        $code     = $_REQUEST['code'];
        $branch   = $_REQUEST['branch'];

        $listmsg ="0";



        $checkNumber = DB::select("select distinct list_number from sf_training_details where list_number = '$number' and branch='$branch'  and  role_type = 'ADVISOR'");

        if(empty($checkNumber[0]->list_number)){

            if($number != "NO"){

                DB::statement(DB::raw(
                    "INSERT INTO  sf_training_details  values ('$code','$date','$program','$status','$number','$branch','ADVISOR')"));
            }
            else{

                $data = DB::select("select list_number from sf_training_details where code = '$code'");
                $num = $data[0]->list_number;

                DB::statement(DB::raw(
                    "INSERT INTO  sf_training_details  values ('$code','$date','$program','$status','$num','$branch','ADVISOR')"));

            }

            $listmsg = "1";
        }



        $programs  = DB::select("select A.completed_date,A.status,B.PROGRAM,A.list_number from  sf_training_details A,sf_training_programs B where A.program_id = B.Id and A.code = '$code'");


        $selectPrograms = DB::select("select  B.PROGRAM,B.id 
       from  sf_training_programs B,sf_training_details A
       where B.id not in (select program_id  from sf_training_details  where code = '$code') and B.Train_Category = 'ADVISOR'
       group by B.PROGRAM,B.id");

        if(empty($programs[0]->list_number)){

            $msg = "1";
        }
        else{
            $msg = "0";
        }





        return response()->json(['data' => $programs,'msg'=>$msg,'Sprograms'=>$selectPrograms,'listmsg'=>$listmsg]);


    }


    function trainingSearchAdvisors(Request $request){

        $zone   = $request->session()->get('USERZONE');
        $month  = $_REQUEST['month'];
        $year   = $_REQUEST['year'];


        $allBranches = DB::select("Select * from sf_branches X where X.zonal_code = '$zone'");

        $AdvisorAllDetails = DB::select("select distinct B.agt_code,B.agt_branch_code,B.agt_first_name,B.agt_last_name,B.agt_appoint_date,A.LIST_NUMBER
          from sfms_agent_details B LEFT outer JOIN sf_training_details A on B.agt_code = A.Code
          where B.agt_branch_code  IN (Select X.branch_code
                           from sf_branches X
                            where X.ZONAL_CODE = '$zone') 
                            AND                             
                                 EXTRACT(MONTH FROM TO_DATE(A.COMPLETED_DATE, 'mm/dd/yyyy')) = '$month'
                                 and  EXTRACT(YEAR FROM TO_DATE( A.COMPLETED_DATE, 'mm/dd/yyyy')) = '$year'
                                 and A.Role_Type = 'ADVISOR'
                            AND 
                                  AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and B.agt_sub_code is null
                                  order by A.LIST_NUMBER ASC ");

        $leaderAllDetails = DB::select("select distinct B.agt_code,B.agt_branch_code,B.agt_first_name,B.agt_last_name,B.agt_appoint_date,A.LIST_NUMBER
from sfms_agent_details B LEFT outer JOIN sf_training_details A on B.agt_code = A.Code
where B.agt_branch_code  IN (Select X.branch_code
                           from sf_branches X
                            where X.ZONAL_CODE = '$zone') 
                                
                                  AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and B.agt_sub_code is not null
                                  order by A.LIST_NUMBER ASC ");


        return view('Trainig.training')->with('branches',$allBranches)->with('all',$AdvisorAllDetails)->with('alllead',$leaderAllDetails);

    }


//leaders functions


    function loadModelProgramsLeader(Request $request){


        $code = $_REQUEST['code'];

        $programs  = DB::select("select A.completed_date,A.status,B.PROGRAM,A.list_number from  sf_training_details A,sf_training_programs B where A.program_id = B.Id and A.code = '$code'");

        $selectPrograms = DB::select("select  B.PROGRAM,B.id 
    from  sf_training_programs B,sf_training_details A
    where B.id not in (select program_id  from sf_training_details  where code = '$code') and B.Train_Category = 'LEADER'
    group by B.PROGRAM,B.id");

        if(empty($programs[0]->list_number)){

            $msg = "1";
        }
        else{
            $msg = "0";
        }

        return response()->json(['data' => $programs,'msg'=>$msg,'Sprograms'=>$selectPrograms]);


    }





    public function updateTrainingDataLeader(Request $request){




        $zone     = $request->session()->get('USERZONE');
        $region   = $request->session()->get('USERREGION');


        $program  = $_REQUEST['program'];
        $date     = $_REQUEST['date'];
        $status   = $_REQUEST['status'];
        $number   = $_REQUEST['number'];
        $code     = $_REQUEST['code'];
        $branch   = $_REQUEST['branch'];

        $listmsg ="0";



        $checkNumber = DB::select("select distinct list_number from sf_training_details where list_number = '$number' and branch='$branch' and  role_type = 'LEADER'");


        if(empty($checkNumber[0]->list_number)){

            if($number != "NO"){

                DB::statement(DB::raw(
                    "INSERT INTO  sf_training_details  values ('$code','$date','$program','$status','$number','$branch','LEADER')"));
            }
            else{

                $data = DB::select("select list_number from sf_training_details where code = '$code'");
                $num = $data[0]->list_number;

                DB::statement(DB::raw(
                    "INSERT INTO  sf_training_details  values ('$code','$date','$program','$status','$num','$branch','LEADER')"));

            }

            $listmsg = "1";
        }



        $programs  = DB::select("select A.completed_date,A.status,B.PROGRAM,A.list_number from  sf_training_details A,sf_training_programs B where A.program_id = B.Id and A.code = '$code'");


        $selectPrograms = DB::select("select  B.PROGRAM,B.id 
       from  sf_training_programs B,sf_training_details A
       where B.id not in (select program_id  from sf_training_details  where code = '$code') and B.Train_Category = 'LEADER'
       group by B.PROGRAM,B.id");

        if(empty($programs[0]->list_number)){

            $msg = "1";
        }
        else{
            $msg = "0";
        }

        return response()->json(['data' => $programs,'msg'=>$msg,'Sprograms'=>$selectPrograms,'listmsg'=>$listmsg]);


    }

    function trainingSearchLeader(Request $request){

        $zone   = $request->session()->get('USERZONE');
        $month  = $_REQUEST['month'];
        $year   = $_REQUEST['year'];




        $allBranches = DB::select("Select * from sf_branches X where X.zonal_code = '$zone'");

        $AdvisorAllDetails = DB::select("select distinct B.agt_code,B.agt_branch_code,B.agt_first_name,B.agt_last_name,B.agt_appoint_date,A.LIST_NUMBER
from sfms_agent_details B LEFT outer JOIN sf_training_details A on B.agt_code = A.Code
where B.agt_branch_code  IN (Select X.branch_code
                           from sf_branches X
                            where X.ZONAL_CODE = '$zone' ) 
                                
                                  AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and B.agt_sub_code is null
                                  order by A.LIST_NUMBER ASC ");


        $leaderAllDetails = DB::select("select distinct B.agt_code,B.agt_branch_code,B.agt_first_name,B.agt_last_name,B.agt_appoint_date,A.LIST_NUMBER
          from sfms_agent_details B LEFT outer JOIN sf_training_details A on B.agt_code = A.Code
          where B.agt_branch_code  IN (Select X.branch_code
                           from sf_branches X
                            where X.ZONAL_CODE = '$zone') 
                            AND                             
                                 EXTRACT(MONTH FROM TO_DATE(A.COMPLETED_DATE, 'mm/dd/yyyy')) = '$month'
                                 and  EXTRACT(YEAR FROM TO_DATE( A.COMPLETED_DATE, 'mm/dd/yyyy')) = '$year'
                                 and A.Role_Type = 'LEADER'
                            AND 
                                  AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and B.agt_sub_code is not null
                                  order by A.LIST_NUMBER ASC  ");


        return view('Trainig.train_lead')->with('branches',$allBranches)->with('all',$AdvisorAllDetails)->with('alllead',$leaderAllDetails);


    }

    function trainingFilterLeader(Request $request){


        $filter_branch = $_REQUEST['key'];


        $branch   = $request->session()->get('USERBRANCH');
        $zone     = $request->session()->get('USERZONE');
        $userRole = $request->session()->get('USERROLE');
        // $programs = DB::select("select short_name,id from sf_training_programs where train_category = 'ADVISOR'");


        $allBranches = DB::select("Select * from sf_branches X where X.zonal_code = '$zone'");
        /* $filteredData = DB::select("select * from sfms_agent_details where agt_branch_code  IN (Select X.branch_code from sf_branches X where X.ZONAL_CODE = 'CEZ' and X.branch_code = '$filter_branch') AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and agt_sub_code is null");*/

        $AdvisorAllDetails = DB::select("select distinct B.agt_code,B.agt_branch_code,B.agt_first_name,B.agt_last_name,B.agt_appoint_date,A.LIST_NUMBER
from sfms_agent_details B LEFT outer JOIN sf_training_details A on B.agt_code = A.Code
where B.agt_branch_code  IN (Select X.branch_code
                           from sf_branches X
                            where X.ZONAL_CODE = '$zone' ) 
                                
                                  AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and B.agt_sub_code is null
                                  order by A.LIST_NUMBER ASC ");



        $leaderAllDetails = DB::select("select distinct B.agt_code,B.agt_branch_code,B.agt_first_name,B.agt_last_name,B.agt_appoint_date,A.LIST_NUMBER
from sfms_agent_details B LEFT outer JOIN sf_training_details A on B.agt_code = A.Code
where B.agt_branch_code  IN (Select X.branch_code
                           from sf_branches X
                            where X.ZONAL_CODE = '$zone' and X.branch_code = '$filter_branch') 
                           
                                  AND AGT_TERMI_DATE IS NULL AND AGT_TERMINATE_IND = 'NO' and B.agt_sub_code is not null
                                  order by A.LIST_NUMBER ASC  ");


        return view('Trainig.train_lead')->with('branches',$allBranches)->with('all',$AdvisorAllDetails)->with('alllead',$leaderAllDetails);




    }


    public function trainingCategory(Request $request){




        $advisor = DB::select("select * from ge_sf_training_programs where train_category = 'ADVISOR'");
        $leaders = DB::select("select * from ge_sf_training_programs where train_category = 'LEADER'");

        return view('Trainig.inviteSys.TrainingPath')
            ->with('advisors',$advisor)
            ->with('leaders',$leaders);


    }
    public function viewProgramInvitaion(Request $request)
    {

        $pepole = array();
        $_SESSION['training_pepole']  = $pepole;

        $code     = $request->input('id');
        $program = DB::select("select * from ge_sf_training_programs where id='$code' ");
        $lable = 'O';


        if(($program[0]->train_category)== 'ADVISOR'){

            $lable = 'B';
        }


        $zones    = DB::select("select * from sf_zonal");



        return view('Trainig.inviteSys.TrainingSelection')
            ->with('progrm',$program)
            ->with('lable',$lable)
            ->with('zones',$zones);


    }

    public function TrainingPepole(Request $request)
    {

        $code     = $request->input('id');

        $rcode     = $request->input('rcode');
        $bcode     = $request->input('bcode');



        $pepole = array();
        $pepole =  $_SESSION['training_pepole'];
        $data =  "'L000'";



        foreach ($pepole as  $value) {

            $k = ",'".$value."'";
            $data = $data.$k ;


        }

        if( $rcode == '0' &&  $bcode == '0'){

            $results = DB::select("select * from ge_sf_user_details where user_code not in ($data)");

        }
        if($rcode != '0' &&  $bcode == '0'){

            $results = DB::select("select * from ge_sf_user_details where region = '$rcode' and user_code not in ($data) ");
        }
        if($rcode != '0' &&  $bcode != '0'){

            $results = DB::select("select * from ge_sf_user_details where branch = '$bcode' and user_code not in ($data)");
        }



        return response()->json(['total' => count( $results), 'data' =>   $results]);
    }


    public function addOrRemovePepole(Request $request){

        $code     = $request->input('code');

        $pepole = array();
        $pepole =  $_SESSION['training_pepole'];



        if(($key = array_search($code, $pepole))!== false) {

            unset($pepole[$key]);
            $_SESSION['training_pepole']  = $pepole;


        }else{

            array_push($pepole, $code);
            $_SESSION['training_pepole']  = $pepole;



        }


        $data =  "'L000'";

        foreach ($pepole as  $value) {

            $k = ",'".$value."'";
            $data = $data.$k ;


        }


        $results = DB::select("select * from ge_sf_user_details where user_code in ($data)");


        return response()->json(['total' => count( $results), 'data' =>   $results]);


    }

    public function checkboxChecker(Request $request){

        $code = $request->input('code');

        $pepole = array();
        $pepole =  $_SESSION['training_pepole'];

        if(($key = array_search($code, $pepole))!== false) {

            echo 1;

        }else{


            echo 0;


        }



    }


    public function CreateEvent(Request $request){

        $name  = $request->input('name');
        $des   = $request->input('des');
        $Edate = $request->input('Edate');
        $Rdate = $request->input('Rdate');
        $proID = $request->input('proID');
        $progType ='LEADER';

        $milliseconds = round(microtime(true) * 1000);
        $eventID = rand()+$milliseconds;


        if((substr($proID,0,1))=='A'){

            $progType ='ADVISOR';
        }



        $pepole = array();
        $pepole =  $_SESSION['training_pepole'];
        $count  = sizeof($pepole);


        if(empty($pepole)){

            echo "You dont have any participants ";
        }
        else{

            DB::statement(DB::raw(
                "INSERT INTO  sf_events  values ('$eventID','$name','$des',TO_DATE('$Edate','MM/DD/RRRR'),TO_DATE('$Rdate','MM/DD/RRRR'),'GENERAL','$count','0','$progType','$proID','PENDING') "));


            foreach($pepole as $r){

                DB::statement(DB::raw(
                    "INSERT INTO  sf_events_deatils  values ('$eventID','$name','$r','NO','$proID') "));


            }


            echo 1;
        }

    }


    public function LoadTrainPrograms(Request $request){

        $proID = $request->input('proID');


        $results  = DB::select("select A.*, to_char(A.event_date,'RRRR/mm/dd') as event_date from sf_events A where program_id = '$proID' and event_party = 'GENERAL' and final_state = 'PENDING'");


        return response()->json(['total' => count( $results), 'data' =>   $results]);


    }


    public function LoadProgramClan(Request $request){

        $proID = $request->input('proID');//for future updates
        $date  = $request->input('date');//for future updates
        $id    = $request->input('id');

        $results  = DB::select("select * from ge_sf_user_details where user_code in (select s.participant_code from sf_events_deatils s
where  s.event_id = '$id' )
 ");


        return response()->json(['total' => count( $results), 'data' =>   $results]);

    }

    public function FinishEventAttempt(Request $request){

        $allVals = array();

        $eventID  = $request->input('eventID');
        $allVals  = $request->input('allVals');

        foreach ($allVals as $v) {

            $user = DB::select("select branch from ge_sf_user_details where user_code = '$v'");

            $branch =  $user[0]->branch;

            $event = DB::select("select a.*, to_char(event_date,'mm/dd/rrrr') as event_date from sf_events a where event_id  = '$eventID'");
            $pro_id = $event[0]->program_id;

            $prog = DB::select("select * from sf_training_details where program_id = '$pro_id' and code = '$v'");

            if(sizeof($prog)==0){

                $listNumber="0";
                $u = DB::select("select * from sf_training_details where code = '$v'");

                if(sizeof($u)>0){ $listNumber= $u[0]->list_number; }



                $Cdate = $event[0]->event_date;
                $protype = $event[0]->program_type;

                DB::statement(DB::raw(
                    "INSERT INTO  sf_training_details  values ('$v','$Cdate','$pro_id','YES','$listNumber','$branch','$protype') "));

                $size =sizeof($allVals);
                DB::statement("UPDATE sf_events set participated_count = '$size'  where event_id = '$eventID'");
                DB::statement("UPDATE sf_events set final_state = 'FINISHED'  where event_id = '$eventID'");

                DB::statement("UPDATE sf_events_deatils set participated_status = 'YES'  where event_id = '$eventID' and participant_code = '$v'");



            }

        }


        echo 1;


    }
}
