<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
session_start();
Route::group(['middleware' => ['web']], function () {

//    Route::get('/', function () {
//        $testArr=array('name'=>'A.H.M Fernando','occupation'=>'Doctor','address'=>'Colombo');
//        return view('home',compact('testArr'));
//    });

//    Route::get('home',function(){
//        $testArr=array('name'=>'A.H.M Fernando','occupation'=>'Doctor','address'=>'Colombo');
//        return view('home',compact('testArr'));
//    });

//    Route::get('Test','HomeController@testController');
    Route::get('login',function(){
        return view('login');
    });

    Route::get('/loginCheck','loginController@authenticate');


    Route::get('admin',function(){
        if(isset($_SESSION['ADMIN'])) {
            return view('admin');
        }else{
            return view('login');
        }
    });
    Route::get('logout','LogController@logout');



    Route::get('getGroupData','hierarchyData@group');
});


Route::get('home',function(){
    if(isset($_SESSION['USER_CODE'])) {
        return view('Dashboard.dashboard');
    }else{
        return view('login');
    }
});
Route::get('/',function(){
    if(isset($_SESSION['USER_CODE'])) {
        return view('Dashboard.dashboard');
    }else{
        return view('login');
    }
});
Route::post('test_image_upload','AdminController@Image_upload');
// Route::post('test_image_upload',function(){
//     echo "Hello";
// });

Route::post('reset_password_check','loginController@reset_password_check');
Route::get('change_password','loginController@change_password');

Route::get('/enter_lead','Lead_controller@submit_lead');
Route::get('/search_lead','Lead_controller@search_lead');
Route::get('/search_lead_group','Lead_controller@search_lead_group');
Route::get('/reminder','Lead_controller@reminder');
Route::get('/search_indiv_lead','Lead_controller@search_indiv_lead');
Route::get('/get_followup_details','Lead_controller@get_followup_details');
Route::get('/update_lead_followup','Lead_controller@update_lead_followup');
Route::get('/retrieve_leads','Lead_controller@load_lead_details');
Route::get('/chart1data','Charts_conroller@chart1data');
Route::get('/chart2data','Charts_conroller@chart2data');
Route::get('/chart3data','Charts_conroller@chart3data');
Route::get('/chart4data','Charts_conroller@chart4data');
Route::get('/chart1_0_1data','Charts_conroller@chart1_0_1data');
Route::get('/month_non_motor','Charts_conroller@month_non_motor');
Route::get('/cumulative_target_achievement','Charts_conroller@cumulative_target_achievement');
Route::get('/cumulative_non_motor','Charts_conroller@cumulative_non_motor');
Route::get('/get_lead_data','Lead_controller@get_lead_data');



Route::get('/cumulativeCWG','Charts_conroller@cumulativeCWG');
Route::get('/cumulativeMOTOR','Charts_conroller@cumulativeMOTOR');
Route::get('/cumulativeNONMOTOR','Charts_conroller@cumulativeNONMOTOR');
Route::get('/FMTNONMOTOR','Charts_conroller@FMTNONMOTOR');
Route::get('/cumulativePOLICY','Charts_conroller@cumulativePOLICY');

/////////////////////////Training new module\\\\\\\\\\\\\\\\\\\\\\\\\\\

Route::get('/trainingcategory',  'TrainingController@trainingCategory');
Route::get('/viewProgramInvitaion',  'TrainingController@viewProgramInvitaion');
Route::get('/Training_pepole',  'TrainingController@TrainingPepole');
Route::get('/addOrRemove',  'TrainingController@addOrRemovePepole');
Route::get('/checkboxChecker',  'TrainingController@checkboxChecker');
Route::get('/CreateEvent',  'TrainingController@CreateEvent');
Route::get('/LoadTrainPrograms',  'TrainingController@LoadTrainPrograms');
Route::get('/LoadProgramClan',  'TrainingController@LoadProgramClan');
Route::get('/FinishEventAttempt',  'TrainingController@FinishEventAttempt');

Route::get('/sales-plan-get_branches',  'ActivityMartController@sales_plan_get_branches');
Route::get('/sales-plan-get_regions',  'ActivityMartController@sales_plan_get_regions');

/////////////////////////END\\\\\\\\\\\\\\\\\\\\\\\\\\\



/////////////////////////Quotation\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/quotaion',  'QuotationController@Quotaion');

/////////////////////////Quotation\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/SendEmail',  'EmailController@notificationEmail');

/////////////////////////END\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
Route::get('/advisor_details','Charts_conroller@advisor_details');

