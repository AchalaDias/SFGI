<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class Charts_conroller extends Controller
{
    public function chart1_0_1data(){

        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];



        if($user_role == 'ADVISOR'){


            if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

             $chart_result = DB::select(DB::raw("
            SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM  T_REPORT_DNCN_GWP_FMT T) W 
            where agent_code in ($string)         
            group by W.DEPT_NEW
            order by W.DEPT_NEW

           "));

            }else{

             $chart_result = DB::select(DB::raw("
            SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM  T_REPORT_DNCN_GWP_FMT T) W 
            where agent_code='$agent_code'         
            group by W.DEPT_NEW
            order by W.DEPT_NEW

           "));
         }

        }
        else if($user_role == 'BRMGR'){

            /* $chart_result = DB::select(DB::raw("
            SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM  T_REPORT_DNCN_GWP_FMT T) W 
            where agent_code in (select user_code from ge_sf_user_details where branch = '$user_branch' )          
            group by W.DEPT_NEW
            order by W.DEPT_NEW

        "));
*/



             $chart_result = DB::select(DB::raw("
            SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM  T_REPORT_DNCN_GWP_FMT T) W 
            where W.business_party = 'AGENT' and W.assurance_code = '$user_branch'       
            group by W.DEPT_NEW
            order by W.DEPT_NEW

        "));

        }
        else if($user_role == 'REMGR'){

             $chart_result = DB::select(DB::raw("
            SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM  T_REPORT_DNCN_GWP_FMT T) W 
            where W.business_party = 'AGENT' and W.assurance_code in (select branch from ge_sf_user_details where region = '$user_region' )          

            group by W.DEPT_NEW
            order by W.DEPT_NEW

        "));

        }
        else if($user_role == 'ZOMGR'){

             $chart_result = DB::select(DB::raw("
            SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM  T_REPORT_DNCN_GWP_FMT T) W 
            where W.business_party = 'AGENT' and W.assurance_code in (select branch from ge_sf_user_details where zone = '$user_zone' )    
            group by W.DEPT_NEW
            order by W.DEPT_NEW

        "));

        }else{

             $chart_result = DB::select(DB::raw("
            SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM  T_REPORT_DNCN_GWP_FMT T) W   
            where W.business_party = 'AGENT'       
            group by W.DEPT_NEW
            order by W.DEPT_NEW

        "));



        }
        
       
        //return response()->json(['data'=>$chart_result]);
        return json_encode($chart_result);
    }

    public function chart1data(){

        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];



        if($user_role == 'ADVISOR'){


          if($user_role == 'ADVISOR'){


            if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

          $chart_result = DB::select(DB::raw("
              select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and agent_code in ($string)
            group by  fmt.pol_status

           "));

            }
        }

            else{

            $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and agent_code='$agent_code'
            group by  fmt.pol_status

           "));
        }
            
        }
        else if($user_role == 'BRMGR'){
/*
            $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and agent_code in (select user_code from ge_sf_user_details where branch = '$user_branch' )  
            group by  fmt.pol_status

        "));
*/

         $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' 
            and fmt.business_party = 'AGENT' and fmt.assurance_code = '$user_branch'  
            group by  fmt.pol_status

        "));
           


        }
          else if($user_role == 'REMGR'){

            $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and fmt.business_party = 'AGENT' and fmt.assurance_code in (select branch from ge_sf_user_details where region = '$user_region' )  
            group by  fmt.pol_status

        "));

           


        }
          else if($user_role == 'ZOMGR'){

            $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and fmt.business_party = 'AGENT' and fmt.assurance_code in (select branch from ge_sf_user_details where zone = '$user_zone' )  
            group by  fmt.pol_status

        "));

           


        }
        else{

              $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and fmt.business_party = 'AGENT' 
            group by  fmt.pol_status

        "));


        }

        //return response()->json(['data'=>$chart_result]);
        return json_encode($chart_result);
    }    //

    public function chart2data(){
        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];


        if($user_role == 'ADVISOR'){



            if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

        
                 $chart_result = DB::select(DB::raw("
            select DECODE(FMT.DEPT,'MOTOR',decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dncn_no) nop from t_report_dncn_gwp_fmt fmt where agent_code in ($string)
            group by  DECODE(FMT.DEPT,'MOTOR',
            decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
             "));
            }

        else{

                 $chart_result = DB::select(DB::raw("
            select DECODE(FMT.DEPT,'MOTOR',decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dncn_no) nop from t_report_dncn_gwp_fmt fmt where agent_code='$agent_code'
            group by  DECODE(FMT.DEPT,'MOTOR',
            decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
             "));

        }
            
        }
        else if($user_role == 'BRMGR'){


            /* $chart_result = DB::select(DB::raw("
            select DECODE(FMT.DEPT,'MOTOR',decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dncn_no) nop from t_report_dncn_gwp_fmt fmt where agent_code in (select user_code from ge_sf_user_details where branch = '$user_branch' ) 
            group by  DECODE(FMT.DEPT,'MOTOR',
            decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));
  */


             $chart_result = DB::select(DB::raw("
            select DECODE(FMT.DEPT,'MOTOR',decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dncn_no) nop from
             t_report_dncn_gwp_fmt fmt 

                where  
                 fmt.business_party = 'AGENT' and fmt.assurance_code = '$user_branch'  
                 group by  DECODE(FMT.DEPT,'MOTOR',
                           decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
                           ,decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));
  



        }
          else if($user_role == 'REMGR'){




             $chart_result = DB::select(DB::raw("
            select DECODE(FMT.DEPT,'MOTOR',decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dncn_no) nop from t_report_dncn_gwp_fmt fmt 

            where  fmt.business_party = 'AGENT' and fmt.assurance_code in (select branch from ge_sf_user_details where region = '$user_region' ) 

            group by  DECODE(FMT.DEPT,'MOTOR',
            decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));

           


        }
          else if($user_role == 'ZOMGR'){


             $chart_result = DB::select(DB::raw("
            select DECODE(FMT.DEPT,'MOTOR',decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dncn_no) nop from t_report_dncn_gwp_fmt fmt

             where  fmt.business_party = 'AGENT' and fmt.assurance_code in (select branch from ge_sf_user_details where zone = '$user_zone' ) 

            group by  DECODE(FMT.DEPT,'MOTOR',
            decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));



        }
        else{


              $chart_result = DB::select(DB::raw("
            select DECODE(FMT.DEPT,'MOTOR',decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dncn_no) nop from t_report_dncn_gwp_fmt fmt

             where  fmt.business_party = 'AGENT' 

            group by  DECODE(FMT.DEPT,'MOTOR',
            decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));

            

        }


        return json_encode($chart_result);
    }    
    
    public function chart3data(){

        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];

          $year = date('Y');
        $month = date('m');



        if($user_role == 'ADVISOR'){



        $chart_result_1 = DB::select(DB::raw("
            select * from GE_SF_INV_MONTHLY_TARGETS where agent_code='$agent_code'
        "));
        $array=($chart_result_1);
        $motor_target=$array[0]->motor;
        $nonmotor_target=$array[0]->nonmotor;
        
        
        //getting achievement of the month
        $chart_result_2 = DB::select(DB::raw("
            select decode(t.class_code,'MTR','MOTOR','NONMOTOR') as TYPE,SUM(T.TARGET_AMT) TARGET_AMOUNT,
            (SELECT SUM(FMT.GWP) FROM T_REPORT_DNCN_GWP_FMT FMT WHERE agent_code='$agent_code' and DECODE(FMT.DEPT,'MOTOR','MOTOR','NONMOTOR')=decode(t.class_code,'MTR','MOTOR','NONMOTOR')) ACHIEVEMENT_AMT
            from wf_gen_branch_class_target t
            where t.achive_year=extract(year from sysdate)
            and t.achive_month=extract(month from sysdate)
            GROUP BY decode(t.class_code,'MTR','MOTOR','NONMOTOR')
        "));


        $array=($chart_result_2);
        $motor_achievement=$array[1]->achievement_amt;
        $nonmotor_achievement=$array[0]->achievement_amt;



        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);

            
        }
        else if($user_role == 'BRMGR'){



          $chart_result_1 = DB::select(DB::raw("
           select sum(t.mtr_target) as motor,sum(t.nm_target) as nonmotor
        from ge_sf_branch_tragets t 
        where t.branch = '$user_branch'
               and t.year='$year' and t.month='$month'   
        "));
       $array=($chart_result_1);
        $motor_target=($array[0]->motor);
        $nonmotor_target=($array[0]->nonmotor);
        
        
        
        
        //getting achievement of the month
         $chart_result_2 = DB::select(DB::raw("
            select decode(t.class_code,'MTR','MOTOR','NONMOTOR') as TYPE,SUM(T.TARGET_AMT) TARGET_AMOUNT,
            (SELECT SUM(FMT.GWP) FROM T_REPORT_DNCN_GWP_FMT FMT 
            WHERE  FMT.business_party = 'AGENT' and FMT.assurance_code = '$user_branch' 

            and DECODE(FMT.DEPT,'MOTOR','MOTOR','NONMOTOR')=decode(t.class_code,'MTR','MOTOR','NONMOTOR')) ACHIEVEMENT_AMT
            from wf_gen_branch_class_target t
            where t.achive_year=extract(year from sysdate)
            and t.achive_month=extract(month from sysdate)
            GROUP BY decode(t.class_code,'MTR','MOTOR','NONMOTOR')
        "));


        $array=($chart_result_2);
        $motor_achievement=$array[1]->achievement_amt;
        $nonmotor_achievement=$array[0]->achievement_amt;



        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);


        }
          else if($user_role == 'REMGR'){


        $chart_result_1 = DB::select(DB::raw("
        select sum(t.mtr_target) as motor,sum(t.nm_target) as nonmotor
        from ge_sf_branch_tragets t 
        where t.branch in (select branch from ge_sf_user_details where region = '$user_region' ) 
               and t.year='$year' and t.month='$month'   

        "));
        $array=($chart_result_1);
        $motor_target=($array[0]->motor);
        $nonmotor_target=($array[0]->nonmotor);
        
        
        
        //getting achievement of the month
        $chart_result_2 = DB::select(DB::raw("
            select decode(t.class_code,'MTR','MOTOR','NONMOTOR') as TYPE,SUM(T.TARGET_AMT) TARGET_AMOUNT,
            (SELECT SUM(FMT.GWP) FROM T_REPORT_DNCN_GWP_FMT FMT WHERE FMT.business_party = 'AGENT' and FMT.assurance_code in (select branch from ge_sf_user_details where region = '$user_region' ) 

            and DECODE(FMT.DEPT,'MOTOR','MOTOR','NONMOTOR')=decode(t.class_code,'MTR','MOTOR','NONMOTOR')) ACHIEVEMENT_AMT
            from wf_gen_branch_class_target t
            where t.achive_year=extract(year from sysdate)
            and t.achive_month=extract(month from sysdate)
            GROUP BY decode(t.class_code,'MTR','MOTOR','NONMOTOR')
        "));


        $array=($chart_result_2);
        $motor_achievement=$array[1]->achievement_amt;
        $nonmotor_achievement=$array[0]->achievement_amt;



        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);



        }
          else if($user_role == 'ZOMGR'){

              $chart_result_1 = DB::select(DB::raw("
               select sum(t.mtr_target) as motor,sum(t.nm_target) as nonmotor
               from ge_sf_branch_tragets t 
               where t.branch in (select branch from ge_sf_user_details where zone = '$user_zone' ) 
               and t.year='$year' and t.month='$month'   
        "));
        $array=($chart_result_1);
        $motor_target=($array[0]->motor);
        $nonmotor_target=($array[0]->nonmotor);
        
        
        
        //getting achievement of the month
        $chart_result_2 = DB::select(DB::raw("
            select decode(t.class_code,'MTR','MOTOR','NONMOTOR') as TYPE,SUM(T.TARGET_AMT) TARGET_AMOUNT,
            (SELECT SUM(FMT.GWP) FROM T_REPORT_DNCN_GWP_FMT FMT where FMT.business_party = 'AGENT' and FMT.assurance_code in (select branch from ge_sf_user_details where zone = '$user_zone' ) 

            and DECODE(FMT.DEPT,'MOTOR','MOTOR','NONMOTOR')=decode(t.class_code,'MTR','MOTOR','NONMOTOR')) ACHIEVEMENT_AMT
            from wf_gen_branch_class_target t
            where t.achive_year=extract(year from sysdate)
            and t.achive_month=extract(month from sysdate)
            GROUP BY decode(t.class_code,'MTR','MOTOR','NONMOTOR')
        "));


        $array=($chart_result_2);
        $motor_achievement=$array[1]->achievement_amt;
        $nonmotor_achievement=$array[0]->achievement_amt;



        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);





           
        }
        else{


        $chart_result_1 = DB::select(DB::raw("
           select sum(t.mtr_target) as motor,sum(t.nm_target) as nonmotor
           from ge_sf_branch_tragets t 
           where t.year='$year' and t.month='$month'   
        "));
        $array=($chart_result_1);
        $motor_target=($array[0]->motor);
        $nonmotor_target=($array[0]->nonmotor);
        
        
        
        //getting achievement of the month
        $chart_result_2 = DB::select(DB::raw("
            select decode(t.class_code,'MTR','MOTOR','NONMOTOR') as TYPE,SUM(T.TARGET_AMT) TARGET_AMOUNT,
            (SELECT SUM(FMT.GWP) FROM T_REPORT_DNCN_GWP_FMT FMT WHERE FMT.business_party = 'AGENT' 
            and DECODE(FMT.DEPT,'MOTOR','MOTOR','NONMOTOR')=decode(t.class_code,'MTR','MOTOR','NONMOTOR')) ACHIEVEMENT_AMT
            from wf_gen_branch_class_target t
            where t.achive_year=extract(year from sysdate)
            and t.achive_month=extract(month from sysdate)
            GROUP BY decode(t.class_code,'MTR','MOTOR','NONMOTOR')
        "));


        $array=($chart_result_2);
        $motor_achievement=$array[1]->achievement_amt;
        $nonmotor_achievement=$array[0]->achievement_amt;



        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);

            
            
        }




        //return response()->json(['data'=>$chart_result]);
        return json_encode($data);
    }

    public function chart4data(){
        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];



        if($user_role == 'ADVISOR'){




            if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

        
              $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept='MOTOR' and agent_code in ($string)
            group by  fmt.pol_status
        "));

            }


        else{
        $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept='MOTOR' and agent_code='$agent_code'
            group by  fmt.pol_status
        "));

       }

        }
        else if($user_role == 'BRMGR'){



       /* $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept='MOTOR' and agent_code in (select user_code from ge_sf_user_details where branch = '$user_branch' ) 
            group by  fmt.pol_status
        "));
*/

         $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept='MOTOR' and  business_party = 'AGENT' and assurance_code = '$user_branch'
            group by  fmt.pol_status
        "));

            

        }
        else if($user_role == 'REMGR'){


             $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept='MOTOR' and business_party = 'AGENT' and assurance_code in (select branch from ge_sf_user_details where region = '$user_region' )         
            group by  fmt.pol_status
        "));


        }
        else if($user_role == 'ZOMGR'){



             $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept='MOTOR' and business_party = 'AGENT' and assurance_code  in (select branch from ge_sf_user_details where zone = '$user_zone' )        
            group by  fmt.pol_status
        "));

           
        }else{


               $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept='MOTOR' and business_party = 'AGENT'    
            group by  fmt.pol_status
        "));

            
        }
        



        return json_encode($chart_result);
    }

    public function month_non_motor(){

        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];



        if($user_role == 'ADVISOR'){



            if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

        
            $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept !='MOTOR' and agent_code in ($string)
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status

        "));

            }


            else{
           
       $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept !='MOTOR' and agent_code='$agent_code'
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status

        "));

            }

        }
        else if($user_role == 'BRMGR'){


/*
             $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept !='MOTOR' and agent_code in (select user_code from ge_sf_user_details where branch = '$user_branch' ) 
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status

        "));
*/


             $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept !='MOTOR' and  business_party = 'AGENT' and assurance_code = '$user_branch' 
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status

        "));




        }
        else if($user_role == 'REMGR'){



            $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept !='MOTOR' and business_party = 'AGENT' and assurance_code in (select branch from ge_sf_user_details where region = '$user_region' ) 
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status

        "));


        }
        else if($user_role == 'ZOMGR'){



            $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept !='MOTOR' and business_party = 'AGENT' and assurance_code in (select branch from ge_sf_user_details where zone = '$user_zone' ) 
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status

        "));

           
        }else{

             $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept !='MOTOR'  and business_party = 'AGENT' 
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status

        "));


            
        }

       
        return json_encode($chart_result);
    }



    public function cumulative_non_motor(){

        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];



        if($user_role == 'ADVISOR'){

                if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

        
             
      $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept !='MOTOR' and agent_code in ($string)
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status
        "));

            }



            else{
           
      $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept !='MOTOR' and agent_code='$agent_code'
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status
        "));

  }

        }
        else if($user_role == 'BRMGR'){

            /*$chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept !='MOTOR' and agent_code in (select user_code from ge_sf_user_details where branch = '$user_branch' ) 
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status
        "));
*/

         $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept !='MOTOR' and  business_party = 'AGENT' and assurance_code = '$user_branch'
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status
        "));





        }
        else if($user_role == 'REMGR'){


              $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from GI_DRAFT_FMT_GWP_MONTHEND fmt
            where fmt.dept !='MOTOR' and  business_party = 'AGENT' and assurance_code  in (select branch from ge_sf_user_details where region = '$user_region') 
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status
        "));




        }
        else if($user_role == 'ZOMGR'){



            $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept !='MOTOR' and  business_party = 'AGENT' and assurance_code in (select branch from ge_sf_user_details where zone = '$user_zone' ) 
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status

        "));

           
        }else{



              $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.Dept='MISC' THEN fmt.gwp END) MISC_gwp,
            sum(CASE WHEN fmt.Dept='MARINE' THEN fmt.gwp END) MARINE_gwp,
            sum(CASE WHEN fmt.Dept='MED' THEN fmt.gwp END) MED_gwp,
            sum(CASE WHEN fmt.Dept='FIRE' THEN fmt.gwp END) FIRE_gwp,
            sum(CASE WHEN fmt.Dept='ENGG' THEN fmt.gwp END) ENG_gwp,
            sum(CASE WHEN fmt.Dept='WCI' THEN fmt.gwp END) WCI_gwp
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept !='MOTOR' and  business_party = 'AGENT' 
            and fmt.pol_status in ('NEW','RENEWAL','ADDITION')
            GROUP BY fmt.pol_status

        "));

            
            
        }


        return json_encode($chart_result);
    }




    public function cumulative_target_achievement(){

        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];

        $year = date("Y");
        $month = date("m");



        if($user_role == 'ADVISOR'){

            
        $chart_result_2 = DB::select(DB::raw("
            select * from GE_SF_INV_MONTHLY_TARGETS where agent_code='$agent_code'
        "));
        $array=($chart_result_2);
        $motor_target=($array[0]->motor*12);
        $nonmotor_target=($array[0]->nonmotor*12);
        
        //cumulative achievement from tcs
        $chart_result_1 = DB::select(DB::raw("
            
            select  B.MTR_NON_MOTOR,SUM(B.TOTAL) as total
              from
            (
            (select mtr_non_motor,sum(t.gwp) as total from gi_final_gwp_tcs t where t.month <=extract(month from sysdate) and t.year=extract(year from sysdate) and t.code='$agent_code' group by mtr_non_motor) 
            union
             (select mtr_non_motor, sum(t1.gwp) as total from gi_final_gwp_takaful t1 where t1.month <=extract(month from sysdate) and t1.year=extract(year from sysdate) and t1.code='$agent_code'  group by mtr_non_motor)
             ) B
             group by B.MTR_NON_MOTOR
        "));
        $array=($chart_result_1);

        $motor_achievement=$array[0]->total;
        $nonmotor_achievement=$array[1]->total;

        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);
     
        }
        else if($user_role == 'BRMGR'){



       $chart_result_2 = DB::select(DB::raw("
        select sum(t.mtr_target) as motor,sum(t.nm_target) as nonmotor
        from ge_sf_branch_tragets t 
        where t.branch = '$user_branch'
               and t.year='$year' and t.month<='$month'   
        "));
        $array=($chart_result_2);
        $motor_target=($array[0]->motor);
        $nonmotor_target=($array[0]->nonmotor);
        
        //cumulative achievement from tcs
       $chart_result_1 = DB::select(DB::raw("
            
            select  B.MTR_NON_MOTOR,SUM(B.TOTAL) as total
              from
            (
            (select mtr_non_motor,sum(t.gwp) as total from gi_final_gwp_tcs t where t.month <=extract(month from sysdate) and t.year=extract(year from sysdate) and t.assurace_code = '$user_branch'  
             group by mtr_non_motor) 
            union
             (select mtr_non_motor, sum(t1.gwp) as total from gi_final_gwp_takaful t1 where t1.month <=extract(month from sysdate) and t1.year=extract(year from sysdate) and t1.assurace_code = '$user_branch' 
               group by mtr_non_motor)
             ) B
             group by B.MTR_NON_MOTOR
        "));
        $array=($chart_result_1);

        $motor_achievement=$array[0]->total;
        $nonmotor_achievement=$array[1]->total;

        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);
     


        }
        else if($user_role == 'REMGR'){

        $chart_result_2 = DB::select(DB::raw("
        select sum(t.mtr_target) as motor,sum(t.nm_target) as nonmotor
        from ge_sf_branch_tragets t 
        where t.branch in (select branch from ge_sf_user_details where region = '$user_region'  ) 
               and t.year='$year' and t.month<='$month'    
        "));
        $array=($chart_result_2);
        $motor_target=($array[0]->motor);
        $nonmotor_target=($array[0]->nonmotor);
        
        //cumulative achievement from tcs
        $chart_result_1 = DB::select(DB::raw("
            
            select  B.MTR_NON_MOTOR,SUM(B.TOTAL) as total
              from
            (
            (select mtr_non_motor,sum(t.gwp) as total from gi_final_gwp_tcs t where t.month <=extract(month from sysdate) and t.year=extract(year from sysdate) and t.assurace_code in (select branch from ge_sf_user_details where region = '$user_region' )   
             group by mtr_non_motor) 
            union
             (select mtr_non_motor, sum(t1.gwp) as total from gi_final_gwp_takaful t1 where t1.month <=extract(month from sysdate) and t1.year=extract(year from sysdate) and t1.assurace_code in (select branch from ge_sf_user_details where region = '$user_region' )   
               group by mtr_non_motor)
             ) B
             group by B.MTR_NON_MOTOR
        "));
        $array=($chart_result_1);

        $motor_achievement=$array[0]->total;
        $nonmotor_achievement=$array[1]->total;

        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);
     

        }
        else if($user_role == 'ZOMGR'){

             
        $chart_result_2 = DB::select(DB::raw("
         select sum(t.mtr_target) as motor,sum(t.nm_target) as nonmotor
        from ge_sf_branch_tragets t 
        where t.branch in (select branch from ge_sf_user_details where zone = '$user_zone' ) 
               and t.year='$year' and t.month<='$month'    
        "));
        $array=($chart_result_2);
        $motor_target=($array[0]->motor);
        $nonmotor_target=($array[0]->nonmotor);
        
        //cumulative achievement from tcs
        $chart_result_1 = DB::select(DB::raw("
            
            select  B.MTR_NON_MOTOR,SUM(B.TOTAL) as total
              from
            (
            (select mtr_non_motor,sum(t.gwp) as total from gi_final_gwp_tcs t where t.month <=extract(month from sysdate) and t.year=extract(year from sysdate) and t.assurace_code in (select branch from ge_sf_user_details where zone = '$user_zone' )   
             group by mtr_non_motor) 
            union
             (select mtr_non_motor, sum(t1.gwp) as total from gi_final_gwp_takaful t1 where t1.month <=extract(month from sysdate) and t1.year=extract(year from sysdate) and t1.assurace_code in (select branch from ge_sf_user_details where zone = '$user_zone' )    
               group by mtr_non_motor)
             ) B
             group by B.MTR_NON_MOTOR
        "));
        $array=($chart_result_1);

        $motor_achievement=$array[0]->total;
        $nonmotor_achievement=$array[1]->total;

        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);
     

        }else{



        $chart_result_2 = DB::select(DB::raw("
           select sum(t.mtr_target) as motor,sum(t.nm_target) as nonmotor
        from ge_sf_branch_tragets t 
        where t.year='$year' and t.month<='$month'  


        "));
        $array=($chart_result_2);
        $motor_target=($array[0]->motor);
        $nonmotor_target=($array[0]->nonmotor);
        
        //cumulative achievement from tcs
        $chart_result_1 = DB::select(DB::raw("
            
            select  B.MTR_NON_MOTOR,SUM(B.TOTAL) as total
              from
            (
            (select mtr_non_motor,sum(t.gwp) as total from gi_final_gwp_tcs t where t.month <=extract(month from sysdate) and t.year=extract(year from sysdate) 
             group by mtr_non_motor) 
            union
             (select mtr_non_motor, sum(t1.gwp) as total from gi_final_gwp_takaful t1 where t1.month <=extract(month from sysdate) and t1.year=extract(year from sysdate) 
               group by mtr_non_motor)
             ) B
             group by B.MTR_NON_MOTOR
        "));
        $array=($chart_result_1);

        $motor_achievement=$array[0]->total;
        $nonmotor_achievement=$array[1]->total;

        $data=array("motor_target"=>$motor_target,"nonmotor_target"=>$nonmotor_target,"motor_achievement"=>$motor_achievement,"nonmotor_achievement"=>$nonmotor_achievement);
     




        }



        return json_encode($data);
    }

    public function advisor_details(Request $request){
        $agent_code=$_SESSION['USER_CODE'];
        $key=$request['key'];
            $advisor_result = DB::select(DB::raw("
                select * from GE_SF_USER_DETAILS where USER_CODE='$key'
            "));
        return json_encode($advisor_result);
    }    //

    // new cumulative
    public function cumulativeCWG(){

        $agent_code=$_SESSION['USER_CODE'];
         $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];



        if($user_role == 'ADVISOR'){

             if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

        
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
            where code in ($string) and year=extract(year from sysdate) and month<=extract(month from sysdate)
            group by W.DEPT_NEW
            )
            
            union
            
            (SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM t_report_dncn_gwp_fmt T) W          
            where agent_code in ($string) 
            group by W.DEPT_NEW
           )
           ) B group by B.DEPT_NEW

        "));

            }




            else{

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
            where code='$agent_code' and year=extract(year from sysdate) and month<=extract(month from sysdate)
            group by W.DEPT_NEW
            )
            
            union
            
            (SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM t_report_dncn_gwp_fmt T) W          
            where agent_code='$agent_code' 
            group by W.DEPT_NEW
           )
           ) B group by B.DEPT_NEW

        "));

         }

        }
        else if($user_role == 'BRMGR'){


            /* $chart_result = DB::select(DB::raw("
            SELECT B.DEPT_NEW,round(sum(B.gwp),2) GWP FROM
            ((SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MTR','MOTOR',
            'FIR','FIRE',
            'MRN','MARINE',
            'ENG','ENGG',
            'MIS','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM  Gi_Final_Gwp_Tcs T) W          
            where code in (select user_code from ge_sf_user_details where branch = '$user_branch' )  
             and year=extract(year from sysdate) and month<=extract(month from sysdate)
            group by W.DEPT_NEW
            )
            
            union
            
            (SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM t_report_dncn_gwp_fmt T) W          
            where agent_code in (select user_code from ge_sf_user_details where branch = '$user_branch' )  
            group by W.DEPT_NEW
           )
           ) B group by B.DEPT_NEW

        "));
*/

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
            where assurace_code ='$user_branch' 
             and year=extract(year from sysdate) and month<=extract(month from sysdate)
            group by W.DEPT_NEW
            )
            
            union
            
            (SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM t_report_dncn_gwp_fmt T) W          
            where assurance_code = '$user_branch' 
            group by W.DEPT_NEW
           )
           ) B group by B.DEPT_NEW

        "));



            

        }
        else if($user_role == 'REMGR'){

           
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
            where assurace_code in (select branch from ge_sf_user_details where region = '$user_region' )  
             and year=extract(year from sysdate) and month<=extract(month from sysdate)
            group by W.DEPT_NEW
            )
            
            union
            
            (SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM t_report_dncn_gwp_fmt T) W          
            where assurance_code in (select branch from ge_sf_user_details where region = '$user_region' )  
            group by W.DEPT_NEW
           )
           ) B group by B.DEPT_NEW

        "));


        }
        else if($user_role == 'ZOMGR'){

            
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
            where assurace_code in (select branch from ge_sf_user_details where zone = '$user_zone' )  
             and year=extract(year from sysdate) and month<=extract(month from sysdate)
            group by W.DEPT_NEW
            )
            
            union
            
            (SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM t_report_dncn_gwp_fmt T) W          
            where assurance_code in (select branch from ge_sf_user_details where zone = '$user_zone' )  
            group by W.DEPT_NEW
           )
           ) B group by B.DEPT_NEW

        "));

        }else{





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
            where year=extract(year from sysdate) and month<=extract(month from sysdate)
            group by W.DEPT_NEW
            )
            
            union
            
            (SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM t_report_dncn_gwp_fmt T) W          
              
            group by W.DEPT_NEW
           )
           ) B group by B.DEPT_NEW

        "));


            


        }


     
        return json_encode($chart_result);
    }

    public function cumulativeMOTOR(){

        $agent_code=$_SESSION['USER_CODE'];
         $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];



        if($user_role == 'ADVISOR'){



                if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

        
           $chart_result = DB::select(DB::raw("
            select B.pol_status,sum(motor_car_gwp) as motor_car_gwp,sum(motor_nonCar_GWP) as motor_nonCar_GWP from
        (
              select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and agent_code in ($string)
            group by  fmt.pol_status


            union


            select fmt.policy_status as pol_status,
            sum(CASE WHEN (fmt.mtr_non_motor='Motor' or fmt.mtr_non_motor='motor') THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN (fmt.mtr_non_motor!='Motor' and fmt.mtr_non_motor!='motor') THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from Gi_Final_Gwp_Tcs fmt                                            
            where fmt.dept='MTR' and code in ($string) and year=extract(year from sysdate) and month<=extract(month from sysdate)                                                                             
            group by  fmt.policy_status                                        
            ) B group by B.pol_status

        "));


            }



            else{

             $chart_result = DB::select(DB::raw("
            select B.pol_status,sum(motor_car_gwp) as motor_car_gwp,sum(motor_nonCar_GWP) as motor_nonCar_GWP from
        (
              select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and agent_code='$agent_code'
            group by  fmt.pol_status


            union


            select fmt.policy_status as pol_status,
            sum(CASE WHEN (fmt.mtr_non_motor='Motor' or fmt.mtr_non_motor='motor') THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN (fmt.mtr_non_motor!='Motor' and fmt.mtr_non_motor!='motor') THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from Gi_Final_Gwp_Tcs fmt                                            
            where fmt.dept='MTR' and code='$agent_code' and year=extract(year from sysdate) and month<=extract(month from sysdate)                                                                             
            group by  fmt.policy_status                                        
            ) B group by B.pol_status

        "));

         }

        }
        else if($user_role == 'BRMGR'){



           /*  $chart_result = DB::select(DB::raw("
            select B.pol_status,sum(motor_car_gwp) as motor_car_gwp,sum(motor_nonCar_GWP) as motor_nonCar_GWP from
        (
              select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and agent_code in (select user_code from ge_sf_user_details where branch = '$user_branch' ) 
            group by  fmt.pol_status


            union


            select fmt.policy_status as pol_status,
            sum(CASE WHEN (fmt.mtr_non_motor='Motor' or fmt.mtr_non_motor='motor') THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN (fmt.mtr_non_motor!='Motor' and fmt.mtr_non_motor!='motor') THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from Gi_Final_Gwp_Tcs fmt                                            
            where fmt.dept='MTR' and code in (select user_code from ge_sf_user_details where branch = '$user_branch' ) 
            and year=extract(year from sysdate) and month<=extract(month from sysdate)                                                                             
            group by  fmt.policy_status                                        
            ) B group by B.pol_status

        "));*/

           $chart_result = DB::select(DB::raw("
            select B.pol_status,sum(motor_car_gwp) as motor_car_gwp,sum(motor_nonCar_GWP) as motor_nonCar_GWP from
        (
              select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and  business_party = 'AGENT' and assurance_code = '$user_branch'
            group by  fmt.pol_status


            union


            select fmt.policy_status as pol_status,
            sum(CASE WHEN (fmt.mtr_non_motor='Motor' or fmt.mtr_non_motor='motor') THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN (fmt.mtr_non_motor!='Motor' and fmt.mtr_non_motor!='motor') THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from Gi_Final_Gwp_Tcs fmt                                            
            where fmt.dept='MTR' and fmt.assurace_code = '$user_branch'
            and year=extract(year from sysdate) and month<=extract(month from sysdate)                                                                             
            group by  fmt.policy_status                                        
            ) B group by B.pol_status

        "));




            


        }
        else if($user_role == 'REMGR'){


                   $chart_result = DB::select(DB::raw("
            select B.pol_status,sum(motor_car_gwp) as motor_car_gwp,sum(motor_nonCar_GWP) as motor_nonCar_GWP from
        (
              select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and business_party = 'AGENT' and assurance_code  in (select branch from ge_sf_user_details where region = '$user_region' ) 
            group by  fmt.pol_status


            union


            select fmt.policy_status as pol_status,
            sum(CASE WHEN (fmt.mtr_non_motor='Motor' or fmt.mtr_non_motor='motor') THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN (fmt.mtr_non_motor!='Motor' and fmt.mtr_non_motor!='motor') THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from Gi_Final_Gwp_Tcs fmt                                            
            where fmt.dept='MTR' and business_party_new = 'AGENT' and assurace_code  in (select branch from ge_sf_user_details where region = '$user_region' ) 
            and year=extract(year from sysdate) and month<=extract(month from sysdate)                                                                             
            group by  fmt.policy_status                                        
            ) B group by B.pol_status

        "));


             

        }
        else if($user_role == 'ZOMGR'){


                   $chart_result = DB::select(DB::raw("
            select B.pol_status,sum(motor_car_gwp) as motor_car_gwp,sum(motor_nonCar_GWP) as motor_nonCar_GWP from
        (
              select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and fmt.business_party = 'AGENT' and fmt.assurance_code  in (select branch from ge_sf_user_details where zone = '$user_zone' ) 
            group by  fmt.pol_status


            union


            select fmt.policy_status as pol_status,
            sum(CASE WHEN (fmt.mtr_non_motor='Motor' or fmt.mtr_non_motor='motor') THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN (fmt.mtr_non_motor!='Motor' and fmt.mtr_non_motor!='motor') THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from Gi_Final_Gwp_Tcs fmt                                            
            where fmt.dept='MTR' and fmt.business_party_new = 'AGENT' and fmt.assurace_code  in (select branch from ge_sf_user_details where zone = '$user_zone' ) 
            and year=extract(year from sysdate) and month<=extract(month from sysdate)                                                                             
            group by  fmt.policy_status                                        
            ) B group by B.pol_status

        "));


            
        }else{


                   $chart_result = DB::select(DB::raw("
            select B.pol_status,sum(motor_car_gwp) as motor_car_gwp,sum(motor_nonCar_GWP) as motor_nonCar_GWP from
        (
              select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and business_party = 'AGENT' 
            group by  fmt.pol_status


            union


            select fmt.policy_status as pol_status,
            sum(CASE WHEN (fmt.mtr_non_motor='Motor' or fmt.mtr_non_motor='motor') THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN (fmt.mtr_non_motor!='Motor' and fmt.mtr_non_motor!='motor') THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from Gi_Final_Gwp_Tcs fmt                                            
            where fmt.dept='MTR' and business_party_new = 'AGENT' 
            and year=extract(year from sysdate) and month<=extract(month from sysdate)                                                                             
            group by  fmt.policy_status                                        
            ) B group by B.pol_status

        "));



        }
        
        
      
        return json_encode($chart_result);
    }

    //cumulative non motor class wise

    public function FMTNONMOTOR(){

        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];



        if($user_role == 'ADVISOR'){





                if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

          $chart_result = DB::select(DB::raw("
            select W.NEW_POLICY,
            round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
            round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
            round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
            round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
            round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
            round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
             from (select decode(t.pol_status,'ADDITION','ADDITION',
              'PPW-CANC','PPW-CANC',
              'RENEWAL','RENEWAL',
              'REINSTATE','REINSTATE',
              'CANCEL','CANCEL',
              'DELETION','DELETION',
              'NEW','NEW'
            ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
            where W.dept!='MOTOR' and agent_code in ($string)
            group by W.NEW_POLICY
        "));

            }



            else{

            $chart_result = DB::select(DB::raw("
            select W.NEW_POLICY,
            round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
            round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
            round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
            round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
            round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
            round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
             from (select decode(t.pol_status,'ADDITION','ADDITION',
              'PPW-CANC','PPW-CANC',
              'RENEWAL','RENEWAL',
              'REINSTATE','REINSTATE',
              'CANCEL','CANCEL',
              'DELETION','DELETION',
              'NEW','NEW'
            ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
            where W.dept!='MOTOR' and agent_code='$agent_code'
            group by W.NEW_POLICY
        "));
        }
        }
        else if($user_role == 'BRMGR'){

           /* $chart_result = DB::select(DB::raw("
            select W.NEW_POLICY,
            round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
            round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
            round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
            round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
            round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
            round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
             from (select decode(t.pol_status,'ADDITION','ADDITION',
              'PPW-CANC','PPW-CANC',
              'RENEWAL','RENEWAL',
              'REINSTATE','REINSTATE',
              'CANCEL','CANCEL',
              'DELETION','DELETION',
              'NEW','NEW'
            ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
            where W.dept!='MOTOR' and agent_code in (select user_code from ge_sf_user_details where branch = '$user_branch' )    
            group by W.NEW_POLICY
        "));*/

          $chart_result = DB::select(DB::raw("
            select W.NEW_POLICY,
            round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
            round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
            round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
            round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
            round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
            round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
             from (select decode(t.pol_status,'ADDITION','ADDITION',
              'PPW-CANC','PPW-CANC',
              'RENEWAL','RENEWAL',
              'REINSTATE','REINSTATE',
              'CANCEL','CANCEL',
              'DELETION','DELETION',
              'NEW','NEW'
            ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
            where W.dept!='MOTOR' and W.assurance_code = '$user_branch'   
            group by W.NEW_POLICY
        "));

            

        }
        else if($user_role == 'REMGR'){

             $chart_result = DB::select(DB::raw("
            select W.NEW_POLICY,
            round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
            round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
            round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
            round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
            round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
            round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
             from (select decode(t.pol_status,'ADDITION','ADDITION',
              'PPW-CANC','PPW-CANC',
              'RENEWAL','RENEWAL',
              'REINSTATE','REINSTATE',
              'CANCEL','CANCEL',
              'DELETION','DELETION',
              'NEW','NEW'
            ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
            where W.dept!='MOTOR' and W.business_party = 'AGENT' and W.assurance_code in (select branch from ge_sf_user_details where region = '$user_region'  )    
            group by W.NEW_POLICY
        "));


          
        }
        else if($user_role == 'ZOMGR'){


             $chart_result = DB::select(DB::raw("
            select W.NEW_POLICY,
            round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
            round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
            round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
            round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
            round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
            round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
             from (select decode(t.pol_status,'ADDITION','ADDITION',
              'PPW-CANC','PPW-CANC',
              'RENEWAL','RENEWAL',
              'REINSTATE','REINSTATE',
              'CANCEL','CANCEL',
              'DELETION','DELETION',
              'NEW','NEW'
            ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
            where W.dept!='MOTOR' and W.assurance_code in (select branch from ge_sf_user_details where zone = '$user_zone'  )    
            group by W.NEW_POLICY
        "));



            

        }else{


              $chart_result = DB::select(DB::raw("
            select W.NEW_POLICY,
            round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
            round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
            round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
            round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
            round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
            round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
             from (select decode(t.pol_status,'ADDITION','ADDITION',
              'PPW-CANC','PPW-CANC',
              'RENEWAL','RENEWAL',
              'REINSTATE','REINSTATE',
              'CANCEL','CANCEL',
              'DELETION','DELETION',
              'NEW','NEW'
            ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
            where W.dept!='MOTOR' and W.assurance_code in (select branch from ge_sf_user_details where USER_ROLE = 'ADVISOR' )  
            group by W.NEW_POLICY
        "));




        }


        return json_encode($chart_result);
    }


    //cumulative non motor class wise

    public function cumulativeNONMOTOR(){

        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];



        if($user_role == 'ADVISOR'){



                if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

       
              $chart_result = DB::select(DB::raw("
            select  B.NEW_POLICY,sum(MRN) MRN,sum(MED) MED,sum(MIS) MIS,sum(ENG) ENG,sum(FIR) FIR,sum(WCI) WCI from              
         (              
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MRN' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MIS' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIR' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.policy_status,'ADDITION','ADDITION',
          'PPW-CANC__','PPW-CANC',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'Renewal','RENEWAL',
          'Reinstate','REINSTATE',
          'PPW CANC','PPW-CANC',
          'REINSTATE','REINSTATE',
          'Additional','ADDITION',
          'CANCELLED','CANCEL',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW',
          'New','NEW',
          'ADDITIONAL','ADDITION'
        ) NEW_POLICY,t.* FROM Gi_Final_Gwp_Tcs t) W 
        where W.dept!='MTR' and code in ($string) and year=extract(year from sysdate) and month<extract(month from sysdate)
        group by W.NEW_POLICY
        
        union
        
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.pol_status,'ADDITION','ADDITION',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'REINSTATE','REINSTATE',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW'
        ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
        where W.dept!='MOTOR' and agent_code in ($string)
        group by W.NEW_POLICY
        ) B group by B.NEW_POLICY
        "));

            }



            else{

              $chart_result = DB::select(DB::raw("
            select  B.NEW_POLICY,sum(MRN) MRN,sum(MED) MED,sum(MIS) MIS,sum(ENG) ENG,sum(FIR) FIR,sum(WCI) WCI from              
         (              
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MRN' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MIS' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIR' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.policy_status,'ADDITION','ADDITION',
          'PPW-CANC__','PPW-CANC',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'Renewal','RENEWAL',
          'Reinstate','REINSTATE',
          'PPW CANC','PPW-CANC',
          'REINSTATE','REINSTATE',
          'Additional','ADDITION',
          'CANCELLED','CANCEL',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW',
          'New','NEW',
          'ADDITIONAL','ADDITION'
        ) NEW_POLICY,t.* FROM Gi_Final_Gwp_Tcs t) W 
        where W.dept!='MTR' and code='$agent_code' and year=extract(year from sysdate) and month<extract(month from sysdate)
        group by W.NEW_POLICY
        
        union
        
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.pol_status,'ADDITION','ADDITION',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'REINSTATE','REINSTATE',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW'
        ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
        where W.dept!='MOTOR' and agent_code='$agent_code'
        group by W.NEW_POLICY
        ) B group by B.NEW_POLICY
        "));

          }
        }
        else if($user_role == 'BRMGR'){

              /*$chart_result = DB::select(DB::raw("
            select  B.NEW_POLICY,sum(MRN) MRN,sum(MED) MED,sum(MIS) MIS,sum(ENG) ENG,sum(FIR) FIR,sum(WCI) WCI from              
         (              
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MRN' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MIS' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIR' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.policy_status,'ADDITION','ADDITION',
          'PPW-CANC__','PPW-CANC',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'Renewal','RENEWAL',
          'Reinstate','REINSTATE',
          'PPW CANC','PPW-CANC',
          'REINSTATE','REINSTATE',
          'Additional','ADDITION',
          'CANCELLED','CANCEL',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW',
          'New','NEW',
          'ADDITIONAL','ADDITION'
        ) NEW_POLICY,t.* FROM Gi_Final_Gwp_Tcs t) W 
        where W.dept!='MTR' and code in (select user_code from ge_sf_user_details where branch = '$user_branch' )  
         and year=extract(year from sysdate) and month<extract(month from sysdate)
        group by W.NEW_POLICY
        
        union
        
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.pol_status,'ADDITION','ADDITION',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'REINSTATE','REINSTATE',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW'
        ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
        where W.dept!='MOTOR' and agent_code in (select user_code from ge_sf_user_details where branch = '$user_branch' )  
        group by W.NEW_POLICY
        ) B group by B.NEW_POLICY
        "));*/


         $chart_result = DB::select(DB::raw("
            select  B.NEW_POLICY,sum(MRN) MRN,sum(MED) MED,sum(MIS) MIS,sum(ENG) ENG,sum(FIR) FIR,sum(WCI) WCI from              
         (              
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MRN' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MIS' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIR' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.policy_status,'ADDITION','ADDITION',
          'PPW-CANC__','PPW-CANC',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'Renewal','RENEWAL',
          'Reinstate','REINSTATE',
          'PPW CANC','PPW-CANC',
          'REINSTATE','REINSTATE',
          'Additional','ADDITION',
          'CANCELLED','CANCEL',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW',
          'New','NEW',
          'ADDITIONAL','ADDITION'
        ) NEW_POLICY,t.* FROM Gi_Final_Gwp_Tcs t) W 
        where W.dept!='MTR' and W.assurace_code = '$user_branch' 
         and year=extract(year from sysdate) and month<extract(month from sysdate)
        group by W.NEW_POLICY
        
        union
        
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.pol_status,'ADDITION','ADDITION',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'REINSTATE','REINSTATE',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW'
        ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
        where W.dept!='MOTOR' and business_party = 'AGENT' and assurance_code = '$user_branch'
        group by W.NEW_POLICY
        ) B group by B.NEW_POLICY
        "));

            


        }
        else if($user_role == 'REMGR'){

              $chart_result = DB::select(DB::raw("
            select  B.NEW_POLICY,sum(MRN) MRN,sum(MED) MED,sum(MIS) MIS,sum(ENG) ENG,sum(FIR) FIR,sum(WCI) WCI from              
         (              
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MRN' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MIS' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIR' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.policy_status,'ADDITION','ADDITION',
          'PPW-CANC__','PPW-CANC',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'Renewal','RENEWAL',
          'Reinstate','REINSTATE',
          'PPW CANC','PPW-CANC',
          'REINSTATE','REINSTATE',
          'Additional','ADDITION',
          'CANCELLED','CANCEL',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW',
          'New','NEW',
          'ADDITIONAL','ADDITION'
        ) NEW_POLICY,t.* FROM Gi_Final_Gwp_Tcs t) W 
        where W.dept!='MTR' and W.assurace_code  in (select branch from ge_sf_user_details where region = '$user_region' )  
         and year=extract(year from sysdate) and month<extract(month from sysdate)
        group by W.NEW_POLICY
        
        union
        
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.pol_status,'ADDITION','ADDITION',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'REINSTATE','REINSTATE',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW'
        ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
        where W.dept!='MOTOR' and business_party = 'AGENT' and assurance_code in (select branch from ge_sf_user_details where region = '$user_region' )  
        group by W.NEW_POLICY
        ) B group by B.NEW_POLICY
        "));

            

        }
        else if($user_role == 'ZOMGR'){

                      $chart_result = DB::select(DB::raw("
            select  B.NEW_POLICY,sum(MRN) MRN,sum(MED) MED,sum(MIS) MIS,sum(ENG) ENG,sum(FIR) FIR,sum(WCI) WCI from              
         (              
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MRN' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MIS' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIR' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.policy_status,'ADDITION','ADDITION',
          'PPW-CANC__','PPW-CANC',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'Renewal','RENEWAL',
          'Reinstate','REINSTATE',
          'PPW CANC','PPW-CANC',
          'REINSTATE','REINSTATE',
          'Additional','ADDITION',
          'CANCELLED','CANCEL',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW',
          'New','NEW',
          'ADDITIONAL','ADDITION'
        ) NEW_POLICY,t.* FROM Gi_Final_Gwp_Tcs t) W 
        where W.dept!='MTR' and  W.assurace_code  in (select branch from ge_sf_user_details where zone = '$user_zone' )  
         and year=extract(year from sysdate) and month<extract(month from sysdate)
        group by W.NEW_POLICY
        
        union
        
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.pol_status,'ADDITION','ADDITION',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'REINSTATE','REINSTATE',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW'
        ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
        where W.dept!='MOTOR' and business_party = 'AGENT' and assurance_code in (select branch from ge_sf_user_details where zone = '$user_zone' )  
        group by W.NEW_POLICY
        ) B group by B.NEW_POLICY
        "));

        }else{



                        $chart_result = DB::select(DB::raw("
            select  B.NEW_POLICY,sum(MRN) MRN,sum(MED) MED,sum(MIS) MIS,sum(ENG) ENG,sum(FIR) FIR,sum(WCI) WCI from              
         (              
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MRN' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MIS' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIR' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.policy_status,'ADDITION','ADDITION',
          'PPW-CANC__','PPW-CANC',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'Renewal','RENEWAL',
          'Reinstate','REINSTATE',
          'PPW CANC','PPW-CANC',
          'REINSTATE','REINSTATE',
          'Additional','ADDITION',
          'CANCELLED','CANCEL',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW',
          'New','NEW',
          'ADDITIONAL','ADDITION'
        ) NEW_POLICY,t.* FROM Gi_Final_Gwp_Tcs t) W 
        where W.dept!='MTR'
         and year=extract(year from sysdate) and month<extract(month from sysdate)
        group by W.NEW_POLICY
        
        union
        
        select W.NEW_POLICY,
        round(sum(CASE WHEN W.dept='MARINE' THEN W.gwp END ),2) MRN ,
        round(sum(CASE WHEN W.dept='MED' THEN W.gwp END ),2) MED,
        round(sum(CASE WHEN W.dept='MISC' THEN W.gwp END ),2) MIS,
        round(sum(CASE WHEN W.dept='ENGG' THEN W.gwp END ),2) ENG,
        round(sum(CASE WHEN W.dept='FIRE' THEN W.gwp END ),2) FIR,
        round(sum(CASE WHEN W.dept='WCI' THEN W.gwp END ),2) WCI
         from (select decode(t.pol_status,'ADDITION','ADDITION',
          'PPW-CANC','PPW-CANC',
          'RENEWAL','RENEWAL',
          'REINSTATE','REINSTATE',
          'CANCEL','CANCEL',
          'DELETION','DELETION',
          'NEW','NEW'
        ) NEW_POLICY,t.* FROM t_report_dncn_gwp_fmt t) W 
        where W.dept!='MOTOR' and  business_party = 'AGENT' 
        group by W.NEW_POLICY
        ) B group by B.NEW_POLICY
        "));

           


        }


        return json_encode($chart_result);
    }
    

    public function cumulativePOLICY(){

        $agent_code=$_SESSION['USER_CODE'];
        $user_role=$_SESSION['USER_ROLE'];

        $user_branch=$_SESSION['USER_BRANCH'];
        $user_region=$_SESSION['USER_REGION'];
        $user_zone=$_SESSION['USER_ZONE'];



        if($user_role == 'ADVISOR'){



                if(isset($_SESSION['LEADER_CODE'])){


                $codes  = json_decode($_SESSION['ADVISOR_TEAM_MEMBER_LIST']);

                $string  = "'MB000'";
              
                 foreach($codes as $i){

                    $code = $i->code;

                    $string = $string.",'".$code."'";

                }

         $chart_result = DB::select(DB::raw("
              select DECODE(FMT.DEPT,'MTR',decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),
            decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dn_cn_no) nop from Gi_Final_Gwp_Tcs fmt where code in ($string)
            and 
            year=extract(year from sysdate) and month<extract(month from sysdate)
            group by  DECODE(FMT.DEPT,'MTR',
            decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));

            }





            else{

            $chart_result = DB::select(DB::raw("
              select DECODE(FMT.DEPT,'MTR',decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),
            decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dn_cn_no) nop from Gi_Final_Gwp_Tcs fmt where code='$agent_code' 
            and 
            year=extract(year from sysdate) and month<extract(month from sysdate)
            group by  DECODE(FMT.DEPT,'MTR',
            decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));

        }

        }
        else if($user_role == 'BRMGR'){

   /*          $chart_result = DB::select(DB::raw("
              select DECODE(FMT.DEPT,'MTR',decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),
            decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dn_cn_no) nop from Gi_Final_Gwp_Tcs fmt where code in (select user_code from ge_sf_user_details where branch = '$user_branch' )  and 
            year=extract(year from sysdate) and month<extract(month from sysdate)
            group by  DECODE(FMT.DEPT,'MTR',
            decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));*/


              $chart_result = DB::select(DB::raw("
              select DECODE(FMT.DEPT,'MTR',decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),
            decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dn_cn_no) nop
             from Gi_Final_Gwp_Tcs fmt 

             where fmt.assurace_code = '$user_branch'   

             and 
            year=extract(year from sysdate) and month<extract(month from sysdate)
            group by  DECODE(FMT.DEPT,'MTR',
            decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));



        }
        else if($user_role == 'REMGR'){

           
             $chart_result = DB::select(DB::raw("
              select DECODE(FMT.DEPT,'MTR',decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),
            decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dn_cn_no) nop from Gi_Final_Gwp_Tcs fmt
             where fmt.assurace_code in (select branch from ge_sf_user_details where region = '$user_region' )  and 
            year=extract(year from sysdate) and month<extract(month from sysdate)
            group by  DECODE(FMT.DEPT,'MTR',
            decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));

          
        }
        else if($user_role == 'ZOMGR'){

            
             $chart_result = DB::select(DB::raw("
              select DECODE(FMT.DEPT,'MTR',decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),
            decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dn_cn_no) nop from Gi_Final_Gwp_Tcs fmt 

            where fmt.assurace_code in (select branch from ge_sf_user_details where zone = '$user_zone' )  and 

            year=extract(year from sysdate) and month<extract(month from sysdate)
            group by  DECODE(FMT.DEPT,'MTR',
            decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));
        }else{



             $chart_result = DB::select(DB::raw("
              select DECODE(FMT.DEPT,'MTR',decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),
            decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dn_cn_no) nop from Gi_Final_Gwp_Tcs fmt
             where   
            year=extract(year from sysdate) and month<extract(month from sysdate)
            group by  DECODE(FMT.DEPT,'MTR',
            decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));

            


        }



        return json_encode($chart_result);
    }
}


