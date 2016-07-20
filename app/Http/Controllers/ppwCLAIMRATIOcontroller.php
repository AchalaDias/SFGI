<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Input;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class ppwCLAIMRATIOcontroller extends Controller
{

	public function claimRatio(){
        $agent_code=$_SESSION['USER_CODE'];
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
        //return response()->json(['data'=>$chart_result]);
        return json_encode($claim_result);
    }

    public function ppwRatio(){
        $agent_code=$_SESSION['USER_CODE'];
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
        //return response()->json(['data'=>$chart_result]);
        return json_encode($ppw_result);
    } 


    public function training_star_count(){
        $agent_code=$_SESSION['USER_CODE'];
	    if(isset($_SESSION['LEADER_CODE'])){
    		$star_result = DB::select(DB::raw("
	      		select 
	            	round((select count(*) from sf_training_details where code='$agent_code' and ROLE_TYPE='LEADER')/(select count(*) from sf_training_programs where TRAIN_CATEGORY='LEADER')*100,2) as percentage
	            from dual
	        "));
	    }else if(!isset($_SESSION['LEADER_CODE'])){
	    	$star_result = DB::select(DB::raw("
	      		select 
	            	round((select count(*) from sf_training_details where code='$agent_code' and ROLE_TYPE='ADVISOR')/(select count(*) from sf_training_programs where TRAIN_CATEGORY='ADVISOR')*100,2) as percentage
	            from dual
	        "));
	    }
	        
        //return response()->json(['data'=>$chart_result]);
        return json_encode($star_result);
    } 
}
