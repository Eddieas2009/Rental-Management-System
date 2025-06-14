<?php

function getPendingPayments() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM payments WHERE status = 'Pending' ORDER BY payment_date DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$pendingpayments = getPendingPayments();
$count = count($pendingpayments);

$dstmt = $pdo->prepare("SELECT T.tenantID, T.`first_name`,T.`last_name`,U.`unitname`,P.`amount`, P.`month`,P.`year` FROM tenantproperty T JOIN units U ON T.`unitID`=U.`unitID` join `payments` P on T.`tenantID`=P.tenant_id WHERE P.`status`='pending'");
$dstmt->execute();
$defaulters = $dstmt->fetchAll(PDO::FETCH_ASSOC);


?>
<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand gap-3">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center gap-1">
							
							<li class="nav-item dark-mode d-none d-sm-flex">
								<a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
								</a>
							</li>
							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count"><?php echo $count; ?></span>
									<i class='bx bx-bell'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Notifications</p>
											
										</div>
									</a>
									<div class="header-notifications-list" style="max-height: 300px !important; overflow-y: auto;">
										<?php foreach ($defaulters as $defaulter): ?>
										<a class="dropdown-item" href="Payments.php?id=<?php echo $defaulter['tenantID']; ?>">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-primary text-primary"><i class="bx bx-group"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name"><?php echo $defaulter['first_name'] . ' ' . $defaulter['last_name']; ?>
													<span class="msg-time float-end">Amount : <?php echo number_format($defaulter['amount']); ?></span></h6>
													<p class="msg-info">For: <?php echo date("F", mktime(0, 0, 0, $defaulter['month'], 10)) . ' ' . $defaulter['year']; ?></p>
												</div>
											</div>
										</a>
										<?php endforeach; ?>
									</div>
									<a href="PendingPayments.php">
										<div class="text-center msg-footer">View All Notifications</div>
									</a>
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large" style="display: none">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">8</span>
									<i class='bx bx-comment'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title"></p>
											<p class="msg-header-clear ms-auto"></p>
										</div>
									</a>
									<div class="header-message-list">
										
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer"></div>
									</a>
								</div>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown px-3">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar">
							<div class="user-info ps-3">
								<p class="user-name mb-0"><?php echo $auth_user['username']; ?></p>
								<p class="designattion mb-0"><?php echo $auth_user['role']; ?></p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#changePasswordModal"><i class='bx bx-download'></i><span>Change Password</span></a>
							</li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item" href="settings/logout.php"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>