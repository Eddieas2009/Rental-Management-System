<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">RMS</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<?php if($auth_user['role'] != 'tenant'){ ?>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-home'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
					<ul>
						<li> <a href="Dashboard.php"><i class="bx bx-right-arrow-alt"></i>Dasboard</a>
						</li>
					</ul>
				</li>
				<?php } ?>
				<?php if($auth_user['role'] != 'tenant'){ ?>
				<li>
					<a href="users.php">
						<div class="parent-icon"><i class='bx bx-user-pin' ></i>
						</div>
						<div class="menu-title">Users</div>
					</a>
				</li>
				<?php } ?>
				<?php if($auth_user['role'] != 'tenant'){ ?>
				<li>
					<a href="properties.php">
						<div class="parent-icon"><i class='bx bx-buildings'></i>
						</div>
						<div class="menu-title">Properties</div>
					</a>
				</li>
				<?php } ?>
				<?php if($auth_user['role'] != 'tenant'){ ?>
				<li>
					<a href="Tenants.php">
						<div class="parent-icon"><i class='bx bxs-group'></i>
						</div>
						<div class="menu-title">Tenants</div>
					</a>
				</li>
				<li>
					<a href="Condominiums.php">
						<div class="parent-icon"><i class='bx bx-buildings'></i>
						</div>
						<div class="menu-title">Condominiums</div>
					</a>
				</li>
				<?php } ?>
				
				<!-- <li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx  bx-wrench'></i>   
						</div>
						<div class="menu-title">Maintenance</div>
					</a>
					<ul>
					<?php echo ''; // if($auth_user['role'] != 'tenant'){ ?>
						<li> <a href="Categories.php"><i class="bx bx-right-arrow-alt"></i>Categories</a>
						</li>
						<li> <a href="SubCategories.php"><i class="bx bx-right-arrow-alt"></i>SubCategories</a>
						</li>
						<?php echo ''; // } ?>
						<li> <a href="Requests.php"><i class="bx bx-right-arrow-alt"></i>PendingRequests</a>
						</li>
						<li> <a href="Completed.php"><i class="bx bx-right-arrow-alt"></i>Completed</a>
						</li>
					</ul>
				</li> -->

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx  bx-wallet-alt'></i>   
						</div>
						<div class="menu-title">Expenses</div>
					</a>
					<ul>
						<li> <a href="Excategory.php"><i class="bx bx-right-arrow-alt"></i>Categories</a>
						</li>
						</li><li> <a href="Expenses.php"><i class="bx bx-right-arrow-alt"></i>Expenses</a>
						</li>
					</ul>
				</li>
				
				<?php if($auth_user['role'] != 'tenant'){ ?>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-clipboard' ></i>
						</div>
						<div class="menu-title">Reports</div>
					</a>
					<ul>
						<li> <a href="PendingPayments.php"><i class="bx bx-right-arrow-alt"></i>Pending Payments</a>
						</li>
						<li> <a href="MonthlyPayments.php"><i class="bx bx-right-arrow-alt"></i>Monthly Payments</a>
						</li>
						<li> <a href="Tenantsreport.php"><i class="bx bx-right-arrow-alt"></i>Tenats</a>
						</li>
						<li> <a href="Expensesreport.php"><i class="bx bx-right-arrow-alt"></i>Expenses</a>
						</li>
						<li> <a href="Condominiumsreport.php"><i class="bx bx-right-arrow-alt"></i>Condominiums</a>
						</li>
					</ul>
				</li>
				<?php } ?>

			</ul>
			<!--end navigation-->
		</div>