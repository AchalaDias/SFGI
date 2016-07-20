<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class selectController extends Controller
{
    public function title_select(){
        $title_result = DB::select(DB::raw("
            select * from GE_SF_LEAD_TITLE
        "));
        //return response()->json(['data'=>$chart_result]);
        return json_encode($title_result);
    }    //

    public function product_select(){
        $product_result = DB::select(DB::raw("
            select * from GE_SF_LEAD_PRODUCT

        "));
        //return response()->json(['data'=>$chart_result]);
        return json_encode($product_result);
    }

    public function vehicle_status_select(){
        $vs_result = DB::select(DB::raw("
            select * from GE_SF_LEAD_VEHICLE_STATUS

        "));
        //return response()->json(['data'=>$chart_result]);
        return json_encode($vs_result);
    }

    public function occupation_select(){
        $os_result = DB::select(DB::raw("
            select * from GE_SF_LEAD_OCCUPATION

        "));
        //return response()->json(['data'=>$chart_result]);
        return json_encode($os_result);
    }

    public function businessparty_select(){
        $bp_result = DB::select(DB::raw("
            select * from GE_SF_LEAD_BUSINESSPARTY

        "));
        //return response()->json(['data'=>$chart_result]);
        return json_encode($bp_result);
    }

    public function leadstatus_select(){
        $lead_result = DB::select(DB::raw("
            select * from GE_SF_LEAD_STATUS

        "));
        //return response()->json(['data'=>$chart_result]);
        return json_encode($lead_result);
    }
}
