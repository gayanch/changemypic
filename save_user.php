<?php
/** 
 * Author: Gayan C. Karunarathna < agchamara93 [at] gmail.com >
 *
 * this saves the loged in user's details into database (user table).
 * should call with a POST request.
 * required parameters (All are mandetory)
 *		id:		facebook id of the user
 *		name: 	fullname of the user
 *		email:	email address of the user
 */
 
 require_once 'db.php';
 
 if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email'])) {
 	$db = new Db();
 	$con = $db->get_connection();
 	
 	$stmt = $con->prepare("INSERT INTO user VALUES(?, ?, ?)");
 	$stmt->bind_param('sss', $_POST['id'], $_POST['name'], $_POST['email']);
 	
 	if ($stmt->execute()) {
 		echo "Success";
 	} else {
 		echo "Error";
 	}
 	
 	$con->close();
 } else {
 	echo 'One or more required parameters are missing.';
 }
?>
