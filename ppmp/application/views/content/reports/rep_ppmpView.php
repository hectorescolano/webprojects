<script type="text/javascript">
	$(function(){
		var buttonPrint = $("#printPPMP");
		buttonPrint.click(function(){
			window.print();
		});
	});

</script>
<?php 

    function checkValue($value){
        if(isset($value) || !empty($value)){
            echo strtoupper($value);
        } else {
            echo "";
        }
    }

?>


<div class="container-fluid">

	<!-- <h5 class="text-center">GOVERNMENT POLICY BOARD TECHNICAL SUPPORT OFFICE</h5> -->
    <h4 class="text-center"><u>PROJECT PROCUREMENT MANAGEMENT PLAN</u></h4>
    <h5 class="text-center">2017</h5>
    <?php 
            // $department = $this->DatabaseModel->getUserDeptByAddress($ppmp['dept']);
            // var_dump($department);
    ?>


    <div style="font-size: 80%;">
        <div class="text-left .small">END-USER/UNIT: <strong><?php checkValue($department);?></strong></div>
        <div class="text-left .small">Account Code: <strong><?php checkValue($ppmp_reports[0]->account_code);?></strong></div>
        <!-- <div class="text-left .small"><strong>Charged to GAA</strong></div> -->
        <div class="text-left .small">Projects, Program and Activities (PAPs)</div>
    </div>
    <br>
    <div class="hidden-print">
    	<a href="ReportController" class="btn btn-default">BACK</a>
    	<a href="#print" id="printPPMP" class="btn btn-primary">PRINT</a>
    </div>



        <?php
            // var_dump($ppmp_reports);
           // var_dump($this->session->userdata['ses_ppmp'][0]);
            // var_dump($setup);

            $checkMark = "<span class='glyphicon glyphicon glyphicon-ok' aria-hidden='true'></span>";

            if(isset($ppmp_reports))
            {
                if($setup == 1){
            	?>
            	<table class="table table-bordered table-condensed" style="font-size: 9px;">
                <tr class="text-center">
                    <td colspan="3"></td>
                    <td colspan="2">QUANTITY</td>
                    <td colspan="2">ESTIMATED BUDGET</td>
                    <td></td>
                    <td colspan="12">Schedule / Milestone of Activities</td>
                </tr>
            	<tr class="text-center">

                    <td>NO</td>
            		<td style="width: 14%;">CODE</td>
            		<td>DESCRIPTION</td>
            		<td colspan="2">SIZE</td>
            		<td>UNIT COST</td>
            		<td>TOTAL COST</td>
            		<td>MODE OF PROCUREMENT</td>
            		<td>JAN</td>
            		<td>FEB</td>
            		<td>MAR</td>
            		<td>APR</td>
            		<td>MAY</td>
            		<td>JUN</td>
            		<td>JUL</td>
            		<td>AUG</td>
            		<td>SEP</td>
            		<td>OCT</td>
            		<td>NOV</td>
            		<td>DEC</td>
            	</tr>
	            	<?php
                        $sumTotalCost = 0.00;
                        $ctr = 1;

		            	foreach ($ppmp_reports as $row) {

                            $sumTotalCost = $sumTotalCost + $row->TotalAmount;

                            // $first = ($row->Feb != null ? $checkMark:$row->Feb);
                            // $second = ($row->May != null ? $checkMark:$row->May);
                            // $third = ($row->Aug != null ? $checkMark:$row->Aug);
                            // $fourth = ($row->Oct != null ? $checkMark:$row->Oct);


		            		echo "<tr class='text-center'>";
                            echo "<td>$ctr</td>";
		            		echo "<td>$row->Code</td>";
		            		echo "<td class='text-left'>$row->description</td>";
		            		echo "<td class='text-right'>$row->TotalQty</td>";
		            		echo "<td class='text-center'>$row->uom</td>";
		            		echo "<td class='text-right'>".number_format((float)$row->unit_price, 2, '.', ',')."</td>";
		            		echo "<td class='text-right'>".number_format((float)$row->TotalAmount, 2, '.', ',')."</td>";
		            		echo "<td>$row->proc_method</td>";
		            		echo "<td class='text-right'>0</td>"; //jan
		            		echo "<td class='text-right'>$row->Feb</td>"; //feb
		            		echo "<td class='text-right'>0</td>"; //mar
		            		echo "<td class='text-right'>0</td>"; //april
		            		echo "<td class='text-right'>$row->May</td>"; //may
		            		echo "<td class='text-right'>0</td>"; //jun
		            		echo "<td class='text-right'>0</td>"; //jul
		            		echo "<td class='text-right'>$row->Aug</td>"; //aug
		            		echo "<td class='text-right'>0</td>"; //set
		            		echo "<td class='text-right'>$row->Oct</td>"; //oct
		            		echo "<td class='text-right'>0</td>"; //nov
		            		echo "<td class='text-right'>0</td>"; //dec
		            		echo "</tr>";
                            $ctr++;
		            	}
                        echo "<tr>";
                        echo "<td class='text-center'><strong>Total Budget</strong></td>";
                        echo "<td class='text-right' colspan='6'><strong>".number_format((float)$sumTotalCost, 2, '.', ',')."</strong></td>";
                        echo "<td colspan='13'></td>";
                        echo "</tr>";
	            	?>
            	</table>
            	
            	<?php
            } 
                else {  ?>
                
                <table class="table table-bordered table-condensed" style="font-size: 9px;">
                <tr class="text-center">
                    <td colspan="3"></td>
                    <td colspan="2">QUANTITY</td>
                    <td colspan="2">ESTIMATED BUDGET</td>
                    <td></td>
                    <td colspan="12">Schedule / Milestone of Activities</td>
                </tr>
                    <tr class='text-center'>
                        <td>NO</td>
                        <td style="width: 14%;">CODE</td>
                        <td>GENERAL DESCRIPTION</td>
                        <td colspan="2">SIZE</td>
                        <td>UNIT COST</td>
                        <td>TOTAL COST</td>
                        <td>MODE OF PROCUREMENT</td>
                        <td>JAN</td>
                        <td>FEB</td>
                        <td>MAR</td>
                        <td>APR</td>
                        <td>MAY</td>
                        <td>JUN</td>
                        <td>JUL</td>
                        <td>AUG</td>
                        <td>SEP</td>
                        <td>OCT</td>
                        <td>NOV</td>
                        <td>DEC</td>
                    </tr>
                    <?php
                        $sumTotalCost = 0.00;
                        $ctr = 1;
                        foreach ($ppmp_reports as $row) {
                            $sumTotalCost = $sumTotalCost + $row->TotalAmount;
                            $TotalQty = ($row->TotalQty != null ? $row->TotalQty:'1');

                            $first = ($row->Feb != null ? $checkMark:$row->Feb);
                            $second = ($row->May != null ? $checkMark:$row->May);
                            $third = ($row->Aug != null ? $checkMark:$row->Aug);
                            $fourth = ($row->Oct != null ? $checkMark:$row->Oct);

                            echo "<tr class='text-center'>";
                            echo "<td>$ctr</td>";
                            echo "<td>$row->Code</td>";
                            echo "<td class='text-left'>$row->description</td>";
                            echo "<td class='text-right'>$TotalQty</td>";
                            echo "<td class='text-center'>unit</td>";
                            echo "<td class='text-right'>".number_format((float)$row->TotalAmount, 2, '.', ',')."</td>";
                            echo "<td class='text-right'>".number_format((float)$row->TotalAmount, 2, '.', ',')."</td>";
                            echo "<td>$row->proc_method</td>";
                            echo "<td class='text-right'>$checkMark</td>"; //jan
                            echo "<td class='text-right'>$checkMark</td>"; //feb
                            echo "<td class='text-right'>$checkMark</td>"; //mar
                            echo "<td class='text-right'>$checkMark</td>"; //april
                            echo "<td class='text-right'>$checkMark</td>"; //may
                            echo "<td class='text-right'>$checkMark</td>"; //jun
                            echo "<td class='text-right'>$checkMark</td>"; //jul
                            echo "<td class='text-right'>$checkMark</td>"; //aug
                            echo "<td class='text-right'>$checkMark</td>"; //set
                            echo "<td class='text-right'>$checkMark</td>"; //oct
                            echo "<td class='text-right'>$checkMark</td>"; //nov
                            echo "<td class='text-right'>$checkMark</td>"; //dec
                            echo "</tr>";
                            $ctr++;
                        }

                        echo "<tr>";
                        echo "<td class='text-center'><strong>Total Budget</strong></td>";
                        echo "<td class='text-right' colspan='6'><strong>".number_format((float)$sumTotalCost, 2, '.', ',')."</strong></td>";
                        echo "<td colspan='13'></td>";
                        echo "</tr>";
                    ?>
                    
                </table>



                <?php }
            }
        	?>
            <div class="text-left" style="font-size: 10px;"><strong>Note: Technical Specification for each Item/Project being proposed shall be submitted as part of the pppmp.</strong></div>
            <br>
            <br>
        	<table style="font-size: 10px;width: 100%;">

                <tr>
                    <td>
                        <table>
                            <tr>
                                <td width="50%" style="vertical-align: top;"><strong><small>Prepared By:</small></strong></td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                               <strong> <?php checkValue($ppmp['preparedby']);?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small><?php checkValue($ppmp['position']);?></small>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td>
                        <table>
                            <tr>
                                <td width="50%" style="vertical-align: top;"><strong><small>Submitted By:</small></strong></td>

                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                               <strong> <?php checkValue($ppmp['requestedby']);?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small><?php checkValue($ppmp['rb_designation']);?></small>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <td width="60%" style="vertical-align: top;"><strong><small>Evaluated as to Budgetary Allocation:</small></strong></td>

                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                               <strong> <?php checkValue($ppmp['fundadmin']);?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small><?php checkValue($ppmp['fa_designation']);?></small>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                <tr>
        </table>
</div>
