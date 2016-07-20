<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Input;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndividualChartContoller extends Controller
{
    public function chart1_0_1data_group(Request $request){

        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];
        


        if($key!="group"){
            // echo "!all";
            $chart_result = DB::select(DB::raw("
                SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
                'FIRE','FIRE',
                'MARINE','MARINE',
                'ENGG','ENGG',
                'MISC','MISC',
                'MED','MED',
                'WCI','WCI',
                '','MISC') DEPT_NEW,T.* FROM  T_REPORT_DNCN_GWP_FMT T) W          
                where agent_code='$key'
                group by W.DEPT_NEW
                order by round(sum(W.gwp),2) desc
                "));

        }else if($key=='group'){
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
        // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            $string=$string.",'".$_SESSION['USER_CODE']."'";
            // echo $string;
            $chart_result = DB::select(DB::raw("
                SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
                'FIRE','FIRE',
                'MARINE','MARINE',
                'ENGG','ENGG',
                'MISC','MISC',
                'MED','MED',
                'WCI','WCI',
                '','MISC') DEPT_NEW,T.* FROM  T_REPORT_DNCN_GWP_FMT T) W          
                where agent_code IN (".$string.")
                group by W.DEPT_NEW
                order by round(sum(W.gwp),2) desc
                "));
            // $arr=join(',',$data);
            
            
        }
        
        //return response()->json(['data'=>$chart_result]);
        return json_encode($chart_result);
    }

    public function chart1data_group(Request $request){
        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];
        
        if($key!="group"){
            // echo "!all";
            $chart_result = DB::select(DB::raw("
                select fmt.pol_status,
                sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                    END) motor_car_gwp,
                    
                    sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                    END) motor_nonCar_GWP
                
                from t_report_dncn_gwp_fmt fmt
                where fmt.dept='MOTOR' and agent_code='$key' 
                group by  fmt.pol_status
                "));

        }else if($key=='group'){
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
            // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            $string=$string.",'".$_SESSION['USER_CODE']."'";
            // echo $string;
            $chart_result = DB::select(DB::raw("
                select fmt.pol_status,
                sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                    END) motor_car_gwp,
                    
                    sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                    END) motor_nonCar_GWP
                
                from t_report_dncn_gwp_fmt fmt
                where fmt.dept='MOTOR' and agent_code IN (".$string.") 
                group by  fmt.pol_status
                "));
            // $arr=join(',',$data);
            
            
        }
        //return response()->json(['data'=>$chart_result]);
        return json_encode($chart_result);
    }    //

    public function chart2data_group(Request $request){
        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];



        if($key!="group"){
            // echo "!all";
            $chart_result = DB::select(DB::raw("
                select DECODE(FMT.DEPT,'MOTOR',decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
                ,round(sum(fmt.gwp),2) GWP,count(fmt.dncn_no) nop from t_report_dncn_gwp_fmt fmt
                where agent_code='$key'
                group by  DECODE(FMT.DEPT,'MOTOR',
                decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
                ,decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
                "));

        }else if($key=='group'){
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
            // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            $string=$string.",'".$_SESSION['USER_CODE']."'";
            // echo $string;
            $chart_result = DB::select(DB::raw("
                select DECODE(FMT.DEPT,'MOTOR',decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
                ,round(sum(fmt.gwp),2) GWP,count(fmt.dncn_no) nop from t_report_dncn_gwp_fmt fmt
                where agent_code IN (".$string.") 
                group by  DECODE(FMT.DEPT,'MOTOR',
                decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
                ,decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
                "));
            // $arr=join(',',$data);
            
            
        }
        //return response()->json(['data'=>$chart_result]);
        return json_encode($chart_result);
    }    //
    //
    public function chart3data_group(Request $request){
        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];

        // echo sizeof($array);
        //getting achievement of the month
        if($key!="group"){
            $chart_result_1 = DB::select(DB::raw("
                select * from GE_SF_INV_MONTHLY_TARGETS where agent_code='$key'
            "));

            $motor_target=0;
            $nonmotor_target=0;
            $array=($chart_result_1);
            if(sizeof($array)>0){
                $motor_target=$array[0]->motor;
                $nonmotor_target=$array[0]->nonmotor;
            }else{
                $motor_target='0';
                $nonmotor_target='0';
            }
            // echo "!all";
            $chart_result_2 = DB::select(DB::raw("
                select decode(t.class_code,'MTR','MOTOR','NONMOTOR') as TYPE,
                (SELECT SUM(FMT.GWP) FROM T_REPORT_DNCN_GWP_FMT FMT WHERE agent_code='$key' and DECODE(FMT.DEPT,'MOTOR','MOTOR','NONMOTOR')=decode(t.class_code,'MTR','MOTOR','NONMOTOR')) ACHIEVEMENT_AMT
                from wf_gen_branch_class_target t
                where t.achive_year=extract(year from sysdate)
                and t.achive_month=extract(month from sysdate)
                GROUP BY decode(t.class_code,'MTR','MOTOR','NONMOTOR')
                "));

        }else if($key=='group'){
            $leader=$_SESSION['USER_CODE'];
            $chart_result_1 = DB::select(DB::raw("
                select * from GE_SF_INV_MONTHLY_TARGETS where agent_code='$leader'
            "));

            $motor_target=0;
            $nonmotor_target=0;
            $array=($chart_result_1);
            if(sizeof($array)>0){
                $motor_target=$array[0]->motor;
                $nonmotor_target=$array[0]->nonmotor;
            }else{
                $motor_target='0';
                $nonmotor_target='0';
            }
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
            // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            $string=$string.",'".$_SESSION['USER_CODE']."'";
            // echo $string;
            $chart_result_2 = DB::select(DB::raw("
                select decode(t.class_code,'MTR','MOTOR','NONMOTOR') as TYPE,
                (SELECT SUM(FMT.GWP) FROM T_REPORT_DNCN_GWP_FMT FMT WHERE agent_code IN (".$string.") and DECODE(FMT.DEPT,'MOTOR','MOTOR','NONMOTOR')=decode(t.class_code,'MTR','MOTOR','NONMOTOR')) ACHIEVEMENT_AMT
                from wf_gen_branch_class_target t
                where t.achive_year=extract(year from sysdate)
                and t.achive_month=extract(month from sysdate)
                GROUP BY decode(t.class_code,'MTR','MOTOR','NONMOTOR')
                "));
            // $arr=join(',',$data);
            
            
        }

        $motor_achievement=0;
        $nonmotor_achievement=0;

        $array=($chart_result_2);
        if(sizeof($array)>0){
            $motor_achievement=$array[1]->achievement_amt;
            $nonmotor_achievement=$array[0]->achievement_amt;
        }else{
            $motor_achievement='0';
            $nonmotor_achievement='0';
        }
        



        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);



        //return response()->json(['data'=>$chart_result]);
        return json_encode($data);
    }

    public function chart4data_group(Request $request){
        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];

        if($key!="group"){
            // echo "!all";
            $chart_result = DB::select(DB::raw("
                select B.pol_status,sum(motor_car_gwp) as motor_car_gwp,sum(motor_nonCar_GWP) as motor_nonCar_GWP from
                (
                  select fmt.pol_status,
                sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                    END) motor_car_gwp,
                    
                    sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                    END) motor_nonCar_GWP
                
                from t_report_dncn_gwp_fmt fmt
                where fmt.dept='MOTOR' and agent_code='$key'
                group by  fmt.pol_status

                union

                select fmt.policy_status as pol_status,
                sum(CASE WHEN (fmt.mtr_non_motor='Motor' or fmt.mtr_non_motor='motor') THEN fmt.gwp
                    END) motor_car_gwp,
                    
                    sum(CASE WHEN (fmt.mtr_non_motor!='Motor' or fmt.mtr_non_motor!='motor') THEN fmt.gwp
                    END) motor_nonCar_GWP
                
                from Gi_Final_Gwp_Tcs fmt                                            
                where fmt.dept='MTR' and code='$key' and year=extract(year from sysdate) and month<=extract(month from sysdate)                                                                              
                group by  fmt.policy_status                                        
                ) B group by B.pol_status
                "));

        }else if($key=='group'){
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
            // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            $string=$string.",'".$_SESSION['USER_CODE']."'";
            // echo $string;
            $chart_result = DB::select(DB::raw("
                select B.pol_status,sum(motor_car_gwp) as motor_car_gwp,sum(motor_nonCar_GWP) as motor_nonCar_GWP from
                (
                  select fmt.pol_status,
                sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                    END) motor_car_gwp,
                    
                    sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                    END) motor_nonCar_GWP
                
                from t_report_dncn_gwp_fmt fmt
                where fmt.dept='MOTOR' and agent_code='$key'
                group by  fmt.pol_status
                union
                select fmt.policy_status as pol_status,
                sum(CASE WHEN (fmt.mtr_non_motor='Motor' or fmt.mtr_non_motor='motor') THEN fmt.gwp
                    END) motor_car_gwp,
                    
                    sum(CASE WHEN (fmt.mtr_non_motor!='Motor' or fmt.mtr_non_motor!='motor') THEN fmt.gwp
                    END) motor_nonCar_GWP
                
                from Gi_Final_Gwp_Tcs fmt                                            
                where fmt.dept='MTR' and code IN (".$string.") and 
                year=extract(year from sysdate) and month<extract(month from sysdate)                                                                              
                group by  fmt.policy_status                                        
                ) B group by B.pol_status
                "));
            // $arr=join(',',$data);
            
            
        }

        //return response()->json(['data'=>$chart_result]);
        return json_encode($chart_result);
    }

    public function month_non_motor_group(Request $request){
        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];


        if($key!="group"){
            // echo "!all";
            $chart_result = DB::select(DB::raw("
                select fmt.pol_status,
                sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
                sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
                sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
                sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
                sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
                sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
                
                from t_report_dncn_gwp_fmt fmt
                where fmt.dept !='MOTOR' and agent_code='$key'
                and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
                GROUP BY fmt.pol_status
                "));

        }else if($key=='group'){
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
            // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            $string=$string.",'".$_SESSION['USER_CODE']."'";
            // echo $string;
            $chart_result = DB::select(DB::raw("
                select fmt.pol_status,
                sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
                sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
                sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
                sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
                sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
                sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
                
                from t_report_dncn_gwp_fmt fmt
                where fmt.dept !='MOTOR' and agent_code IN (".$string.")
                and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
                GROUP BY fmt.pol_status
                "));
            // $arr=join(',',$data);
            
            
        }

        //return response()->json(['data'=>$chart_result]);
        return json_encode($chart_result);
    }

    public function cumulative_non_motor_group(Request $request){
        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];
        
        if($key!="group"){
            // echo "!all";
            $chart_result = DB::select(DB::raw("
                select fmt.pol_status,
                sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
                sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
                sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
                sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
                sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
                sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
                
                from GI_DRAFT_FMT_GWP_MONTHEND fmt
                where fmt.dept !='MOTOR' and agent_code='$key'
                and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
                GROUP BY fmt.pol_status
                "));

        }else if($key=='group'){
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
            // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            $string=$string.",'".$_SESSION['USER_CODE']."'";
            // echo $string;
            // IN (".$string.")
            $chart_result = DB::select(DB::raw("
                select fmt.pol_status,
                sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
                sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
                sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
                sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
                sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
                sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
                
                from GI_DRAFT_FMT_GWP_MONTHEND fmt
                where fmt.dept !='MOTOR' and agent_code IN (".$string.")
                and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
                GROUP BY fmt.pol_status
                "));
            // $arr=join(',',$data);
            
            
        }
        //return response()->json(['data'=>$chart_result]);
        return json_encode($chart_result);
    }

    public function cumulative_target_achievement_group(Request $request){
        $agent_code=$_SESSION['USER_CODE'];
        $key='MB1017';//$request['key'];
        //cumulative achievement from tcs
        if($key!="group"){
            $chart_result_2 = DB::select(DB::raw("
                select * from GE_SF_INV_MONTHLY_TARGETS where agent_code='$key'
            "));

            $array=($chart_result_2);
            $motor_target=($array[0]->motor*12);
            $nonmotor_target=($array[0]->nonmotor*12);
            if(sizeof($array)>0){
                $motor_target=$array[0]->motor;
                $nonmotor_target=$array[0]->nonmotor;
            }else{
                $motor_target='0';
                $nonmotor_target='0';
            }
            // echo "!all";
            $chart_result_1 = DB::select(DB::raw("
                select  B.MTR_NON_MOTOR,SUM(B.TOTAL)  as total
                  from
                (
                (select mtr_non_motor,sum(t.gwp) as total from gi_final_gwp_tcs t where t.month <=extract(month from sysdate) and t.year=extract(year from sysdate) and t.code='$key' group by mtr_non_motor) 
                union
                 (select mtr_non_motor, sum(t1.gwp) as total from gi_final_gwp_takaful t1 where t1.month <=extract(month from sysdate) and t1.year=extract(year from sysdate) and t1.code='$key'  group by mtr_non_motor)
                 ) B
                 group by B.MTR_NON_MOTOR
                "));

        }else if($key=='group'){
            $leader=$_SESSION['USER_CODE'];
            $chart_result_2 = DB::select(DB::raw("
                select * from GE_SF_INV_MONTHLY_TARGETS where agent_code='$leader'
            "));

            $array=($chart_result_2);
            $motor_target=($array[0]->motor*12);
            $nonmotor_target=($array[0]->nonmotor*12);
            if(sizeof($array)>0){
                $motor_target=$array[0]->motor;
                $nonmotor_target=$array[0]->nonmotor;
            }else{
                $motor_target='0';
                $nonmotor_target='0';
            }
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
            // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            $string=$string.",'".$_SESSION['USER_CODE']."'";
            // echo $string;
            // IN (".$string.")
            $chart_result_1 = DB::select(DB::raw("
                select  B.MTR_NON_MOTOR,SUM(B.TOTAL)  as total
                  from
                (
                (select mtr_non_motor,sum(t.gwp) as total from gi_final_gwp_tcs t where t.month <=extract(month from sysdate) and t.year=extract(year from sysdate) and t.code IN (".$string.") group by mtr_non_motor) 
                union
                 (select mtr_non_motor, sum(t1.gwp) as total from gi_final_gwp_takaful t1 where t1.month <=extract(month from sysdate) and t1.year=extract(year from sysdate) and t1.code IN (".$string.")  group by mtr_non_motor)
                 ) B
                 group by B.MTR_NON_MOTOR
                "));
            // $arr=join(',',$data);
            
            
        }


        $array=($chart_result_1);
        // echo "target ach cumu";
        // echo $array[0]->mtr_non_motor;
        $motor_achievement=$array[0]->total;
        $nonmotor_achievement=$array[1]->total;

        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);
     



        
        //return response()->json(['data'=>$chart_result]);
        return json_encode($data);
    }

    public function cumulative_cwg_group(Request $request){

        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];


        if($key!="group"){
            // echo "!all";
            $chart_result = DB::select(DB::raw("
                SELECT B.DEPT_NEW,round(sum(B.gwp),2) GWP FROM
                ((SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MTR','MOTOR',
                'FIR','FIRE',
                'MRN','MARINE',
                'ENG','ENGG',
                'MIS','MISC',
                'MED','MED',
                'WCI','WCI',
                '','MISC') DEPT_NEW,T.* FROM  Gi_Final_Gwp_Tcs T) W          
                where code='$key' and year=extract(year from sysdate) and month<=extract(month from sysdate)
                group by W.DEPT_NEW
                )
                
                union
                
                (SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  
                    (SELECT DECODE(t.dept,'MOTOR','MOTOR',
                'FIRE','FIRE',
                'MARINE','MARINE',
                'ENGG','ENGG',
                'MISC','MISC',
                'MED','MED',
                'WCI','WCI',
                '','MISC') DEPT_NEW,T.* FROM t_report_dncn_gwp_fmt T) W          
                where agent_code='$key' 
                group by W.DEPT_NEW
               )
               ) B group by B.DEPT_NEW
                "));

        }else if($key=='group'){
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
            // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            $string=$string.",'".$_SESSION['USER_CODE']."'";
            // echo $string;
            // IN (".$string.")
            $chart_result = DB::select(DB::raw("
                SELECT B.DEPT_NEW,round(sum(B.gwp),2) GWP FROM
                ((SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MTR','MOTOR',
                'FIR','FIRE',
                'MRN','MARINE',
                'ENG','ENGG',
                'MIS','MISC',
                'MED','MED',
                'WCI','WCI',
                '','MISC') DEPT_NEW,T.* FROM  Gi_Final_Gwp_Tcs T) W          
                where code IN (".$string.") and year=extract(year from sysdate) and month<=extract(month from sysdate)
                group by W.DEPT_NEW
                )
                
                union
                
                (SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  
                    (SELECT DECODE(t.dept,'MOTOR','MOTOR',
                'FIRE','FIRE',
                'MARINE','MARINE',
                'ENGG','ENGG',
                'MISC','MISC',
                'MED','MED',
                'WCI','WCI',
                '','MISC') DEPT_NEW,T.* FROM t_report_dncn_gwp_fmt T) W          
                where agent_code IN (".$string.") 
                group by W.DEPT_NEW
               )
               ) B group by B.DEPT_NEW
                "));
            // $arr=join(',',$data);
        }
        //return response()->json(['data'=>$chart_result]);
        return json_encode($chart_result);
    }

    public function CMNOP_group(Request $request){
        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];


        if($key!="group"){
            // echo "!all";
            $chart_result = DB::select(DB::raw("
                select DECODE(FMT.DEPT,'MTR',decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),
                decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
                ,round(sum(fmt.gwp),2) GWP,count(fmt.dn_cn_no) nop from Gi_Final_Gwp_Tcs fmt where code='$key' and 
                year=extract(year from sysdate) and month<extract(month from sysdate)
                group by  DECODE(FMT.DEPT,'MTR',
                decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
                ,decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
                "));

        }else if($key=='group'){
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
            // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            $string=$string.",'".$_SESSION['USER_CODE']."'";
            // echo $string;
            // IN (".$string.")
            $chart_result = DB::select(DB::raw("
                select DECODE(FMT.DEPT,'MTR',decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),
                decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
                ,round(sum(fmt.gwp),2) GWP,count(fmt.dn_cn_no) nop from Gi_Final_Gwp_Tcs fmt where code IN (".$string.") and 
                year=extract(year from sysdate) and month<extract(month from sysdate)
                group by  DECODE(FMT.DEPT,'MTR',
                decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
                ,decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
                "));
            // $arr=join(',',$data);
            
            
        }
        //return response()->json(['data'=>$chart_result]);
        return json_encode($chart_result);
    }

    // retrieve_leads_group
    public function retrieve_leads_group(Request $request){
        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];

        if($key!="group"){
            // echo "!all";
            $search_group = DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE='$key'"));

        }else if($key=='group'){
            // echo "all";
            $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
            // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
        // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
            $string='';
            foreach($data as $y){
                for($x=0;$x<sizeof($y);$x++){
                    $code=$y[$x]->code;
                    $string=$string."'".$code."'";
                    if($x==(sizeof($y)-1)){
                        break;
                    }
                    $string=$string.",";
                    // echo $code;
                    // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
                }
             
            }
            // echo $string;
            $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN (".$string.")"));        
            // $arr=join(',',$data);
            
            
        }

        return response()->json(['data'=>$search_group]);
    }



    public function ppwRatio_search_user(Request $request){


          $agent_code = $request->input('key');

          $ppw_result = DB::select(DB::raw("
            select '10%'as pecentage,z.* from (select 

            DECODE(ZONAL_CODE, 'NNZ', 'HEAD OFFICE',
                                'NEZ', 'NORTH-EASTERN ZONE',
                                'WEZ', 'NORTH-WESTERN  ZONE',
                                'SUZ','SOUTHERN ZONE',
                                'CEZ','CENTRAL ZONE',
                                'MET','METRO ZONE') zone,

            mg.zonal_code,sum(w.gwp) GWP,sum(w.ppw_)*-1 PPW from
            (select tc.assurace_code,round(sum(tc.gwp),2) gwp,
            nvl((select round(sum(tcs.gwp),2) from t_report_dncn_gwp_fmt tcs
            where
            tcs.pol_status='PPW-CANC'
            and tcs.agent_code='$agent_code'
            --AND TCS.TAKAFUL='NO'
            and tcs.assurance_code=tc.assurace_code

            ),0)
            ppw_

            from (
            select AO.ASSURACE_CODE,AO.GWP,AO.MONTH,AO.YEAR
              from gi_final_gwp_tcs AO
              WHERE AO.CODE='$agent_code'
            UNION all
               select AO1.ASSURACE_CODE,AO1.GWP,AO1.MONTH,AO1.YEAR from gi_final_gwp_takaful AO1
               WHERE AO1.CODE='$agent_code'
              ) TC
            where tc.year=extract(year from add_months(sysdate,-2))
            and tc.month=extract(month from add_months(sysdate,-2))

            group by  tc.assurace_code) w,MIS_GI_BRANCHES mg
            where w.assurace_code=mg.branch_code
            group by mg.zonal_code
            ) z

        "));
        
        return json_encode($ppw_result);
        



    }


    public function claimRatio_search_user(Request $request){

        $agent_code = $request->input('key');


          $claim_result = DB::select(DB::raw("
            SELECT  *
            FROM 
            (
            select  CHANNEL_CODE,TYPE,NVL(MTR,0) AS TOTAL
            FROM GE_SF_RATIO_CALCULATIONS 
            where CHANNEL_CODE='$agent_code'
            --and ASSU_CODE IN (@ASSU_CODE)
            ) p
            PIVOT
            (
            SUM(TOTAL)
            FOR TYPE IN ('XOL'AS XOL,
              'SALES_PROMO' AS SALES_PROMO,'RI_COMM_INCOME' AS RI_COMM_INCOME,'COMMISSION_PAID' AS COMMISSION_PAID,'RI' AS RI,'RI_CLAIM_PAID' AS RI_CLAIM_PAID,
              'CLAIM_OS_RI_FMT' AS CLAIM_OS_RI_FMT,'UEP' AS UEP,'TITLE_TRF' AS TITLE_TRF,'GWP' AS GWP,'DAC_RI_COMM' AS DAC_RI_COMM,
              'CLAIM_PAID_COST' AS CLAIM_PAID_COST,'CLAIM_OS_RI_LST' AS CLAIM_OS_RI_LST,'CLAIM_OS_LST' AS CLAIM_OS_LST,'DAC' AS DAC,'CLAIM_OS_FMT' AS CLAIM_OS_FMT)
            ) pvt

        "));
    
        return json_encode($claim_result);



    }


    public function training_star_count_serach_user(Request $request){


        $agent_code = $request->input('key');

            $star_result = DB::select(DB::raw("
                select 
                    round((select count(*) from sf_training_details where code='$agent_code' and ROLE_TYPE='LEADER')/(select count(*) from sf_training_programs where TRAIN_CATEGORY='LEADER')*100,2) as percentage
                from dual
            "));

              return json_encode($star_result);


    }











}











        // if($key!="group"){
        //     // echo "!all";
        //     $chart_result = DB::select(DB::raw("
                
        //         "));

        // }else if($key=='group'){
        //     // echo "all";
        //     $data=Array(json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']));
        //     // $data=Array($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);
        //     // echo $_SESSION['ADVISOR_TEAM_MEMBER_LIST'];
        //     $string='';
        //     foreach($data as $y){
        //         for($x=0;$x<sizeof($y);$x++){
        //             $code=$y[$x]->code;
        //             $string=$string."'".$code."'";
        //             if($x==(sizeof($y)-1)){
        //                 break;
        //             }
        //             $string=$string.",";
        //             // echo $code;
        //             // $search_group =DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE IN '".implode("','",$data)."'")));        
        //         }
             
        //     }
        //     $string=$string.",'".$_SESSION['USER_CODE']."'";
        //     // echo $string;
        //     // IN (".$string.")
        //     $chart_result = DB::select(DB::raw("
                
        //         "));
        //     // $arr=join(',',$data);
            
            
        // }