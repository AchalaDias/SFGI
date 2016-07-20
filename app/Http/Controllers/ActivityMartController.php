<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

use App\Quotation;


class ActivityMartController extends Controller{











    //---------------------------------------------sales plan ---------------------------------------//



    public function sales_plan (Request $request){

        $m = date("m");
        $y = date("Y");
        $agent = $request->session()->get('AGENT_CODE');


        $userRole =$request->session()->get('USERROLE');
        $branch = $request->session()->get('USERBRANCH');


        $zone =   $request->session()->get('USERZONE');

        $region =  $request->session()->get('USERREGION');

        $agent = $request->session()->get('AGENT_CODE');



        $result  = DB::select(DB::raw("SELECT * FROM SF_USER_SALES_ACTIVITIES  WHERE BANC_CODE = '$agent' AND ACTIVITY_YEAR = '$y'
AND  ACTIVITY_MONTH = '$m'"));



        switch ($userRole) {


            case "UWR":
                $sql = "  SELECT AGENT_NAME,AGENT_CODE FROM SF_USER_DETAILS WHERE COMPANY_CODE IS NULL AND AGENT_CODE = '$agent' AND USER_ROLE = 'UWR' ORDER BY AGENT_NAME";
                break;
            case "BRMGR":
                $sql = " SELECT AGENT_NAME,AGENT_CODE FROM SF_USER_DETAILS  WHERE COMPANY_CODE IS NULL AND (AGENT_BRANCH = '$branch' AND USER_ROLE = 'UWR') ORDER BY AGENT_NAME";
                break;
            case "REMGR":
                $sql = " SELECT AGENT_NAME,AGENT_CODE FROM SF_USER_DETAILS  WHERE COMPANY_CODE IS NULL AND (AGENT_REGION = '$region' AND USER_ROLE = 'UWR') ORDER BY AGENT_NAME";
                break;
            case "ZOMGR":
                $sql = " SELECT AGENT_NAME,AGENT_CODE FROM SF_USER_DETAILS  WHERE COMPANY_CODE IS NULL AND (AGENT_ZONE = '$zone' AND USER_ROLE = 'UWR') ORDER BY AGENT_NAME";
                break;



            case "MGR":
                $sql = "SELECT AGENT_NAME,AGENT_CODE FROM SF_USER_DETAILS WHERE COMPANY_CODE IS NULL AND USER_ROLE = 'UWR' ORDER BY AGENT_NAME";
                break;

            default:
        }


        $advisors = DB::select(DB::raw( $sql));






        if($userRole=="UWR"){

            return view('ActivityMart.salesplan')
                ->with("results",$result)
                ->with("advisors",$advisors);


        }
        else if($userRole == "BRMGR"){


            $summary = DB::select(DB::raw("SELECT F.SALES_ACTIVITY,SUM(F.FIRST_WEEK) as w1,SUM(F.SECOND_WEEK) as w2,SUM(F.THIRD_WEEK) as w3,SUM(F.FOURTH_WEEK) as w4 ,(select sales_activity   from sf_sales_activities where sales_code =F.SALES_ACTIVITY ) as activity_name
 FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code
WHERE F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
GROUP BY F.SALES_ACTIVITY
ORDER BY F.SALES_ACTIVITY ASC
 "));

            //  $editsum =DB::select(DB::raw(""));



            return view('ActivityMart.salesplan')

                ->with("advisors",$advisors)
                ->with("summary", $summary);



        }
        else if($userRole == "REMGR"){


            $summary = DB::select(DB::raw("SELECT F.SALES_ACTIVITY,SUM(F.FIRST_WEEK) as w1,SUM(F.SECOND_WEEK) as w2,SUM(F.THIRD_WEEK) as w3,SUM(F.FOURTH_WEEK) as w4,(select sales_activity   from sf_sales_activities where sales_code =F.SALES_ACTIVITY ) as activity_name
 FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_REGION = '$region' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code
WHERE F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
GROUP BY F.SALES_ACTIVITY
ORDER BY F.SALES_ACTIVITY ASC
 "));
            $branches = DB::select(DB::raw("select * from sf_branches where region_code='$region'"));

            return view('ActivityMart.salesplan')

                ->with("advisors",$advisors)
                ->with("summary", $summary)
                ->with("branches",$branches);



        }
        else if($userRole == "ZOMGR"){


            $summary = DB::select(DB::raw("SELECT F.SALES_ACTIVITY,SUM(F.FIRST_WEEK) as w1,SUM(F.SECOND_WEEK) as w2,SUM(F.THIRD_WEEK) as w3,SUM(F.FOURTH_WEEK) as w4 ,(select sales_activity   from sf_sales_activities where sales_code =F.SALES_ACTIVITY ) as activity_name
 FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_ZONE = '$zone' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code
WHERE F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
GROUP BY F.SALES_ACTIVITY
ORDER BY F.SALES_ACTIVITY ASC
 "));

            $regions = DB::select(DB::raw("select * from sf_regions where zonal_code='$zone'"));

            return view('ActivityMart.salesplan')

                ->with("advisors",$advisors)
                ->with("summary", $summary)
                ->with("regions",$regions);



        }



        else if($userRole == "MGR"){



            $zones =DB::table('sf_zonal')->get();


            return view('ActivityMart.salesplan')

                ->with("advisors",$advisors)
                ->with("zones", $zones);




        }


        else{




            return "YOU are not authorized to access this level. Please contact the system administrator";
        }













    }




    public function sales_plan_add(Request $request){


        $userRole =$request->session()->get('USERROLE');
        $branch = $request->session()->get('USERBRANCH');


        $zone =   $request->session()->get('USERZONE');

        $region =  $request->session()->get('USERREGION');

        $agent = $request->session()->get('AGENT_CODE');
        $m = date("m");
        $y = date("Y");

        $c = (count($request->input())/4);

        for($i=0;$i< $c;$i++){




            $num = ($i+1);
            $sactivity =  sprintf('%05d',$num);

            $tot = ($request->input($num.'1')+$request->input($num.'2')+$request->input($num.'3')+$request->input($num.'4'));

            DB::table('SF_USER_SALES_ACTIVITIES')->insert([
                'BANC_CODE' => $agent, 'SALES_ACTIVITY' => $sactivity, 'FIRST_WEEK' => $request->input($num.'1'), 'SECOND_WEEK' => $request->input($num.'2') , 'THIRD_WEEK' => $request->input($num.'3') , 'FOURTH_WEEK' => $request->input($num.'4') ,'ACTIVITY_MONTH' => $m, 'ACTIVITY_YEAR' => $y, 'ACTIVITY_TOT' => $tot
            ]);





        }






        return "success";


    }


    public function sales_plan_br_edit(Request $request){




        $m = date("m");
        $y = date("Y");


        $branch =    $request->input('branch');
        $rule = $request->input('rule');

        // add today date for where
        $result =  DB::select(DB::raw("Select L.w1, L.w2, L.w3, L.w4, L.agent_code , S.Agent_Name, S.agent_branch
 FROM
(SELECT  p.agent_code,    SUM(F.FIRST_WEEK) as w1,SUM(F.SECOND_WEEK) as w2,SUM(F.THIRD_WEEK) as w3,SUM(F.FOURTH_WEEK) as w4
FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE, T.AGENT_NAME,  T.AGENT_BRANCH  FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code
WHERE F.SALES_ACTIVITY = '$rule'
AND F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
GROUP BY P.AGENT_CODE
ORDER BY P.AGENT_CODE ASC) L

Join sf_user_details S ON L.agent_code = S.Agent_Code"));



        $current = DB::select(DB::raw("SELECT F.SALES_ACTIVITY,SUM(F.FIRST_WEEK) as w1,SUM(F.SECOND_WEEK) as w2,SUM(F.THIRD_WEEK) as w3,SUM(F.FOURTH_WEEK) as w4
 FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code
WHERE F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
AND F.SALES_ACTIVITY = '$rule'
GROUP BY F.SALES_ACTIVITY
ORDER BY F.SALES_ACTIVITY ASC
 "));

        $pending = DB::select(DB::raw("
SELECT * from sf_user_details F
WHERE F.AGENT_BRANCH = '$branch'
AND F.User_Role='UWR'
AND F.Agent_Code NOT IN (


SELECT  p.agent_code 
FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE, T.AGENT_NAME,  T.AGENT_BRANCH  FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code
WHERE F.SALES_ACTIVITY = '$rule'
AND F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
GROUP BY P.AGENT_CODE
 )"));


        return view('ActivityMart.salesplanBREDIT')
            ->with("results",$result)
            ->with("current",$current)
            ->with("pending",$pending);




    }



    public function sales_plan_br_update(Request $request){

        //send email

        $c = ( ( count($request->input()) - 1 )/5);

        for($i=0;$i< $c;$i++){

            DB::table('SF_USER_SALES_ACTIVITIES')
                ->where('BANC_CODE','=',$request->input('br'.$i.'2'))
                ->where('SALES_ACTIVITY','=',$request->input('ruleID'))
                ->update(['FIRST_WEEK' => $request->input('br'.$i.'1'),
                    'SECOND_WEEK' => $request->input('br'.$i.'3'),
                    'THIRD_WEEK' => $request->input('br'.$i.'4'),
                    'FOURTH_WEEK' => $request->input('br'.$i.'5')

                ]);




        }



        return "success";

    }



    public function sales_plan_reg_view(Request $request){

        $m = date("m");
        $y = date("Y");

        $branch =$request->input('branch');
        $region = $request->input('region');
        /*   $summary = DB::select(DB::raw("SELECT F.SALES_ACTIVITY,SUM(F.FIRST_WEEK) as w1,SUM(F.SECOND_WEEK) as w2,SUM(F.THIRD_WEEK) as w3,SUM(F.FOURTH_WEEK) as w4
 FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code
WHERE F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
GROUP BY F.SALES_ACTIVITY
ORDER BY F.SALES_ACTIVITY ASC
 ")); */


        $summary = DB::select(DB::raw("select * from 
(
SELECT F.SALES_ACTIVITY,SUM(F.FIRST_WEEK) as w1,SUM(F.SECOND_WEEK) as w2,SUM(F.THIRD_WEEK) as w3,SUM(F.FOURTH_WEEK) as w4 ,(select sales_activity   from sf_sales_activities where sales_code =F.SALES_ACTIVITY ) as activity_name
 FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code

WHERE F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
GROUP BY F.SALES_ACTIVITY
ORDER BY F.SALES_ACTIVITY ASC

) A


JOIN ( 
SELECT M.SALES_ACTIVITY as SF1,SUM(M.FIRST_WEEK) as ww1,SUM(M.SECOND_WEEK) as ww2,SUM(M.THIRD_WEEK) as ww3,SUM(M.FOURTH_WEEK) as ww4
 FROM SF_USER_SALES_ACTIVITIES M
JOIN (SELECT L.AGENT_CODE FROM SF_USER_DETAILS L WHERE L.AGENT_REGION = '$region' AND L.User_Role='UWR' ) X ON X.AGENT_CODE = M.Banc_Code
WHERE M.ACTIVITY_YEAR = '$y'
AND M.ACTIVITY_MONTH = '$m'
GROUP BY M.SALES_ACTIVITY
ORDER BY M.SALES_ACTIVITY ASC

) S ON S.SF1 = A.SALES_ACTIVITY"));


        //  $editsum =DB::select(DB::raw(""));



        return view('ActivityMart.salesplanREG')
            ->with("summary", $summary)
            ->with('branch',$branch);










    }



    public function sales_plan_get_branches(Request $request){


        $region = $request->input('region');

        $branches = DB::select(DB::raw("Select * from  sf_branches where region_code='$region'"));

        return  $branches;

    }





    public function sales_plan_get_regionstats(Request $request){


        $m = date("m");
        $y = date("Y");


        $region = $request->input('region');
        $zone =  $request->input('zone');
        /*   $summary = DB::select(DB::raw("SELECT F.SALES_ACTIVITY,SUM(F.FIRST_WEEK) as w1,SUM(F.SECOND_WEEK) as w2,SUM(F.THIRD_WEEK) as w3,SUM(F.FOURTH_WEEK) as w4
 FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code
WHERE F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
GROUP BY F.SALES_ACTIVITY
ORDER BY F.SALES_ACTIVITY ASC
 ")); */


        $summary = DB::select(DB::raw("select * from 
(
SELECT F.SALES_ACTIVITY,SUM(F.FIRST_WEEK) as w1,SUM(F.SECOND_WEEK) as w2,SUM(F.THIRD_WEEK) as w3,SUM(F.FOURTH_WEEK) as w4 ,(select sales_activity   from sf_sales_activities where sales_code =F.SALES_ACTIVITY ) as activity_name
 FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_REGION= '$region' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code

WHERE F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
GROUP BY F.SALES_ACTIVITY
ORDER BY F.SALES_ACTIVITY ASC

) A


JOIN ( 
SELECT M.SALES_ACTIVITY as SF1,SUM(M.FIRST_WEEK) as ww1,SUM(M.SECOND_WEEK) as ww2,SUM(M.THIRD_WEEK) as ww3,SUM(M.FOURTH_WEEK) as ww4
 FROM SF_USER_SALES_ACTIVITIES M
JOIN (SELECT L.AGENT_CODE FROM SF_USER_DETAILS L WHERE L.AGENT_ZONE = '$zone' AND L.User_Role='UWR' ) X ON X.AGENT_CODE = M.Banc_Code
WHERE M.ACTIVITY_YEAR = '$y'
AND M.ACTIVITY_MONTH = '$m'
GROUP BY M.SALES_ACTIVITY
ORDER BY M.SALES_ACTIVITY ASC

) S ON S.SF1 = A.SALES_ACTIVITY"));


        //  $editsum =DB::select(DB::raw(""));



        return view('ActivityMart.salesplanZONE')
            ->with("summary", $summary);


    }




    public function sales_plan_get_regions(Request $request){



        $zone = $request->input('zone');

        $regions = DB::select(DB::raw("Select * from  sf_regions  where zonal_code='$zone'"));

        return  $regions;






    }

    public function sales_plan_get_zonestats(Request $request){

        $m = date("m");
        $y = date("Y");


        $zone = $request->input('zone');


        $summary = DB::select(DB::raw("SELECT F.SALES_ACTIVITY,SUM(F.FIRST_WEEK) as w1,SUM(F.SECOND_WEEK) as w2,SUM(F.THIRD_WEEK) as w3,SUM(F.FOURTH_WEEK) as w4 ,(select sales_activity   from sf_sales_activities where sales_code =F.SALES_ACTIVITY ) as activity_name
 FROM SF_USER_SALES_ACTIVITIES F
JOIN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_ZONE = '$zone' AND T.User_Role='UWR' ) P ON P.AGENT_CODE = F.Banc_Code
WHERE F.ACTIVITY_YEAR = '$y'
AND F.ACTIVITY_MONTH = '$m'
GROUP BY F.SALES_ACTIVITY
ORDER BY F.SALES_ACTIVITY ASC
 "));


        return view('ActivityMart.salesplanMGR')
            ->with("summary", $summary);


    }










    //-------------------------------------- end--------------------------------------//

    //-----------------------------------activity_result---------------------------------//

    public function activity_result(Request $request){

        $m = date("m");
        $y = date("Y");

        $month = $m-1;
        $year =$y;

        if($month == 0){
            $month = 12;
            $year = $y - 1;

        }
        $userRole =$request->session()->get('USERROLE');
        $branch = $request->session()->get('USERBRANCH');


        $zone =   $request->session()->get('USERZONE');

        $region =  $request->session()->get('USERREGION');

        $agent = $request->session()->get('AGENT_CODE');


        switch ($userRole) {



            case "UWR":
                $sql = "SELECT AGENT_NAME,AGENT_CODE FROM SF_USER_DETAILS  WHERE   AGENT_CODE = '$agent' AND USER_ROLE = 'UWR' ORDER BY AGENT_NAME";
                break;

            case "BRMGR":
                /*                $sql = " (SELECT A.AGENT_CODE FROM SF_AGENT_HISTORY A WHERE
                  A.MONTH = '$month' AND A.YEAR = '$year' AND A.status = 'ACTIVE' AND A.BRANCH = '$branch'
                  )UNION
                  (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_BRANCH = '$branch' AND TYPE = 'BANC' AND USER_ROLE = 'UWR')

                 ";*/
                $sql = "  (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_BRANCH = '$branch' AND TYPE = 'BANC' AND USER_ROLE = 'UWR')   
 union 
  (
  select agt_code as agent_code from sfms_agent_details c where agt_branch_code IN (SELECT BRANCH_CODE FROM SF_BRANCHES WHERE BRANCH_CODE = '$branch')
  AND c.agt_terminate_ind = 'NO'
       )
";
                break;

            case "REMGR":

                /*                $sql =" (SELECT A.AGENT_CODE FROM SF_AGENT_HISTORY A WHERE
                  A.MONTH = '$month' AND A.YEAR = '$year' AND A.status = 'ACTIVE' AND A.BRANCH  IN (SELECT BRANCH_CODE FROM SF_BRANCHES WHERE REGION_CODE = '$region')
                  )UNION
                  (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_REGION = '$region' AND TYPE = 'BANC' AND USER_ROLE = 'UWR')

                 ";*/
                $sql = "  (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_REGION = '$region' AND TYPE = 'BANC' AND USER_ROLE = 'UWR')   
 union 
  (
  select agt_code as agent_code from sfms_agent_details c where agt_branch_code IN (SELECT BRANCH_CODE FROM SF_BRANCHES WHERE REGION_CODE = '$region')
  AND c.agt_terminate_ind = 'NO'
       )
";


                break;

            case "ZOMGR":

                /*
                $sql = " (SELECT A.AGENT_CODE FROM SF_AGENT_HISTORY A WHERE
                  A.MONTH = '$month' AND A.YEAR = '$year' AND A.status = 'ACTIVE' AND A.BRANCH  IN (SELECT BRANCH_CODE FROM SF_BRANCHES WHERE ZONAL_CODE = '$zone')
                  )UNION
                  (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_ZONE = '$zone' AND TYPE = 'BANC' AND USER_ROLE = 'UWR')

                 ";*/

                $sql = "  (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_ZONE = '$zone' AND TYPE = 'BANC' AND USER_ROLE = 'UWR')   
 union 
  (
  select agt_code as agent_code from sfms_agent_details c where agt_branch_code IN (SELECT BRANCH_CODE FROM SF_BRANCHES WHERE ZONAL_CODE = '$zone')
  AND c.agt_terminate_ind = 'NO'
       )
";
                break;



            case "MGR":
                $sql = " (SELECT A.AGENT_CODE FROM SF_AGENT_HISTORY A WHERE 
  A.MONTH = '$month' AND A.YEAR = '$year' AND A.status = 'ACTIVE'  
  )UNION
  (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE   TYPE = 'BANC' AND USER_ROLE = 'UWR')

 ";
                break;


            default:
        }
        if($request->session()->get('USERTYPE') == 'ADV'){

            $temp = DB::table('sfms_agent_details')->where('agt_code','=',$agent)->get();

            if(empty($temp)){


                return "sorry we couldn't find your agent code in Biscoa Table";
            }
            $agent_super = $temp[0]->agt_id;

            $sql = "
                SELECT  B.Agent_Code as agent_code,
                (Select C.AGT_FULL_NAME as agent_name from sfms_agent_details C where C.AGT_CODE = B.Agent_Code) as agent_name

                FROM 
                SF_AGENT_HISTORY B
                WHERE 
                B.Month = '$month' AND B.Year = '$year'
                AND
                (B.TEAM_CODE IN (select A.LEADER_CODE from sf_agent_history A
                where A.month = '$month' and A.year ='$year'
                AND A.agent_Code = '$agent') 
                OR B.GROUP_CODE IN (select A.LEADER_CODE from sf_agent_history A
                where A.month = '$month' and A.year ='$year'
                AND A.agent_Code = '$agent')
                OR B.AGFM IN (select A.LEADER_CODE from sf_agent_history A
                where A.month = '$month' and A.year ='$year'
                AND A.agent_Code = '$agent')
                OR B.agent_code = '$agent')
                AND B.STATUS = 'ACTIVE'
                ";


        }




        $results = DB::select(DB::raw($sql));


        if($userRole == "UWR"){


            $summary = DB::select(DB::raw("SELECT  ACTIVITY, DECODE(FIRST_WEEK,0,0,FIRST_WEEK) AS FIRST_WEEK,  FIRST_ACTUAL,  
                  DECODE(SECOND_WEEK,0,0,SECOND_WEEK) AS SECOND_WEEK,  SECOND_ACTUAL,   
                  DECODE(THIRD_WEEK,0,0,THIRD_WEEK) AS THIRD_WEEK,THIRD_ACTUAL, 
                  DECODE(FOURTH_WEEK,0,0,FOURTH_WEEK)AS FOURTH_WEEK, FOURTH_ACTUAL,   
                  ACTUAL,  PLANNED,    DECODE(PLANNED,0,0,ROUND((ACTUAL/PLANNED) * 100,2)) AS ACHIVE  
                  FROM  
                    (SELECT SA.SALES_ACTIVITY AS ACTIVITY,T.FIRST_WEEK AS FIRST_WEEK,  
                        T.SECOND_WEEK AS SECOND_WEEK,T.THIRD_WEEK AS THIRD_WEEK  
                             ,T.FOURTH_WEEK AS FOURTH_WEEK,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)  
                             FROM SF_LEAD_FOLLOWUP FOL 
                              WHERE  
                             EXTRACT(MONTH FROM FOL.EVENT_DATE) =  '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE) = '$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY  
                             AND FOL.USER_ID = '$agent') AS ACTUAL,  
                             (SELECT SUM(S.FIRST_WEEK) + SUM(T.SECOND_WEEK) + SUM(T.THIRD_WEEK) + SUM(T.FOURTH_WEEK)   
                             FROM SF_USER_SALES_ACTIVITIES S WHERE  
                             S.BANC_CODE = '$agent' 
                             AND S.ACTIVITY_MONTH = '$m'
                             AND S.ACTIVITY_YEAR = '$y'
                             AND S.SALES_ACTIVITY = T.SALES_ACTIVITY  
                             ) AS PLANNED,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL    
                             WHERE  
                             EXTRACT(DAY FROM  FOL.EVENT_DATE ) >= 1  
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE ) <= 7 
                            and EXTRACT(MONTH FROM FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) ='$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID = '$agent') AS FIRST_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL   
                             WHERE  
                             EXTRACT(DAY FROM FOL.EVENT_DATE ) >= 8 
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE ) <= 14  
                             AND EXTRACT(MONTH FROM  FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) = '$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID = '$agent') AS SECOND_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)    
                             FROM SF_LEAD_FOLLOWUP FOL   
                             WHERE   
                             EXTRACT(DAY FROM FOL.EVENT_DATE ) >= 15  
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE  ) <= 21  
                             and EXTRACT(MONTH FROM  FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) = '$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID = '$agent') AS THIRD_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL   
                             WHERE 
                             EXTRACT(DAY FROM  FOL.EVENT_DATE ) >= 22  
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE ) <= 31  
                             and EXTRACT(MONTH FROM  FOL.EVENT_DATE ) =  '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) = '$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID = '$agent') AS FOURTH_ACTUAL  
                             FROM SF_USER_SALES_ACTIVITIES T,SF_SALES_ACTIVITIES SA  
                            WHERE  
                            T.BANC_CODE = '$agent'  
                             AND T.ACTIVITY_MONTH = '$m'
                             AND T.ACTIVITY_YEAR = '$y'
                             AND T.SALES_ACTIVITY = SA.SALES_CODE  
                             ORDER BY T.SALES_ACTIVITY ASC)"));




            return view('ActivityMart.activity_result')
                ->with("results", $results)
                ->with("summary",$summary);


        }

        else{






            return view('ActivityMart.activity_result')
                ->with("results", $results);







        }

















    }

    public function activity_result_ajax(Request $request){



        $agent =     $request->input('branch');
        $m =   $request->input('month');
        $y  =    $request->input('year');

        $summary = DB::select(DB::raw("SELECT  ACTIVITY, DECODE(FIRST_WEEK,0,0,FIRST_WEEK) AS FIRST_WEEK,  FIRST_ACTUAL,  
                  DECODE(SECOND_WEEK,0,0,SECOND_WEEK) AS SECOND_WEEK,  SECOND_ACTUAL,   
                  DECODE(THIRD_WEEK,0,0,THIRD_WEEK) AS THIRD_WEEK,THIRD_ACTUAL, 
                  DECODE(FOURTH_WEEK,0,0,FOURTH_WEEK)AS FOURTH_WEEK, FOURTH_ACTUAL,   
                  ACTUAL,  PLANNED,   DECODE(PLANNED,0,0,ROUND((ACTUAL/PLANNED) * 100,2))  AS ACHIVE  
                  FROM  
                    (SELECT SA.SALES_ACTIVITY AS ACTIVITY,T.FIRST_WEEK AS FIRST_WEEK,  
                        T.SECOND_WEEK AS SECOND_WEEK,T.THIRD_WEEK AS THIRD_WEEK  
                             ,T.FOURTH_WEEK AS FOURTH_WEEK,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)  
                             FROM SF_LEAD_FOLLOWUP FOL 
                              WHERE  
                             EXTRACT(MONTH FROM FOL.EVENT_DATE) =  '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE) = '$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY  
                             AND FOL.USER_ID = '$agent') AS ACTUAL,  
                             (SELECT SUM(S.FIRST_WEEK) + SUM(T.SECOND_WEEK) + SUM(T.THIRD_WEEK) + SUM(T.FOURTH_WEEK)   
                             FROM SF_USER_SALES_ACTIVITIES S WHERE  
                             S.BANC_CODE = '$agent' 
                             AND S.ACTIVITY_MONTH = '$m'
                             AND S.ACTIVITY_YEAR = '$y'
                             AND S.SALES_ACTIVITY = T.SALES_ACTIVITY  
                             ) AS PLANNED,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL    
                             WHERE  
                             EXTRACT(DAY FROM  FOL.EVENT_DATE ) >= 1  
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE ) <= 7 
                            and EXTRACT(MONTH FROM FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) ='$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID = '$agent') AS FIRST_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL   
                             WHERE  
                             EXTRACT(DAY FROM FOL.EVENT_DATE ) >= 8 
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE ) <= 14  
                             AND EXTRACT(MONTH FROM  FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) = '$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID = '$agent') AS SECOND_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)    
                             FROM SF_LEAD_FOLLOWUP FOL   
                             WHERE   
                             EXTRACT(DAY FROM FOL.EVENT_DATE ) >= 15  
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE  ) <= 21  
                             and EXTRACT(MONTH FROM  FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) = '$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID = '$agent') AS THIRD_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL   
                             WHERE 
                             EXTRACT(DAY FROM  FOL.EVENT_DATE ) >= 22  
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE ) <= 31  
                             and EXTRACT(MONTH FROM  FOL.EVENT_DATE ) =  '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) = '$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID = '$agent') AS FOURTH_ACTUAL  
                             FROM SF_USER_SALES_ACTIVITIES T,SF_SALES_ACTIVITIES SA  
                            WHERE  
                            T.BANC_CODE = '$agent'  
                             AND T.ACTIVITY_MONTH = '$m'
                             AND T.ACTIVITY_YEAR = '$y'
                             AND T.SALES_ACTIVITY = SA.SALES_CODE  
                             ORDER BY T.SALES_ACTIVITY ASC)"));


        return view('ActivityMart.activity_resultSearch')
            ->with("summary", $summary);



    }

    public function activity_result_summary(Request $request){

        $m = date("m");
        $y = date("Y");

        $userRole =$request->session()->get('USERROLE');
        $branch = $request->session()->get('USERBRANCH');


        $zone =   $request->session()->get('USERZONE');

        $region =  $request->session()->get('USERREGION');

        $agent = $request->session()->get('AGENT_CODE');





        if($userRole == 'UWR'){
            return view('Stats.progress_error')
                ->with('error1',"Sorry! You are not authorized to access this feature ")
                ->with('error2',"");

        }
        else if($userRole == 'BRMGR'){


            $br= DB::table("sf_branches")->where("branch_code","=",$branch)->get();

            return view('ActivityMart.activity_summary')
                ->with("branches",$br);

        }
        else if($userRole == 'REMGR'){


            $regions = DB::table("sf_regions")->where("region_code","=",$region)->get();
            $br= DB::table("sf_branches")->where("region_code","=",$region)->get();

            return view('ActivityMart.activity_summary')
                ->with("branches",$br)
                ->with("regions",$regions);

        }

        else if($userRole == 'ZOMGR'){

            $zones = DB::table("sf_zonal")->where("zonal_code","=",$zone)->get();
            $regions = DB::table("sf_regions")->where("zonal_code","=",$zone)->get();
            // $br= DB::table("sf_branches")->where("region_code","=",$region)->get();

            return view('ActivityMart.activity_summary')
                // ->with("branches",$br)
                ->with("regions",$regions)
                ->with ("zones",$zones);

        }


        else if($userRole == 'MGR'){

            $zones = DB::table("sf_zonal")->get();



            return view('ActivityMart.activity_summary')

                ->with ("zones",$zones);

        }

        //$zone = DB::select(DB::raw("SELECT ZONAL_NAME,ZONAL_CODE FROM SF_ZONAL  WHERE ZONAL_CODE = '$zone'  ORDER BY ZONAL_ID ASC"));

        //$branches = DB::select(DB::raw("SELECT BRANCH_CODE,BRANCH_NAME FROM SF_BRANCHES  WHERE BRANCH_CODE = '$branch'   "));

        //$region = DB::select(DB::raw("SELECT REGION_CODE,REGION_NAME FROM SF_REGIONS  WHERE SF_REGIONS = '$region'   "));

        return view('ActivityMart.activity_summary');


    }


    public function activity_summary_brajax (Request $request){





        $branch =     $request->input('branch');
        $m =   $request->input('month');
        $y  =    $request->input('year');

        $summary = DB::select(DB::raw(" 
SELECT  ACTIVITY,   FIRST_WEEK,  NVL(FIRST_ACTUAL,0) AS FIRST_ACTUAL,   
                            SECOND_WEEK,   
                         NVL(SECOND_ACTUAL,0) AS SECOND_ACTUAL,  
                             THIRD_WEEK,    
                              NVL(THIRD_ACTUAL,0) AS THIRD_ACTUAL,  
                              FOURTH_WEEK,   
                              NVL(FOURTH_ACTUAL,0) AS FOURTH_ACTUAL,   
                              NVL(ACTUAL,0) AS ACTUAL,    
							           (FIRST_WEEK + SECOND_WEEK + THIRD_WEEK + FOURTH_WEEK) as PLANNED,
                        DECODE(ACTUAL,0,0,NVL(ROUND((ACTUAL/(FIRST_WEEK + SECOND_WEEK + THIRD_WEEK + FOURTH_WEEK)) * 100,2),0)) AS ACHIVE
                             FROM  
                             (SELECT (SELECT SAT.SALES_ACTIVITY FROM SF_SALES_ACTIVITIES SAT WHERE SAT.SALES_CODE = T.SALES_ACTIVITY) AS ACTIVITY,SUM(T.FIRST_WEEK) AS FIRST_WEEK, 
                             SUM(T.SECOND_WEEK) AS SECOND_WEEK,SUM(T.THIRD_WEEK) AS THIRD_WEEK  
                             ,SUM(T.FOURTH_WEEK) AS FOURTH_WEEK,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL  
                             WHERE   
                             EXTRACT(MONTH FROM  FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) ='$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY  
                             AND FOL.USER_ID IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch')) AS ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL   
                             WHERE   
                             EXTRACT(DAY FROM  FOL.EVENT_DATE ) >= 1  
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE ) <= 7  
                             AND EXTRACT(MONTH FROM  FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) ='$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY    
                             AND FOL.USER_ID  IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch')) AS FIRST_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)     
                           FROM SF_LEAD_FOLLOWUP FOL  
                             WHERE  
                             EXTRACT(DAY FROM FOL.EVENT_DATE) >= 8  
                              AND EXTRACT(DAY FROM FOL.EVENT_DATE) <= 14 
                            AND EXTRACT(MONTH FROM FOL.EVENT_DATE) = '$m'
                              AND EXTRACT(YEAR FROM FOL.EVENT_DATE) = '$y'
                              AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch')) AS SECOND_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)    
                              FROM SF_LEAD_FOLLOWUP FOL   
                              WHERE   
                             EXTRACT(DAY FROM FOL.EVENT_DATE) >= 15  
                             AND EXTRACT(DAY FROM FOL.EVENT_DATE) <= 21  
                              AND EXTRACT(MONTH FROM FOL.EVENT_DATE) = '$m'
                              AND EXTRACT(YEAR FROM FOL.EVENT_DATE) = '$y'
                              AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch')) AS THIRD_ACTUAL,  
                              (SELECT COUNT(FOL.JOB_STATUS_CODE)    
                             FROM SF_LEAD_FOLLOWUP FOL   
                              WHERE  
                              EXTRACT(DAY FROM FOL.EVENT_DATE) >= 22  
                              AND EXTRACT(DAY FROM FOL.EVENT_DATE) <= 31  
                              AND EXTRACT(MONTH FROM FOL.EVENT_DATE) = '$m'
                              AND EXTRACT(YEAR FROM FOL.EVENT_DATE) = '$y'
                              AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY  
                              AND FOL.USER_ID  IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch') ) AS FOURTH_ACTUAL  
                              FROM SF_USER_SALES_ACTIVITIES T,SF_SALES_ACTIVITIES SA  
                              WHERE  
                              T.BANC_CODE IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_BRANCH = '$branch')
                              AND T.ACTIVITY_MONTH = '$m'
                              AND T.ACTIVITY_YEAR =  '$y'
                              AND T.SALES_ACTIVITY = SA.SALES_CODE  
                              GROUP BY T.SALES_ACTIVITY  
                              ORDER BY T.SALES_ACTIVITY ASC)"));




        return view('ActivityMart.activity_resultSearch')
            ->with("summary", $summary);


        /*



    */


    }


    public function activity_summary_reajax(Request $request){



        $region =     $request->input('region');
        $m =   $request->input('month');
        $y  =    $request->input('year');

        $summary = DB::select(DB::raw(" 
SELECT  ACTIVITY,   FIRST_WEEK,  NVL(FIRST_ACTUAL,0) AS FIRST_ACTUAL,   
                            SECOND_WEEK,   
                         NVL(SECOND_ACTUAL,0) AS SECOND_ACTUAL,  
                             THIRD_WEEK,    
                              NVL(THIRD_ACTUAL,0) AS THIRD_ACTUAL,  
                              FOURTH_WEEK,   
                              NVL(FOURTH_ACTUAL,0) AS FOURTH_ACTUAL,   
                              NVL(ACTUAL,0) AS ACTUAL,    
							           (FIRST_WEEK + SECOND_WEEK + THIRD_WEEK + FOURTH_WEEK) as PLANNED,
                              DECODE(ACTUAL,0,0,NVL(ROUND((ACTUAL/(FIRST_WEEK + SECOND_WEEK + THIRD_WEEK + FOURTH_WEEK)) * 100,2),0)) AS ACHIVE
                             FROM  
                             (SELECT (SELECT SAT.SALES_ACTIVITY FROM SF_SALES_ACTIVITIES SAT WHERE SAT.SALES_CODE = T.SALES_ACTIVITY) AS ACTIVITY,SUM(T.FIRST_WEEK) AS FIRST_WEEK, 
                             SUM(T.SECOND_WEEK) AS SECOND_WEEK,SUM(T.THIRD_WEEK) AS THIRD_WEEK  
                             ,SUM(T.FOURTH_WEEK) AS FOURTH_WEEK,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL  
                             WHERE   
                             EXTRACT(MONTH FROM  FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) ='$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY  
                             AND FOL.USER_ID IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_REGION = '$region')) AS ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL   
                             WHERE   
                             EXTRACT(DAY FROM  FOL.EVENT_DATE ) >= 1  
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE ) <= 7  
                             AND EXTRACT(MONTH FROM  FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) ='$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY    
                             AND FOL.USER_ID  IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_REGION = '$region')) AS FIRST_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)     
                           FROM SF_LEAD_FOLLOWUP FOL  
                             WHERE  
                             EXTRACT(DAY FROM FOL.EVENT_DATE) >= 8  
                              AND EXTRACT(DAY FROM FOL.EVENT_DATE) <= 14 
                            AND EXTRACT(MONTH FROM FOL.EVENT_DATE) = '$m'
                              AND EXTRACT(YEAR FROM FOL.EVENT_DATE) = '$y'
                              AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_REGION = '$region')) AS SECOND_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)    
                              FROM SF_LEAD_FOLLOWUP FOL   
                              WHERE   
                             EXTRACT(DAY FROM FOL.EVENT_DATE) >= 15  
                             AND EXTRACT(DAY FROM FOL.EVENT_DATE) <= 21  
                              AND EXTRACT(MONTH FROM FOL.EVENT_DATE) = '$m'
                              AND EXTRACT(YEAR FROM FOL.EVENT_DATE) = '$y'
                              AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_REGION = '$region')) AS THIRD_ACTUAL,  
                              (SELECT COUNT(FOL.JOB_STATUS_CODE)    
                             FROM SF_LEAD_FOLLOWUP FOL   
                              WHERE  
                              EXTRACT(DAY FROM FOL.EVENT_DATE) >= 22  
                              AND EXTRACT(DAY FROM FOL.EVENT_DATE) <= 31  
                              AND EXTRACT(MONTH FROM FOL.EVENT_DATE) = '$m'
                              AND EXTRACT(YEAR FROM FOL.EVENT_DATE) = '$y'
                              AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY  
                              AND FOL.USER_ID  IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_REGION = '$region') ) AS FOURTH_ACTUAL  
                              FROM SF_USER_SALES_ACTIVITIES T,SF_SALES_ACTIVITIES SA  
                              WHERE  
                              T.BANC_CODE IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_REGION = '$region')
                              AND T.ACTIVITY_MONTH = '$m'
                              AND T.ACTIVITY_YEAR =  '$y'
                              AND T.SALES_ACTIVITY = SA.SALES_CODE  
                              GROUP BY T.SALES_ACTIVITY  
                              ORDER BY T.SALES_ACTIVITY ASC)"));




        return view('ActivityMart.activity_resultSearch')
            ->with("summary", $summary);






    }





    public function activity_summary_zoajax(Request $request){



        $zone =     $request->input('zone');
        $m =   $request->input('month');
        $y  =    $request->input('year');

        $summary = DB::select(DB::raw(" 
SELECT  ACTIVITY,   FIRST_WEEK,  NVL(FIRST_ACTUAL,0) AS FIRST_ACTUAL,   
                            SECOND_WEEK,   
                         NVL(SECOND_ACTUAL,0) AS SECOND_ACTUAL,  
                             THIRD_WEEK,    
                              NVL(THIRD_ACTUAL,0) AS THIRD_ACTUAL,  
                              FOURTH_WEEK,   
                              NVL(FOURTH_ACTUAL,0) AS FOURTH_ACTUAL,   
                              NVL(ACTUAL,0) AS ACTUAL,    
							           (FIRST_WEEK + SECOND_WEEK + THIRD_WEEK + FOURTH_WEEK) as PLANNED,
                          DECODE(ACTUAL,0,0,NVL(ROUND((ACTUAL/(FIRST_WEEK + SECOND_WEEK + THIRD_WEEK + FOURTH_WEEK)) * 100,2),0)) AS ACHIVE
                             FROM  
                             (SELECT (SELECT SAT.SALES_ACTIVITY FROM SF_SALES_ACTIVITIES SAT WHERE SAT.SALES_CODE = T.SALES_ACTIVITY) AS ACTIVITY,SUM(T.FIRST_WEEK) AS FIRST_WEEK, 
                             SUM(T.SECOND_WEEK) AS SECOND_WEEK,SUM(T.THIRD_WEEK) AS THIRD_WEEK  
                             ,SUM(T.FOURTH_WEEK) AS FOURTH_WEEK,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL  
                             WHERE   
                             EXTRACT(MONTH FROM  FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) ='$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY  
                             AND FOL.USER_ID IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_ZONE = '$zone')) AS ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)   
                             FROM SF_LEAD_FOLLOWUP FOL   
                             WHERE   
                             EXTRACT(DAY FROM  FOL.EVENT_DATE ) >= 1  
                             AND EXTRACT(DAY FROM  FOL.EVENT_DATE ) <= 7  
                             AND EXTRACT(MONTH FROM  FOL.EVENT_DATE ) = '$m'
                             AND EXTRACT(YEAR FROM  FOL.EVENT_DATE ) ='$y'
                             AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY    
                             AND FOL.USER_ID  IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_ZONE = '$zone')) AS FIRST_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)     
                           FROM SF_LEAD_FOLLOWUP FOL  
                             WHERE  
                             EXTRACT(DAY FROM FOL.EVENT_DATE) >= 8  
                              AND EXTRACT(DAY FROM FOL.EVENT_DATE) <= 14 
                            AND EXTRACT(MONTH FROM FOL.EVENT_DATE) = '$m'
                              AND EXTRACT(YEAR FROM FOL.EVENT_DATE) = '$y'
                              AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_ZONE = '$zone')) AS SECOND_ACTUAL,  
                             (SELECT COUNT(FOL.JOB_STATUS_CODE)    
                              FROM SF_LEAD_FOLLOWUP FOL   
                              WHERE   
                             EXTRACT(DAY FROM FOL.EVENT_DATE) >= 15  
                             AND EXTRACT(DAY FROM FOL.EVENT_DATE) <= 21  
                              AND EXTRACT(MONTH FROM FOL.EVENT_DATE) = '$m'
                              AND EXTRACT(YEAR FROM FOL.EVENT_DATE) = '$y'
                              AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY   
                             AND FOL.USER_ID IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_ZONE = '$zone')) AS THIRD_ACTUAL,  
                              (SELECT COUNT(FOL.JOB_STATUS_CODE)    
                             FROM SF_LEAD_FOLLOWUP FOL   
                              WHERE  
                              EXTRACT(DAY FROM FOL.EVENT_DATE) >= 22  
                              AND EXTRACT(DAY FROM FOL.EVENT_DATE) <= 31  
                              AND EXTRACT(MONTH FROM FOL.EVENT_DATE) = '$m'
                              AND EXTRACT(YEAR FROM FOL.EVENT_DATE) = '$y'
                              AND FOL.JOB_STATUS_CODE = T.SALES_ACTIVITY  
                              AND FOL.USER_ID  IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_ZONE = '$zone')) AS FOURTH_ACTUAL  
                              FROM SF_USER_SALES_ACTIVITIES T,SF_SALES_ACTIVITIES SA  
                              WHERE  
                              T.BANC_CODE IN (SELECT T.AGENT_CODE FROM SF_USER_DETAILS T WHERE T.AGENT_ZONE = '$zone') 
                              AND T.ACTIVITY_MONTH = '$m'
                              AND T.ACTIVITY_YEAR =  '$y'
                              AND T.SALES_ACTIVITY = SA.SALES_CODE  
                              GROUP BY T.SALES_ACTIVITY  
                              ORDER BY T.SALES_ACTIVITY ASC)"));




        return view('ActivityMart.activity_resultSearch')
            ->with("summary", $summary);
    }


    public function lead_chart(Request $request){

        $agent = $request->session()->get('AGENT_CODE');

        $results = DB::select(DB::raw("
select *  from sf_sales_activities A LEFT JOIN (SELECT COUNT(B.LEAD_NO)as count, B.STATUS  FROM SF_LEAD_MANAGEMENT B WHERE AGENT_CODE ='$agent'  group by B.STATUS ) C ON C.status = A.sales_code  ORDER BY A.Sales_Activity "));

        return   $results;
    }




    public function lead_management(Request $request){


        $userRole =$request->session()->get('USERROLE');
        $branch = $request->session()->get('USERBRANCH');


        $zone =   $request->session()->get('USERZONE');

        $region =  $request->session()->get('USERREGION');

        $agent = $request->session()->get('AGENT_CODE');



        $zones =    DB::table("sf_zonal")->get();
        $regions =    DB::table("sf_regions")->where("zonal_code","=",$zone)->get();
        $branches =    DB::table("sf_branches")->where("region_code","=",$region)->get();
        $advisors = DB::table("sf_user_details")->where("agent_branch","=",$branch)->get();

        return view('ActivityMart.leadMan')
            ->with("zones",$zones)
            ->with("branches",$branches)
            ->with("advisors",$advisors)
            ->with("regions",$regions);






    }




    public function get_advisors(Request $request){


        $branch =     $request->input('branch');


        $advisors = DB::table('sf_user_details')->where('agent_branch','=',$branch)->get();

        return  $advisors;


    }

    public function add_lead(Request $request){
        $agent = $request->session()->get('AGENT_CODE');


        $title = $request->input('title');

        $name  =  str_replace("'"," ", $request->input('customerName')) ;
        $address =  str_replace("'"," ",$request->input('address')) ;
        $mobile = $request->input('mobile');
        $home = $request->input('home');
        $town = $request->input('town');
        $date = $request->input('date');
        $nic = $request->input('leadnic');
        $remarks = $request->input('remarks');
        $prospect = $request->input('prospect');
        $epf = $request->input('epf');


        if(empty($request->input('date'))){

            $date = date("d/m/Y");

        }



        $status = $request->input('status');

        DB::statement(DB::raw(" 
begin
INSERT_SF_LEAD_DETAILS( '','$name
','$address','$town','$address , $town' ,'$home','$mobile','$status','$nic','$agent',TO_DATE('$date','mm/dd/RRRR'),'$remarks','$title',
 '$title  $name', '$prospect','$epf','NO'
);  
 end;         

 "));

        return "success";

    }

    public function lead_search(Request $request){

        $leadNum  =   $request->input('leadNum') ."%";

        if(!empty( $request->input('phone'))){
            $phone1 = $request->input('phone') ."%";
            $phone = "(T.Mobile_No LIKE '$phone1')";
            $phone2 = "(T.CONATCT_NO LIKE '$phone1')";

        }else{
            $phone = "(T.Mobile_No is null OR T.Mobile_No LIKE '%')";
            $phone2 = "(T.CONATCT_NO is null OR T.CONATCT_NO LIKE '%')";

        }


        if(!empty( $request->input('nic'))){
            $nic1 = $request->input('nic') ."%";
            $nic = "(T.nic LIKE '$nic1')";
        }else{

            $nic = "(T.nic is null OR T.nic LIKE '%')";
        }
        $clientName = $request->input('clientName') ."%";



        $m = date("m");
        $y = date("Y");
        $agent = $request->session()->get('AGENT_CODE');


        $userRole =$request->session()->get('USERROLE');
        $branch = $request->session()->get('USERBRANCH');


        $zone =   $request->session()->get('USERZONE');

        $region =  $request->session()->get('USERREGION');

        $agent = $request->session()->get('AGENT_CODE');

        if($userRole == 'UWR'){
            $results =  DB::select(DB::raw("SELECT  rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date FROM SF_LEAD_MANAGEMENT T  
 WHERE  T.Agent_Code = '$agent' AND T.CUSTOMER_NAME LIKE '$clientName' AND T.LEAD_NO LIKE '$leadNum' AND  $nic  AND ( $phone OR $phone2 )"));


        }else if($userRole == 'BRMGR'){

            $results =  DB::select(DB::raw("SELECT  rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date FROM SF_LEAD_MANAGEMENT T  
 WHERE  T.Agent_Code IN (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_BRANCH = '$branch') AND T.CUSTOMER_NAME LIKE '$clientName' AND T.LEAD_NO LIKE '$leadNum' AND  $nic  AND ( $phone OR $phone2 )"));


        }
        else if($userRole == 'REMGR'){

            $results =  DB::select(DB::raw("SELECT  rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date FROM SF_LEAD_MANAGEMENT T  
 WHERE  T.Agent_Code IN (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_REGION = '$region') AND T.CUSTOMER_NAME LIKE '$clientName' AND T.LEAD_NO LIKE '$leadNum' AND  $nic  AND ( $phone OR $phone2 )"));


        }
        else if($userRole == 'ZOMGR'){

            $results =  DB::select(DB::raw("SELECT  rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date FROM SF_LEAD_MANAGEMENT T  
 WHERE  T.Agent_Code IN (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_ZONE = '$zone') AND T.CUSTOMER_NAME LIKE '$clientName' AND T.LEAD_NO LIKE '$leadNum' AND  $nic  AND ( $phone OR $phone2 )"));


        }
        else if($userRole == 'MGR'){

            $results =  DB::select(DB::raw("SELECT  rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date FROM SF_LEAD_MANAGEMENT T  
 WHERE  T.CUSTOMER_NAME LIKE '$clientName' AND T.LEAD_NO LIKE '$leadNum' AND  $nic  AND ( $phone OR $phone2 )"));
        }
        return response()->json(['total' => count( $results), 'data' =>   $results]);

    }

    public function lead_view(Request $request){
        //$agent = $request->session()->get('AGENT_CODE');
        $leadNum =  $request->input('leadNum');

        $results =  DB::select(DB::raw("SELECT T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date FROM SF_LEAD_MANAGEMENT T  
 WHERE    T.LEAD_NO = '$leadNum'"));

        $history=DB::table("sf_lead_followup")->where("lead_no","=", $leadNum )->leftJoin("sf_sales_activities","sf_sales_activities.sales_code","=","sf_lead_followup.job_status_code")->orderBy('event_date', 'asc')->orderBy('job_status_code', 'asc')->get();


        return view('ActivityMart.leadView')
            ->with("history",$history)
            ->with("results",$results);

    }

    public function quotation(Request $request){
        // $agent = $request->session()->get('AGENT_CODE');
        $leadNum =  $request->input('leadNum');

        $results =  DB::select(DB::raw("SELECT T.*,TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date FROM SF_LEAD_MANAGEMENT T  
 WHERE   T.LEAD_NO = '$leadNum'"));




        return view('ActivityMart.quotation')

            ->with("results",$results)->with('leadNum',$leadNum);

    }








    public function quotationMRP(Request $request){

        $leadNum =  $request->input('leadNum');

        $results =  DB::select(DB::raw("SELECT T.*,TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date FROM SF_LEAD_MANAGEMENT T  
 WHERE   T.LEAD_NO = '$leadNum'"));




        return view('ActivityMart.MRP')

            ->with("results",$results);

    }









    public function update_lead(Request $request){
        $agent = $request->session()->get('AGENT_CODE');


        $title = $request->input('title');
        $leadno = $request->input('leadNo1');
        $name  =   $request->input('customerName');
        $address = $request->input('address');
        $mobile = $request->input('mobile');
        $home = $request->input('home');
        $town = $request->input('town');
        $date = $request->input('date');
        $nic = $request->input('leadnic');
        $remarks = $request->input('remarks');
        $prospect = $request->input('prospect');
        $epf = $request->input('epf');


        if(empty($request->input('date'))){

            $date = date("d/m/Y");

        }



        $status = $request->input('status');

        DB::statement(DB::raw(" 
begin
INSERT_SF_LEAD_DETAILS( '$leadno','$name
','$address','$town','$address , $town' ,'$home','$mobile','$status','$nic','$agent',TO_DATE('$date','mm/dd/RRRR'),'$remarks','$title',
 '$title  $name', '$prospect','$epf','YES'
);  
 end;         

 "));

        return "success";

    }




    public function lead_followup_Add(Request $request){
        $agent = $request->session()->get('AGENT_CODE');

        $status = $request->input('status');
        $last = $request->input('last');
        $date = $request->input('date');
        $remarks = $request->input('remarks');
        $leadNo = $request->input('leadNo');

        DB::statement(DB::raw("

    begin

    INSERT_SF_LEADFOLLOWUP('$leadNo','$status','$remarks','$agent',TO_DATE('$date','mm/dd/RRRR'),'$last');

    end;
    "));

        return "success";

    }

    public function lead_date_search(Request $request){




        $agent = $request->session()->get('AGENT_CODE');


        $userRole =$request->session()->get('USERROLE');
        $branch = $request->session()->get('USERBRANCH');


        $zone =   $request->session()->get('USERZONE');

        $region =  $request->session()->get('USERREGION');

        $agent = $request->session()->get('AGENT_CODE');

        $month = $request->input('month');
        $year = $request->input('year');

        if($userRole == 'UWR'){
            $results = DB::select(DB::raw("SELECT rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date,  
             (SELECT COUNT(SQ.LEAD_NO)  
             FROM SF_QUATATION_MANAGEMENT SQ  
             WHERE SQ.LEAD_NO = T.LEAD_NO) AS LEADCOUNT  
             FROM SF_LEAD_MANAGEMENT T  
             WHERE T.AGENT_CODE = '$agent' AND
             EXTRACT(MONTH FROM T.SYSTEM_DATE) = '$month' AND 
             EXTRACT(YEAR FROM T.SYSTEM_DATE) = '$year' 
            "));
        }
        else if($userRole == 'BRMGR'){

            $results = DB::select(DB::raw("SELECT rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date,  
             (SELECT COUNT(SQ.LEAD_NO)  
             FROM SF_QUATATION_MANAGEMENT SQ  
             WHERE SQ.LEAD_NO = T.LEAD_NO) AS LEADCOUNT  
             FROM SF_LEAD_MANAGEMENT T  
             WHERE T.AGENT_CODE IN (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_BRANCH = '$branch') AND
             EXTRACT(MONTH FROM T.SYSTEM_DATE) = '$month' AND 
             EXTRACT(YEAR FROM T.SYSTEM_DATE) = '$year' 
             "));


        }
        else if($userRole == 'REMGR'){

            $results = DB::select(DB::raw("SELECT rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date,  
             (SELECT COUNT(SQ.LEAD_NO)  
             FROM SF_QUATATION_MANAGEMENT SQ  
             WHERE SQ.LEAD_NO = T.LEAD_NO) AS LEADCOUNT  
             FROM SF_LEAD_MANAGEMENT T  
             WHERE T.AGENT_CODE IN (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_REGION = '$region') AND
             EXTRACT(MONTH FROM T.SYSTEM_DATE) = '$month' AND 
             EXTRACT(YEAR FROM T.SYSTEM_DATE) = '$year' 
             "));
        }
        else if($userRole == 'ZOMGR'){
            $results = DB::select(DB::raw("SELECT rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date,  
             (SELECT COUNT(SQ.LEAD_NO)  
             FROM SF_QUATATION_MANAGEMENT SQ  
             WHERE SQ.LEAD_NO = T.LEAD_NO) AS LEADCOUNT  
             FROM SF_LEAD_MANAGEMENT T  
             WHERE T.AGENT_CODE IN (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_ZONE = '$zone') AND
             EXTRACT(MONTH FROM T.SYSTEM_DATE) = '$month' AND 
             EXTRACT(YEAR FROM T.SYSTEM_DATE) = '$year'
            "));}
        else if($userRole == 'MGR'){
            $results = DB::select(DB::raw("SELECT  rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date,  
             (SELECT COUNT(SQ.LEAD_NO)  
             FROM SF_QUATATION_MANAGEMENT SQ  
             WHERE SQ.LEAD_NO = T.LEAD_NO) AS LEADCOUNT  
             FROM SF_LEAD_MANAGEMENT T  
             WHERE  
             EXTRACT(MONTH FROM T.SYSTEM_DATE) = '$month' AND 
             EXTRACT(YEAR FROM T.SYSTEM_DATE) = '$year'
            "));}



        return response()->json(['total' => count( $results), 'data' =>   $results]);

    }
    public function lead_date_search1(Request $request){






        $agent = $request->session()->get('AGENT_CODE');
        $month = $request->input('month');
        $year = $request->input('year');



        $userRole =$request->session()->get('USERROLE');
        $branch = $request->session()->get('USERBRANCH');


        $zone =   $request->session()->get('USERZONE');

        $region =  $request->session()->get('USERREGION');

        $agent = $request->session()->get('AGENT_CODE');

        $month = $request->input('month');
        $year = $request->input('year');

        if($userRole == 'UWR'){
            $results = DB::select(DB::raw("SELECT rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date,  
             (SELECT COUNT(SQ.LEAD_NO)  
             FROM SF_QUATATION_MANAGEMENT SQ  
             WHERE SQ.LEAD_NO = T.LEAD_NO) AS LEADCOUNT  
             FROM SF_LEAD_MANAGEMENT T  
             WHERE T.AGENT_CODE = '$agent'


             ORDER BY T.SYSTEM_DATE"));
        }
        else if($userRole == 'BRMGR'){



            $results = DB::select(DB::raw("SELECT rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date,  
             (SELECT COUNT(SQ.LEAD_NO)  
             FROM SF_QUATATION_MANAGEMENT SQ  
             WHERE SQ.LEAD_NO = T.LEAD_NO) AS LEADCOUNT  
             FROM SF_LEAD_MANAGEMENT T  
             WHERE T.AGENT_CODE IN (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_BRANCH = '$branch') 


             ORDER BY T.SYSTEM_DATE"));

        }
        else if($userRole == 'REMGR'){


            $results = DB::select(DB::raw("SELECT rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date,  
             (SELECT COUNT(SQ.LEAD_NO)  
             FROM SF_QUATATION_MANAGEMENT SQ  
             WHERE SQ.LEAD_NO = T.LEAD_NO) AS LEADCOUNT  
             FROM SF_LEAD_MANAGEMENT T  
             WHERE T.AGENT_CODE IN (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_REGION = '$region') 


             ORDER BY T.SYSTEM_DATE"));
        }
        else if($userRole == 'ZOMGR'){

            $results = DB::select(DB::raw("SELECT rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date,  
             (SELECT COUNT(SQ.LEAD_NO)  
             FROM SF_QUATATION_MANAGEMENT SQ  
             WHERE SQ.LEAD_NO = T.LEAD_NO) AS LEADCOUNT  
             FROM SF_LEAD_MANAGEMENT T  
             WHERE T.AGENT_CODE IN (SELECT AGENT_CODE FROM SF_USER_DETAILS WHERE AGENT_ZONE = '$zone') 


             ORDER BY T.SYSTEM_DATE"));
        }
        else if($userRole == 'MGR'){

            $results = DB::select(DB::raw("SELECT rownum as rownumber,T.*, TO_CHAR(T.proposal_date, 'dd-MM-RRRR') as proposal_date,  
             (SELECT COUNT(SQ.LEAD_NO)  
             FROM SF_QUATATION_MANAGEMENT SQ  
             WHERE SQ.LEAD_NO = T.LEAD_NO) AS LEADCOUNT  
             FROM SF_LEAD_MANAGEMENT T  
          
             ORDER BY T.SYSTEM_DATE"));

        }


        return response()->json(['total' => count( $results), 'data' =>   $results]);

    }



}