<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use DB;
use App\Http\Requests;
use App\Quotation;
use App\Http\Controllers\Controller;

class Lead_controller extends Controller
{
    public function get_lead_data(Request $request){
        $key=$request['key'];
        $agent_code=$_SESSION['USER_CODE'];
        $search_result = DB::select(DB::raw("select * from GE_SF_LEAD_MANAGEMENT WHERE LEAD_NO LIKE '%$key%' AND AGENT_CODE='$agent_code' "));
        return json_encode($search_result);
    }

    public function reminder(Request $request){
        $lead_no=$request['lead_no'];
        $customer=$request['customer'];
        $contact_no=$request['contact_no'];
        $email=$request['email'];
        $type=$request['type'];
        $notification=$request['notification'];
        $reminder_date=$request['reminder_date'];
        $user_id=$request['agent_code'];
        DB::statement(DB::raw("insert into GE_SF_LEAD_NOTIFICATIONS values('$lead_no','$customer','$contact_no','$email','$user_id','$type',TO_DATE('$reminder_date','MM/DD/YYYY'),'$notification')"));
//        $search_result = DB::select(DB::raw("select * from GE_SF_LEAD_MANAGEMENT WHERE LEAD_NO LIKE '%$key%' OR MOBILE_NO LIKE '%$key%' OR CONATCT_NO LIKE '%$key%' OR AGENT_CODE LIKE '%$key%' OR NIC LIKE '%$key%'"));
//        return response()->json(['data'=>$search_result]);
        return 1;
    }
    public function update_lead_followup(Request $request){
        $lead_no=$request['lead_no'];
        $status=$request['status'];
        $last_update=$request['last_update'];
        $remarks=$request['remarks'];
        $user_id=$_SESSION['USER_CODE'];
        DB::statement(DB::raw("insert into ge_sf_lead_followup values('$lead_no','null',TO_DATE('$last_update','MM/DD/YYYY'),'$remarks','$user_id','$status')"));
//        $search_result = DB::select(DB::raw("select * from GE_SF_LEAD_MANAGEMENT WHERE LEAD_NO LIKE '%$key%' OR MOBILE_NO LIKE '%$key%' OR CONATCT_NO LIKE '%$key%' OR AGENT_CODE LIKE '%$key%' OR NIC LIKE '%$key%'"));
//        return response()->json(['data'=>$search_result]);
        return 1;
    }
    public function search_lead(Request $request){
        $key=$request['key'];
        $agent_code=$_SESSION['USER_CODE'];
        $search_result = DB::select(DB::raw("select * from GE_SF_LEAD_MANAGEMENT WHERE (LEAD_NO LIKE '%$key%' OR MOBILE_NO LIKE '%$key%' OR CONATCT_NO LIKE '%$key%' OR AGENT_CODE LIKE '%$key%' OR NIC LIKE '%$key%') AND AGENT_CODE='$agent_code' "));
        return response()->json(['data'=>$search_result]);
    }
    public function search_lead_group(Request $request){
        $key=$request['key'];
        $agent_code=$_SESSION['USER_CODE'];
        $search_result = DB::select(DB::raw("select * from GE_SF_LEAD_MANAGEMENT WHERE (LEAD_NO LIKE '%$key%' OR MOBILE_NO LIKE '%$key%' OR CONATCT_NO LIKE '%$key%' OR AGENT_CODE LIKE '%$key%' OR NIC LIKE '%$key%') "));
        return response()->json(['data'=>$search_result]);
    }
    public function search_indiv_lead(Request $request){
        $key=$request['key'];
        $agent_code=$_SESSION['USER_CODE'];
        $search_result = DB::select(DB::raw("select * from GE_SF_LEAD_MANAGEMENT WHERE LEAD_NO='$key'"));
        return json_encode($search_result);
    }
    public function get_followup_details(Request $request){
        $key=$request['key'];
        $search_result = DB::select(DB::raw("select * from ge_sf_lead_followup WHERE LEAD_NO='$key' order by event_date desc"));
        return json_encode($search_result);
    }
    public function load_lead_details(){
        $agent_code=$_SESSION['USER_CODE'];
        $leads = DB::select(DB::raw("select LEAD_NO,CUSTOMER_NAME,ADDRESS,AGENT_CODE,PROPOSAL_DATE from GE_SF_LEAD_MANAGEMENT WHERE AGENT_CODE='$agent_code'"));
        return response()->json(['data'=>$leads]);
    }
    public function submit_lead(Request $request){
        $data=$request['detailsArray'];
        if(isset($_SESSION['USER_CODE'])){
            $agent_code=$_SESSION['USER_CODE'];
        }
        $title=$data[0];
        $c_name=$data[1];
        $c_address=$data[2];
        $c_mobile=$data[3];
        $c_home=$data[4];
        $c_town=$data[5];
        $c_nic=$data[6];
        $risk_address=$data[7];
        $product=$data[8];
        $vehicle_no=$data[9];
        $status=$data[10];
        $proposal_date=$data[11];
        $remarks=$data[12];
        $occupation=$data[13];
        $party_code=$data[14];
        $business_party=$data[15];

        $lead_no=$data[16];
//            date("Ymd").$agent_code.date("his");
        $system_date=date("Y:m:d");

        echo $proposal_date;
//        DB::insert('insert into GE_SF_LEAD_MANAGEMENT(LEAD_NO,TITLE,CUSTOMER_NAME,ADDRESS,CONATCT_NO,MOBILE_NO,TOWN,NIC,RISK_ADDRESS,AGENT_CODE,PRODUCT,VEHICLE_NO,STATUS,OCCUPATION,REMARKS,PROPOSAL_DATE,SYSTEM_DATE,BUSINESS_PARTY,PARTY_CODE,LAST_UPDATE_DATE)
////VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$lead_no,$title,$c_name,$c_address,$c_home,$c_mobile,$c_town,$c_nic,$risk_address,$agent_code,$product,$vehicle_no,$status,$occupation,$remarks,$proposal_date,$system_date,$business_party,$party_code,$system_date]);
//        DB::table('GE_SF_LEAD_MANAGEMENT')->insert(
//            array('LEAD_NO'=>$lead_no,'TITLE'=>$title,'CUSTOMER_NAME'=>$c_name,'ADDRESS'=>$c_address,'CONTACT_NO'=>$c_home,'MOBILE_NO'=>$c_mobile,'TOWN'=>$c_town,'NIC'=>$c_nic,'RISK_ADDRESS'=>$risk_address,'AGENT_CODE'=>$agent_code,'PRODUCT'=>$product,'VEHICLE_NO'=>$vehicle_no,'STATUS'=>$status,'OCCUPATION'=>$occupation,'REMARKS'=>$remarks,'PROPOSAL_DATE'=>$proposal_date,'SYSTEM_DATE'=>$system_date,'BUSINESS_PARTY'=>$business_party,'PARTY_CODE'=>$party_code,'LAST_UPDATE_DATE'=>$system_date)
//        );

//        DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
        DB::statement(DB::raw("insert into GE_SF_LEAD_MANAGEMENT values('$lead_no','$title','$c_name','$c_address','$c_home','$c_mobile','$c_town','$c_nic','$risk_address','$agent_code','$product','$vehicle_no','$status','$occupation','$remarks',TO_DATE('$proposal_date','MM/DD/YYYY'),TO_DATE('$system_date','YYYY-mm-dd'),'$business_party','$party_code',TO_DATE('$system_date','YYYY-mm-dd'))"));
//        DB::statement(DB::raw("insert into GE_SF_LEAD_MANAGEMENT values('$lead_no','$title','$c_name','$c_address','$c_home','$c_mobile','$c_town','$c_nic','$risk_address','$agent_code','$product','$vehicle_no','$status','$occupation','$remarks','$proposal_date','$system_date','$business_party','$party_code','$system_date')"));
        return $agent_code;
    }
}
