<?php
namespace Primetime;
require __DIR__ . '/../src/functions.php';
require __DIR__ . '/../src/new-pt-process.php';
?>

<?php view('form-header', ['title' => 'New Patient Registration']) ?>

<?php view('primetime-logo') ?>
<p class="h5 text-center">NEW PATIENT REGISTRATION FORM</p>

<div class="container-fluid" style="border:1px solid #737373; max-width: 95%">
	<br>	
	<div class="container-fluid">
		<form id="new-patient" method="POST" style="padding-left: 20px">
			<p class="h5">Patient Information</p> 
        	<div class="form-row">
        		<div class="col-sm-6 col-md-4">
                 	<input type="text" class="form-control mb-2" id="ptfirstname" placeholder="First Name" maxlength="30" required 
						value="<?= $inputs['ptfirstname'] ?? '' ?>">
						<small><?= $errors['texterror'] ?? '' ?></small>
            	</div>
            	<div class="col-sm-6 col-md-4">
					<input type="text" class="form-control mb-2" id="ptmiddlename" placeholder="Middle Name" maxlength="25">
                </div>
	            <div class="col-sm-6 col-md-4">
					<input type="text" class="form-control mb-2" id="ptlastname" placeholder="Last Name" maxlength="30" required>
                </div>
            </div>

            <div class="form-group"> 
				<input type="text" class="form-control mb-2" id="ptaddress" placeholder="Address" maxlength="50" required>
            </div>
			<div class="form-row">
				<div class="col-sm-6 col-md-3">			
					<input type="text" class="form-control mb-2" id="ptAddress2" placeholder="Apartment, Studio, or Floor" maxlength="35">
				</div>
				<div class="col-sm-6 col-md-3">
					<input type="number" pattern="[0-9]*" class="form-control mb-2" id="ptSSN" placeholder="Patient's SSN">
				</div>
				<div class="col-md-6 col-md-3">
					<input type="tel" class="form-control mb-2" id="ptPhone1" placeholder="Primary Phone">
				</div>
				<div class="col-md-6 col-md-3">
					<input type="tel" class="form-control mb-2" id="ptPhone2" placeholder="Secondary Phone" required>
				</div>
			
			</div>
            <div class="form-row">
				<div class ="col-sm-6 col-md-6">			 
					<input type="email" class="form-control mb-2" id="ptEmail" placeholder="Email Address (for appointment reminders)" maxlength="50" required>
				</div>
				<div class="col-sm-6 col-md-3">
					<select class="form-control mb-2" id="ptGender" required>
					<option selected>Select Gender</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Other">Other</option>
					</select>
				</div>
				<div class="col-sm-6 col-md-3">
					<select class="form-control mb-2" id="ptMstatus" required>
					<option selected>Select Marital Status</option>
					<option value="Married">Married</option>
					<option value="Single">Single</option>
					<option value="Divorced">Divorced</option>
					<option value="Separated">Separated</option>
					<option value="Widowed">Widowed</option>
					</select>
				</div>
			</div>
            <div class="form-row">
                <div class="col-sm-6 col-md-4">    
					<input type="text" class="form-control mb-2" id="ptCity" placeholder="City" maxlength="25" required>
                </div>
				<div class="col-sm-6 col-md-1">      
					<select class="form-control mb-2" id="ptState" required>
					<option selected>State</option>
					<?php view('states') ?>
					</select>
				</div>
				<div class="col-sm-6 col-md-2">      
					<input type="number" class="form-control mb-2" id="ptZip" placeholder="Zip Code" required>
				</div>
				<div class="col-sm-6 col-md-2">      
					<div class="nativeDatePicker form-control mb-2" onfocus="(this.type='date')" onblur="(this.type='text')">
						<input type="date" id="ptDOB" name="ptDOB">
						<span class="validity"></span>
					</div>
					<p class="fallbackLabel">Patient's DOB</p>
					<div class="fallbackDatePicker">
					<span>
						<label for="day">Day:</label>
							<select id="day" name="day">
							</select>
					</span>
					<span>
						<label for="month">Month:</label>
							<select id="month" name="month">
								<option selected>January</option>
								<option>February</option>
								<option>March</option>
								<option>April</option>
								<option>May</option>
								<option>June</option>
								<option>July</option>
								<option>August</option>
								<option>September</option>
								<option>October</option>
								<option>November</option>
								<option>December</option>
							</select>
					</span>
					<span>
						<label for="year">Year:</label>
							<select id="year" name="year">
							</select>
					</span>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<select class="form-control mb-2" id="ptReligious" required>
					<option selected>Religious beliefs that may affect care?</option>
					<option value="Yes">Yes</option>
					<option value="No">No</option>
					</select>
				</div>
			</div>
			
			<br>
			<div class="alert alert-primary show form-row" role="alert">
				<div class="col d-flex justify-content-start">
					<label class="float-left width:80% text-align:right">As a courtesy, you will typically receive a reminder call the day before your appointments. If you do not wish to receive these calls, please check here.
					</label>
				</div>
				<div class="d-flex justify-content-end"> 
					<input type="radio" name="radios" class="form-check-input" id="doNotRemind">
				</div>
			</div>	
			
		</form>
	
		</div>
	<br> 
	<div class="container-fluid">
    <form style="padding-left: 10px">
	   <p class="h5">Emergency Contact Information</p> 
       <div class="form-row">
            <div class="col-sm-6 col-md-4">
            <input type="text" class="form-control mb-2" id="emfirstname" placeholder="First Name" maxlength="30" required>
            </div>
	        <div class="col-sm-6 col-md-4">
            <input type="text" class="form-control mb-2" id="emlastname" placeholder="Last Name" maxlength="30" required>
            </div>
	        <div class="col-sm-6 col-md-2">
            <input type="tel" class="form-control mb-2" id="emPhone" placeholder="Emergency Phone" required>
	        </div>
	        <div class="col-sm-6 col-md-2">
            <input type="text" class="form-control mb-2" id="relationtopt" placeholder="Relationship to Patient" required>
            </div>
       </div>
	</form><br>
	</div>
	<br> 
	<div class="container-fluid">
     <form style="padding-left: 10px">
	 <p class="h5">Insurance Information</p>
     <div class="alert alert-primary alert-dismissible fade show" role="alert">
     PLEASE CAREFULLY COMPLETE ALL SECTIONS, AS THIS WILL AFFECT YOUR CLAIM FILING
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
     </button>
     </div>
	 <div class="form-row">
         <div class="col-sm-6 col-md-5">
         <input type="text" class="form-control mb-2" id="Insurance1" placeholder="Primary Insurance">
	     </div>
         <div class="col-sm-6 col-md-3">
         <input type="text" class="form-control mb-2" id="insID1" placeholder="ID Number">
         </div>
	     <div class="col-sm-6 col-md-4">
         <input type="text" class="form-control mb-2" id="insGrp1" placeholder="Group Number">
         </div>
	 </div>
	 <div class="form-row">
         <div class="col-sm-6 col-md-7">
         <input type="text" class="form-control mb-2" id="insName1" placeholder="Subscriber's Name">
         </div>
         <div class="col-sm-6 col-md-3">
         <input type="number" class="form-control mb-2" id="insSSN1" placeholder="Subscriber's Soc Sec #">
         </div>
	     <div class="col-sm-6 col-md-2">      
         <input type="text" class="form-control mb-2" onfocus="(this.type='date')" onblur="(this.type='text')" id="insDOB1" placeholder="Subscriber's DOB">
	     </div>
     </div>
		 <br>	
  	 <div class="form-row">
         <div class="col-sm-6 col-md-5">
         <input type="text" class="form-control mb-2" id="Insurance2" placeholder="Secondary Insurance">
	     </div>
         <div class="col-sm-6 col-md-3">
         <input type="text" class="form-control mb-2" id="insID2" placeholder="ID Number" required>
         </div>
	     <div class="col-sm-6 col-md-4">
         <input type="text" class="form-control mb-2" id="insGrp2" placeholder="Group Number">
         </div>
	 </div>
	 <div class="form-row">
         <div class="col-sm-6 col-md-7">
         <input type="text" class="form-control mb-2" id="insName2" placeholder="Subscriber's Name">
         </div>
         <div class="col-sm-6 col-md-3">
         <input type="number" class="form-control mb-2" id="insSSN2" placeholder="Subscriber's Soc Sec #">
         </div>
	     <div class="col-sm-6 col-md-2">      
         <input type="text" class="form-control mb-2" onfocus="(this.type='date')" onblur="(this.type='text')" id="insDOB2" placeholder="Subscriber's DOB">
	     </div>
     </div>
	 <br>  
	 <div class="form-row">
         <div class="col-sm-6 col-md-5">
         <input type="text" class="form-control mb-2" id="Insurance3" placeholder="Tertiary Insurance">
	     </div>
         <div class="col-sm-6 col-md-3">
         <input type="text" class="form-control mb-2" id="insID3" placeholder="ID Number">
         </div>
	     <div class="col-sm-6 col-md-4">
         <input type="text" class="form-control mb-2" id="insGrp3" placeholder="Group Number">
         </div>
	 </div>
	 <div class="form-row">
         <div class="col-sm-6 col-md-7">
         <input type="text" class="form-control mb-2" id="insName3" placeholder="Subscriber's Name">
         </div>
         <div class="col-sm-6 col-md-3">
         <input type="number" class="form-control mb-2" id="insSSN3" placeholder="Subscriber's Soc Sec #">
         </div>
	     <div class="col-sm-6 col-md-2">      
         <input type="text" class="form-control mb-2" onfocus="(this.type='date')" onblur="(this.type='text')" id="insDOB3" placeholder="Subscriber's DOB">
	     </div>
     </div>
	 </form>
	  
	<br>  
	</div>
	<br>
	<div class="container-fluid">
		<form style="padding-left: 10px">
		<p class="h5">Auto Accident or Work Related Injury</p>
       	<div class="form-row">
        	<div class="col-sm-6 col-md-4">    
                 <input type="text" class="form-control mb-2" id="wcInsName" placeholder="Auto/Work Comp Insurance Co. Name" maxlength="25">
            </div>
			<div class="col-sm-6 col-md-4">    
                 <input type="text" class="form-control mb-2" id="wcCaseWorker" placeholder="Case Worker" maxlength="25">
            </div>
			<div class="col-sm-6 col-md-2">      
				<input type="number" class="form-control mb-2" id="wcClaimNumber" placeholder="Claim Number">
			</div>
			<div class="col-sm-6 col-md-2">    
                 <input type="text" class="form-control mb-2" id="wcAccType" placeholder="Accident Type" maxlength="25">
            </div>
		</div>	
		<div class="form-row">
			<div class="col-sm-6 col-md-6">    
                <input type="text" class="form-control mb-2" id="lawyerName" placeholder="Attorney's Name" maxlength="25">
            </div>
			<div class="col-sm-6 col-md-3">
				<input type="tel" class="form-control mb-2" id="lawyerPhone" placeholder="Attorney's Phone">
         	</div>
			<div class="col-sm-6 col-md-2">      
				<input type="text" class="form-control mb-2" onfocus="(this.type='date')" onblur="(this.type='text')" id="wcDateofAcc" placeholder="Date of Accident">
			</div>
			<div class="col-sm-6 col-md-1">      
            	<select class="form-control mb-2" id="wcState" required>
					<option selected>State</option>
						<?php view('states') ?>
				 </select>
		    </div>
		</div>
		</form><br>
	</div>
	<div class="container-fluid">
		<form style="padding-left: 10px">
			<div class="alert alert-primary" role="alert">
		<h4 class="alert-heading">Medicare Part B Patients:</h4>
		<p>Are you currently receiving or have you received any of these services THIS YEAR (Select from list)</p>
		<fieldset class="form-group mb-0">
			<div class="row">
			
				<div class="col-sm-10">
					<div class="form-check">
						<input class="form-check-input" type="radio" id="medb_spchthrpy" value="option1">
						<label class="form-check-label" for="medb_spchthrpy">
							Speech Therapy
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" id="medb_occuthrpy" value="option2">
						<label class="form-check-label" for="medb_occuthrpy">
							Occupational Therapy
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" id="medb_physthrpy" value="option3">
						<label class="form-check-label" for="medb_physthrpy">
							Physical Therapy
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" id="medb_homehlth" value="option4">
						<label class="form-check-label" for="medb_homehlth">
							Home Health
						</label>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
		</form>
	</div>
	<br>
	
	
	<div class="container-fluid">
		<p class="h5">Guarantor/Parent Information </p>
		<form style="padding-left: 10px" id="guarantor-info">
			<div class="btn-group-toggle mb-2" data-toggle="buttons">
				<label class="btn btn-primary active" style="width:100%">
					<input type="checkbox" checked onclick="input_disable(this);" id="g_check"> If guarantor or parent is also the patient, click here.
				</label>	
			</div>
			<fieldset id="g-info">
				<div class="form-row">
					<div class="col-sm-6 col-md-6">
						<input type="text" class="form-control mb-2" id="guarName" placeholder="Guarantor's Name">
					</div>
					<div class="col-sm-6 col-md-3">      
						<input type="text" class="form-control mb-2" onfocus="(this.type='date')" onblur="(this.type='text')" id="guarDOB" placeholder="Guarantor's DOB">
					</div>
					<div class="col-sm-6 col-md-3">
						<input type="text" class="form-control mb-2" id="guarSSN" placeholder="Guarantor's SS#">
					</div>
				</div>
				<div class="form-row">
					<div class="col-sm-6 col-md-7">
						<input type="text" class="form-control mb-2" id="guarAddress" placeholder="Guarantor's Address">
					</div>
					<div class="col-sm-6 col-md-2">
						<input type="text" class="form-control mb-2" id="guarApt" placeholder="Apt or Suite">
					</div>
					<div class="col-sm-6 col-md-3">
						<input type="text" class="form-control mb-2" id="guarCity" placeholder="City">
					</div>
				</div>	
				<div class="form-row">	
					<div class="col-sm-6 col-md-1">
						<select class="form-control mb-2" id="guarState" placeholder="State">
					<option selected>State</option>
						<?php view('states') ?>
				</select>
					</div>
					<div class="col-sm-6 col-md-3">      
						<input type="number" class="form-control mb-2" id="guarZip" placeholder="Zip Code" required>
					</div>
					<div class="col-sm-6 col-md-4">    
						<input type="tel" class="form-control mb-2" id="guarPhone1" placeholder="Primary/Mobile Phone">
					</div>
					<div class="col-sm-6 col-md-4">
						<input type="tel" class="form-control mb-2" id="guarPhone2" placeholder="Secondary/Work Phone">
					</div> 
				</div>
			</fieldset>
		</form>
	</div>

	<br>
	<br>
	<div class="container-fluid">
		<form style="padding-left: 10px">
			<div class="p">
	<strong>ALL PATIENTS AND RESPONSIBLE PARTIES PLEASE READ AND SIGN:</strong>
	I authorize release of any medical information necessary to process the claim. I authorize the payment of medical benefits directly to this office for 
	services rendered. I understand that I am finanacially responsible for charges not covered by this authorization, except where prohibited by law. If the 
	delinquent account is referred for collection and/or litigation, patient agrees to pay Primetime Physical Therapy's collection agency fees, attorney's
	fees and court costs associated with the collection of /litigation process. I understand that Primetime Physical Therapy assumes no responsibility for
	personal property such as jewelry, glasses, dentures, clothing items, or any other personal items. I agree to hold Primetime Physical Therapy risk-free
	from any and all costs, liability, and damages of any nature whatsoever, including reasonable attorney's fees, resulting directly from the release of my
	medical records pursuant to this consent. I acknowledge that I have read this authorization and fully understand its contents.
	</p>
		</form>
	</div>
	<br><br>
	</div>
	<div class="container-fluid">    
		<form class="container" action="process.php" method="POST" name="SIGFORM" onSubmit="submitForm();" enctype="multipart/form-data" target="_self">
			<div id="signature-pad" class="m-signature-pad">
				<div class="m-signature-pad--body">
					<canvas></canvas>
					<input type="hidden" name="signature" id="signature" value="">
				</div>
			</div>        
			<button type="submit" class="btn-primary">Sign and Submit</button>
			<button type="button" class="btn-secondary" onclick="signaturePad.clear();">Clear Pad</button><br><br>
		</form>
	
	</div>

	
	
</div>







<script src="js/signature_pad.js"></script>
<script type="text/javascript">


</script>
<script src="../js/primetimept.js"></script>
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap-4.4.1.js"></script>
<?php view('footer') ?>