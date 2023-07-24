<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
if ($_SESSION['email'] == "") {
	header("location: http://localhost/danish/Design/login.php");
}
// echo '<pre>';
// print_r($_SESSION);

$hostserver = 'localhost';
$user = 'root';
$password = 'root';
$db = 'danishtest';
$nameErr = $emailErr = $rollnoErr = $branchErr = '';

// Edit student data
if ($_GET['id']) {
	$conobj = new mysqli($hostserver, $user, $password, $db);

	if ($conobj->connect_error) {
		echo "Db not connnected " . $conobj->connect_error;
	}
	$curr_id = $_GET['id'];
	$sql = "SELECT * FROM task2 WHERE id = $curr_id";
	$curr_obj = $conobj->query($sql);

	$row = $curr_obj->fetch_object();

	$name = $row->name;
	$email = $row->email;
	$rollno = $row->rollno;
	$branch = $row->branch;

	$hiddenemail = $email;
	$hiddenid = $curr_id;
}

// Add Sudent data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = $email = $rollno = $branch = $hiddenemail = $hiddenid = '';
	$name = $_POST['name'];
	$email = $_POST['email'];
	$rollno = $_POST['rollno'];
	$branch = $_POST['branch'];
	$hiddenemail = $_POST['hiddenemail'];
	$hiddenid = $_POST['hiddenid'];

	if (empty($name)) {
		$nameErr = "Name is required";
	}
	if (empty($email)) {
		$emailErr = "Email is required";
	}
	if (empty($rollno)) {
		$rollnoErr = "Rollno is required";
	}
	if (empty($branch)) {
		$branchErr = "Branch is required";
	}

	if (!($nameErr || $emailErr || $rollnoErr || $branchErr)) {
		$conobj = new mysqli($hostserver, $user, $password, $db);
		if ($conobj->connect_error) {
			echo "DB Not Connected! <br>" . $conobj->connect_error;
		}

		$insert = "INSERT INTO task2 (name, rollno, email, branch) VALUES ('$name', '$rollno', '$email', '$branch')";
		$update = "UPDATE task2  SET name = '$name', email = '$email', rollno = '$rollno', branch = '$branch' WHERE id = $hiddenid";
		$sql = "SELECT email FROM task2 WHERE email = '$email'";
		$obj = $conobj->query($sql);

		if ($hiddenemail == $email) {
			if ($conobj->query($update)) {
				echo "data updated <br>";
			} else {
				echo "Data is not Updated ";
			}
		} else if (isset($obj->fetch_object()->email)) {
			$emailErr = "email already exist";
		} else {
			if ($hiddenemail) {
				if ($conobj->query($update)) {
					echo "data updated <br>";
				} else {
					echo "Data is not updated ";
				}
			} else {
				if ($conobj->query($insert)) {
					echo "data added <br>";
				} else {
					echo "Data is not added ";
				}
			}
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
								<h2>Add Student</h2>
							</div>
							<div>
							<div class="user-btn-div plus">
									<a title="Add blog" href="login.php?action=logout"></i>Log out</a>
								</div>
								<div class="user-btn-div plus">
									<a title="Add blog" href="list.php"></i>Back to listing</a>
								</div>
							</div>
							<div class="dashboard-inner">
								<div class="main-dash-summry Edit-profile edit-dealer-prof dealer-edit">
									<form action="add.php" method="post" name="admin_form" id="admin_form" novalidate="novalidate">
										<div class="left-column">
											<div class="input-row">
												<div class="full">
													<div class="input-block">
														<label>Name: <span class="star">*</span></label>
														<span class="reg_span">
															<input type="text" name="name" value="<?php echo $name ?>" id="name" class="inputbox-main">
															<span class="errormessage"><?php echo $nameErr ?></span>
														</span>
													</div>
												</div>
											</div>
											<div class="input-row ">
												<div class="full">
													<div class="input-block">
														<label>Branch: <span class="star">*</span></label>
														<span class="reg_span">
															<input type="text" name="branch" value="<?php echo $branch ?>" id="branch" class="inputbox-main">
															<span class="errormessage"><?php echo $branchErr ?></span>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="right-column">
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
												<input type="submit" value="Add" class="btn-submit btn">
												<input type="button" value="Cancel" onclick="javascript:history.go(-1);" class="btn-submit btn">
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