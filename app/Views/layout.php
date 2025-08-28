<!doctype html>
<html>

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<!-- jQuery UI -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- Google Icons -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<link rel="stylesheet" href="/styles/smartdesk_style.css" />

	<!-- Favicons -->
	<link rel="icon" href="https://smartdeskall.s3-eu-west-1.amazonaws.com/favicon-16x16.png" type="image/png" sizes="16x16">
	<link rel="apple-touch-icon" sizes="180x180" href="/frontend/img/logos/apple_touch_icon.png">

	<!-- Select2 -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" />

	<!-- toaster -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<!-- Language script -->
	<script src='/scripts/datepicker-it.js' type='text/javascript'></script>
	<script src='/scripts/datepicker-en.js' type='text/javascript'></script>

	<!-- JQuery Timepicker -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
	
	<script src="/scripts/easy-bs-modals.js"></script>
	<script src="/scripts/easy-bs-modals-utils.js"></script>

	<!-- DateRangePicker -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<!-- datatables -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap4.min.css">
	<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js"></script>
	<script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
	<script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

	<title><?= $title; ?></title>
	<style>
		body
		{
			margin:0 !important;
			font-size:16px !important;
		}

		.btn .btn-primary .btn-primary:hover
		{
			background:orange !important;
		}
	</style>
</head>

