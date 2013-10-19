<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><?php echo $site_name; ?></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="index.php">Naslovnica</a></li>
				<li><a href="#about">O Nama</a></li>
				<li><a href="#contact">Kontakt</a></li>
			</ul>
			<?php
				if (isset($_SESSION['user']) && isset($_SESSION['nickname'])) {
					echo "<p class='navbar-text pull-right'>Prijavljen kao ";
					echo $_SESSION['nickname'];
					echo " | <a href='logout.php'>Odjava</a></p>";
				} else {
echo <<<END
					<form class="navbar-form navbar-right" action="index.php" method="POST">
						<div class="form-group">
							<input type="text" placeholder="Email" class="form-control" name="email">
						</div>
						<div class="form-group">
							<input type="password" placeholder="Lozinka" class="form-control" name="password">
						</div>
						<button type="submit" class="btn btn-success">Sign in</button>
					</form>
END;
				}
			?>
			<!-- <p class="navbar-text pull-right">Prijavljen kao <?php echo $_SESSION['nickname']; ?> | <a href="logout.php">Odjava</a></p> -->
		</div><!--/.navbar-collapse -->
	</div>
</div>