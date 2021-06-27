<?php
if(isset($_POST['Submit'])){ 
	$emp_name=trim($_POST["emp_name"]);
	$emp_email=trim($_POST["email"]);
	$emp_ph=trim($_POST["phone"]);
	$emp_uname=trim($_POST["username"]);
	$password=trim($_POST["password"]);
	$confirm=trim($_POST["confirm"]);

	if($emp_name =="") {
	$error_empname=  "<span class='error'>Please enter your name.</span>";
	}

	elseif($emp_email == "") {
	$error_email=  "<span class='error'>Please enter your email</span>"; 
	} 

	elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $emp_email)){
	$error_email= "<span class='error'>Please enter valide email, like your@abc.com</span>";
	}

	elseif($emp_ph == ""){
	$error_ph =  "<span class='error'>Please enter phone number.</span>";
	}

	elseif(is_numeric(trim($emp_ph)) == false){
	$error_ph =  "<span class='error'>Please enter numeric value.</span>";
	}

	elseif($emp_uname == ""){
	$error_username =  "<span class='error'>Please enter uername.</span>";
	}

	elseif(strlen($emp_uname)<5){
	$error_username =  "<span class='error'>Username should be atleast five characters.</span>";
	}

	elseif($password == ""){
	$error_password=  "<span class='error'>Please enter password</span>";
	}

	elseif($confirm == ""){
	$error_confirm=  "<span class='error'>Please enter confirm password</span>";
	}

	elseif($password != $confirm) {
	$error_confirm=  "<span class='error'>Password and confirm password does not match</span>";
	}

	else{
	// Mysql insert statement
	// After successful form submission, it will be redirect to thankyou.php file.
	header("Location: thankyou.php");
	}
}
