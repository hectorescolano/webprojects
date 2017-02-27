<link rel="stylesheet" type="text/css"  href="<?= base_url('assets/css/scsr.css'); ?>" />
<?php

function getSetValue($param) {
    if (isset($param)) {
        return $param;
    } else {
        return "";
    }
}
?>
<?php //if(isset($scsr_data)) var_dump($scsr_data);  ?>
<div class="container-fluid">
    <div class="table-responsive">
        <div style="font-size:68%;">
            <!-- BUTTON PRINT & SAVE -->
            <p class="hidden-print">
                <a id="back-btn" href="../search" class="btn btn-link btn-lg">
                    <span class="glyphicon glyphicon-backward"></span> BACK
                </a>  
                <a id="print-btn" href="javascript:window.print();" class="btn btn-link btn-lg">
                    <span class="glyphicon glyphicon-print"></span> PRINT
                </a>

<?= $errorMsg; ?>
            </p>		
            <!-- FORM HEADER -->
            <table class="headerTable" style="line-height: 0.9;">
                <tr>
                    <td align="center">
                        <img src="<?= base_url('assets/images/ph_seal_cebucity.png'); ?>" alt="cebucityhall_logo">
                    </td>
                    <td>
                        <table>
                            <tr><td>REPUBLIC OF THE PHILIPPINES</td></tr>
                            <tr><td>CITY OF CEBU</td></tr>
                            <tr><td><strong>DEPARTMENT OF SOCIAL WELFARE SERVICES</strong></td></tr>
                            <tr><td>Cebu City Hall</td></tr>
                            <tr><td>Tel. Nos. 261-7986/ 262-5163</td></tr>
                            <tr><td>SOCIAL CASES SUMMARY REPORT</td></tr>
                        </table>
                    </td>
                    <td align="center">
                        <img src="<?= base_url('assets/images/dsws_logo.png'); ?>" alt="dsws_logo">
                    </td>
                </tr>
                <tr><td colspan="3">SCSR#: <?php echo getSetValue($scsr_data[0]->scsr_rec_id); ?></td></tr>
            </table>
            <!-- DECEASED TABLE -->
            <table class="deceasedTableA" style="font-size:90%;">
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td style="text-align:left; padding:10px;">Name of Deceased</td>
                                <td>Date of Death</td>
                                <td>Place of Death</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->deceased_name); ?></td>
                                <td style="border-bottom: 1px solid #000;"><?php echo date_format(date_create(getSetValue($scsr_data[0]->deceased_dod)), "m/d/Y"); ?></td>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->deceased_pod); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td style="text-align:left; padding:10px;">Date of Birth</td>
                                <td>Place of Birth</td>
                                <td>Last Address</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000;"><?php echo date_format(date_create(getSetValue($scsr_data[0]->deceased_dob)), "m/d/Y"); ?></td>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->deceased_pob); ?></td>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->deceased_street_add)." BRGY. ".getSetValue($scsr_data[0]->deceased_brgy) ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="line-height: 0.9;">
                            <tr>
                                <td style="text-align:left; padding:10px;">Civil Status</td>
                                <td>&nbsp;</td>
                                <td style="border-left: 1px solid #000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="30%" style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->deceased_cs); ?></td>
                                <td style="border-bottom: 1px solid #000;"></td>
                                <td style="border-bottom: 1px solid #000;border-left: 1px solid #000;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="line-height: 0.9;">
                            <tr>
                                <td style="text-align:left;padding:10px;">Name of Spouse</td>
                                <td style="border-bottom: 1px solid #000;"></td>
                                <td style="border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->deceased_spouse); ?></td>
                                <td style="border-bottom: 1px solid #000;"></td>
                                <td style="border-bottom: 1px solid #000;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                <table style="line-height: 0.9;">
                    <tr style="text-align: center;">
                        <td style='border-left: 1px solid #000;border-bottom: 1px solid #000;'>#</td>
                        <td style='border-left: 1px solid #000;border-bottom: 1px solid #000;'><strong>NAME OF CHILD</strong></td>
                        <td style='border-left: 1px solid #000;border-bottom: 1px solid #000;'><strong>AGE</strong></td>
                        <td style='border-left: 1px solid #000;border-bottom: 1px solid #000;'><strong>ADDRESS</strong></td>
                        <td style='border-right: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;'><strong>RELATION TO DECEASED</strong></td>
                        <td style='border-right: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;'><strong>LEGITIMATE</strong></td>
                    </tr>
                    <?php
                    if (isset($children)) {
                        $i = 1;
                        foreach ($children as $child) {
                            echo "<tr style='text-align:left;'>";
                            echo "<td style='border-left: 1px solid #000;border-bottom: 1px solid #000;'>$i</td>";
                            echo "<td style='border-left: 1px solid #000;border-bottom: 1px solid #000;'>$child->name</td>";
                            echo "<td style='border-left: 1px solid #000;border-bottom: 1px solid #000;'>$child->age</td>";
                            echo "<td style='border-left: 1px solid #000;border-bottom: 1px solid #000;'>$child->address</td>";
                            echo "<td style='border-right: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;'>$child->rel</td>";
                            echo "<td style='border-right: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;'>$child->legit</td>";
                            echo "</tr>";
                            $i++;
                        }
                    }
                    ?>
                </table>
                </tr>
            </table>
            <table class="deceasedTableC" style="font-size:90%;">
                <tr>
                    <td>
                        <table style="line-height: 0.9;">
                            <tr>
                                <td style="text-align:left; padding:10px;">Cause of Death</td>
                                <td>Lingering Ailment</td>
                                <td>Hospitalization</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->deceased_cod); ?></td>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->deceased_la); ?></td>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->deceased_hos); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="line-height: 0.9;">
                            <tr>
                                <td style="text-align:left; padding:10px;">Who paid hospital bills?</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->deceased_paid_hos); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td style="text-align:left; padding:10px;">Other Sources of Financial Support</td>
                                <td>DONATION</td>
                                <td>Who paid the burial expenses?</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo getSetValue($scsr_data[0]->deceased_paid_burial_exp); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- CLAIMANT TABLE -->
            <table class="claimantTable" style="font-size:90%;">
                <tr>
                    <td>
                        <table style="line-height: 0.9;">
                            <tr>
                                <td style="text-align:left; padding:10px;">Name of Claimant</td>
                                <td style="text-align:left;">Civil Status</td>
                            </tr>
                            <tr>
                                <td><?php echo getSetValue($scsr_data[0]->claimant_name); ?></td>
                                <td><?php echo getSetValue($scsr_data[0]->deceased_cs); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td style="text-align:left; padding:10px;border-top: 1px solid #000;">Contact No.</td>
                                <td style="border-top: 1px solid #000;">Address</td>
                                <td style="border-top: 1px solid #000;">Age</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->claimant_contact_no); ?></td>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->claimant_street_add)." BRGY. ".getSetValue($scsr_data[0]->claimant_brgy); ?></td>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->claimant_age); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td style="text-align:left; padding:10px;">Date of Birth</td>
                                <td>Place of Birth</td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #000;"><?php echo date_format(date_create(getSetValue($scsr_data[0]->claimant_dob)), "m/d/Y"); ?></td>
                                <td style="border-bottom: 1px solid #000;"><?php echo getSetValue($scsr_data[0]->claimant_pob); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td style="text-align:left; padding:10px;">Form of Support to Deceased</td>
                                <td style="text-align:left;">FINANCIAL AND MORAL</td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
            <!-- SOCIAL WORKER TABLE -->
            <table class="socialWorkerTable"  style="font-size:90%;" style="line-height: 0.9;">
                <tr><td style="text-align:left; padding:10px;border-bottom: 1px solid #000;">Financial Capability Assesment (by Social Workers)</td></tr>
                <tr><td style="border-bottom: 1px solid #000;padding:10px;">Claimant asked financial aid for payment of their debts.</td></tr>
            </table>
            <!-- APPROVAL TABLE -->
            <table class="approvalTable" style="font-size:90%;" style="line-height: 0.9;">
                <tr><td style="text-align:left; padding:10px;">Recommending for the approval of this application for the Burial Assistance of Ten Thousand (P10,000.00).</td></tr>
                <tr><td style="text-align:left;padding:10px;">for&nbsp;&nbsp;&nbsp;
                        <i><?php echo getSetValue($scsr_data[0]->deceased_name); ?></i> &nbsp;&nbsp;&nbsp; 
                        thru  &nbsp;&nbsp;&nbsp;
                        <i><?php echo getSetValue($scsr_data[0]->claimant_name); ?></i> &nbsp;&nbsp;&nbsp; <strong>Eligible for Financial Assistance
                        Done this &nbsp;&nbsp;&nbsp;<?php echo date('dS'). " of ".date('M., Y'); ?></strong>
                    </td>
                </tr>
            </table>
            <br>
            <!-- SIGNATORIES TABLE -->
            <table class="signatoriesTable" style="font-size:90%;" style="line-height: 0.7;">
                <tr><td style="text-align:center;padding:10px;">Prepared by:</td><td style="text-align:center; padding:10px;">Approved:</td></tr>
                <tr>
                    <td style="text-align:center;padding:10px;"><u><strong>VIVIAN A. NARDO</strong></u></td>
                    <td style="text-align:center;"><u><strong>HON. TOMAS R. OSMEÑA</strong></u></td>
                </tr>
                <tr><td style="text-align:center;">SWO - III RSW - 0003898<br>DSWS - CEBU CITY</td><td style="text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;CITY MAYOR</td></tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <table>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td style="text-align:center; padding:10px;">By Authority of the Mayor:</td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td style="text-align:center;"><strong>LEA QUANO JAPSON</strong></td></tr>
                            <tr><td style="text-align:center;">OIC-DSWS</td></tr>
                        </table>
                    </td>
                </tr>			
            </table>
            <!-- BUTTON PRINT & SAVE -->
            <p class="hidden-print">
                <a id="back-btn" href="../search" class="btn btn-link btn-lg">
                    <span class="glyphicon glyphicon-backward"></span> BACK
                </a>   
                <a id="print-btn" href="javascript:window.print();" class="btn btn-link btn-lg">
                    <span class="glyphicon glyphicon-print"></span> PRINT
                </a>
            </p>
        </div>
    </div>
</div>