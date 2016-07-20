<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function testController(){
        $testArr=array('name'=>'A.H.M Fernando','occupation'=>'Doctor','address'=>'Colombo');
        return view('home',compact('testArr'));
    }
}