<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class ZoneChartsController extends Controller
{
    public function zone_details(Request $request){


    	$key = $request->input("key");

            $Branch_result = DB::select(DB::raw("
 					select * from ge_sf_user_details where user_role = 'ZOMGR' and zone='$key'
            "));
            
        return json_encode($Branch_result);

    }

     public function chart1_0_1data_group_zone(Request $request){


    	 $key = $request->input("key");


             $chart_result = DB::select(DB::raw("
            SELECT  W.DEPT_NEW,round(sum(W.gwp),2) gwp FROM  (SELECT DECODE(t.dept,'MOTOR','MOTOR',
            'FIRE','FIRE',
            'MARINE','MARINE',
            'ENGG','ENGG',
            'MISC','MISC',
            'MED','MED',
            'WCI','WCI',
            '','MISC') DEPT_NEW,T.* FROM  T_REPORT_DNCN_GWP_FMT T) W 
            where W.business_party = 'AGENT' and W.assurance_code in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch)    
            group by W.DEPT_NEW
            order by W.DEPT_NEW

        "));

              return json_encode($chart_result);


    }

    public function chart1data_group_zone(Request $request){

    	$key = $request->input("key");


          $chart_result = DB::select(DB::raw("
            select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and fmt.business_party = 'AGENT' and fmt.assurance_code in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch ) 
            group by  fmt.pol_status

        "));

        return json_encode($chart_result);
    }


    public function chart2data_group_zone(Request $request){

    	$key = $request->input("key");

             $chart_result = DB::select(DB::raw("
            select DECODE(FMT.DEPT,'MOTOR',decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dncn_no) nop from t_report_dncn_gwp_fmt fmt 

            where  fmt.business_party = 'AGENT' and fmt.assurance_code in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch ) 

            group by  DECODE(FMT.DEPT,'MOTOR',
            decode(fmt.pol_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.pol_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));

             return json_encode($chart_result);


    }

    public function cumulative_cwg_group_zone(Request $request){

     $key = $request->input("key");


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
            where assurace_code in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch) 
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
            where assurance_code in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch) 
            group by W.DEPT_NEW
           )
           ) B group by B.DEPT_NEW

        "));

 return json_encode($chart_result);


    }


    public function chart4data_group_zone(Request $request){

    		     $key = $request->input("key");


    		      $chart_result = DB::select(DB::raw("
            select B.pol_status,sum(motor_car_gwp) as motor_car_gwp,sum(motor_nonCar_GWP) as motor_nonCar_GWP from
        	(
              select fmt.pol_status,
            sum(CASE WHEN fmt.risk_code='MOTOR-CAR' THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN fmt.risk_code !='MOTOR-CAR' THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from t_report_dncn_gwp_fmt fmt
            where fmt.dept='MOTOR' and  business_party = 'AGENT' and assurance_code in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch ) 
            group by  fmt.pol_status


            union


            select fmt.policy_status as pol_status,
            sum(CASE WHEN (fmt.mtr_non_motor='Motor' or fmt.mtr_non_motor='motor') THEN fmt.gwp
                END) motor_car_gwp,
                
                sum(CASE WHEN (fmt.mtr_non_motor!='Motor' and fmt.mtr_non_motor!='motor') THEN fmt.gwp
                END) motor_nonCar_GWP
            
            from Gi_Final_Gwp_Tcs fmt                                            
            where fmt.dept='MTR' and  business_party_new = 'AGENT' and fmt.assurace_code in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch) 
            and year=extract(year from sysdate) and month<=extract(month from sysdate)                                                                             
            group by  fmt.policy_status                                        
            ) B group by B.pol_status

        "));

    		       return json_encode($chart_result);

    }


    public function CMNOP_group_zone(Request $request){


    	  $key = $request->input("key");


              $chart_result = DB::select(DB::raw("
              select DECODE(FMT.DEPT,'MTR',decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL'),
            decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL')) as type
            ,round(sum(fmt.gwp),2) GWP,count(fmt.dn_cn_no) nop
             from Gi_Final_Gwp_Tcs fmt 

             where fmt.assurace_code in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch )    

             and 
            year=extract(year from sysdate) and month<extract(month from sysdate)
            group by  DECODE(FMT.DEPT,'MTR',
            decode(fmt.policy_status,'NEW','MOTOR_NEW','MOTOR_RENEWAL')
            ,decode(fmt.policy_status,'NEW','NONMOTOR_NEW','NONMOTOR_RENEWAL'))
        "));

                return json_encode($chart_result);


    }


    public function chart3data_group_zone(Request $request){

	  $key = $request->input("key");


	  $year = date('Y');
	  $month = date('m');



          $chart_result_1 = DB::select(DB::raw("
           select sum(t.mtr_target) as motor,sum(t.nm_target) as nonmotor
        from ge_sf_branch_tragets t 
        where t.branch in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch) 
               and t.year='$year' and t.month='$month'   
        "));
       $array=($chart_result_1);
        $motor_target=($array[0]->motor);
        $nonmotor_target=($array[0]->nonmotor);
        
        
        
        
        //getting achievement of the month
         $chart_result_2 = DB::select(DB::raw("
            select decode(t.class_code,'MTR','MOTOR','NONMOTOR') as TYPE,SUM(T.TARGET_AMT) TARGET_AMOUNT,
            (SELECT SUM(FMT.GWP) FROM T_REPORT_DNCN_GWP_FMT FMT 
            WHERE  FMT.business_party = 'AGENT' and FMT.assurance_code in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch) 

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


          return json_encode($data);


    }
}