<body class="bg-light">
	<div class="container-fluid p-0">

		<?php //if (!isset($flag_header_readonly) || $flag_header_readonly != true) : ?>
			<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom" style="margin-bottom:25px;">
				<div class="container-fluid">

					<a class="navbar-brand m-0 p-0" href="/smartdesk/home/">
						<img class="img-fluid m-0 p-0" src="" width="80"/>
					</a>

					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<?php //if(! $this->permissionmanager->is_only_reception($this->session->userdata('logged_in')['permissions'])): ?>

						<!-- <div class="collapse navbar-collapse" id="navbar"> -->
							<!--

							<ul class="navbar-nav mr-auto">
								<?php //if ($this->permissionmanager->is_reception($this->session->userdata('logged_in')['permissions'])) : ?>
									<li class="nav-item active dropdown">
										<a class="nav-link dropdown-toggle" id="receptionistDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons md-18">people</i> Reception
										</a>
										<div class="dropdown-menu" aria-labelledby="receptionistDropdown">
											<a class="dropdown-item" href="/smartdesk/receptionist/register_guest">
												<?= ""//$this->lang->line('receptionist_invite_guest_title'); ?>
											</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="/smartdesk/receptionist/search_guest">
												<?= ""//$this->lang->line('receptionist_search_guest_title'); ?>
											</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="/smartdesk/receptionist/get_brochures">
												<?= ""//$this->lang->line('receptionist_manegement_bochures'); ?>
											</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="/smartdesk/receptionist/get_canteen">
												<?= ""//$this->lang->line('receptionist_manegement_canteen'); ?>
											</a>
										</div>
									</li>
								<?php //endif; ?>

								<?php //if ($this->permissionmanager->is_carraio($this->session->userdata('logged_in')['permissions'])) : ?>
									<li class="nav-item active">
										<a class="nav-item nav-link" title="Admin" href="/smartdesk/carraio/"><i class="material-icons md-18">door_front</i> Carraio</a>
									</li>
								<?php //endif; ?>
							</ul>

							<ul class="navbar-nav">

								<?php // if (!empty($this->session->userdata('logged_in')['is_admin']) && ($this->session->userdata('logged_in')['is_admin'] === true)) : ?>
									<li class="nav-item active">
										<a class="nav-item nav-link" title="Admin" href="/smartdesk/admin/"><i class="material-icons md-18">perm_contact_calendar</i> <?=""// $this->lang->line('smartdesk_nav_admin_button'); ?></a>
									</li>
								<?php //endif; ?>

								<?php //if ($this->permissionmanager->is_reception($this->session->userdata('logged_in')['permissions']) || (!empty($this->session->userdata('logged_in')['is_admin']) && ($this->session->userdata('logged_in')['is_admin'] === true))): ?>
									<li class="nav-item active dropdown">
										<a class="nav-link dropdown-toggle" id="reportDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Report"><i class="material-icons md-18">assessment</i> Report</a>
										<div class="dropdown-menu" aria-labelledby="reportDropdown">
											
											<a class="dropdown-item" title="<?="" //$this->lang->line('smartdesk_nav_report_meetingrooms_label'); ?>" href="/smartdesk/meetingRoom/report"><?= ""//this->lang->line('smartdesk_nav_report_meetingrooms'); ?></a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" title="Report prenotazioni" href="/smartdesk/report/"><?="" //$this->lang->line('smartdesk_nav_report_bookings'); ?></a>
											<div class="dropdown-divider"></div>
											<a href="/smartdesk/report/bookingsList" class="dropdown-item"><?="" //$this->lang->line('smartdesk_nav_report_saturation'); ?></a>
											<div class="dropdown-divider"></div>
											<a href="/smartdesk/meetingRoom/report" class="dropdown-item">Report sale riunioni</a>
											<div class="dropdown-divider"></div>											 
											 -->
											 <!-- <a class="dropdown-item" title="<?= ""//$this->lang->line('smartdesk_nav_report_guest_invitations'); ?>" href="/smartdesk/report/guest_invitations">
												<?="" //$this->lang->line('smartdesk_nav_report_guest_invitations'); ?>
											</a>

											<div class="dropdown-divider"></div> 

											<a class="dropdown-item" title="<?= ""//$this->lang->line('smartdesk_nav_report_checkins'); ?>" href="/smartdesk/report/guest_checkins">
												<?= ""//$this->lang->line('smartdesk_nav_report_checkins'); ?>
											</a>
											<hr>
											<a class="dropdown-item" title="<?= ""//$this->lang->line('smartdesk_nav_report_canteen'); ?>" href="/smartdesk/report/guest_canteen">
												<?= ""//$this->lang->line('smartdesk_nav_report_canteen'); ?>
											</a>
											
											<?php /*
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" title="Report di tutte le scrivanie" href="/smartdesk/report/desks">Report di tutte<br />le scrivanie</a>
											*/ ?>
										</div>
									</li>
								<?php //endif; ?>
								<li class="nav-item active">
									<a class="nav-item nav-link" title="Logout" href="/smartdesk/login/logout/"><i class="material-icons md-18">power_settings_new</i> <?= ""//$this->lang->line('smartdesk_nav_logout_button'); ?></a>
								</li>
							</ul>
						</div> -->
					<?php// else: ?>

						<?php if(!empty($_SESSION['user_login'])): ?>
							<div class="collapse navbar-collapse" id="navbar">
								<ul class="navbar-nav ml-auto">
									<?php if($_SESSION['user_login']['tipo'] == 'admin' || $_SESSION['user_login']['tipo'] == 'sysadmin'): ?>
										<li class="nav-item dropdown">
											<a class="nav-link active dropdown-toggle" id="adminDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="material-icons md-18">people</i> Admin
											</a>
											<ul class="dropdown-menu" aria-labelledby="adminDropdown">
												<li><a class="dropdown-item" onclick="location.href='Users';">Utenti</a></li>
												<li><a class="dropdown-item" onclick="location.href='Campagne';">Campagne</a></li>
												<li><a class="dropdown-item" onclick="location.href='Esiti';">Esiti</a></li>
												<li><a class="dropdown-item" onclick="location.href='Attivita';">Attività</a></li>
												<li><a class="dropdown-item" onclick="location.href='Products';">Prodotti</a></li>
												<li><a class="dropdown-item" onclick="location.href='ContattiWebVista';">ContattiWebVista</a></li>
											</ul>
										</li>
									<?php else: ?>
										<li class="nav-item dropdown">
										<a class="nav-link active dropdown-toggle" id="adminDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons md-18">people</i> <?=$_SESSION['user_login']['nome'] . " " .$_SESSION['user_login']['cognome']?>
										</a>
										<ul class="dropdown-menu" aria-labelledby="adminDropdown">
											<li><a class="dropdown-item" onclick="location.href='/CampagneContatti';">Campagne</a></li>
										</ul>
									</li>
									<?php endif; ?>

									<li class="nav-item">
										<a class="nav-item nav-link" title="Logout" href="/LogOut/">
											<i class="material-icons md-18">power_settings_new</i> <?= ""//$this->lang->line('smartdesk_nav_logout_button'); ?>
										</a>
									</li>

								</ul>
							</div>
					<?php endif; ?>
				</div>
			</nav>
		<?php //endif; ?>

		<div class="container-fluid"><?= $template; ?></div>

		<div class="mt-5" style="border-top: 4px solid orange;"></div>
		<div class="mt-1" style="border-top: 4px solid black;"></div>

		<nav class="navbar navbar-light bg-light" style="padding-top:10px; padding-bottom:10px;">
			<span class="text-muted">Powered by <strong>WP</strong></span>
		</nav>

	</div>
		<script>
		  	$(document).ready(function () 
			{
				//redirect al login se non trova la sessione login
				<?php if(empty($_SESSION["user_login"])): ?>
            		location.href = '/';
				<?php endif; ?>

	 			$('.dropdown').click(function()
	 			{				
	 				$('.dropdown-menu').toggleClass('show');
					return false;	
				})
			})
		</script>
</body>

</html>