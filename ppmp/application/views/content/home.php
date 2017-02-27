<script type="text/javascript">
	$(function()
	{
		$('#submit-btn').click(show_preloader);
		function show_preloader()
		{
			$("#loading").fadeIn("slow");
		}
	});
</script>
<br>
<h3 class="page-header text-center">Burial Assistance Information System</h3>
<br>
<br>

<div class="container well">
<!-- <h2 class="text-center text-primary page-header">Burial Assistance Information System</h2> -->
		<?php
			$userrole =  $this->session->userdata['logged_in_burial']['role'];
			$userlogged = strtoupper($this->session->userdata['logged_in_burial']['name']);
		?>
	
	<div class="row">
				<div class="col-md-4">
					<a class="btn btn-default btn-block btn-lg" href='rg'><span class="glyphicon glyphicon-copy" aria-hidden="true"></span> REGISTER</a>
				</div>
				<div class="col-md-4">
					<a class="btn btn-default btn-block btn-lg" href='search'><span class="glyphicon glyphicon-search" aria-hidden="true"></span> SEARCH TRANSACTIONS</a>
				</div>
				<div class="col-md-4">
					<a class="btn btn-default btn-block btn-lg" href='scsr'><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> MAKE SCSR REPORT</a>
				</div>
	</div>

			<br>
	<div class="row">
				<div class="col-md-4">
					<a class="btn btn-default btn-block btn-lg" href='vr'><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> MAKE VOUCHER / OBR / CERT. </a>
				</div>

				<div class="col-md-4">
					<a class="btn btn-default btn-block btn-lg" href='print'><span class="glyphicon glyphicon-print" aria-hidden="true"></span> MAKE SUMMARY REPORT </a>
				</div>


			<?php 
				$user_role = $this->session->userdata['logged_in_burial']['role'];

				if($user_role == 1){ ?>
						<div class="col-md-4">
							<a class="btn btn-default btn-block btn-lg" href='users'><span class="glyphicon glyphicon-user" aria-hidden="true"></span> USER ACCOUNTS</a>
						</div>
			<?php } ?>
				
	</div>
</div>






