<script type="text/javascript">
	$(function(){
			//alert("jquery loaded");
			$('#selected_claimant').change(function(){
				if($(this).val().length > 0){
					$('#form1').submit();
				} else {
					alert("Please select claimant to load data.");
				}
				
			});
	});
</script>


<div class="container-fluid well">
	<h2 class="text-center">VOUCHER / OBR / CERTIFICATION</h2>
	<hr>
	<div class="text-right">
 		<a class="btn btn-default btn-link" href='search'>
 			<span class="glyphicon glyphicon-search" aria-hidden="true"></span> SEARCH / UPDATE
 	 	</a>
 	</div>
	<?php 
		if(isset($errorMsg)) echo $errorMsg;
	?>
	
	<form method="post" action="loadClaimantData" id="form1">
            
            
            
		
		<fieldset>
			<legend class="text-primary"><small>PAYEE / CLAIMANT</small></legend>
			<div class="row">
				<div class="form-group col-md-2">
					<select class="form-control" id="selected_claimant" name="selected_claimant" required>
						<option value="">-- Select here --</option>
						<?php 
							foreach ($client_ctr_no as $row) {
								$claimant_name = $row->CLAIMANT_FNAME." ,".$row->CLAIMANT_LNAME;
								$control_no = $row->CONTROL_NO;
								if(isset($current_selected)){
									if($control_no == $current_selected)
										echo "<option value='$control_no' selected>$claimant_name</option>";
									else
										echo "<option value='$control_no'>$claimant_name</option>";
								} else {
									echo "<option value='$control_no'>$claimant_name</option>";
								}
								
							}
						?>						
					</select>
				</div>
			</div>
		</fieldset>
	</form>

	<br>


	<form method="post" action="saveVrObrCert">
            <input type="hidden" name="dv_obr_cert[deceased_fname]" value="<?php if(isset($deceased_fname)) echo $deceased_fname;?>">
            <input type="hidden" name="dv_obr_cert[deceased_mname]" value="<?php if(isset($deceased_mname)) echo $deceased_mname;?>">
            <input type="hidden" name="dv_obr_cert[deceased_lname]" value="<?php if(isset($deceased_lname)) echo $deceased_lname;?>">
            
            <input type="hidden" name="dv_obr_cert[claimant_fname]" value="<?php if(isset($claimant_fname)) echo $claimant_fname;?>">
            <input type="hidden" name="dv_obr_cert[claimant_mname]" value="<?php if(isset($claimant_mname)) echo $claimant_mname;?>">
            <input type="hidden" name="dv_obr_cert[claimant_lname]" value="<?php if(isset($claimant_lname)) echo $claimant_lname;?>">
		<div class="form-group text-center">
			<button type="submit" class="btn btn-primary btn-lg">Save</button>
			<button type="reset" class="btn btn-default btn-lg">Clear</button>
			<a href="./" class="btn btn-link btn-lg">Back</a>
		</div>
		<fieldset>
			<legend class="text-primary"><small>VOUCHER DETAILS</small></legend>
			<div class="row">
				<div class="form-group col-md-1">
					<label for="dv_no">CTRL #:</label>
					<input type="text" class="form-control" id="dv_no" value="<?=$dv_no;?>" name="dv_obr_cert[dv_no]" readonly="">
				</div>
				<div class="form-group col-md-1">
					<label for="dv_payee_id">Employee No:</label>
					<input type="text" class="form-control" id="dv_payee_id" name="dv_obr_cert[dv_payee_id]" readonly="">
				</div>
				<div class="form-group col-md-3">
					<label for="dv_payee">Payee:</label>
					<input type="text" class="form-control" id="dv_payee" value="<?php if(isset($selected_claimant_name))echo $selected_claimant_name;?>" name="dv_obr_cert[dv_payee]" readonly required>
					
				</div>
				<div class="form-group col-md-3">
					<label for="dv_brgy">Address (City / Brgy.):</label>
					<input type="text" class="form-control" id="dv_brgy" name="dv_obr_cert[dv_brgy]" value="<?php if(isset($deceased_address)) echo $deceased_address;?>" readonly="">
				</div>
				<div class="form-group col-md-2">
					<label for="dv_mop">Mode of Payment:</label>
					<select class="form-control" id="dv_mop" name="dv_obr_cert[dv_mop]" autofocus="" required="">
						<option value="">-- Select here --</option>
						<option value="CHECK">CHECK</option>
						<option value="CASH">CASH</option>					
					</select>
				</div>
			</div>
			<?php 
				$explanation = ""; 
				if(!isset($selected_deceased_name)){
					$selected_deceased_name = "";
				} else {
					$explanation = "To payment of Burial Assistance of late	\n\t".$selected_deceased_name."\nCebu City as per supporting reto attached in the amount of ...";
				}
			?>
			<div class="row">
				<div class="form-group col-md-8">
					<label for="dv_explain">Explanation:</label>
					<textarea class="form-control" id="dv_explain" name="dv_obr_cert[dv_explain]" rows="5" readonly=""><?=$explanation;?></textarea>
				</div>
				<div class="form-group col-md-2">
					<label for="dv_amount">Amount</label>
					<input type="text" class="form-control" id="dv_amount" name="dv_obr_cert[dv_amount]" value="P 10,000.00" readonly="">
				</div>
			</div>

		</fieldset>

		
		
		<br>


		<fieldset>
			<legend class="text-primary"><small>OBR DETAILS</small></legend>
			<div class="row">
				<div class="form-group col-md-1">
					<label for="obr_no">OBR #:</label>
					<input type="text" class="form-control" value="<?=$obr_no;?>" id="obr_no" name="dv_obr_cert[obr_no]" readonly="">
				</div>
				<div class="form-group col-md-2">
					<label for="obr_rc">RC #:</label>
					<input type="text" class="form-control" id="obr_rc" name="dv_obr_cert[obr_rc]" value="07-154-0011011-1" readonly="">
				</div>
				<div class="form-group col-md-3">
					<label for="obr_payee">Payee:</label>
					<input type="text" class="form-control" id="obr_payee" name="dv_obr_cert[obr_payee]" value="<?php if(isset($selected_claimant_name))echo $selected_claimant_name;?>" required readonly>
					
				</div>
				<div class="form-group col-md-2">
					<label for="obr_office">Office:</label>
					<input type="text" class="form-control" id="obr_office" name="dv_obr_cert[obr_office]" value="BURIAL ASSISTANCE OFFICE" readonly="">
				</div>
				<div class="form-group col-md-3">
					<label for="obr_brgy">Address (City / Brgy.):</label>
					<input type="text" class="form-control" id="obr_brgy" name="dv_obr_cert[obr_brgy]" value="<?php if(isset($deceased_address)) echo $deceased_address;?>" readonly>
				</div>
			</div>
			<div class="row">
				
				<div class="form-group col-md-6">
					<label for="obr_particulars">Particulars</label>
					<textarea class="form-control" id="obr_particulars" name="dv_obr_cert[obr_particulars]" required="" rows="5" readonly=""><?=$explanation;?></textarea>
				</div>
				<div class="form-group col-md-1">
					<label for="obr_fpp">F.P.P</label>
					<input type="text" class="form-control" id="obr_fpp" name="dv_obr_cert[obr_fpp]" value="1010" readonly="">
				</div>
				<div class="form-group col-md-2">
					<label for="obr_ac">Account Code</label>
					<input type="text" class="form-control" id="obr_ac" name="dv_obr_cert[obr_ac]" value="969-041" readonly="">
				</div>
				<div class="form-group col-md-2">
					<label for="obr_amount">Amount</label>
					<input type="text" class="form-control" id="obr_amount" name="dv_obr_cert[obr_amount]" value="P 10,000.00" readonly="">
				</div>
			</div>
		</fieldset>
		
		<br>

		<fieldset>
			<legend class="text-primary"><small>CERTIFICATION / RECOMMENDATION DETAILS</small></legend>
			<div class="row">
				<div class="form-group col-md-3">
					<label for="cert_interviewer">Name of Interviewer:</label>
					<input type="text" class="form-control" id="cert_interviewer" name="dv_obr_cert[cert_interviewer]" required="">
				</div>
				<div class="form-group col-md-3">
					<label for="cert_deceased_name">Name of Deceased:</label>
					<input type="text" class="form-control" id="cert_deceased_name" value="<?php if(isset($selected_deceased_name))echo $selected_deceased_name;?>" name="dv_obr_cert[cert_deceased_name]" required readonly>
					
				</div>
				<div class="form-group col-md-2">
					<label for="cert_deceased_dod">Date of Death:</label>
					<input type="date" class="form-control" id="cert_deceased_dod" name="dv_obr_cert[cert_deceased_dod]" required="" value="<?php if(isset($deceased_dod)) echo $deceased_dod;?>" readonly>
				</div>
				
			</div>
			<div class="row">
				<div class="form-group col-md-3">
					<label for="cert_claimant_name">Name of Claimant:</label>
					<input type="text" class="form-control" id="cert_claimant_name" value="<?php if(isset($selected_claimant_name))echo $selected_claimant_name;?>" name="dv_obr_cert[cert_claimant_name]" required readonly>
					
				</div>
				<div class="form-group col-md-4">
					<label for="cert_claimant_add">Claimant Address:</label>
					<input type="text" class="form-control" id="cert_claimant_add" name="dv_obr_cert[cert_claimant_add]" required="" value="<?php if(isset($claimant_brgy)) echo $claimant_brgy; ?>" readonly>
				</div>
			</div>
		</fieldset>
		
		<br>

	
		<div class="form-group text-center">
				<button type="submit" class="btn btn-primary btn-lg">Save</button>
				<button type="reset" class="btn btn-default btn-lg">Clear</button>
				<a href="./" class="btn btn-link btn-lg">Back</a>
		</div>
		
	</form>
</div>