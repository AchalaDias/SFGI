<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class test extends Controller
{
    //

    public function testFunc(){
        $servername = "172.16.2.77";
        $username = "root";
        $password = "rockball12";
        $dbname = "asteriskcdrdb";



// Create connection
        $conn2 = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
        if (!$conn2) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $servername = "172.16.2.77";
        $username = "root";
        $password = "rockball12";
        $dbname = "asterisk";



// Create connection
        $conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        ///////////////////////
//        total incoming
        $query="select asteriskcdrdb.cdr.calldate,asteriskcdrdb.cdr.src,asteriskcdrdb.cdr.dst,asterisk.users.name,asteriskcdrdb.cdr.disposition,asterisk.users.extension,asteriskcdrdb.cdr.duration
from asterisk.users inner join asteriskcdrdb.cdr
on asterisk.users.extension = asteriskcdrdb.cdr.dst
";
        $result=mysqli_query($conn,$query);
        $c=0;
        while($data=$result->fetch_assoc()){
            $c++;
        }
//        total outgoing
        $query2="select asteriskcdrdb.cdr.calldate,asteriskcdrdb.cdr.src,asteriskcdrdb.cdr.dst,asterisk.users.name,asteriskcdrdb.cdr.disposition,asterisk.users.extension,asteriskcdrdb.cdr.duration
from asterisk.users inner join asteriskcdrdb.cdr
on asterisk.users.extension = asteriskcdrdb.cdr.src
";
        $result2=mysqli_query($conn,$query2);
        $d=0;
        while($data=$result2->fetch_assoc()){
            $d++;
        }


//

        $testArr=array('count'=>$c,'count2'=>$d);
        return view('home',compact('testArr'));
    }
}