///////////////////////individual chart details/////////////
Route::get('/chart1data_group','IndividualChartContoller@chart1data_group');
Route::get('/chart2data_group','IndividualChartContoller@chart2data_group');
Route::get('/chart3data_group','IndividualChartContoller@chart3data_group');
Route::get('/chart4data_group','IndividualChartContoller@chart4data_group');
Route::get('/chart1_0_1data_group','IndividualChartContoller@chart1_0_1data_group');
Route::get('/month_non_motor_group','IndividualChartContoller@month_non_motor_group');
Route::get('/cumulative_target_achievement_group','IndividualChartContoller@cumulative_target_achievement_group');
Route::get('/cumulative_non_motor_group','IndividualChartContoller@cumulative_non_motor_group');
Route::get('/cumulative_cwg_group','IndividualChartContoller@cumulative_cwg_group');
Route::get('/CMNOP_group','IndividualChartContoller@CMNOP_group');

Route::get('/retrieve_leads_group','IndividualChartContoller@retrieve_leads_group');

Route::get('/ppwRatio','ppwCLAIMRATIOcontroller@ppwRatio');
Route::get('/claimRatio','ppwCLAIMRATIOcontroller@claimRatio');

Route::get('/training_star_count','ppwCLAIMRATIOcontroller@training_star_count');

Route::get('/title_select','selectController@title_select');
Route::get('/product_select','selectController@product_select');
Route::get('/vehicle_status_select','selectController@vehicle_status_select');
Route::get('/occupation_select','selectController@occupation_select');
Route::get('/businessparty_select','selectController@businessparty_select');
Route::get('/leadstatus_select','selectController@leadstatus_select');



//////////////////////////Branch Chrats\\\\\\\\\\\\\\\\\\\\\\
Route::get('/Branch_details','branchChartsController@Branch_details');
Route::get('/chart1_0_1data_group_branch','branchChartsController@chart1_0_1data_group_branch');
Route::get('/chart1data_group_branch','branchChartsController@chart1data_group_branch');
Route::get('/chart2data_group_branch','branchChartsController@chart2data_group_branch');
Route::get('/cumulative_cwg_group_branch','branchChartsController@cumulative_cwg_group_branch');
Route::get('/chart4data_group_branch','branchChartsController@chart4data_group_branch');
Route::get('/CMNOP_group_branch','branchChartsController@CMNOP_group_branch');
Route::get('/chart3data_group_branch','branchChartsController@chart3data_group_branch');

//////////////////////////Region Chrats\\\\\\\\\\\\\\\\\\\\\\
Route::get('/region_details','RegionChartsController@region_details');
Route::get('/chart1_0_1data_group_region','RegionChartsController@chart1_0_1data_group_region');
Route::get('/chart1data_group_region','RegionChartsController@chart1data_group_region');
Route::get('/chart2data_group_region','RegionChartsController@chart2data_group_region');
Route::get('/cumulative_cwg_group_region','RegionChartsController@cumulative_cwg_group_region');
Route::get('/chart4data_group_region','RegionChartsController@chart4data_group_region');
Route::get('/CMNOP_group_region','RegionChartsController@CMNOP_group_region');
Route::get('/chart3data_group_region','RegionChartsController@chart3data_group_region');



///////////////////////////Claim/PPW rations - select User\\\\\\\\\\\\\\\\\\\\\\

Route::get('/claimRatio_search_user','IndividualChartContoller@claimRatio_search_user');
Route::get('/ppwRatio_search_user','IndividualChartContoller@ppwRatio_search_user');
Route::get('/training_star_count_serach_user','IndividualChartContoller@training_star_count_serach_user');



//////////////////////////Region Chrats\\\\\\\\\\\\\\\\\\\\\\
Route::get('/zone_details','ZoneChartsController@zone_details');
Route::get('/chart1_0_1data_group_zone','ZoneChartsController@chart1_0_1data_group_zone');
Route::get('/chart1data_group_zone','ZoneChartsController@chart1data_group_zone');
Route::get('/chart2data_group_zone','ZoneChartsController@chart2data_group_zone');
Route::get('/cumulative_cwg_group_zone','ZoneChartsController@cumulative_cwg_group_zone');
Route::get('/chart4data_group_zone','ZoneChartsController@chart4data_group_zone');
Route::get('/CMNOP_group_zone','ZoneChartsController@CMNOP_group_zone');
Route::get('/chart3data_group_zone','ZoneChartsController@chart3data_group_zone');
