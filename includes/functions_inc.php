<?php
	 function  emptyInputSignup($fn, $add, $con, $age, $gen, $un, $pwd)
	 {
	 	$result;
	 	if (empty($fn) || empty($add) || empty($con) || empty($age) || empty($gen) || empty($un) || empty($pwd)) {
	 		$result = true;
	 	}
	 	else {
	 		$result = false;
	 	}
	 	return $result;
	 }

	 function invalidUid($un)
	 {
	 	$result;
	 	if (!preg_match("/^[a-zA-Z0-9]*$/", $un)) {
	 		$result = true;
	 	}
	 	else {
	 		$result = false;
	 	}
	 	return $result;
	 }

	 function uidExists($conn, $un)
	 {
	 	$sql = "SELECT * FROM client WHERE username = ?;";
	 	$stmt = mysqli_stmt_init($conn);
	 	if (!mysqli_stmt_prepare($stmt,$sql)) {
	 		header("location: ../signup.php?error=stmtfailed");
	 		exit();
	 	}

	 	mysqli_stmt_bind_param($stmt, "s", $un);
	 	mysqli_stmt_execute($stmt);

	 	$resultData = mysqli_stmt_get_result($stmt);
	 	if ($row = mysqli_fetch_assoc($resultData)) {
	 		return $row;
	 	}
	 	else {
	 		$result = false;
	 		return $result;
	 	}
	 	mysqli_stmt_close($stmt);
	 }

	 function createUser($conn, $fn, $add, $con, $age, $gen, $un, $pwd)
	 {
	 	$sql = "INSERT INTO client (fullname, address, contact, age, gender, username, password) VALUES (?, ?, ?, ?, ?, ?, ?);";

	 	$stmt = mysqli_stmt_init($conn);
	 	if (!mysqli_stmt_prepare($stmt,$sql)) {
	 		header("location: ../signup.php?error=stmtfailed");
	 		exit();
	 	}

	 	mysqli_stmt_bind_param($stmt, "sssssss", $fn, $add, $con, $age, $gen, $un, $pwd);
	 	mysqli_stmt_execute($stmt);
	 	mysqli_stmt_close($stmt);
	 	header("location: ../signup.php?error=none");

	 	exit();
	 }

	 function createAccomodation($conn, $book_by, $book_contact, $book_address, $book_name, $book_age, $book_gender, $book_departure, $dest_id, $acc_id, $origin_id, $book_tracker)
	 {
	 	$stmt = mysqli_stmt_init($conn);
	 	if (!mysqli_stmt_prepare($stmt,$sql)) {
	 		header("location: ../accomodation.php?error=stmtfailed");
	 		exit();
	 	}

	 	mysqli_stmt_bind_param($stmt, "sssssssssss", $book_by, $book_contact, $book_address, $book_name, $book_age, $book_gender, $book_departure, $dest_id, $acc_id, $origin_id, $book_tracker);
	 	mysqli_stmt_execute($stmt);
	 	mysqli_stmt_close($stmt);
	 	header("location: ../accomodation.php?error=none");

	 	exit();
	 }

	 function  emptyInputLogin($un, $pwd)
	 {
	 	$result;
	 	if (empty($un) || empty($pwd)) {
	 		$result = true;
	 	}
	 	else {
	 		$result = false;
	 	}
	 	return $result;
	 }

	 function  emptyInputReserved($bookdep)
	 {
	 	$result;
	 	if (empty($bookdep)) {
	 		$result = true;
	 	}
	 	else {
	 		$result = false;
	 	}
	 	return $result;
	 }
	 
 ?>