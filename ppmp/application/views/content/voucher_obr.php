<link rel="stylesheet" type="text/css"  href="<?=base_url('assets/css/voucherobr.css');?>" />

<?php
	$date_year = date("Y");
	$date_month = date("m");
	$date_day = date("d");

	$dv_ctr = sprintf("%'.03d\n", $dv_id[0]->ID);
	$dv_control_no = "DV-".$date_day."".$date_year."".$date_month."-".$dv_ctr;

	$obr_ctr = sprintf("%'.03d\n", $obr_id[0]->ID);
	$obr_control_no = "OBR-".$date_day."".$date_year."".$date_month."-".$obr_ctr;
?>

<div class="container-fluid">
	<div class="table-responsive">


		<form method="post" action="saveVrObrCert">
			<!-- BUTTON PRINT & SAVE -->
			<p class="hidden-print">
				<a id="back-btn" href="./" class="btn btn-link">
					<span class="glyphicon glyphicon-backward"></span> BACK
				</a>   
				<a id="print-btn" href="javascript:window.print();" class="btn btn-link">
					<span class="glyphicon glyphicon-print"></span> PRINT
				</a>
				<button type='submit' class="btn btn-link">SAVE</button>

				<div class="hidden-print"><?=$errorMsg;?></div>

				<div class="form-group hidden-print">
					<select name="dv[CLIENT_ID]" class="form-control" required>
						<option value="">[SELECT HERE CLAIMANT & DECEASED]</option>
						<?php 
							foreach ($clients as $row) {
								echo "<option value='".$row->ID."'>".$row->CLAIMANT_LNAME.",".$row->CLAIMANT_FNAME." - ".$row->DECEASED_LNAME.",".$row->DECEASED_FNAME."</option>";
							}
						?>	
					</select>
				</div>
			</p>
			<!-- // -->


			<table border="1">
				<tr>
					<td style="text-align:center;"><img src="<?=base_url('assets/images/ph_seal_cebucity.png');?>" alt="cebucityhall_logo"></td>
					<td width="60%">
						<table style="text-align:center;">
							<tr><td style="padding-top:10px;">Rebulic of the Philippines</td></tr>
							<tr><td>City of Cebu</td></tr>
							<tr><td><h3>DISBURSEMENT VOUCHER</h3></td></tr>
						</table>
					</td>
					<td style="text-align:center;" width="20%">
						<table>
							<tr><td></td></tr>
							<tr><td style="text-align:left;padding-left:5px;">No. <input class="transparent" type="text" name="dv[DV_CTR_NO]" value="<?=$dv_control_no;?>" style="text-align: center;" readonly></td></tr>
						</table>
					</td>
				</tr>
				<tr style="font-size:70%;">
					<td colspan="3" style="padding-left:5px;">Mode of Payment
						<span class="mop">
							<label for="mop1"><input id="mop1" type="radio" name="dv[DV_MOP]" value="CHECK"> Check</label>
							<label for="mop2"><input id="mop2" type="radio" name="dv[DV_MOP]" value="CASH" checked> Cash</label>
							<label for="mop3"><input id="mop3" type="radio" name="dv[DV_MOP]" value="OTHER"> Others (specify): ___________________</label>
						</span>
					</td>
				</tr>
			</table>
			
			
			<table style="font-size:70%;">
				<tr style="border-left:1px solid;border-right:1px solid;border-bottom:1px solid;border-color:#000;">				
					<td style="padding-left:5px;border-right:1px solid;border-left:1px solid;border-color:#000;">OBR No:</td>
					<td><input class="transparent" type="text" name="dv[OBR_CTR_NO]" value="<?=$obr_control_no;?>" readonly></td>
					<td style="padding-left:5px;border-right:1px solid;border-left:1px solid;border-color:#000;">Responsibility Center:</td>
					<td><input class="transparent" type="text" name="dv[DV_RC_NO]" required></td>
					<td style="padding-left:5px;border-right:1px solid;border-left:1px solid;border-color:#000;">Office/Unit/Project:</td>
					<td><input class="transparent" type="text" name="dv[OFFICE]"></td>
					<td style="padding-left:5px;border-right:1px solid;border-left:1px solid;border-color:#000;">Code:</td>
					<td><input class="transparent" type="text" name="dv[CODE]"></td>
				</tr>
				<tr style="border-left:1px solid;border-right:1px solid;border-bottom:1px solid;border-color:#000;">
					<td style="padding-left:5px;border-right:1px solid;border-left:1px solid;border-color:#000;">TIN/Employee ID:</td>
					<td><input class="transparent" type="text" name="dv[ID]"></td>
					<td style="padding-left:5px;border-right:1px solid;border-left:1px solid;border-color:#000;">Payee</td>
					<td><input class="transparent" type="text" name="dv[DV_PAYEE]" required></td>
					<td style="padding-left:5px;border-right:1px solid;border-left:1px solid;border-color:#000;">Address</td>
					<td colspan="3"><input class="transparent" type="text" name="dv[ADDRESS]"></td>
				</tr>
			</table>

			<table>
				<tr style="border-left:1px solid;border-right:1px solid;border-bottom:1px solid;border-color:#000; text-align:center;">
					<td>EXPLANATION</td>
					<td style="border-left:1px solid #000;">AMOUNT</td>
				</tr>
				<?php 
					$explanation = "To payment of Burial Assistance of late																									Cebu City as per supporting hereto attached in the amount of ...

