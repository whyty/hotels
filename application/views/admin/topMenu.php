<div id="wrapper">

	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/admin">Hotels Admin</a>
		</div>
		<!-- Top Menu Items -->
		<ul class="nav navbar-right top-nav">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $username ?> <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li>
						<a href="/admin/settings"><i class="fa fa-fw fa-gear"></i> Settings</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="/admin/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
					</li>
				</ul>
			</li>
		</ul>
		<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav side-nav">
				<li <?php if($active == 'index'):?>class="active" <?php endif;?>>
					<a href="/admin"><i class="fa fa-fw fa-dashboard"></i> Home</a>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#hotels"><i class="fa fa-fw fa-bed"></i> Hotels</a>
					<ul id="hotels" class="dropdown <?php if($parentActive && $parentActive == 'hotels'):?>open<?php else:?>collapse<?php endif;?>">
						<li <?php if($active == 'addHotel'):?>class="open" <?php endif;?>>
							<a href="/admin/addHotel">Add hotel</a>
						</li>
						<li>
							<a href="#">Hotel list</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</nav>

	<div id="page-wrapper">

		<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header"><?php echo $sectionName ?></h1>
				</div>
			</div>
			<!-- /.row -->

