<?php
//initiate the session (must be the first statement in the document)
session_start();

//linked files
require_once 'fp/dbConnect.php';
require_once 'fp/stringFunctions.php';
require_once 'fp/logInValidation.php'; //$userID, $custID
require_once 'fp/header.php';

$useCSS = 'home.css';

//build list of active workflows
$conn = mysqli_connect($db_server, $db_username, $db_password, $db_database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT WKF_id, WKF_number, WKF_item, WKF_desc, WKF_status
        FROM WKF
        WHERE WKF_CUS_id = '$custID' AND WKF_status = 'Active'";
        
$result = mysqli_query($conn,$sql);

$activeWorkflows = "<table id='activeTable' class='table1'>
            <thead>
                <tr>
                    <th class='titleRow' colspan='4'>Active Workflows</th>
                </tr>
                <tr>
                    <th>Number</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>";

if($result->num_rows != 0){

    while($row = $result->fetch_assoc()){

        $activeWorkflows .= "<tr onclick='gotoWorkflow(this)' id='" . $row['WKF_id'] . "'>
            <td>" . $row['WKF_number'] . "</td>
            <td>" . $row['WKF_item'] . "</td>
            <td>" . $row['WKF_desc'] . "</td>
            <td>" . $row['WKF_status'] . "</td></tr>";
    }

}

$activeWorkflows .= "</table>";


echo <<<_FixedHTML

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/$useCSS">
    <link rel="stylesheet" type="text/css" href="../css/default.css">
    <title>Work Flow Lab</title>
    <script>
        function gotoWorkflow(row){

            var html = 'workFlow.php?wkf_id=' + row.id;
            window.location.replace(html);
            
        }
    </script>
</head>
<body>  
    $header
    <div class="content">
        <div class='leftDiv holderDiv divSize1'>
            $activeWorkflows
            <div class='bottomButtons'>
                <input type="button" onclick="location.href='createWorkflow.php';" value="New Workflow" class="button1" />
                <input type="button" onclick="location.href='workFlowControl.php';" value="Control Center" class="button1"/>
            </div>
        </div>
        <div class='rightDiv holderDiv divSize1'>
            Other stuff
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>

_FixedHTML;


?>