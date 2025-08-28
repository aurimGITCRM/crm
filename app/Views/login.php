<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title; ?></title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<!-- jQuery UI -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<style>

	* {
		font-family: -apple-system, BlinkMacSystemFont, "San Francisco", Helvetica, Arial, sans-serif;
		font-weight: 300;
		margin: 0;
	}
	html, body {
		height: 100%;
		width: 100%;
		margin: 0 0;
		display: flex;
		align-items: flex-start;
		justify-content: flex-start;
		background: #f3f2f2;
	}
	h4 {
		font-size: 24px;
		font-weight: 600;
		color: #000;
		opacity: 0.85;
	}
	label {
		font-size: 12.5px;
		color: #000;
		opacity: 0.8;
		font-weight: 400;
	}
	form {
		padding: 40px 30px;
		background: #fefefe;
		display: flex;
		flex-direction: column;
		align-items: flex-start;
		padding-bottom: 20px;
		width: 300px;
	}
	form h4 {
		margin-bottom: 20px;
		color: rgba(0, 0, 0, 0.5);
	}
	form h4 span {
		color: black;
		font-weight: 700;
	}
	form p {
		line-height: 155%;
		margin-bottom: 5px;
		font-size: 14px;
		color: #000;
		opacity: 0.65;
		font-weight: 400;
		max-width: 200px;
		margin-bottom: 40px;
	}
	a.discrete {
		color: rgba(0, 0, 0, 0.4);
		font-size: 14px;
		border-bottom: solid 1px rgba(0, 0, 0, 0);
		padding-bottom: 4px;
		margin-left: auto;
		font-weight: 300;
		transition: all 0.3s ease;
		margin-top: 40px;
	}
	a.discrete:hover {
		border-bottom: solid 1px rgba(0, 0, 0, 0.2);
	}
	button {
		cursor: pointer;
		-webkit-appearance: none;
		width: auto;
		min-width: 100px;
		border-radius: 24px;
		text-align: center;
		padding: 15px 40px;
		margin-top: 5px;
		background-color: #004A99 ;
		color: #fff;
		font-size: 14px;
		margin-left: auto;
		font-weight: 500;
		box-shadow: 0px 2px 6px -1px rgba(0, 0, 0, 0.13);
		border: none;
		transition: all 0.3s ease;
		outline: 0;
	}
	button:hover {
		transform: translateY(-3px);
		box-shadow: 0 2px 6px -1px rgba(182, 157, 230, 0.65);
	}
	button:hover:active {
		transform: scale(0.99);
	}
	input {
		font-size: 16px;
		padding: 20px 0px;
		height: 56px;
		border: none;
		border-bottom: solid 1px rgba(0, 0, 0, 0.1);
		background: #fff;
		width: 280px;
		box-sizing: border-box;
		transition: all 0.3s linear;
		color: #000;
		font-weight: 400;
		-webkit-appearance: none;
	}
	input:focus {
		border-bottom: solid 1px #b69de6;
		outline: 0;
		box-shadow: 0 2px 6px -8px rgba(182, 157, 230, 0.45);
	}
	.floating-label {
		position: relative;
		margin-bottom: 10px;
		width: 100%;
	}
	.floating-label label {
		position: absolute;
		top: calc(50% - 7px);
		left: 0;
		opacity: 0;
		transition: all 0.3s ease;
		padding-left: 44px;
	}
	.floating-label input {
		width: calc(100% - 44px);
		margin-left: auto;
		display: flex;
	}
	.floating-label .icon {
		position: absolute;
		top: 1rem;
		left: 0;
	}
	.floating-label input:not(:placeholder-shown) {
		padding: 28px 0px 12px 0px;
	}
	.floating-label input:not(:placeholder-shown) + label {
		transform: translateY(-10px);
		opacity: 0.7;
	}
	.floating-label input:not(:valid):not(:focus) + label + .icon {
		animation-name: shake-shake;
		animation-duration: 0.3s;
	}
	@keyframes shake-shake {
		0% {
			transform: translateX(-3px);
		}
		20% {
			transform: translateX(3px);
		}
		40% {
			transform: translateX(-3px);
		}
		60% {
			transform: translateX(3px);
		}
		80% {
			transform: translateX(-3px);
		}
		100% {
			transform: translateX(0px);
		}
	}
	.session {
		display: flex;
		flex-direction: row;
		width: auto;
		max-width: 100%;
		height: auto;
		margin: auto auto;
		background: #ffffff;
		border-radius: 4px;
		box-shadow: 0px 2px 6px -1px rgba(0, 0, 0, 0.12);
	}
	.left {
		width: 220px;
		height: auto;
		min-height: 100%;
		position: relative;
		background-color: #004A99;
		background-size: cover;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	@media screen and (max-width: 600px) {
		.left {
			display: none;
		}
	}

	.errore
	{
		padding-top: 15px;
		font-size:16px;
		color:red;
	}
</style>

<body>
	
	<div class="session">

		<div class="left">
			<img src="<?=$logoUrl; ?>" style="width: 100px; margin: 1rem" />
		</div>

		<?= validation_list_errors() ?>
		
		<?= form_open("/LoginVerify", array('data-ajax' => 'false')); ?>

			<h4>CRM  <span>Aurim</span></h4>
			<p>Benvenuto, inserisci le credenziali per autenticarti.</p>

			<div class="floating-label">
				<input type="text" name="username" id="username" placeholder="Username" value="<?= set_value('username'); ?>" autocomplete="off" required />
				<label for="email">Username:</label>
				<div class="icon">
					<span class="material-icons-outlined">person</span>
				</div>
			</div>

			<div class="floating-label">
				<input type="password" name="password" id="pwd" placeholder="Password" autocomplete="off" required />
				<label for="password">Password:</label>
				<div class="icon">
					<span class="material-icons-outlined">password</span>
				</div>
			</div>

			<button type="submit">
				Log in 
				<span class="material-icons-outlined" style="font-size: 20px; vertical-align: middle;">login</span>
			</button>

			<?php if(!empty($_SESSION['login_error'])): ?>
				<div id="errore" class="errore"><?=$_SESSION['login_error']?></div>
				<script>
					setTimeout(function(){$('#errore').hide();},3000);				
				</script>
			<?php endif; ?>

			<div style="padding-top: 15px;text-align: right !important;width:100%;">
				<a href="https://www.privacylab.it/informativa.php?19686455612" target="_blank" style="color:#004A99;font-size: 13px;">Informativa privacy</a>
			</div>

		<?php echo form_close(); ?>

	</div>

</body>

</html>