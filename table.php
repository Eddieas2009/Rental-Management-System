<!doctype html>
<html lang="en" class="color-sidebar sidebarcolor3">


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:31:07 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/css/dark-theme.css" />
	<link rel="stylesheet" href="assets/css/semi-dark.css" />
	<link rel="stylesheet" href="assets/css/header-colors.css" />
	<title>Table</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<?php include 'includes/sidemenu.php'; ?>
		<!--end sidebar wrapper -->
		<!--start header -->
		<?php include 'includes/header.php'; ?>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Tables</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Data Table</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Settings</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
								<a class="dropdown-item" href="javascript:;">Another action</a>
								<a class="dropdown-item" href="javascript:;">Something else here</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">DataTable</h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Name</th>
										<th>Position</th>
										<th>Office</th>
										<th>Age</th>
										<th>Start date</th>
										<th>Salary</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Tiger Nixon</td>
										<td>System Architect</td>
										<td>Edinburgh</td>
										<td>61</td>
										<td>2011/04/25</td>
										<td>$320,800</td>
									</tr>
									<tr>
										<td>Garrett Winters</td>
										<td>Accountant</td>
										<td>Tokyo</td>
										<td>63</td>
										<td>2011/07/25</td>
										<td>$170,750</td>
									</tr>
									<tr>
										<td>Ashton Cox</td>
										<td>Junior Technical Author</td>
										<td>San Francisco</td>
										<td>66</td>
										<td>2009/01/12</td>
										<td>$86,000</td>
									</tr>
									<tr>
										<td>Cedric Kelly</td>
										<td>Senior Javascript Developer</td>
										<td>Edinburgh</td>
										<td>22</td>
										<td>2012/03/29</td>
										<td>$433,060</td>
									</tr>
									<tr>
										<td>Airi Satou</td>
										<td>Accountant</td>
										<td>Tokyo</td>
										<td>33</td>
										<td>2008/11/28</td>
										<td>$162,700</td>
									</tr>
									<tr>
										<td>Brielle Williamson</td>
										<td>Integration Specialist</td>
										<td>New York</td>
										<td>61</td>
										<td>2012/12/02</td>
										<td>$372,000</td>
									</tr>
									<tr>
										<td>Herrod Chandler</td>
										<td>Sales Assistant</td>
										<td>San Francisco</td>
										<td>59</td>
										<td>2012/08/06</td>
										<td>$137,500</td>
									</tr>
									<tr>
										<td>Rhona Davidson</td>
										<td>Integration Specialist</td>
										<td>Tokyo</td>
										<td>55</td>
										<td>2010/10/14</td>
										<td>$327,900</td>
									</tr>
									<tr>
										<td>Colleen Hurst</td>
										<td>Javascript Developer</td>
										<td>San Francisco</td>
										<td>39</td>
										<td>2009/09/15</td>
										<td>$205,500</td>
									</tr>
									<tr>
										<td>Sonya Frost</td>
										<td>Software Engineer</td>
										<td>Edinburgh</td>
										<td>23</td>
										<td>2008/12/13</td>
										<td>$103,600</td>
									</tr>
									<tr>
										<td>Jena Gaines</td>
										<td>Office Manager</td>
										<td>London</td>
										<td>30</td>
										<td>2008/12/19</td>
										<td>$90,560</td>
									</tr>
									<tr>
										<td>Quinn Flynn</td>
										<td>Support Lead</td>
										<td>Edinburgh</td>
										<td>22</td>
										<td>2013/03/03</td>
										<td>$342,000</td>
									</tr>
									<tr>
										<td>Charde Marshall</td>
										<td>Regional Director</td>
										<td>San Francisco</td>
										<td>36</td>
										<td>2008/10/16</td>
										<td>$470,600</td>
									</tr>
									<tr>
										<td>Haley Kennedy</td>
										<td>Senior Marketing Designer</td>
										<td>London</td>
										<td>43</td>
										<td>2012/12/18</td>
										<td>$313,500</td>
									</tr>
									<tr>
										<td>Tatyana Fitzpatrick</td>
										<td>Regional Director</td>
										<td>London</td>
										<td>19</td>
										<td>2010/03/17</td>
										<td>$385,750</td>
									</tr>
									<tr>
										<td>Michael Silva</td>
										<td>Marketing Designer</td>
										<td>London</td>
										<td>66</td>
										<td>2012/11/27</td>
										<td>$198,500</td>
									</tr>
									<tr>
										<td>Paul Byrd</td>
										<td>Chief Financial Officer (CFO)</td>
										<td>New York</td>
										<td>64</td>
										<td>2010/06/09</td>
										<td>$725,000</td>
									</tr>
									<tr>
										<td>Gloria Little</td>
										<td>Systems Administrator</td>
										<td>New York</td>
										<td>59</td>
										<td>2009/04/10</td>
										<td>$237,500</td>
									</tr>
									<tr>
										<td>Bradley Greer</td>
										<td>Software Engineer</td>
										<td>London</td>
										<td>41</td>
										<td>2012/10/13</td>
										<td>$132,000</td>
									</tr>
									<tr>
										<td>Dai Rios</td>
										<td>Personnel Lead</td>
										<td>Edinburgh</td>
										<td>35</td>
										<td>2012/09/26</td>
										<td>$217,500</td>
									</tr>
									<tr>
										<td>Jenette Caldwell</td>
										<td>Development Lead</td>
										<td>New York</td>
										<td>30</td>
										<td>2011/09/03</td>
										<td>$345,000</td>
									</tr>
									<tr>
										<td>Yuri Berry</td>
										<td>Chief Marketing Officer (CMO)</td>
										<td>New York</td>
										<td>40</td>
										<td>2009/06/25</td>
										<td>$675,000</td>
									</tr>
									<tr>
										<td>Caesar Vance</td>
										<td>Pre-Sales Support</td>
										<td>New York</td>
										<td>21</td>
										<td>2011/12/12</td>
										<td>$106,450</td>
									</tr>
									<tr>
										<td>Doris Wilder</td>
										<td>Sales Assistant</td>
										<td>Sydney</td>
										<td>23</td>
										<td>2010/09/20</td>
										<td>$85,600</td>
									</tr>
									<tr>
										<td>Angelica Ramos</td>
										<td>Chief Executive Officer (CEO)</td>
										<td>London</td>
										<td>47</td>
										<td>2009/10/09</td>
										<td>$1,200,000</td>
									</tr>
									<tr>
										<td>Gavin Joyce</td>
										<td>Developer</td>
										<td>Edinburgh</td>
										<td>42</td>
										<td>2010/12/22</td>
										<td>$92,575</td>
									</tr>
									<tr>
										<td>Jennifer Chang</td>
										<td>Regional Director</td>
										<td>Singapore</td>
										<td>28</td>
										<td>2010/11/14</td>
										<td>$357,650</td>
									</tr>
									<tr>
										<td>Brenden Wagner</td>
										<td>Software Engineer</td>
										<td>San Francisco</td>
										<td>28</td>
										<td>2011/06/07</td>
										<td>$206,850</td>
									</tr>
									<tr>
										<td>Fiona Green</td>
										<td>Chief Operating Officer (COO)</td>
										<td>San Francisco</td>
										<td>48</td>
										<td>2010/03/11</td>
										<td>$850,000</td>
									</tr>
									<tr>
										<td>Shou Itou</td>
										<td>Regional Marketing</td>
										<td>Tokyo</td>
										<td>20</td>
										<td>2011/08/14</td>
										<td>$163,000</td>
									</tr>
									<tr>
										<td>Michelle House</td>
										<td>Integration Specialist</td>
										<td>Sydney</td>
										<td>37</td>
										<td>2011/06/02</td>
										<td>$95,400</td>
									</tr>
									<tr>
										<td>Suki Burks</td>
										<td>Developer</td>
										<td>London</td>
										<td>53</td>
										<td>2009/10/22</td>
										<td>$114,500</td>
									</tr>
									<tr>
										<td>Prescott Bartlett</td>
										<td>Technical Author</td>
										<td>London</td>
										<td>27</td>
										<td>2011/05/07</td>
										<td>$145,000</td>
									</tr>
									<tr>
										<td>Gavin Cortez</td>
										<td>Team Leader</td>
										<td>San Francisco</td>
										<td>22</td>
										<td>2008/10/26</td>
										<td>$235,500</td>
									</tr>
									<tr>
										<td>Martena Mccray</td>
										<td>Post-Sales support</td>
										<td>Edinburgh</td>
										<td>46</td>
										<td>2011/03/09</td>
										<td>$324,050</td>
									</tr>
									<tr>
										<td>Unity Butler</td>
										<td>Marketing Designer</td>
										<td>San Francisco</td>
										<td>47</td>
										<td>2009/12/09</td>
										<td>$85,675</td>
									</tr>
									<tr>
										<td>Howard Hatfield</td>
										<td>Office Manager</td>
										<td>San Francisco</td>
										<td>51</td>
										<td>2008/12/16</td>
										<td>$164,500</td>
									</tr>
									<tr>
										<td>Hope Fuentes</td>
										<td>Secretary</td>
										<td>San Francisco</td>
										<td>41</td>
										<td>2010/02/12</td>
										<td>$109,850</td>
									</tr>
									<tr>
										<td>Vivian Harrell</td>
										<td>Financial Controller</td>
										<td>San Francisco</td>
										<td>62</td>
										<td>2009/02/14</td>
										<td>$452,500</td>
									</tr>
									<tr>
										<td>Timothy Mooney</td>
										<td>Office Manager</td>
										<td>London</td>
										<td>37</td>
										<td>2008/12/11</td>
										<td>$136,200</td>
									</tr>
									<tr>
										<td>Jackson Bradshaw</td>
										<td>Director</td>
										<td>New York</td>
										<td>65</td>
										<td>2008/09/26</td>
										<td>$645,750</td>
									</tr>
									<tr>
										<td>Olivia Liang</td>
										<td>Support Engineer</td>
										<td>Singapore</td>
										<td>64</td>
										<td>2011/02/03</td>
										<td>$234,500</td>
									</tr>
									<tr>
										<td>Bruno Nash</td>
										<td>Software Engineer</td>
										<td>London</td>
										<td>38</td>
										<td>2011/05/03</td>
										<td>$163,500</td>
									</tr>
									<tr>
										<td>Sakura Yamamoto</td>
										<td>Support Engineer</td>
										<td>Tokyo</td>
										<td>37</td>
										<td>2009/08/19</td>
										<td>$139,575</td>
									</tr>
									<tr>
										<td>Thor Walton</td>
										<td>Developer</td>
										<td>New York</td>
										<td>61</td>
										<td>2013/08/11</td>
										<td>$98,540</td>
									</tr>
									<tr>
										<td>Finn Camacho</td>
										<td>Support Engineer</td>
										<td>San Francisco</td>
										<td>47</td>
										<td>2009/07/07</td>
										<td>$87,500</td>
									</tr>
									<tr>
										<td>Serge Baldwin</td>
										<td>Data Coordinator</td>
										<td>Singapore</td>
										<td>64</td>
										<td>2012/04/09</td>
										<td>$138,575</td>
									</tr>
									<tr>
										<td>Zenaida Frank</td>
										<td>Software Engineer</td>
										<td>New York</td>
										<td>63</td>
										<td>2010/01/04</td>
										<td>$125,250</td>
									</tr>
									<tr>
										<td>Zorita Serrano</td>
										<td>Software Engineer</td>
										<td>San Francisco</td>
										<td>56</td>
										<td>2012/06/01</td>
										<td>$115,000</td>
									</tr>
									<tr>
										<td>Jennifer Acosta</td>
										<td>Junior Javascript Developer</td>
										<td>Edinburgh</td>
										<td>43</td>
										<td>2013/02/01</td>
										<td>$75,650</td>
									</tr>
									<tr>
										<td>Cara Stevens</td>
										<td>Sales Assistant</td>
										<td>New York</td>
										<td>46</td>
										<td>2011/12/06</td>
										<td>$145,600</td>
									</tr>
									<tr>
										<td>Hermione Butler</td>
										<td>Regional Director</td>
										<td>London</td>
										<td>47</td>
										<td>2011/03/21</td>
										<td>$356,250</td>
									</tr>
									<tr>
										<td>Lael Greer</td>
										<td>Systems Administrator</td>
										<td>London</td>
										<td>21</td>
										<td>2009/02/27</td>
										<td>$103,500</td>
									</tr>
									<tr>
										<td>Jonas Alexander</td>
										<td>Developer</td>
										<td>San Francisco</td>
										<td>30</td>
										<td>2010/07/14</td>
										<td>$86,500</td>
									</tr>
									<tr>
										<td>Shad Decker</td>
										<td>Regional Director</td>
										<td>Edinburgh</td>
										<td>51</td>
										<td>2008/11/13</td>
										<td>$183,000</td>
									</tr>
									<tr>
										<td>Michael Bruce</td>
										<td>Javascript Developer</td>
										<td>Singapore</td>
										<td>29</td>
										<td>2011/06/27</td>
										<td>$183,000</td>
									</tr>
									<tr>
										<td>Donna Snider</td>
										<td>Customer Support</td>
										<td>New York</td>
										<td>27</td>
										<td>2011/01/25</td>
										<td>$112,000</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<th>Name</th>
										<th>Position</th>
										<th>Office</th>
										<th>Age</th>
										<th>Start date</th>
										<th>Salary</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<?php include 'includes/footer.php'; ?>
	</div>
	<!--end wrapper-->
	<!--start switcher-->
	<div class="switcher-wrapper">
		<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
		</div>
		<div class="switcher-body">
			<div class="d-flex align-items-center">
				<h5 class="mb-0 text-uppercase">Theme Customizer</h5>
				<button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
			</div>
			<hr/>
			<h6 class="mb-0">Theme Styles</h6>
			<hr/>
			<div class="d-flex align-items-center justify-content-between">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
					<label class="form-check-label" for="lightmode">Light</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
					<label class="form-check-label" for="darkmode">Dark</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
					<label class="form-check-label" for="semidark">Semi Dark</label>
				</div>
			</div>
			<hr/>
			<div class="form-check">
				<input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
				<label class="form-check-label" for="minimaltheme">Minimal Theme</label>
			</div>
			<hr/>
			<h6 class="mb-0">Header Colors</h6>
			<hr/>
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator headercolor1" id="headercolor1"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor2" id="headercolor2"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor3" id="headercolor3"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor4" id="headercolor4"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor5" id="headercolor5"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor6" id="headercolor6"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor7" id="headercolor7"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor8" id="headercolor8"></div>
					</div>
				</div>
			</div>
			<hr/>
			<h6 class="mb-0">Sidebar Backgrounds</h6>
			<hr/>
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
	<script src="assets/plugins/validation/jquery.validate.min.js"></script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:31:08 GMT -->
</html>