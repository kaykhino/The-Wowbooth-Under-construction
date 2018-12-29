<?php
	include_once '../libs/db.php';
	
	$visitorName = $_POST['name'];
	$visitorEmail = $_POST['email'];
	
	$returnedData = array('success' => '', 'error' => array());
	
	function visitorExists($email) {
	    $conn = &$GLOBALS['conn'];
	    $querysql = "SELECT email FROM uc_subscription WHERE email = '" . $email . "'";
    	
    	$query = $conn->query($querysql);
		
    	if (!$query) {
   	        die('Could not query:' . $conn->error);
    	}
    			
    	if ($query->num_rows >= 1) {
    	    $GLOBALS['returnedData']['error'] = array('visitorExists' => 'Email, ' . $email .' already exists');
    	    
    	    $conn->close();
    	    
    	    return $GLOBALS['returnedData']['error'];
    	}
    	
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
		
		$conn = &$GLOBALS['conn'];
		$insertsql = "INSERT into uc_subscription(name, email, phonenum, regdate, canceldate, cancelreason, cancelcomment) values('$name', '$email', '', '" . date("Y-m-d") . "', NULL, NULL, NULL)";
		
		if (!$insert = $conn->query($insertsql)) {
		    $GLOBALS['returnedData']['error'] = $GLOBALS['returnedData']['error'] + array('insertfailed' => $conn->error);
		    echo json_encode(($GLOBALS['returnedData']));
		    return false;
		}
		
		$GLOBALS['returnedData']['success'] = true;
		echo json_encode($GLOBALS['returnedData']);
		
		$conn->close();
	}
	
	submitData($visitorName, $visitorEmail);
?>