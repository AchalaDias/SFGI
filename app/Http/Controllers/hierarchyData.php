<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class hierarchyData extends Controller
{
    //
    function group(){
        /* session_start();

        $query=array();
        $query=DB::select("select * from user_login where id=(select id from hierarchy where supercode='B1')");

        if(sizeof($query)>0){

            foreach($query as $x) {
                $_SESSION['users'][] =$x->user_name;

                echo $x->user_name;
            }
        }else{
            echo sizeof($query);
        } */
    }
}
