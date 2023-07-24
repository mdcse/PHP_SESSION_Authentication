<?php

session_start();
if ($_GET['action'] == "logout") {
	unset($_SESSION);
	session_destroy();
} 
$hostserver = 'localhost';
$user = 'root';
$password = 'root';
$db = 'danishtest';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$useremail = $rollno = '';
	$useremail = $_POST['email'];
	$rollno = $_POST['rollno'];

	if (empty($useremail)) {
		$emailErr = "Email is required";
	}
	if (empty($rollno)) {
		$rollnoErr = "Rollno is required";
	}

	if (!($emailErr || $rollnoErr)) {
		$conobj = new mysqli($hostserver, $user, $password, $db);
		if ($conobj->connect_error) {
			echo "Db not connected " . $conobj->connect_error;
		}

		$sql = "SELECT * FROM task2 WHERE email = '$useremail' and rollno = '$rollno'";
		$obj = $conobj->query($sql);
		$userobj = $obj->fetch_object();

		if ($userobj) {
			session_start();
			$_SESSION['email'] = $userobj->email;
			header("location: http://localhost/danish/Design/list.php");
		} else {
			echo "wrong credential";
		}
	}
}

?>


<!DOCTYPE html>

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>CRUD</title>
	<link href="style.css" rel="stylesheet">
	<style>
		.errormessage {
			color: red;
		}
	</style>
</head>

<body>
	<div class="hotel-listing">
		<div class="regi-main">
			<div id="wrapper2">
				<div class="my-account">
					<div class="myaccount-outer ">
						<div class="account-right-div">
							<div class="dashboard-heading">
								<h2>Login</h2>
							</div>
							<div class="dashboard-inner">
								<div class="main-dash-summry Edit-profile edit-dealer-prof dealer-edit">
									<form action="login.php" method="post" name="admin_form" id="admin_form" novalidate="novalidate">

										<div class="left-column">
											<div class="input-row">
												<div class="full">
													<div class="input-block">
														<label>Email Id: <span class="star">*</span></label>
														<span class="reg_span">
															<input type="text" name="email" value="<?php echo $email ?>" id="email" class="inputbox-main">
															<span class="errormessage"><?php echo $emailErr ?></span>
														</span>
													</div>
												</div>
											</div>
											<div class="input-row">
												<div class="full">
													<div class="input-block">
														<label>rollno: <span class="star">*</span></label>
														<span class="reg_span">
															<input type="text" name="rollno" value="<?php echo $rollno ?>" id="rollno" class="inputbox-main">
															<span class="errormessage"><?php echo $rollnoErr ?></span>
														</span>
													</div>
												</div>
											</div>
										</div>
										<!-- Hidden Inputs -->
										<input type="hidden" name="hiddenemail" value="<?php echo $hiddenemail ?>">
										<input type="hidden" name="hiddenid" value="<?php echo $hiddenid ?>">

										<div class="submit-class">
											<div class="full">
												<input type="submit" value="Login" class="btn-submit btn">

											</div>
										</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</body>

</html>