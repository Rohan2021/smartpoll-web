<div class="container-fluid bg-cstm footer">
	<div class="row">
		<div class="col-md-12">
			<a class="navbar-brand" href="#" style="font-size: 12px;"><i class="fa fa-bar-chart"></i> smartpoll.com</a>
		</div>
		<div class="col-md-4 ">
			<ul class="footer-links">
				<li><a href="index.php">Home</a></li>
				<?php
				if(isset($_SESSION['login'])){
					if(!$_SESSION['login']){
				?>
				<li><a href="register.php">Signup</a></li>
				<?php
					}
				}
				?>
				<li><a href="downloadapp.php">Download App</a></li>
			</ul>
		</div>
		<div class="col-md-4">
			<ul class="footer-links">
				<li><a href="#">For report bugs mail us on<br>info@smartpoll.com</a></li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid bg-dark footer text-center" style="color: white; padding: 10px;">
	© 2018 SMARTPOLL
</div>