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
                            <li <?php if($active == 'hotelIntervals'):?>class="active" <?php endif;?>>
                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#hotels"><i class="fa fa-fw fa-bed"></i> Hotels</a>
                                <ul id="hotels" class="dropdown <?php if($parentActive && $parentActive == 'hotels'):?>open<?php else:?>collapse<?php endif;?>">
                                    <li <?php if($active == 'addHotel'):?>class="open" <?php endif;?>>
                                            <a href="/admin/addHotel">Add/Edit hotel</a>
                                    </li>
                                    <li <?php if($active == 'hotelsList'):?>class="open" <?php endif;?>>
                                            <a href="/admin/hotelsList">Hotel list</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#airports"><i class="fa fa-plane"></i> Airports</a>
                                <ul id="airports" class="dropdown <?php if($parentActive && $parentActive == 'airports'):?>open<?php else:?>collapse<?php endif;?>">
                                        <li <?php if($active == 'addAirport'):?>class="open" <?php endif;?>>
                                                <a href="/admin/addAirport">Add/Edit airport</a>
                                        </li>
                                        <li <?php if($active == 'airportsList'):?>class="open" <?php endif;?>>
                                                <a href="/admin/airportsList">Airports list</a>
                                        </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#classifications"><i class="fa fa-clipboard"></i> Classifications</a>
                                <ul id="classifications" class="dropdown <?php if($parentActive && $parentActive == 'classifications'):?>open<?php else:?>collapse<?php endif;?>">
                                        <li <?php if($active == 'addClassification'):?>class="open" <?php endif;?>>
                                                <a href="/admin/addClassification">Add/Edit classification</a>
                                        </li>
                                        <li <?php if($active == 'classificationsList'):?>class="open" <?php endif;?>>
                                                <a href="/admin/classificationsList">Classifications list</a>
                                        </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#themes"><i class="fa fa-bookmark"></i> Themes</a>
                                <ul id="themes" class="dropdown <?php if($parentActive && $parentActive == 'themes'):?>open<?php else:?>collapse<?php endif;?>">
                                        <li <?php if($active == 'addTheme'):?>class="open" <?php endif;?>>
                                                <a href="/admin/addTheme">Add/Edit theme</a>
                                        </li>
                                        <li <?php if($active == 'themesList'):?>class="open" <?php endif;?>>
                                                <a href="/admin/themesList">Themes list</a>
                                        </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#vacations"><i class="fa fa-globe"></i> Vacations</a>
                                <ul id="vacations" class="dropdown <?php if($parentActive && $parentActive == 'vacations'):?>open<?php else:?>collapse<?php endif;?>">
                                        <li <?php if($active == 'addVacation'):?>class="open" <?php endif;?>>
                                                <a href="/admin/addVacation">Add/Edit vacation</a>
                                        </li>
                                        <li <?php if($active == 'vacationsList'):?>class="open" <?php endif;?>>
                                                <a href="/admin/vacationsList">Vacations list</a>
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

