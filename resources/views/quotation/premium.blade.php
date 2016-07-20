@extends('master')

@section('content')
<div class="row">
  <section class="content-header">
      <h1>
        General Quotation Calculation
        <small>Preview</small>
      </h1>
    
    </section>


      <section class="content">
   <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Inputs</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
     
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Sum Insured</label>
                  <input type="number" class="form-control" id="sum"  name="sum" required>
                </div>
                <div class="form-group">
                  <div class="form-group">
                  <label>Vehicle Type</label>
                  <select class="form-control"  id="Vehicle_type"  name="Vehicle_type">
<option value='Angledozer'>Angledozer</option>
<option value='Bachoe'>Bachoe</option>
<option value='Bulldozer'>Bulldozer</option>
<option value='Bullgrader'>Bullgrader</option>
<option value='Cattepiller'>Cattepiller</option>
<option value='Combine Harvester'>Combine Harvester</option>
<option value='Concrete Mixer'>Concrete Mixer</option>
<option value='2WD Tractor'>2WD Tractor</option>
<option value='4WD Tractor'>4WD Tractor</option>
<option value='Ambulance'>Ambulance</option>
<option value='Crane'>Crane</option>
<option value='Dozer'>Dozer</option>
<option value='Dumper'>Dumper</option>
<option value='Excavator'>Excavator</option>
<option value='Fire Brigade'>Fire Brigade</option>
<option value='Fork Lifter'>Fork Lifter</option>
<option value='Hearse'>Hearse</option>
<option value='Road Roller'>Road Roller</option>
<option value='Trade Plate'>Trade Plate</option>
<option value='Trailer'>Trailer</option>
<option value='Treedozer'>Treedozer</option>
<option value='Agriculture Sprayer'>Agriculture Sprayer</option>
<option value='Dust Cart'>Dust Cart</option>
<option value='Grabs'>Grabs</option>
<option value='Leveller'>Leveller</option>
<option value='Mechanical Navies'>Mechanical Navies</option>
<option value='Mobile Canteen / Shop'>Mobile Canteen / Shop</option>
<option value='Mobile Plant'>Mobile Plant</option>
<option value='Mobile Surgery Vehicle'>Mobile Surgery Vehicle</option>
<option value='Mobile X-Ray Vehicle'>Mobile X-Ray Vehicle</option>
<option value='Ripper'>Ripper</option>
<option value='Road Finishing Machine'>Road Finishing Machine</option>
<option value='Road Sweeper'>Road Sweeper</option>
<option value='Scraper'>Scraper</option>
<option value='Sheep Foot Tamping Roller'>Sheep Foot Tamping Roller</option>
<option value='Shovels'>Shovels</option>
<option value='Tar Sprayer'>Tar Sprayer</option>
<option value='Tea Sprayer'>Tea Sprayer</option>
<option value='Tower Wagon'>Tower Wagon</option>
<option value='Trail Builder'>Trail Builder</option>
<option value='Water Cart'>Water Cart</option>
<option value='Welding Plant'>Welding Plant</option>
<option value='Motor Car'>Motor Car</option>
<option value='Jeep'>Jeep</option>
<option value='Double Cab'>Double Cab</option>
<option value='Crew Cab'>Crew Cab</option>
<option value='Van'>Van</option>
<option value='Three Wheeler'>Three Wheeler</option>
<option value='Motor Lorry'>Motor Lorry</option>
<option value='Single Cab(L)'>Single Cab(L)</option>
<option value='Bowser'>Bowser</option>
<option value='Prime Mover'>Prime Mover</option>
<option value='Passenger Carrying Bus'>Passenger Carrying Bus</option>
<option value='Route Bus'>Route Bus</option>
<option value='Motor Cycle-Normal'>Motor Cycle-Normal</option>
<option value='Motor Cycle-Staff'>Motor Cycle-Staff</option>
<option value='Single Cab'>Single Cab</option>

                  </select>
                </div>
                </div>
                 <div class="form-group">
                  <div class="form-group">
                  <label>Usage</label>
                  <select class="form-control" id="Usage"  name="Usage">
                    
                                    <option value="Agriculture">Agriculture</option>
                                    <option value="Private">Private</option>
                                    <option value="Hiring">Hiring</option>
                                    <option value="Rent">Rent</option>
                                    <option value="Route">Route</option>
                  </select>
                </div>
                </div>
               <div class="form-group">
                  <div class="form-group">
                  <label>FuelType</label>
                  <select class="form-control" id="FuelType"  name="FuelType" >
                    
                                    <option value="Electric">Electric</option>
                                    <option value="None">None</option>
                                    <option value="Petrol">Petrol</option>
                                    <option value="Diesel">Diesel</option>
                                    <option value="Hybrid">Hybrid</option>
                  </select>
                </div>
                </div>
               
              </div>
              <!-- /.box-body -->

             <!--  <div class="box-footer">
                <button type="submit" class="btn btn-primary" onclick="return calprim()">Submit</button>
              </div> -->
          
          </div>
          <!-- /.box -->
          </div>














            <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">POLICY COVERS</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
     
              <div class="box-body">
                <div class="form-group">

                <input type="checkbox" id="TPPD" name="TPPD"></input>
                  <label for="exampleInputEmail1">TPPD</label>
                 <!--  <input type="number" class="form-control" id="sum"  name="sum" required> -->
                  <select class="form-control" id="STPPD"  name="STPPD" >
                                    <option value="0">Select One</option>
                                    <option value="100,000.00">100,000.00</option>
                                    <option value="300,000.00">300,000.00</option>
                                    <option value="500,000.00">500,000.00</option>
                                    <option value="1,000,000.00">1,000,000.00</option>
                                    <option value="2,000,000.00">2,000,000.00</option>
                  </select>



                </div>



                <div class="form-group">
                 <input type="checkbox" id="PBAForDriver" name="PBAForDriver"></input>

                  <label for="exampleInputEmail1">PAB for driver</label>
                <div class="row">

               
                 <!--  <input type="number" class="form-control" id="sum"  name="sum" required> -->
                   <div class="col-md-5">
                        <select class="form-control" style="width: 40%" id="SPBAForDriver"  name="SPBAForDriver" >
                        
                                    <option value="0">Select</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                  
                       </select>
                      </div>
                     <div class="col-md-6">
                       <input type="number" class="form-control" id="IPBAForDriver"  name="IPBAForDriver" required>
                       </div>
                </div>
                </div>



                <div class="form-group">
                 <input type="checkbox" id="PBAForPassenger" name="PBAForPassenger"></input>

                  <label for="exampleInputEmail1">PAB for Passenger</label>
                <div class="row">

               
                 <!--  <input type="number" class="form-control" id="sum"  name="sum" required> -->
                      <div class="col-md-5">
                        <select class="form-control" style="width: 40%" id="SPBAForPassenger"  name="SPBAForPassenger" >
                      
                                    <option value="0">Select</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                              
                                  
                       </select>
                      </div>
                     <div class="col-md-6">
                       <input type="number" class="form-control" id="IPBAForPassenger"  name="IPBAForPassenger" required>
                      </div>
                </div>
                </div>








                <div class="form-group">
                 <input type="checkbox" id="Windscreen" name="Windscreen"></input>

                  <label for="exampleInputEmail1">Windscreen</label>
               

               
                 <input type="number" class="form-control" id="IWindscreen"  name="IWindscreen" required> 
                  
                
                </div>


                 <div class="form-group">
                 <input type="checkbox" id="TowingCharge" name="TowingCharge"></input>

                  <label for="exampleInputEmail1">Towing Charge</label>
               

               
                 <input type="number" class="form-control" id="ITowingCharge"  name="ITowingCharge" required> 
                  
                
                </div>

             <!--     <div class="form-group">
                 <input type="checkbox" id="check_RentACar" name="check_RentACar"></input>

                  <label for="exampleInputEmail1">Rent A Car</label>
      
                </div>
 -->

              <!--     <div class="form-group">
                 <input type="checkbox" id="AirBagReplacement" name="AirBagReplacement"></input>

                  <label for="exampleInputEmail1">Air Bag Replacement</label>
               

               
                 <input type="number" class="form-control" id="IAirBagReplacement"  name="IAirBagReplacement" required> 
                  
                
                </div>
 -->

                  <div class="form-group">
                 <input type="checkbox" id="check_WCI" name="check_WCI"></input>

                  <label for="exampleInputEmail1">WCI</label>
                <div class="row">

               
                 <!--  <input type="number" class="form-control" id="sum"  name="sum" required> -->
                      <div class="col-md-5">
                        <select class="form-control" style="width: 40%" id="WCI"  name="WCI" >
                      
                                    <option value="0">Select</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    
   
                       </select>
                      </div>
                    
                </div>
                </div>





                  <div class="form-group">
                 <input type="checkbox" id="check_LegalLiabilityTick" name="check_LegalLiabilityTick"></input>

                  <label for="exampleInputEmail1">Legal Liability</label>
                <div class="row">

               
                 <!--  <input type="number" class="form-control" id="sum"  name="sum" required> -->
                      <div class="col-md-5">
                  <label for="exampleInputEmail1">Count</label>

                        <select class="form-control" style="width: 40%" id="LegalLiability"  name="LegalLiability" >
                      
                                    <option value="0">Select</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>
                                    
   
                       </select>
                      </div>


                       <div class="col-md-5">
                        <label for="exampleInputEmail1">Amount</label>
                        <select class="form-control" style="width: 50%" id="LegalLiabilityAmount"  name="LegalLiabilityAmount" >
                      
                                    <option value="0">Select</option>
                                    <option value="2,000.00">2,000.00</option>
                                    <option value="10,000.00">10,000.00</option>
                                    <option value="20,000.00">20,000.00</option>
                                    <option value="50,000.00">50,000.00</option>
                                    <option value="100,000.00">100,000.00</option>
                                    <option value="200,000.00">200,000.00</option>
                                    <option value="500,000.00">500,000.00</option>
                                    
   
                       </select>
                      </div>
                    
                </div>
                </div>


              
        
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" onclick="return PrimWithCovers()">Submit</button>
              </div>
          
          </div>
          <!-- /.box -->
          </div>

      <div class="col-md-3">
          <div class="box box-info box-solid">
            <div class="box-header">
              <h3 class="box-title">Primum </h3>
            </div>
            <div class="box-body" id="loadBody" style="font-size: 150%">
            0
            </div>
            <!-- /.box-body -->
            <!-- Loading (remove the following to stop the loading)-->
            <div class="overlay" id="loadEffect" hidden="">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- end loading -->
          </div>
          <!-- /.box -->

          <strong id="PError" style="color:red"></strong>
        </div>

