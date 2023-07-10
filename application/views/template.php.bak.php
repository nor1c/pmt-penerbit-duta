<!DOCTYPE html>
<html>
<head>
	<title>Sistem Absensi Duta</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/fullcalendar/fullcalendar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.css">

	<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>


	<br>


<div class="container-fluid">
  <div class="container">
		<nav class="navbar navbar-inverse">
		 
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a href="http://absensi.penerbitduta.top/presences/input" class="navbar-brand" class="active">Sistem Absensi Penerbit Duta</a>
		    </div>


	
	
			<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
				<ul class="nav navbar-nav">

					<li><a href="<?php echo base_url().'presences/input'; ?>">Input Kehadiran</a></li>

			<!--			
					<li class="<?php echo ($this->uri->segment(1)=='home') ? 'active' : ''; ?>"><a href="<?php echo base_url().'home'; ?>">Dashboard</a></li>

			-->		
					<?php
						if($this->session->userdata('user_type_id')==1){
					?>
					<li class="dropdown <?php echo ($this->uri->segment(1)=='master'||$this->uri->segment(1)=='user_category') ? 'active' : ''; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Data Master <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url().'master/divisi/listdata'; ?>">Kelola Divisi</a></li>
							<li><a href="<?php echo base_url().'master/jabatan/listdata'; ?>">Kelola Jabatan</a></li>


							<!--
							<li><a href="<?php echo base_url().'master/golongan/listdata'; ?>">Kelola Golongan</a></li>

							<li class="divider"></li>
							<!--
							<li><a href="<?php echo base_url().'master/jam_kerja/listdata'; ?>">Kelola Jam Kerja</a></li>
							<li><a href="<?php echo base_url().'master/alasan/listdata'; ?>">Kelola Alasan</a></li>
							<li class="divider"></li>-->
							<li><a href="<?php echo base_url().'user_category/listdata'; ?>">Kelola Tipe User</a></li>
							<li>
								<a href="<?=base_url('buku/no_job')?>">Kelola No Job</a>
							</li>
						</ul>
					</li>
					<li class="<?php echo ($this->uri->segment(1)=='user') ? 'active' : ''; ?>"><a href="<?php echo base_url().'user/listdata'; ?>">Data Karyawan</a></li>
					

					<!--
					<li class="<?php echo ($this->uri->segment(1)=='workday_plan') ? 'active' : ''; ?>"><a href="<?php echo base_url().'workday_plan/listdata'; ?>">Perencanaan Hari Kerja</a></li>-->
					<?php
						}
					?>
					<li class="dropdown <?php echo ($this->uri->segment(1)=='presences'||$this->uri->segment(1)=='attendance') ? 'active' : ''; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							Rekap Kehadiran <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url().'presences'; ?>">Data Kehadiran</a></li>
							
							<!--
							<li><a href="<?php echo base_url().'attendance/request'; ?>">Absen Susulan</a></li>
							<li><a href="<?php echo base_url().'attendance/pending'; ?>">Absen Susulan - Pending</a></li> -->
							<?php
							if($this->session->userdata('user_type_id')!='5'){
							?>
							<li class="divider"></li>
							<li><a href="#"></a></li>
							<?php
							}
							?>
						</ul>
					</li>
					<li><a href="<?php echo base_url().'user/logout'; ?>" onclick="return confirm('Anda Yakin ingin keluar ?')">Logout</a></li>
				</ul>
			</nav>
		</div>
	</header>


<div class="container-fluid">
	<div class="container">	
	 <div class="panel-body">
	 	<?php echo $_content; ?>
	 </div>
	 <div class="panel-footer">Penerbit Duta 2020</div>
	 <br>
	
</div>
</div>


	<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
	</script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/moment-develop/moment.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/fullcalendar/fullcalendar.js"></script>
	
	<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>