<?php

//initiate the session (must be the first statement in the document)
session_start();

//linked files
require_once 'dbConnect.php';
require_once 'commonFunctions.php';
//require_once 'logInValidation.php'; //$userID, $custID

//DEBUG
$custID = '1';
$userID = '1';

$output = 'initial';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['wkf_ID'])){

    $wkfID = $_POST['wkf_ID'];

    if(verifyWfCust($wkfID, $custID, $conn)){

            
        $storageAccount = 99;
        
        $stmt = $conn->prepare("UPDATE WFL 
            SET WFL_CUS_id = ?
            WHERE WFL_id =  $wkfID");
    
        $stmt->bind_param("i", $storageAccount);
        
        if($stmt->execute()){
            
            $output = '0';
            
        } else {
            
            $output = '1';
        }
        
    } else {

        $output = '3';

    }

} else {

    $output = '2';
}

echo $output;

?>