</section>


          
       

     </div>

     

      </div>

        </div>




     <script type="text/javascript">

function format1(n, currency) {
    return currency + " " + n.toFixed(2).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
}




       function calprim(){


 $("#loadEffect").removeAttr("hidden");
 $("#loadEffect").show();
 document.getElementById("loadBody").innerHTML = "Loading.....";



             // var webserUrl = "http://localhost:62187/SampleService.asmx";


        var sum           = document.getElementById("sum").value;
        var Vehicle_type  = document.getElementById("Vehicle_type").value;
        var Usage         = document.getElementById("Usage").value;
        var FuelType      = document.getElementById("FuelType").value;

        if(sum == ""){

  swal('Sum Insured is empty!',"",'warning');
 $("#loadEffect").hide();
 document.getElementById("loadBody").innerHTML ="";
return false;

        }


//alert("1:"+sum+"vT :"+Vehicle_type+"usage:"+Usage+"FuelType:"+FuelType);


                        var soapRequest =
'<?xml version="1.0" encoding="utf-8"?>\
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" \
xmlns:xsd="http://www.w3.org/2001/XMLSchema" \
xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">\
  <soap:Body>\
    <CalculateTotalPremium xmlns="http://tempuri.org/">\
      <SumInsured>'+sum+'</SumInsured>\
      <VehicleType>'+Vehicle_type+'</VehicleType>\
      <usage>'+Usage+'</usage>\
      <fuelType>'+FuelType+'</fuelType>\
    </CalculateTotalPremium>\
  </soap:Body>\
</soap:Envelope>';




             $.ajax({
                    type: "POST",
                    url: "http://192.168.10.212:8039/HNBAGService.asmx",
                    contentType: "text/xml",
                    dataType: "xml",
                    data: soapRequest,
                   /* data: { 
                        sum:sum,
                        Vehicle_type:Vehicle_type,
                        Usage:Usage,
                        FuelType:FuelType 
                    },*/
                     success: SuccessOccur,
                    error: ErrorOccur
                });

              function SuccessOccur(data, status, req) {
            if (status == "success")
               // alert(req.responseText);
              console.log(req.responseText);
         

              var text = req.responseXML;
              // $("#loadEffect").removeAttr("hidden");
 $("#loadEffect").hide();
             var  x = text.getElementsByTagName('CalculateTotalPremiumResponse');
            //alert(x);
           // console.log(x);

            // alert(x[0].textContent);

             document.getElementById("loadBody").innerHTML = format1(Number(x[0].textContent.replace('"',' ').replace('"',' ')), "RS :");
        }
        function ErrorOccur(data, status, req) {


            alert(req.responseText + " " + status);
        }

       }



