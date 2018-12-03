<?php
	require_once('../libs/db.php');
	
	$visitorName = $_POST['name'];
	$visitorEmail = $_POST['email'];
	
	$returnedData = array('success' => '', 'error' => array());
	
	function visitorExists($email) {
		$querysql = "SELECT COUNT(*) FROM uc_subscription WHERE email = " . $email;
		
		//$GLOBALS['returnedData']['error'] = array('visitorExists' => 'Email, ' . $email .'already exists');
		return $GLOBALS['returnedData']['error'];
	}
	
	function validateData($name, $email) {
		
		if (empty($name) || !preg_match('/^[a-z ]+$/i' , $name)) {
			$GLOBALS['returnedData']['error'] = array('name' => 'Name is required and must be letters and spaces only');
		}
		
		if (empty($email) || !preg_match('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/' , $email)) {
			$GLOBALS['returnedData']['error'] = $GLOBALS['returnedData']['error'] + array('email' => 'Email is required and must be ex@abc.xyz');
		}
		
		return $GLOBALS['returnedData']['error'];
	}
	
	function submitData(&$name, &$email) {
		if (!empty(validateData($name, $email))) {
			echo json_encode(($GLOBALS['returnedData']));
			return false;
		}
		
		if (!empty(visitorExists($email))) {
			echo json_encode(($GLOBALS['returnedData']));
			return false;
		}
		
		$GLOBALS['returnedData']['success'] = true;
		echo json_encode($GLOBALS['returnedData']);
	}
	
	submitData($visitorName, $visitorEmail);
?>