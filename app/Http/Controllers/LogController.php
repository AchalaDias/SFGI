<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    
    public function logout(){
    	$user_code=$_SESSION['LOGGEDIN_USER'];
    	$login_time_nonformatted=$_SESSION['LOGIN_TIME'];
    	$this->logout_confirm();
    	$logout_time_nonformatted=time();

    	$login_time=date("Y-m-d h:i:s ",$login_time_nonformatted);
    	$logout_time=date("Y-m-d h:i:s ",$logout_time_nonformatted);

 
   		DB::statement(DB::raw("insert into GE_SF_PILOT_RUN_STATS values('$user_code',TO_DATE('$login_time','YYYY/MM/DD HH:MI:SS'),TO_DATE('$logout_time','YYYY/MM/DD HH:MI:SS'))"));

    	return ($login_time);
    }

    public function logout_confirm(){
    	session_destroy();
    }
}
