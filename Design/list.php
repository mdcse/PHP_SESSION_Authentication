<?php
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
$curr_id = $_GET['id'];
$search = $_GET['search'];

if ($curr_id) {
	$conobj = new mysqli($hostserver, $user, $password, $db);
	if ($conobj->connect_error) {
		echo "Db not connected " . $conobj->connect_error;
	}
	$delete = "DELETE FROM task2 WHERE id = '$curr_id'";
	if ($conobj->query($delete)) {
		echo "Data deleted";
	} else {
		echo "Data not deleted";
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	$conobj = new mysqli($hostserver, $user, $password, $db);
	if ($conobj->connect_error) {
		echo "Db not connected: " . $conobj->connect_error;
	}

	$sql = "SELECT * FROM task2";
	$obj = $conobj->query($sql);
	$result = $obj->fetch_all();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$conobj = new mysqli($hostserver, $user, $password, $db);

	if ($conobj->connect_error) {
		echo "Db not connected: " . $conobj->connect_error;
	}

	$search = $_POST['search'];
	// query to filter the record
	$sql = "SELECT * FROM task2 WHERE name = '$search' or email = '$search' or rollno = '$search' or branch = '$search'";

	//if search key is empty
	if ($search == "") {
		$sql = "SELECT * FROM task2";
	}
	$obj = $conobj->query($sql);
	$result = $obj->fetch_all();
}
?>

<!DOCTYPE html>

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>CRUD</title>
	<link href="style.css" rel="stylesheet">
</head>

<body>
	<div class="hotel-listing">
		<div class="block-used1"> <span>
				<div class="account-right-div">
					<div class="dashboard-heading">
						<h2>Manage Blogs</h2>
					</div>
					<div class="dashboard-inner">
						<div class="dash-search">
							<form action="list.php" method="POST" id="frmSearchUser" name="frmSearchUser">
								<input type="text" placeholder="Keyword" class="list-search" id="searchUserEmail" name="search" value="<?php $search ?>">
								<input type="submit" name="serch_btn" id="serch_btn" value="Search" class="add-user search-icon crome-left">
								<span class="reg_span">
									<div class="user-btn-div plus">
										<a title="Add blog" href="login.php?action=logout"></i>Log out</a>
									</div>
									<div class="user-btn-div plus">
										<a title="Add blog" href="add.php"></i>Add New Record</a>
									</div>

								</span>
							</form>
						</div>
						<div class="total_rec">
							<div class="block-used1"> <span>Total Records: </span><?php echo $obj->num_rows ?></div>
						</div>
						<div class="main-dash-summry Edit-profile nopadding11">
							<!--table-->
							<div class="my_table_div">
								<table class="fixes_layout">
									<thead>
										<tr>
											<th class="forWidthSno" width="10%">
												<h1 class="">Id.</h1>
											</th>
											<th width="20%">
												<a class="underline_classs" href="">
													<h1 class="sort">Name</h1>
												</a>
											</th>
											<th width="20%">
												<a class="underline_classs" href="">
													<h1 class="sort">Email</h1>
												</a>
											</th>
											<th width="15%">
												<a class="underline_classs" href="">
													<h1 class="sort">Roll No</h1>
												</a>
											</th>
											a
											<th width="15%">
												<a class="underline_classs" href="">
													<h1 class="sort">Branch</h1>
												</a>
											</th>
											<th width="20%">
												<a class="underline_classs" href="">
													<h1 class="sort">Actions</h1>
												</a>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i = 0; $i < $obj->num_rows; $i++) { ?>

											<tr>
												<td><?php echo $result[$i][0] ?></td>
												<td><?php echo $result[$i][1] ?></td>
												<td><?php echo $result[$i][3] ?></td>
												<td><?php echo $result[$i][2] ?></td>
												<td><?php echo $result[$i][4] ?></td>
												<td class="action-main-block">
													<a class="edit" href="add.php?id=<?php echo $result[$i][0] ?>" title="Edit Blog">&nbsp;
													</a>
													<a class="del del-dealer" href="list.php?id=<?php echo $result[$i][0] ?>" data-id="<?php echo $result[$i][0] ?>" title="Delete Blog">&nbsp;
													</a>
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
	</div>
	</div>
	</div>
</body>

</html>