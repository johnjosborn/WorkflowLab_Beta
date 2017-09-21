<?php

//initiate the session (must be the first statement in the document)
session_start();

//linked files
require_once 'dbConnect.php';
//require_once 'logInValidation.php'; //$userID, $custID

//DEBUG
$custID = '1';

//default declaration values

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['wfl_id'])){

    $activeWkf = $_POST['wfl_id'];

    //All the available steps
    $sql = "SELECT OPS_id, OPS_title, OPS_desc
    FROM OPS
    WHERE OPS_CUS_id = '$custID' OR OPS_CUS_id = '99'
    ORDER By OPS_type, OPS_title";

    $result = mysqli_query($conn,$sql);

    if($result){

        $ops = "<div class='opsHeader toggleDiv'>Available Steps</div>
                <div id='opsContainer' class='opsContainer'>
                <div class='opsSubheader'>Click & Drag to Workflow to Add --></div>
                <div id='sourceOps' class='connectedSortable'>";

        if($result->num_rows != 0){

        while($row = $result->fetch_assoc()){

            $newID =  $row['OPS_id'] . 'n';
            $newTitle = $row['OPS_title'];
            $newDesc = $row['OPS_desc'];

            $ops .= "<div class='s_panel availOp' id='opNum=$newID'>
                        <div class=''>
                            <div class='orderBox'></div>
                            <div class='titleBox'>$newTitle | $newDesc</div>
                        </div>
                    </div>";
        }
    }

    $ops .= "</div></div>";
    } else {
    $ops = "Bad query for available ops.";
    }

}

//Query Workflow
$sql = "SELECT WFL_id, WFL_item, WFL_num, WFL_desc, WFL_status, WFL_ref, WFL_group
FROM WFL
WHERE WFL_CUS_id = '$custID' AND WFL_id = '$activeWkf'";
    
$result = mysqli_query($conn,$sql);

if($result){

    if($result->num_rows != 0){

        while($row = $result->fetch_assoc()){

            $wfNumber = $row['WFL_num'];
            $wfItem = $row['WFL_item'];
            $wfDesc = $row['WFL_desc']; 
            $wfStatus = $row['WFL_status']; 

        }
    }
} 

$output = "<div class='contentTitle'>
                Modify Workflow $wfNumber
            </div>
            <div class='contentHolder'>
                <div id='workflowHeader' class='leftDiv'>
                    <div id='ops'>$ops</div>
                </div>
                <div id='accordionHolder'class='rightDiv scrollable'>
                    <div id='stepAccordian' class='connectedSortable'>
                    steps
                    </div>
                </div>
            </div>
            ";


echo $output;

?>