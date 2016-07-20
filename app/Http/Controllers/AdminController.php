<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use DB;

class AdminController extends Controller
{
	public function Image_upload(){
		
		if(Input::hasFile('file')){
			echo "Uploaded";
			$file=Input::file('file');
			
			if($file->move('User_Images',$file->getClientOriginalName())){
				$file_path=$file->getClientOriginalName();
				$agent_code= preg_split('[\.]', $file_path);
				echo "successfull</br>";

				echo $agent_code[0]." FILEPATH: ".$file_path;
				try {
		            DB::statement(DB::raw("update ge_sf_user_details set img_path='User_Images/".$file->getClientOriginalName()."' where user_code='".$agent_code[0]."'"));
		            echo '<script>window.location.href="admin";</script>';
		        } catch (Exception $e) {
		            return $e;
		        }
			}else{
				echo "unsuccessfull";
			}


		}
    }
}
