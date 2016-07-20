<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use DB;

class loginController extends Controller{

    function reset_password_check(Request $request){
        $username=$request['username'];
        $password=$request['password'];

        $authInfo = DB::select(DB::raw("select * from GE_SF_USER_DETAILS where USER_CODE='$username' and PASSWORD='$password'"));
        if(empty($authInfo)){
            return 0;
        }else{
            return 1;
        }
    }
    function change_password(Request $request){
        $username=$request['username'];
        $new_password=$request['new_password'];

        // $authInfo = DB::statement(DB::raw("update ge_sf_user_details set password='$new_password' where user_code='$username'"));

        try {
            DB::statement(DB::raw("update ge_sf_user_details set password='$new_password' where user_code='$username'"));
            return 1;
        } catch (Exception $e) {
            return $e;
        }
        // return json_encode($authInfo);
        // if(empty($authInfo)){
        //     return 0;
        // }else{
        //     return 1;
        // }
    }


    function authenticate(Request $request){
  
        $user= $request->input('username');  
        $password= $request->input('password');  

        if($user=='admin' && $password=='damith@admin'){
            $_SESSION['ADMIN']='true';
            return $_SESSION['ADMIN'];
        }

        $authInfo = DB::select(DB::raw("select * from GE_SF_USER_DETAILS where USER_CODE='$user' and PASSWORD='$password'"));

        if(!empty($authInfo)){

            $_SESSION['USER_NAME']=$authInfo[0]->user_name;
            $_SESSION['USER_ROLE']=$authInfo[0]->user_role;
            $_SESSION['USER_BRANCH']=$authInfo[0]->branch;
            $_SESSION['USER_CODE']=$authInfo[0]->user_code;
            $_SESSION['USER_ZONE']=$authInfo[0]->zone;
            $_SESSION['USER_REGION']=$authInfo[0]->region;
            //user_image
            $_SESSION['USER_IMAGE']=$authInfo[0]->img_path;
            //temp pilot run use
            $_SESSION['LOGIN_TIME']=time();
            $_SESSION['LOGGEDIN_USER']=$authInfo[0]->user_code;


            $user_code=$_SESSION['USER_CODE'];
            $user_branch=$_SESSION['USER_BRANCH'];
            $user_role=$_SESSION['USER_ROLE'];
            $user_zone=$_SESSION['USER_ZONE'];
            $user_region=$_SESSION['USER_REGION'];


             if($_SESSION['USER_ROLE']=="MGR"){

             

                    $branches_list = DB::select("select branch_name,branch_code from sf_branches
                        where branch_code in (select branch from ge_sf_user_details where user_role = 'BRMGR' group by branch)");

                     $_SESSION['BRANCHES_LIST']=json_encode($branches_list);


                     $cluster_list = DB::select("select region from ge_sf_user_details where user_role = 'REMGR' group by region");
                      $_SESSION['CLUSTER_LIST']=json_encode($cluster_list);

                      $cluster_list = DB::select("select zone from ge_sf_user_details where user_role = 'ZOMGR' group by zone");
                      $_SESSION['ZONE_LIST']=json_encode($cluster_list);





               
                        

                        $_SESSION['ZONE_CODE']=$user_code;
                        
                        $zone_member_codes= DB::select(DB::raw("
                            select a.user_code from ge_sf_user_details a where a.user_code!='$user_code' 
                            "));
                        $_SESSION['ZONE_MEMBER_LIST']=json_encode($zone_member_codes);
                        echo $_SESSION['ZONE_MEMBER_LIST'];
                    



                


            }
           

           else if($_SESSION['USER_ROLE']=="ZOMGR"){

                 //getting users under ZONE manager
                $zone_info=DB::select(DB::raw("
                        select a.user_code from ge_sf_user_details a where a.user_code!='$user_code' and 
                        a.zone = '$user_zone' and a.user_role = 'ADVISOR'
                    "));

                    $branches_list = DB::select("select branch_name,branch_code from sf_branches
                        where branch_code in (select branch from ge_sf_user_details where zone= '$user_zone' and user_role = 'BRMGR' group by branch)");

                     $_SESSION['BRANCHES_LIST']=json_encode($branches_list);


                     $cluster_list = DB::select("select region from ge_sf_user_details where zone= '$user_zone' and user_role = 'REMGR' group by region");
                      $_SESSION['CLUSTER_LIST']=json_encode($cluster_list);





                    if($zone_info[0]!=null){
                        

                        $_SESSION['ZONE_CODE']=$user_code;
                        
                        $zone_member_codes= DB::select(DB::raw("
                            select a.user_code from ge_sf_user_details a where a.user_code!='$user_code' and 
                        a.zone = '$user_zone' and a.user_role = 'ADVISOR'
                            "));
                        $_SESSION['ZONE_MEMBER_LIST']=json_encode($zone_member_codes);
                        echo $_SESSION['ZONE_MEMBER_LIST'];
                    }



                


            }else if($_SESSION['USER_ROLE']=="REMGR"){

                 //getting users under ZONE manager
                $region_info=DB::select(DB::raw("
                        select a.user_code from ge_sf_user_details a where a.user_code!='$user_code' and 
                        a.region = '$user_region' and a.user_role = 'ADVISOR'
                    "));


                 $branches_list = DB::select("select branch_name,branch_code from sf_branches
                        where branch_code in (select branch from ge_sf_user_details where region= '$user_region' and user_role = 'BRMGR' group by branch)");

                     $_SESSION['BRANCHES_LIST']=json_encode($branches_list);


                       if($region_info[0]!=null){
                        

                        $_SESSION['REGION_CODE']=$user_code;
                        
                         $region_info=DB::select(DB::raw("
                        select a.user_code from ge_sf_user_details a where a.user_code!='$user_code' and 
                        a.region = '$user_region' and a.user_role = 'ADVISOR'
                    "));
                        $_SESSION['ZONE_MEMBER_LIST']=json_encode($region_info);
                        echo $_SESSION['ZONE_MEMBER_LIST'];
                    }


                
            }else if($_SESSION['USER_ROLE']=="BRMGR"){
                //getting users under branch manager
                $branch_info=DB::select(DB::raw("
                        select a.user_code from ge_sf_user_details a 
                        where a.branch = (select b.branch from ge_sf_user_details b where b.user_code='$user_code')
                    "));

                    if($branch_info[0]!=null){
                        

                        $_SESSION['BRMGR_CODE']=$user_code;
                        
                        $branch_member_codes= DB::select(DB::raw("
                            select a.user_code from ge_sf_user_details a where a.user_code!='$user_code' and 
                            a.branch = (select b.branch from ge_sf_user_details b where b.user_code='$user_code')
                            "));
                        $_SESSION['BRANCH_MEMBER_LIST']=json_encode($branch_member_codes);
                        echo $_SESSION['BRANCH_MEMBER_LIST'];
                    }
                


            }else if($_SESSION['USER_ROLE']=="ADVISOR"){
                //advisors divide into categories
                $advisor_category=DB::select(DB::raw("select designation_code,group_or_individual from temp_user where code='$user_code'"));

                $group_or_individual='I';

                $category=$advisor_category[0]->designation_code;
                $gORi=$advisor_category[0]->group_or_individual;
                
                

                $sa=false;
                $ssa=false;
                $afmg=false;
                $afmi=false;
                $fmg=false;
                $sfmg=false;
                $sfmi=false;
                $fmi=false;
                $sfeg=false;
                $fei=false;
                $feg=false;

                if($category=="SA"){
                    $sa=true;
                }else if($category=="SSA"){
                    $ssa=true;
                }else if($category=="AFM" && $gORi=="G"){
                    $group_or_individual='G';
             
                    $afmg=true;
                }else if($category=="AFM" && $gORi=="I"){
                    $afmi=true;
                }else if($category=="FM" && $gORi=="G"){
                    $group_or_individual='G';
                    $fmg=true;
                }else if($category=="SFM" && $gORi=="I"){
                    $sfmi=true;
                }else if($category=="FM" && $gORi=="I"){
                    $fmi=true;
                }else if($category=="SFE" && $gORi=="G"){
                    $group_or_individual='G';
                    $sfeg=true;
                }else if($category=="FE" && $gORi=="I"){
                    $fei=true;
                }else if($category=="FE" && $gORi=="G"){
                    $group_or_individual='G';
                    $feg=true;
                }

                $_SESSION['GOI']=$group_or_individual;

                if($sa){

                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }
                }else if($ssa){
                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }

                }else if($afmg){
              
                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }

                    $leader_info = DB::select(DB::raw("select LEADER_CODE from ge_sf_hierarchy where code='$user_code'"));

                    if($leader_info!=null){

                    
                        if($leader_info[0]->leader_code!=null){
                            $leader_code=$leader_info[0]->leader_code;

                            $_SESSION['LEADER_CODE']=$leader_code;
                            
                            $team_member_codes= DB::select(DB::raw("select code from ge_sf_hierarchy where reporter_code='$user_code'"));
                            $_SESSION['ADVISOR_TEAM_MEMBER_LIST']=json_encode($team_member_codes);

                        }
                    

                    }    
                    
                }else if($afmi){
                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }

                }else if($fmg){
                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }

                    $leader_info = DB::select(DB::raw("select LEADER_CODE from ge_sf_hierarchy where code='$user_code'"));

                    if($leader_info!=null){

                    
                        if($leader_info[0]->leader_code!=null){
                            $leader_code=$leader_info[0]->leader_code;

                            $_SESSION['LEADER_CODE']=$leader_code;
                            
                            $team_member_codes= DB::select(DB::raw("select code from ge_sf_hierarchy where reporter_code='$user_code'"));
                            $_SESSION['ADVISOR_TEAM_MEMBER_LIST']=json_encode($team_member_codes);

                        }
                    

                    }
                }else if($sfmg){
                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }

                    $leader_info = DB::select(DB::raw("select LEADER_CODE from ge_sf_hierarchy where code='$user_code'"));

                    if($leader_info!=null){

                    
                        if($leader_info[0]->leader_code!=null){
                            $leader_code=$leader_info[0]->leader_code;

                            $_SESSION['LEADER_CODE']=$leader_code;
                            
                            $team_member_codes= DB::select(DB::raw("select code from ge_sf_hierarchy where reporter_code='$user_code'"));
                            $_SESSION['ADVISOR_TEAM_MEMBER_LIST']=json_encode($team_member_codes);

                        }
                    

                    }
                }else if($sfmi){
                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }

                }else if($fmi){
                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }

                }else if($sfeg){
                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }

                    $leader_info = DB::select(DB::raw("select LEADER_CODE from ge_sf_hierarchy where code='$user_code'"));

                    if($leader_info!=null){

                    
                        if($leader_info[0]->leader_code!=null){
                            $leader_code=$leader_info[0]->leader_code;

                            $_SESSION['LEADER_CODE']=$leader_code;
                            
                            $team_member_codes= DB::select(DB::raw("select code from ge_sf_hierarchy where reporter_code='$user_code'"));
                            $_SESSION['ADVISOR_TEAM_MEMBER_LIST']=json_encode($team_member_codes);

                        }
                    

                    }
                }else if($fei){
                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }

                }else if($feg){
                    $branch_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 

                        "));

                    $zonal_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));
                    
                    $national_rank_info=DB::select(DB::raw("
                        select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                        (
                        select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                        (
                        select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                        from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                        group by t.agent_code
                        order by RANK
                        )B where B.agent_code=m.agent_code order by RANK
                        )C where C.code='$user_code' order by RANK 


                        "));

                    $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

                    $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

                    $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                    
                    if($_SESSION['NATIONAL_RANK']!='1'){

                        $rank_dif=$national_rank_info[0]->rank-1;

                        $national_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

                        $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
                    }


                    if($_SESSION['ZONAL_RANK']!='1'){

                        $rank_dif=$zonal_rank_info[0]->rank-1;
                        $zone_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 


                                "));
                        $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
                        //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
                        $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
                    }


                    if($_SESSION['BRANCH_RANK']!='1'){

                        $rank_dif=$branch_rank_info[0]->rank-1;
                        $branch_rank_dif_info=DB::select(DB::raw("
                                select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
                                (
                                select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
                                (
                                select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
                                from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
                                group by t.agent_code
                                order by RANK
                                )B where B.agent_code=m.agent_code order by RANK
                                )C where C.RANK='$rank_dif' order by RANK 

                                "));
                        $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
                        $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
                    }

                    $leader_info = DB::select(DB::raw("select LEADER_CODE from ge_sf_hierarchy where code='$user_code'"));

                    if($leader_info!=null){

                    
                        if($leader_info[0]->leader_code!=null)
                        {
                            $leader_code=$leader_info[0]->leader_code;

                            $_SESSION['LEADER_CODE']=$leader_code;
                            
                            $team_member_codes= DB::select(DB::raw("select code from ge_sf_hierarchy where reporter_code='$user_code' or code = '$user_code'"));
                            $_SESSION['ADVISOR_TEAM_MEMBER_LIST']=json_encode($team_member_codes);

                        }
                    

                    }

                }

                
                
                $v="CANCELLED";
                // $_SESSION['RENEWAL_LIST']
                $renewal_list= DB::select(DB::raw("
                    select * from Crc_Policy p
                    where extract(year from p.pol_end_date)=extract(year from sysdate) and 
                    extract(month from p.pol_end_date)=extract(month from sysdate) and 
                    p.pol_status !='$v' and 
                    p.pol_agent_code='$user_code'
                    order by p.pol_end_date
                "));
                if($renewal_list!=null){
                    $_SESSION['RENEWAL_LIST']=json_encode($renewal_list);
                }

            }
            
            
            return $authInfo[0]->user_name;

        }else{
            return 0;
        }



    }
//     function authenticate(Request $request){
  
//         $user= $request->input('username');  
//         $password= $request->input('password');  

//         $authInfo = DB::select(DB::raw("select * from GE_SF_USER_DETAILS where USER_CODE='$user' and PASSWORD='$password'"));
// //        $authInfo = DB::select(DB::raw("select * from pusers where username='$user' and password='$password'"));

//         if(!empty($authInfo)){

//             $_SESSION['USER_NAME']=$authInfo[0]->user_name;
//             $_SESSION['USER_ROLE']=$authInfo[0]->user_role;
//             $_SESSION['USER_BRANCH']=$authInfo[0]->branch;
//             $_SESSION['USER_CODE']=$authInfo[0]->user_code;
//             $_SESSION['USER_ZONE']=$authInfo[0]->zone;

//             $user_code=$_SESSION['USER_CODE'];
//             $user_branch=$_SESSION['USER_BRANCH'];
//             $user_role=$_SESSION['USER_ROLE'];
//             $user_zone=$_SESSION['USER_ZONE'];

//             if($_SESSION['USER_ROLE']=="ZOMGR"){

//             }else if($_SESSION['USER_ROLE']=="BRMGR"){
//                 // $branch_mgr_code=DB::select(DB::raw("select LEADER_CODE from ge_sf_hierarchy where code='$user_code'"));
//             }else if($_SESSION['USER_ROLE']=="REMGR"){

//             }else if($_SESSION['USER_ROLE']=="ADVISOR"){

//                 $branch_rank_info=DB::select(DB::raw("
//                     select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
//                     (
//                     select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
//                     (
//                     select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
//                     from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
//                     group by t.agent_code
//                     order by RANK
//                     )B where B.agent_code=m.agent_code order by RANK
//                     )C where C.code='$user_code' order by RANK 

//                     "));

//                 $zonal_rank_info=DB::select(DB::raw("
//                     select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
//                     (
//                     select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
//                     (
//                     select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
//                     from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
//                     group by t.agent_code
//                     order by RANK
//                     )B where B.agent_code=m.agent_code order by RANK
//                     )C where C.code='$user_code' order by RANK 


//                     "));
                
//                 $national_rank_info=DB::select(DB::raw("
//                     select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
//                     (
//                     select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
//                     (
//                     select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
//                     from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
//                     group by t.agent_code
//                     order by RANK
//                     )B where B.agent_code=m.agent_code order by RANK
//                     )C where C.code='$user_code' order by RANK 


//                     "));


//                 $_SESSION['BRANCH_RANK']=$branch_rank_info[0]->rank;

//                 $_SESSION['ZONAL_RANK']=$zonal_rank_info[0]->rank;

//                 $_SESSION['NATIONAL_RANK']=$national_rank_info[0]->rank;

                
//                 if($_SESSION['NATIONAL_RANK']!='1'){

//                     $rank_dif=$national_rank_info[0]->rank-1;

//                     $national_rank_dif_info=DB::select(DB::raw("
//                             select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
//                             (
//                             select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
//                             (
//                             select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
//                             from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details)
//                             group by t.agent_code
//                             order by RANK
//                             )B where B.agent_code=m.agent_code order by RANK
//                             )C where C.RANK='$rank_dif' order by RANK 


//                             "));
//                     $NATIONALgwp_dif=((($national_rank_dif_info[0]->percentage - $national_rank_info[0]->percentage)*$national_rank_info[0]->monthly_target)/100);

//                     $_SESSION['NATIONAL_DIFF']=$NATIONALgwp_dif;
//                 }


//                 if($_SESSION['ZONAL_RANK']!='1'){

//                     $rank_dif=$zonal_rank_info[0]->rank-1;
//                     $zone_rank_dif_info=DB::select(DB::raw("
//                             select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
//                             (
//                             select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
//                             (
//                             select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
//                             from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.zonal_code='$user_zone'
//                             group by t.agent_code
//                             order by RANK
//                             )B where B.agent_code=m.agent_code order by RANK
//                             )C where C.RANK='$rank_dif' order by RANK 


//                             "));
//                     $ZONEgwp_dif=((($zone_rank_dif_info[0]->percentage - $zonal_rank_info[0]->percentage)*$zonal_rank_info[0]->monthly_target)/100);
//                     //$zone_rank_dif_info[0]->gwp - $zonal_rank_info[0]->gwp;
//                     $_SESSION['ZONE_DIFF']=$ZONEgwp_dif;
//                 }


//                 if($_SESSION['BRANCH_RANK']!='1'){

//                     $rank_dif=$branch_rank_info[0]->rank-1;
//                     $branch_rank_dif_info=DB::select(DB::raw("
//                             select C.CODE,C.GWP,C.MONTHLY_TARGET,C.PERCENTAGE,C.RANK from
//                             (
//                             select B.agent_code as code,B.gwp as GWP,B.RANK as RGWP,m.monthly_target ,round(((B.gwp/monthly_target)*100),2) as percentage,RANK() OVER(order by (B.gwp/m.monthly_target)*100 desc) as RANK  from ge_sf_inv_monthly_targets m,
//                             (
//                             select t.agent_code,round(sum(t.gwp),0) gwp,RANK() OVER(order by round(sum(t.GWP),0) desc) as RANK 
//                             from t_report_dncn_gwp_fmt t where t.agent_code in (select user_code from ge_sf_user_details) and t.assurance_code='$user_branch'
//                             group by t.agent_code
//                             order by RANK
//                             )B where B.agent_code=m.agent_code order by RANK
//                             )C where C.RANK='$rank_dif' order by RANK 

//                             "));
//                     $BRANCHgwp_dif=((($branch_rank_dif_info[0]->percentage - $branch_rank_info[0]->percentage)*$branch_rank_info[0]->monthly_target)/100);
//                     $_SESSION['BRANCH_DIFF']=$BRANCHgwp_dif;
//                 }
//                 $leader_info = DB::select(DB::raw("select LEADER_CODE from ge_sf_hierarchy where code='$user_code'"));
//                 if($leader_info!=null){

                
//                     if($leader_info[0]->leader_code!=null){
//                         $leader_code=$leader_info[0]->leader_code;

//                         $_SESSION['LEADER_CODE']=$leader_code;
                        
//                         $team_member_codes= DB::select(DB::raw("select code from ge_sf_hierarchy where reporter_code='$user_code'"));
//                         $_SESSION['ADVISOR_TEAM_MEMBER_LIST']=json_encode($team_member_codes);

//                     }
                

//                 }
//                 $v="CANCELLED";
//                 // $_SESSION['RENEWAL_LIST']
//                 $renewal_list= DB::select(DB::raw("
//                     select * from Crc_Policy p
//                     where extract(year from p.pol_end_date)=extract(year from sysdate) and 
//                     extract(month from p.pol_end_date)=extract(month from sysdate) and 
//                     p.pol_status !='$v' and 
//                     p.pol_agent_code='$user_code'
//                     "));
//                 if($renewal_list!=null){
//                     $_SESSION['RENEWAL_LIST']=json_encode($renewal_list);
//                 }

//             }
            
            

//             return $authInfo[0]->user_name." ".($branch_rank_info[0]->rank)." ".$user_branch;

//         }else{
//             return 0;
//         }



//     }
    
    
}