function PrimWithCovers(){



 $("#loadEffect").removeAttr("hidden");
 $("#loadEffect").show();
 document.getElementById("loadBody").innerHTML = "Loading.....";



        var sum           = document.getElementById("sum").value;
        var Vehicle_type  = document.getElementById("Vehicle_type").value;
        var Usage         = document.getElementById("Usage").value;
        var FuelType      = document.getElementById("FuelType").value;


        var dataArray     = {};
        var CoverArray    = new Array();
        var cover1        = {};
        var cover2        = {};
        var cover3        = {};
        var cover4        = {};
        var cover5        = {};
        var cover7        = {};
        var cover8        = {};
        var cover9        = {};


        dataArray["sumInsured"] = sum;
        dataArray["vehicleType"] = Vehicle_type;
        dataArray["usage"] = Usage;
        dataArray["fuelType"] = FuelType;


 
        var check_TPPD              = document.getElementById("TPPD").checked;
        var check_PBAForDriver      = document.getElementById("PBAForDriver").checked;
        var check_PBAForPassenger   = document.getElementById("PBAForPassenger").checked;
        var check_Windscreen        = document.getElementById("Windscreen").checked;
        var check_TowingCharge      = document.getElementById("TowingCharge").checked;
        /*var check_AirBagReplacement = document.getElementById("AirBagReplacement").checked;*/
       /* var check_RentACar          = document.getElementById("check_RentACar").checked;*/
        var check_WCI               = document.getElementById("check_WCI").checked;
        var check_LegalLiabilityTick  = document.getElementById("check_LegalLiabilityTick").checked;



        if(sum == ""){

          swal('Sum Insured is empty!',"",'warning');
          $("#loadEffect").hide();
          document.getElementById("loadBody").innerHTML ="";
          return false;

        }
        if(check_TPPD == true){

            var TPPD_amount = document.getElementById("STPPD").value;

            if(TPPD_amount == '0'){
               swal('TPPD amount should not be empty!',"",'warning');
               return false;

            }
           
            cover1["cover"]  =  "TPPD";
            cover1["amount"] =  TPPD_amount;
            //cover1 = JSON.stringify(cover1);
            CoverArray.push(cover1);
          
         

        }

         if(check_PBAForDriver == true){

            var count  = document.getElementById("SPBAForDriver").value;
            var amount = document.getElementById("IPBAForDriver").value;

            if(count == '0'){
               swal('PBA For Driver : Count should not be empty!',"",'warning');
               return false;

            }

            if(amount == ""){

              swal('PBA For Driver : Amount should not be empty!',"",'warning');
               return false;

            }

            cover2["cover"]  =  "PAB for driver";
            cover2["count"]  =  count;
            cover2["amount"] =  amount;
            //cover2 = JSON.stringify(cover2);
            CoverArray.push(cover2);
      

        }

         if(check_PBAForPassenger == true){

            var count  = document.getElementById("SPBAForPassenger").value;
            var amount = document.getElementById("IPBAForPassenger").value;

              if(count == '0'){
               swal('PBA For Passenger : Count should not be empty!',"",'warning');
               return false;

            }

            if(amount == ""){

              swal('PBA For Passenger : Amount should not be empty!',"",'warning');
               return false;

            }




            cover3["cover"]  =  "PAB for Passenger";
            cover3["count"]  =  count;
            cover3["amount"] =  amount;
           // cover3 = JSON.stringify(cover3);
            CoverArray.push(cover3);
        

        }
            if(check_Windscreen == true){

            var amount = document.getElementById("IWindscreen").value;

            if(amount == ""){

              swal('Windscreen : Amount should not be empty!',"",'warning');
               return false;

            }

            cover4["cover"]  =  "Windscreen";
            cover4["amount"] =  amount;
           // cover4 = JSON.stringify(cover4);
            CoverArray.push(cover4);
         

        }
          if(check_TowingCharge == true){

            var amount = document.getElementById("ITowingCharge").value;


            if(amount == ""){

              swal('Towing Charge : Amount should not be empty!',"",'warning');
               return false;

            }


            cover5["cover"]  =  "Towing Charge";
            cover5["amount"] =  amount;
            //cover5 = JSON.stringify(cover5);
           CoverArray.push(cover5);
        

        }
         /* if(check_AirBagReplacement == true){

            var amount = document.getElementById("IAirBagReplacement").value;

             if(amount == ""){

              swal('Air Bag Replacement : Amount should not be empty!',"",'warning');
               return false;

            }

            cover6["cover"]  =  "Air Bag Replacement";
            cover6["amount"] =  amount;
           // cover6 = JSON.stringify(cover6);
            CoverArray.push(cover6);
       

        }*/

        /*if(check_RentACar == true){

            var amount = "";
            var count = "";


            cover7["cover"]  =  "Rent A Car";
            cover7["count"] =  count;
            cover7["amount"] =  amount;
           
           // cover6 = JSON.stringify(cover6);
            CoverArray.push(cover7);
       

        }
*/

         if(check_WCI == true){

            var amount = document.getElementById("WCI").value;

             if(amount == "0"){

              swal('WCI : please select an option!',"",'warning');
               return false;

            }

            cover8["cover"]  =  "WCI";
            cover8["count"]  =  count;
            cover8["amount"] =  amount;
           // cover6 = JSON.stringify(cover6);
            CoverArray.push(cover8);
       

        }


        if(check_LegalLiabilityTick == true)
        {

            var amount = document.getElementById("LegalLiabilityAmount").value;
            var count   = document.getElementById("LegalLiability").value;

            if(amount == "0"){

              swal('Legal Liability : Amount should not be empty!',"",'warning');
               return false;

            }
             if(count == "0"){

              swal('Legal Liability : count should not be empty!',"",'warning');
               return false;

            }


            cover9["cover"]  =  "Legal Liability";
            cover9["count"]  =  count;
            cover9["amount"] =  amount;
            //cover5 = JSON.stringify(cover5);
           CoverArray.push(cover9);
        

        }


       //alert(CoverArray);
        dataArray["covers"] = CoverArray;
        var myJsonString = JSON.stringify(dataArray);



        console.log(myJsonString);

      
        //alert(myJsonString);
        //alert(CoverArray);


//return false;

//alert("1:"+sum+"vT :"+Vehicle_type+"usage:"+Usage+"FuelType:"+FuelType);


/*                        var soapRequest =
'<?//xml version="1.0" encoding="utf-8"?>\
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" \
xmlns:xsd="http://www.w3.org/2001/XMLSchema" \
xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">\
  <soap:Body>\
    <CalculateTotalPremiumResponse  xmlns="http://tempuri.org/">\
     <CalculateTotalPremiumResult>'+myJsonString+'</CalculateTotalPremiumResult>\
    </CalculateTotalPremiumResponse >\
  </soap:Body>\
</soap:Envelope>';*/

document.getElementById("PError").innerHTML = "";

var soapRequest ='<?xml version="1.0" encoding="utf-8"?>\
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">\
  <soap:Body>\
    <CalculateTotalPremium xmlns="http://tempuri.org/">\
      <jsonString>'+myJsonString+'</jsonString>\
    </CalculateTotalPremium>\
  </soap:Body>\
</soap:Envelope>';


             $.ajax({
                    type: "POST",
                    url: "http://192.168.10.212:8039/HNBAGService.asmx",
                    contentType: "text/xml",
                    dataType: "xml",
                    data: soapRequest,
                   /* data: { 
                        sum:sum,
                        Vehicle_type:Vehicle_type,
                        Usage:Usage,
                        FuelType:FuelType 
                    },*/
                     success: SuccessOccur,
                    error: ErrorOccur
                });

              function SuccessOccur(data, status, req) {
            if (status == "success")
               // alert(req.responseText);
              console.log(req.responseText);
         

              var text = req.responseXML;
              // $("#loadEffect").removeAttr("hidden");
 $("#loadEffect").hide();
             var  x = text.getElementsByTagName('CalculateTotalPremiumResponse');
            //alert(x);
           // console.log(x);

            // alert(x[0].textContent);

            console.log(x[0].textContent);

            
             if(x[0].textContent == "Premium clculation is failed"){

             
               document.getElementById("PError").innerHTML = "Premium clculation is failed";
                document.getElementById("loadBody").innerHTML = 0.00;
               return false;
            }

            if(x[0].textContent == "Three Wheeler Minimum Premium not achieved"){

             
               document.getElementById("PError").innerHTML = "Three Wheeler Minimum Premium not achieved";
               document.getElementById("loadBody").innerHTML = 0.00;
               return false;
            }

             document.getElementById("loadBody").innerHTML = format1(Number(x[0].textContent.replace('"',' ').replace('"',' ')), "RS :");
        }
        function ErrorOccur(data, status, req) {


            alert(req.responseText + " " + status);
        }


}

      </script>
@endsection