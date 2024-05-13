<!DOCTYPE html>
<html>

<head>
	<title>Sistem Absensi Duta</title>
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/fullcalendar/fullcalendar.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.css"> -->
	<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<!-- adminator -->
	<link rel="stylesheet" href="<?= base_url('assets/adminator/style.css') ?>">


	<!-- JS scripts -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

	<!-- adminator -->
	<script src="<?= base_url('assets/adminator/main.js') ?>" defer></script>
</head>

<body class="app">
	<!-- adminator -->
	<div id="loader">
		<div class="spinner"></div>
	</div>
	<script>
		window.addEventListener('load', function load() {
			const loader = document.getElementById('loader');
			setTimeout(function() {
				loader.classList.add('fadeOut');
			}, 300);
		});
	</script>

	<!-- new template -->
	<div>
		<div class="sidebar">
			<div class="sidebar-inner">
				<!-- ### $Sidebar Header ### -->
				<div class="sidebar-logo">
					<div class="peers ai-c fxw-nw">
						<div class="peer peer-greed">
							<a class="sidebar-link td-n" href="<?=site_url('/dashboard')?>">
								<div class="peers ai-c fxw-nw">
									<div class="peer">
										<div class="logo">
											<img src="assets/static/images/logo.png" alt="">
										</div>
									</div>
									<div class="peer peer-greed">
										<h5 class="lh-1 mB-0 logo-text">Penerbit Duta</h5>
									</div>
								</div>
							</a>
						</div>
						<div class="peer">
							<div class="mobile-toggle sidebar-toggle">
								<a href="" class="td-n">
									<i class="ti-arrow-circle-left"></i>
								</a>
							</div>
						</div>
					</div>
				</div>

				<!-- ### $Sidebar Menu ### -->
				<ul class="sidebar-menu scrollable pos-r">
					<li class="nav-item mT-30 actived">
						<a class="sidebar-link" href="<?=site_url('dashboard')?>">
							<span class="icon-holder">
								<i class="c-blue-500 ti-home"></i>
							</span>
							<span class="title">Dashboard</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="sidebar-link" href="<?=site_url('presences')?>">
							<span class="icon-holder">
								<i class="c-brown-500 ti-calendar"></i>
							</span>
							<span class="title">Riwayat Kehadiran</span>
						</a>
					</li>
					<!-- <li class="nav-item">
						<a class="sidebar-link" href="<?=site_url('pekerjaan')?>">
							<span class="icon-holder">
								<i class="c-brown-500 ti-files"></i>
							</span>
							<span class="title">Input Pekerjaan</span>
						</a>
					</li> -->
					
					<li class="nav-item">
						<a class="sidebar-link" href="<?=site_url('naskah/pengajuan')?>">
							<span class="icon-holder">
								<i class="c-deep-orange-500 ti-file"></i>
							</span>
							<?php
								$this->load->model('Naskah_model');
								$totalPengajuan = $this->Naskah_model->countPengajuan();
							?>
							<span class="title">Pengajuan No. Job <span class="mL-5" style="background:green;color:white;border-radius:3px;padding: 0px 5px;<?=$totalPengajuan == 0 ? 'display:none' : ''?>"><?=$totalPengajuan?></span></span>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="dropdown-toggle" href="javascript:void(0);">
							<span class="icon-holder">
								<i class="c-brown-500 ti-files"></i>
							</span>
							<span class="title">Naskah</span>
							<span class="arrow">
								<i class="ti-angle-right"></i>
							</span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?=site_url('naskah/index')?>" class="sidebar-link">Naskah</a>
							</li>
							<li>
								<a href="<?=site_url('naskah/roles/index')?>" class="sidebar-link">Naskah Roles</a>
							</li>
						</ul>
					</li>
					<!-- <li class="nav-item">
						<a class="sidebar-link" href="calendar.html">
							<span class="icon-holder">
								<i class="c-deep-orange-500 ti-calendar"></i>
							</span>
							<span class="title">Perencanaan Produksi</span>
						</a>
					</li> -->
					<li class="nav-item">
						<a class="sidebar-link" href="<?=site_url('proses_job')?>">
							<span class="icon-holder">
								<i class="c-deep-purple-500 ti-loop"></i>
							</span>
							<span class="title">Proses Job</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="sidebar-link" href="compose.html">
							<span class="icon-holder">
								<i class="c-blue-500 ti-book"></i>
							</span>
							<span class="title">Buku</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="sidebar-link" href="<?=site_url('report/daily')?>">
							<span class="icon-holder">
								<i class="c-orange-500 ti-agenda"></i>
							</span>
							<span class="title">Laporan Harian</span>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="dropdown-toggle" href="javascript:void(0);">
							<span class="icon-holder">
								<i class="c-gray-600 ti-layout-accordion-list"></i>
							</span>
							<span class="title">Data Master</span>
							<span class="arrow">
								<i class="ti-angle-right"></i>
							</span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?=site_url('master/jenjang')?>" class="sidebar-link">Jenjang</a>
							</li>
							<li>
								<a href="<?=site_url('master/mapel')?>" class="sidebar-link">Mapel</a>
							</li>
							<li>
								<a href="<?=site_url('master/kategori')?>" class="sidebar-link">Kategori</a>
							</li>
							<li>
								<a href="<?=site_url('master/ukuran')?>" class="sidebar-link">Ukuran</a>
							</li>
							<li>
								<a href="<?=site_url('holidays')?>" class="sidebar-link">Hari Libur</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a class="sidebar-link" href="<?=site_url('user/logout')?>">
							<span class="icon-holder">
								<i class="c-deep-purple-500 ti-shift-left"></i>
							</span>
							<span class="title">Keluar</span>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<!-- main area -->
		<div class="page-container">
			<!-- Topbar -->
			<div class="header navbar">
				<div class="header-container">
					<ul class="nav-left">
						<li>
							<a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);">
								<i class="ti-menu"></i>
							</a>
						</li>
						<!-- <li class="search-box">
							<a class="search-toggle no-pdd-right" href="javascript:void(0);">
								<i class="search-icon ti-search pdd-right-10"></i>
								<i class="search-icon-close ti-close pdd-right-10"></i>
							</a>
						</li>
						<li class="search-input">
							<input class="form-control" type="text" placeholder="Search...">
						</li> -->
					</ul>
					<ul class="nav-right">
						<!-- <li class="notifications dropdown">
							<span class="counter bgc-red">3</span>
							<a href="" class="dropdown-toggle no-after" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="ti-bell"></i>
							</a>

							<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
								<li class="pX-20 pY-15 bdB">
									<i class="ti-bell pR-10"></i>
									<span class="fsz-sm fw-600 c-grey-900">Notifications</span>
								</li>
								<li>
									<ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
										<li>
											<a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
												<div class="peer mR-15">
													<img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/1.jpg" alt="">
												</div>
												<div class="peer peer-greed">
													<span>
														<span class="fw-500">John Doe</span>
														<span class="c-grey-600">liked your <span class="text-dark">post</span>
														</span>
													</span>
													<p class="m-0">
														<small class="fsz-xs">5 mins ago</small>
													</p>
												</div>
											</a>
										</li>
										<li>
											<a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
												<div class="peer mR-15">
													<img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/2.jpg" alt="">
												</div>
												<div class="peer peer-greed">
													<span>
														<span class="fw-500">Moo Doe</span>
														<span class="c-grey-600">liked your <span class="text-dark">cover image</span>
														</span>
													</span>
													<p class="m-0">
														<small class="fsz-xs">7 mins ago</small>
													</p>
												</div>
											</a>
										</li>
										<li>
											<a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
												<div class="peer mR-15">
													<img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/3.jpg" alt="">
												</div>
												<div class="peer peer-greed">
													<span>
														<span class="fw-500">Lee Doe</span>
														<span class="c-grey-600">commented on your <span class="text-dark">video</span>
														</span>
													</span>
													<p class="m-0">
														<small class="fsz-xs">10 mins ago</small>
													</p>
												</div>
											</a>
										</li>
									</ul>
								</li>
								<li class="pX-20 pY-15 ta-c bdT">
									<span>
										<a href="" class="c-grey-600 cH-blue fsz-sm td-n">View All Notifications <i class="ti-angle-right fsz-xs mL-10"></i></a>
									</span>
								</li>
							</ul>
						</li>
						<li class="notifications dropdown">
							<span class="counter bgc-blue">3</span>
							<a href="" class="dropdown-toggle no-after" data-bs-toggle="dropdown">
								<i class="ti-email"></i>
							</a>

							<ul class="dropdown-menu">
								<li class="pX-20 pY-15 bdB">
									<i class="ti-email pR-10"></i>
									<span class="fsz-sm fw-600 c-grey-900">Emails</span>
								</li>
								<li>
									<ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
										<li>
											<a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
												<div class="peer mR-15">
													<img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/1.jpg" alt="">
												</div>
												<div class="peer peer-greed">
													<div>
														<div class="peers jc-sb fxw-nw mB-5">
															<div class="peer">
																<p class="fw-500 mB-0">John Doe</p>
															</div>
															<div class="peer">
																<small class="fsz-xs">5 mins ago</small>
															</div>
														</div>
														<span class="c-grey-600 fsz-sm">
															Want to create your own customized data generator for your app...
														</span>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
												<div class="peer mR-15">
													<img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/2.jpg" alt="">
												</div>
												<div class="peer peer-greed">
													<div>
														<div class="peers jc-sb fxw-nw mB-5">
															<div class="peer">
																<p class="fw-500 mB-0">Moo Doe</p>
															</div>
															<div class="peer">
																<small class="fsz-xs">15 mins ago</small>
															</div>
														</div>
														<span class="c-grey-600 fsz-sm">
															Want to create your own customized data generator for your app...
														</span>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
												<div class="peer mR-15">
													<img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/3.jpg" alt="">
												</div>
												<div class="peer peer-greed">
													<div>
														<div class="peers jc-sb fxw-nw mB-5">
															<div class="peer">
																<p class="fw-500 mB-0">Lee Doe</p>
															</div>
															<div class="peer">
																<small class="fsz-xs">25 mins ago</small>
															</div>
														</div>
														<span class="c-grey-600 fsz-sm">
															Want to create your own customized data generator for your app...
														</span>
													</div>
												</div>
											</a>
										</li>
									</ul>
								</li>
								<li class="pX-20 pY-15 ta-c bdT">
									<span>
										<a href="email.html" class="c-grey-600 cH-blue fsz-sm td-n">View All Email <i class="fs-xs ti-angle-right mL-10"></i></a>
									</span>
								</li>
							</ul>
						</li> -->
						<li class="dropdown">
							<a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-bs-toggle="dropdown">
								<div class="peer mR-10">
									<img class="w-2r bdrs-50p" src="https://randomuser.me/api/portraits/men/10.jpg" alt="">
								</div>
								<div class="peer">
									<span class="fsz-sm c-grey-900"><?= $this->session->userdata('user_fullname') ?></span>
								</div>
							</a>
							<ul class="dropdown-menu fsz-sm">
								<!-- <li>
									<a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
										<i class="ti-settings mR-10"></i>
										<span>Setting</span>
									</a>
								</li>
								<li>
									<a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
										<i class="ti-user mR-10"></i>
										<span>Profile</span>
									</a>
								</li>
								<li>
									<a href="email.html" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
										<i class="ti-email mR-10"></i>
										<span>Messages</span>
									</a>
								</li>
								<li role="separator" class="divider"></li> -->
								<li>
									<a href="<?= site_url('user/logout') ?>" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
										<i class="ti-power-off mR-10"></i>
										<span>Logout</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>

			<main class="main-content bgc-grey-100">
				<div id="mainContent">
					<?php echo $_content; ?>
				</div>
			</main>
		</div>
	</div>

	<script type="text/javascript">
		const base_url = '<?php echo base_url(); ?>'

		$.fn.serializeObject = function () {
			var o = {};
			var a = this.serializeArray();
			$.each(a, function () {
				if (o[this.name] !== undefined) {
					if (!o[this.name].push) {
						o[this.name] = [o[this.name]];
					}      
					o[this.name].push(this.value || '');
				} else {
					o[this.name] = this.value || '';
				}
			});
			return o;
		};

		let table
		refreshTable = function() {
            table.ajax.reload(null, false)
        }

		let filters = []
		$('#filter').submit(function (e) {
			e.preventDefault()

			filters.filters = $('#filter :input').serialize().replace(/\+/g, '%20');
			
			refreshTable()
		})

		function addOneDay(date) {
			const initialDate = new Date(date)
			initialDate.setDate(initialDate.getDate() + 1)
			const day = String(initialDate.getDate()).padStart(2, '0')
			const month = String(initialDate.getMonth() + 1).padStart(2, '0')
			const year = initialDate.getFullYear()
			const nextDate = day + '/' + month + '/' + year

			return nextDate
		}
	</script>
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script> -->
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script> -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/moment-develop/moment.js"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker.js"></script> -->
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/fullcalendar/fullcalendar.js"></script> -->

	<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>