Amount: TEN THOUSAND PESOS";
				?>
				<tr style="border-left:1px solid;border-right:1px solid;border-bottom:1px solid;border-color:#000;">
					<td>
						<textarea rows="6" cols="30" style="border:none;width:100%;" name="dv[EXPLANATION]" readonly><?=$explanation;?></textarea>
					</td>
					<td class="text-center" style="border-left:1px solid #000;"><strong>P 10,000.00</strong></td>
				</tr>
			</table>

			<table style="font-size:70%;">
				<tr style="border-left:1px solid;border-right:1px solid;border-color:#000;">
					<td style="padding-left:10px;" width="50%">A. Certified</td>
					<td style="padding-left:10px;border-left:1px solid #000;">B. Certified</td>
				</tr>
				<tr>
					<td style="padding-left:30px;border-left:1px solid #000;"><label for="certA1"><input id="certA1" type="checkbox" name="certA"> Allotment obligated for the purpose as indicated above</label></td>
					<td style="padding-left:30px;border-left:1px solid #000;border-right:1px solid #000;">Fund Available</td>
				</tr>
				<tr style="border-bottom:1px solid #000;">
					<td style="padding-left:30px;border-left:1px solid #000;border-right:1px solid #000;"><label for="certA2"><input id="certA2" type="checkbox" name="certA"> Supporting documents complete</label></td>
					<td style="padding-left:30px;border-left:1px solid #000;border-right:1px solid #000;"><input class="transparent" type="text" name="dv[FUND]"></td>
				</tr>
			</table>

			<table style="font-size:70%;">
				<tr style="border-left:1px solid;border-right:1px solid;border-bottom:1px solid;border-color:#000;">
					<td style="border-right:1px solid;border-color:#000;" width="10%">Signature</td>
					<td width="40%">&nbsp;</td>
					<td style="border-left:1px solid;border-right:1px solid;border-color:#000;" width="10%">Signature</td>
					<td width="40%">&nbsp;</td>
				</tr>
			</table>
			<table style="font-size:70%;">
				<tr style="border-left:1px solid;border-right:1px solid;border-bottom:1px solid;border-color:#000;">
					<td style="border-right:1px solid;border-color:#000;" width="10%">Printed Name</td>
					<td width="20%">&nbsp;</td>
					<td width="20%" style="border-left:1px solid;border-right:1px solid;border-color:#000;">Date</td>
					<td style="border-left:1px solid;border-right:1px solid;border-color:#000;" width="10%">Printed Name</td>
					<td width="20%">&nbsp;</td>
					<td width="20%" style="border-left:1px solid;border-right:1px solid;border-color:#000;">Date</td>
				</tr>
			</table>

			<table style="font-size:90%;">
				<tr class="border-notopbot">
					<td class="border-right">Position</td><td style="text-align:center;" class="border-right border-bottom">ARLENE O. RENTUZA</td>
					<td class="border-right">Position</td><td style="text-align:center;" class="border-right border-bottom">TESSIE C. CAMARILLO</td>
				</tr>
				<tr style="font-size:80%;" class="border-notop">
					<td class="border-right">&nbsp;</td><td style="text-align:center;" width="37.5%">Head, Accounting Unit / Authorized Representative</td>
					<td class="border-right border-left">&nbsp;</td><td style="text-align:center;">Treasurer / Authorized Representative</td>
				</tr>
				<tr class="border-notop">
					<td style="height:40px;vertical-align:top;" class="border-right">Pre-Audit:</td>
					<td style="height:40px;vertical-align:top;" class="border-right">Indexed:</td>
					<td style="height:40px;vertical-align:top;">Obligated:</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<table style="font-size:70%;">
				<tr class="border-notop">
					<td style="padding-left:10px;" class="border-right" width="50%">C. Approved for Payment</td>
					<td colspan="4" style="padding-left:10px;" class="border-left" width="50%">D. Recieved Payment</td>
				</tr>

			</table>
			<table style="font-size:70%;">
				<tr class="border-notop">
					<td class="border-right" width="10%">Signature</td>
					<td class="border-right border-left" width="40%">&nbsp;</td>
					<td class="border-right border-left" width="20%">Check No.</td>
					<td class="border-right" width="20%">Bank Name</td>
					<td class="border-left">Date</td>
				</tr>
			</table>
			<table style="font-size:70%;">
				<tr class="border-notop">
					<td class="border-right" width="10%" style="height:30;vertical-align:top;">Printed Name</td>
					<td width="20%" style="height:30;vertical-align:top;">&nbsp;</td>
					<td class="border-right border-left" width="20%" style="height:30px;vertical-align:top;">Date</td>
					<td class="border-right border-left" width="10%">Signature</td>
					<td width="10%">&nbsp;</td>
					<td class="border-right border-left" width="10%">Printed Name</td>
					<td width="10%">&nbsp;</td>
					<td class="border-right border-left">Date</td>
				</tr>
			</table>
			<table style="font-size:90%;">
				<tr class="border-notopbot">
					<td class="border-right">Position</td><td style="text-align:center;" class="border-right border-bottom">TOMAS R. OSMEÑA</td>
					<td class="border-right" width="20%">OR / Other Docuements</td>
					<td class="border-right" width="20%">JEV No.</td>
					<td class="border-right">Date</td>
				</tr>
				<tr style="font-size:80%;" class="border-notop">
					<td class="border-right">&nbsp;</td><td style="text-align:center;">Agency Head / Authorized Representative</td>
					<td class="border-right border-left">&nbsp;</td>
					<td class="border-right border-left">&nbsp;</td>
					<td class="border-right border-left">&nbsp;</td>
				</tr>
			</table>


			<table style="font-size:80%;" class="border-notop">
				<tr>
					<td></td>
					<td class="text-center" width="70%"><h4>JOURNAL ENTRY VOUCHER</h4></td>
					<td class="border-left border-bottom" style="padding: 5px;">No:</td>
				</tr>
				<tr>
					<td class="border-bottom"></td>
					<td class="text-center border-bottom" width="70%">Cebu of Cebu</td>
					<td class="border-left border-bottom" style="padding: 5px;">Date:</td>
				</tr>
				<tr>
					<td colspan="3" class="text-center border-bottom">
						<span class="jev_type">
							<label for="jev_type1"><input id="jev_type1" type="radio" name="dv[JEV_TYPE]" value="COLLECTION"> Collection</label>
							<label for="jev_type2"><input id="jev_type2" type="radio" name="dv[JEV_TYPE]" value="CHECK DBURST"> Check Disbursement</label>
							<label for="jev_type3"><input id="jev_type3" type="radio" name="dv[JEV_TYPE]" value="CASH DBURST"> Cash Disbursement</label>
							<label for="jev_type4"><input id="jev_type4" type="radio" name="dv[JEV_TYPE]" value="OTHER"> Others</label>
						</span>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="text-center">ACCOUNTING ENTRIES</td>
				</tr>
			</table>

			<table style="font-size:80%;" class="border-notop">
				<tr class="text-center">
					<td class="border-bottom border-right" width="10%">Responsibility Center</td>
					<td class="border-bottom border-right border-left">Accounts and Explanation</td>
					<td class="border-bottom border-right border-left">Accounts Code</td>
					<td class="border-bottom border-right border-left">PR</td>
					<td class="border-bottom">Amount</td>
				</tr>
				<tr>
					<td class="border-bottom border-right">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom">&nbsp;</td>
				</tr>
				<tr>
					<td class="border-bottom border-right">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom">&nbsp;</td>
				</tr>
				<tr>
					<td class="border-bottom border-right">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom">&nbsp;</td>
				</tr>
				<tr>
					<td class="border-bottom border-right">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom">&nbsp;</td>
				</tr>
				<tr>
					<td class="border-bottom border-right">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom">&nbsp;</td>
				</tr>
				<tr>
					<td class="border-bottom border-right" colspan="2" style="padding: 20px;">Prepared by:</td>
					<td class="border-bottom" colspan="3" style="padding: 20px;">Approved by:</td>
				</tr>
			</table>



			<br>
			<br>
			<br>
			<br>



			<table border="1">
				<tr>
					<td style="text-align:center;"><img src="<?=base_url('assets/images/ph_seal_cebucity.png');?>" alt="cebucityhall_logo"></td>
					<td width="60%">
						<table style="text-align:center;">
							<tr><td style="padding-top:10px;">Rebulic of the Philippines</td></tr>
							<tr><td>City of Cebu</td></tr>
							<tr><td><h3>OBLIGATION REQUEST</h3></td></tr>
						</table>
					</td>
					<td style="text-align:center;" width="20%">
						<table>
							<tr><td style="text-align:left;padding-left:5px;">Date:</td></tr>
							<tr><td style="text-align:left;padding-left:15px;">Fund:   <label for="gf"><input id="gf" type="checkbox" checked> General Fund</label></td></tr>
							<tr><td style="text-align:left;padding-left:5px;">No. <input style="text-align: center;" class="transparent" type="text" name="dv[OBR_CTR_NO]" value="<?=$obr_control_no;?>" readonly></td></tr>
						</table>
					</td>
				</tr>
			</table>
			<table>
				<tr class="border-notopbot">
					<td class="border-bottom border-right" style="padding-left: 10px;">Payee</td>
					<td class="border-bottom border-right" style="padding-left: 10px;" colspan="4"><input class="transparent" type="text" name="dv[DV_PAYEE]" required></td>
				</tr>
				<tr class="border-notopbot">
					<td class="border-bottom border-right" style="padding-left: 10px;">Office</td>
					<td class="border-bottom border-right" style="padding-left: 10px;" colspan="4">BURIAL ASSISTANCE OFFICE</td>
				</tr>
				<tr class="border-notopbot">
					<td class="border-bottom border-right" style="padding-left: 10px;">Address</td>
					<td class="border-bottom border-right" style="padding-left: 10px;" colspan="4">Cebu City/Brgy. </td>
				</tr>
				<tr class="text-center">
					<td class="border-bottom border-right border-left" width="10%">Responsibility Center</td>
					<td class="border-bottom border-right border-left" width="60%">Particulars</td>
					<td class="border-bottom border-right border-left">F.P.P</td>
					<td class="border-bottom border-right border-left" width="10%">Account Code</td>
					<td class="border-bottom border-right">Amount</td>
				</tr>
				<tr style="height: 500px;">
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right"></td>
				</tr>
				<tr>
					<td class="border-bottom border-right border-left text-right" colspan="4" style="padding-right: 10px;">Total</td>
					<td class="border-bottom border-right border-left" style="padding-left: 10px;"><strong>P 10,000.00</strong></td>
				</tr>
			</table>

			<table style="font-size:70%;">
				<tr style="border-left:1px solid;border-right:1px solid;border-color:#000;">
					<td style="padding-left:10px;" width="50%">A. Certified</td>
					<td style="padding-left:10px;border-left:1px solid #000;">B. Certified</td>
				</tr>
				<tr>
					<td style="padding-left:30px;border-left:1px solid #000;"><label for="certA1"><input id="certA1" type="checkbox" name="certA"> Charges to appropriation/allotment necessary, lawfull and under my direct supervision</label></td>
					<td style="padding-left:30px;border-left:1px solid #000;border-right:1px solid #000;">existance of available appropriation</td>
				</tr>
				<tr style="border-bottom:1px solid #000;">
					<td style="padding-left:30px;border-left:1px solid #000;border-right:1px solid #000;"><label for="certA2"><input id="certA2" type="checkbox" name="certA"> Supporting documents valid, proper and legal</label></td>
					<td style="padding-left:30px;border-left:1px solid #000;border-right:1px solid #000;"><input class="transparent" type="text" name="dv[FUND]"></td>
				</tr>
			</table>
			<table>
				<tr class="border-notop text-center" style="height: 30px;">
					<td class="border-bottom border-right border-left" width="10%">Signature</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left" width="10%">Signature</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
				</tr>
				<tr class="border-notop text-center" style="height: 30px;">
					<td class="border-bottom border-right border-left" width="10%">Printed Name</td>
					<td class="border-bottom border-right border-left"><strong> CARLOTA NELYN P. PAGLINAWAN</strong></td>
					<td class="border-bottom border-right border-left" width="10%">Printed Name</td>
					<td class="border-bottom border-right border-left"><strong> MARIETTA L. GUMIA</strong></td>
				</tr>
				<tr class="text-center">
					<td class="border-right border-left">Position</td>
					<td class="border-bottom border-right border-left">EXECUTIVE ASSISTACNE / ADMINISTRATIVE OFFICER DESIGNATED</td>
					<td class="border-right border-left">Position</td>
					<td class="border-bottom border-right border-left"> CITY BUDGET OFFICER</td>
				</tr>
				<tr class="text-center">
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">Head, Requesting Office/Authorized Representative</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left">Head, Requesting Office/Authorized Representative</td>
				</tr>
				<tr class="border-notop text-center" style="height: 30px;">
					<td class="border-bottom border-right border-left" width="10%">Date</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
					<td class="border-bottom border-right border-left" width="10%">Date</td>
					<td class="border-bottom border-right border-left">&nbsp;</td>
				</tr>

			</table>

			<br>
			<br>
			<br>




			<table>
				<tr class="text-center">
					<td>
						<img class="cert_img" src="<?=base_url('assets/images/ph_seal_cebucity.png');?>" alt="cebucityhall_logo">
					</td>
					<td>
						<table>
								<tr><td>REPUBLIC OF THE PHILIPPINES</td></tr>
								<tr><td>CITY OF CEBU</td></tr>
								<tr><td>&nbsp;</tr>
								<tr><td><strong>DEPARTMENT OF SOCIAL WELFARE SERVICES</strong></td></tr>
								<tr><td>&nbsp;</tr>
								<tr><td>Cebu City Hall</td></tr>
								<tr><td>Tel. Nos. 253-2224 / 259-5967</td></tr>
	 							<tr><td><strong>BURIAL ASSISTANCE PROGRAM 2016</strong></td></tr>
								<tr><td>&nbsp;</tr>
								<tr><td>SOCIAL WORKER CERTIFICATION/RECOMMENDATION</td></tr>
						</table>
					</td>
					<td>
						<img class="cert_img" src="<?=base_url('assets/images/dsws_logo.png');?>" alt="dsws_logo">
					</td>
				</tr>
			</table>

			<br>
			<br>

			<table>
				<tr>
					<td width="1%">Date:</td>
					<td class="text-left"><u><?=$date_month."/".$date_day."/".$date_year;?></u></td>
				</tr>
				<tr class="border-bottom">
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>

			<br>
			<br>

			<p style="text-indent: 50px;">
				I, ________________________, Interviewer of Burial Assistance Office Cebu City, hereby certifies that I have accomplished the Social Case Summary Report and reviewed the required documents attached to be completed, relevant to the application for the financial assistance from Cebu City Burial Assistance Program of:
			</p>

			<br>
			<table>
				<tr>
					<td width="25%" class="text-right">Name of Deceased:</td><td class="border-bottom">&nbsp;</td>
				</tr>
				<tr>
					<td class="text-right">Date of Death:</td><td class="border-bottom">&nbsp;</td>
				</tr>
				<tr>
					<td class="text-right">Certifying further that</td><td class="border-bottom">&nbsp;</td>
				</tr>
			</table>
			<br>
			<p style="text-indent: 50px;">
				With residence ________________________________________, Cebu City, is the authorized claimant of the <strong> TEN THOUSAND (P 10,000.00) PESOS</strong> Cash Assistance, under the Burial Assistance Program of Cebu City for the above specified death benefits claim application.
			</p>

			<p style="text-indent: 50px;">
				Certifying finally, that the above named deceased and authorized claimant are not found on the DSWS Database Center of Claimants established for the Burial Assistance Program of 2016 and therefore authorized to claim.
			</p>
			
			<br>
			<br>

			<p>
				Recommending Approval:
			</p>

			<br>
			<br>

			<p>
				Signed:<br>
				BY AUTHORITY OF _________________________<br>
				City Gov't. Dept Head II<br>
				Cebu City
			</p>


			<br>
			<!-- BUTTON PRINT & SAVE -->
			<p class="hidden-print">
				<a id="back-btn" href="./" class="btn btn-link">
					<span class="glyphicon glyphicon-backward"></span> BACK
				</a>   
				<a id="print-btn" href="javascript:window.print();" class="btn btn-link">
					<span class="glyphicon glyphicon-print"></span> PRINT
				</a>
				<button type='submit' class="btn btn-link">SAVE</button>
				<?=$errorMsg;?>
			</p>
			<!-- // -->

		</form>


	</div>
</div>