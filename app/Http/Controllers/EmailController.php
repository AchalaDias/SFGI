<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use Mail;
use Storage;
use File;

use App\MailClass\PHPMailer;
use App\SMSClass\send_sms;

class EmailController extends Controller
{
    

public function notificationEmail(){

	

$result = DB::select("select a.* from ge_sf_lead_notifications a where extract(DAY from a.notify_date) = extract(DAY from sysdate)
and extract(MONTH from a.notify_date) = extract(MONTH from sysdate) and extract(YEAR from a.notify_date) = extract(YEAR from sysdate)
");


$mailer_fogot = new PHPMailer();
$mailer_fogot->IsSMTP();          // set mailer to use SMTP
$mailer_fogot->Host = "smtp.hnbassurance.com";  // specify main and backup server
$mailer_fogot->SMTPAuth = true;     // turn on SMTP authentication
$mailer_fogot->Username = "misreports";  // SMTP username
$mailer_fogot->Password = "Water@1234"; // SMTP password

$mailer_fogot->From = "misreports@hnbassurance.com";
$mailer_fogot->FromName = "HNBA SALES FORCE GENERAL LEAD REMINDER";


foreach ($result as $k)
{
$lead = $k->lead_no;
$data = DB::select("select * from ge_sf_lead_management where lead_no = '$lead'");

$mailer_fogot->AddAddress($k->email);
/*$mailer_fogot->AddAddress('diaspositive@gmail.com');*/


$msgBody = "<!DOCTYPE html>
<html>
<head>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>
</head>
<body>

<h2>Lead Details</h2>

<table>
  <tr>
    <th>Title</th>
    <th>Details</th>
  </tr>
   <tr>
    <td>Lead No  </td>
    <td>".$k->lead_no."</td>
  </tr>
  <tr>
    <td>Customer name </td>
    <td>".$data[0]->title.$k->customer_name."</td>
  </tr>
  <tr>
    <td>Customer Address</td>
    <td>".$data[0]->address."</td>
  </tr>
  <tr>
    <td>Contact numbers </td>
    <td>".$data[0]->conatct_no."/".$data[0]->mobile_no."</td>
  </tr>
  <tr>
    <td>Product</td>
    <td>".$data[0]->product."</td>
</tr>
 <tr>
    <td>Vehicle no</td>
    <td>".$data[0]->vehicle_no."</td>
</tr>
 <tr>
    <td>Occupation</td>
    <td>".$data[0]->occupation."</td>
</tr>
 <tr>
    <td>Status</td>
    <td>".$data[0]->status."</td>
</tr>
</table>



<h1>✱ Remider : ".$k->notification."</h1>

</body>
</html>";


$mail_body_fog=$msgBody;

$mailer_fogot->Subject = "HNBA SALES FORCE GENERAL LEAD REMINDER";
$mailer_fogot->Body=$msgBody;
$mailer_fogot->AltBody = "HNBA SALES FORCE GENERAL LEAD REMINDER";

if(!$mailer_fogot->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mailer_fogot->ErrorInfo;
   exit;
}else{


	$currentDate = date("Y_m_d_H_i_s");

	$filename = '/var/www/html/SFGI_BACKUP/logs/Emails/' . $currentDate . '_Email_LOG.txt';


	$file = fopen($filename, "w");

	$txt = "Lead No :".$k->lead_no."\n Customer name :".$data[0]->title.$k->customer_name."\n Customer Address :".$data[0]->address."\n  Contact numbers : ".$data[0]->conatct_no."/".$data[0]->mobile_no."\n  Product : ".$data[0]->product."\n Vehicle no :".$data[0]->vehicle_no."\n  Occupation : ".$data[0]->occupation."\n Status : ".$data[0]->status." \n Remider : ".$k->notification;


	fwrite($file, $txt);
	fclose($file);


echo "Sucess!!";

}
}



}


}
