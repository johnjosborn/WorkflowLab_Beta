<?php

//initiate the session (must be the first statement in the document)
session_start();

//linked files
require_once 'dbConnect.php';
//require_once 'logInValidation.php'; //$userID, $custID

//DEBUG
$custID = '1';

//default declaration values
$foundOpen = false;
$workflowProgress = 0;
$compSteps = 0;
$totalSteps = 0;

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['wf_id'])){

    $wfID = $_POST['wf_id'];
    //Query Workflow

    $sql = "SELECT WFL_item, WFL_num, WFL_desc, WFL_status, WFL_notes, WFL_ref, WFL_group
            FROM WFL
            WHERE WFL_CUS_id = '$custID' AND WFL_id = '$wfID'";
    
    $result = mysqli_query($conn,$sql);

    if($result){

        if($result->num_rows != 0){

            while($row = $result->fetch_assoc()){

                $wfNum = $row['WFL_num'];
                $wfItem = $row['WFL_item'];
                $wfDesc = $row['WFL_desc'];
                $wfStatus = $row['WFL_status'];
                $wfNotes = $row['WFL_notes'];
                $wfRef = $row['WFL_ref'];
                $wfGroup = $row['WFL_group'];

                //Workflow header
                $workFlowHeader = "
                <div id='workflowHeader'>
                    <div class='labelDiv'>Item</div>
                    <div class='dataDiv'>$wfItem</div>
                    <div class='labelDiv'>Description</div>
                    <div class='dataDiv'>$wfDesc</div>
                    <div class='labelDiv'>Group</div>
                    <div class='dataDiv'>$wfGroup</div>
                    <div class='labelDiv'>Referece</div>
                    <div class='dataDiv'>$wfRef</div>
                    <div class='labelDiv'>Notes</div>
                    <div class='dataDiv'>$wfRef</div>
                </div>";
            }
        }

    } else { $workFlowHeader = "Bad query header"; }

} else { $workFlowHeader = "Post not set"; }

$output = $workFlowHeader;

$output = "<div id='activeItem' class='accd_header_active' onclick='hActive()'>
                Workflow $wfNum 
            </div>
            <div id='activeContent' class='accd_content' hidden>
                $workFlowHeader
            </div>";

echo $output;

?>