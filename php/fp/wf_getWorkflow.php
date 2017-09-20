<?php

//initiate the session (must be the first statement in the document)
session_start();

//linked files
require_once 'dbConnect.php';
require_once 'logInValidation.php'; //$userID, $custID

//default declaration values
$stepDetail = "";
$foundOpen = false;
$workflowProgress = 0;
$compSteps = 0;
$totalSteps = 0;


$conn = mysqli_connect($db_server, $db_username, $db_password, $db_database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['wkf_id'])){

    $activeWkf = $_POST['wkf_id'];

    //All the steps
    $sql = "SELECT STP_id, STP_title, STP_desc, STP_order, STP_status, STP_notes, STP_details, STP_sign, STP_date
            FROM STP
            WHERE STP_WKF_id = '$activeWkf'
            ORDER By STP_order";
            
    $result = mysqli_query($conn,$sql);

    if($result){
    
        $steps = "<div id='accordionHolder'class='rightDiv'>
                    <div class='containHeader'>Workflow Steps</div>
                    <div id='accordianScroll' class='container scrollable'>
                    <div id='stepAccordian' class=''>";

        if($result->num_rows != 0){

            while($row = $result->fetch_assoc()){

                $thisStatus = $row['STP_status'];

                $totalSteps++;

                $markOpen = "";

                switch($thisStatus){

                    case "Open":
                        $class = "stepOpen";
                        $markOpen = "id='openStep'";
                    break;

                    case "Pending":
                        $class = "stepPending";
                    break;

                    case "Complete":
                        $class = "stepComplete";
                        $compSteps++;
                    break;
                }

                $stpTitle = $row['STP_title'];
                $stpDesc = $row['STP_desc'];
                $stpDetails = $row['STP_details'];
                $stpOrder = $row['STP_order'];
                $stpUsr = $row['STP_sign'];
                $stpDate = $row['STP_date'];
                $stpNotes = $row['STP_notes'];

                $steps .= "<div class='stepHeader $class' $markOpen>
                                <div class='orderBox'>$stpOrder</div>
                                <div class='titleBox'>$stpTitle</div>
                            </div>
                            <div class='stepDetail'>
                                <div class='detLabel'>Description</div>
                                <div class='detData minHeight'>$stpDesc</div>
                                <div class='detLabel'>Details</div>
                                <div class='detData minHeight'>$stpDetails</div>";

                if ($thisStatus == "Complete"){

                    //get user name from id
                     //All the steps
                    $sqlUsr = "SELECT USR_name
                    FROM USR
                    WHERE USR_id = '$stpUsr'";
                    
                    $resultUsr = mysqli_query($conn,$sqlUsr);

                    if($resultUsr){

                        if($resultUsr->num_rows != 0){

                            while($row = $resultUsr->fetch_assoc()){

                                $stpName = $row['USR_name'];
                            }
                        } else {
                            $stpName = "Unknown User";
                        }
                    }

                    $steps .= " <div class='detLabel'>Notes</div>
                                <div class='detData minHeight'>$stpNotes</div>
                                <div class='detLabel'>Completed By:</div>
                                <div class='detData'>$stpName on  $stpDate</div>
                                ";

                } else if ($thisStatus == "Open"){
                    $steps .= " <div class='detLabel'>Notes</div>
                                <div class='detData'>
                                    <textarea id='" . $row['STP_id'] . "note' rows='3'>$stpNotes</textarea>
                                </div>
                                <div>
                                <input type='button' onclick='completeStep(\"" . $row['STP_id'] . "\")' value='Complete Step' class='button1'/>
                                </div>";
                }

                    $steps .= "</div>";

            }

        }

        $steps .= "</div></div>";

    } else { $steps = "Bad query"; }

    //Query Workflow

    $sql = "SELECT WKF_id, WKF_item, WKF_number, WKF_desc, WKF_status
    FROM WKF
    WHERE WKF_CUS_id = '$custID' AND WKF_id = '$activeWkf'";
    
$result = mysqli_query($conn,$sql);

if($result){

if($result->num_rows != 0){

    while($row = $result->fetch_assoc()){

        //Workflow header
        $workFlowHeader = "<div id='workflowHeader' class='leftDiv'>
                                <div id= 'wfHeader' class='containHeader toggleDiv'>Workflow Details</div>
                                <div id='wfContainer' class='container'>
                                    <div id='progress'>
                                        <div class='progressText'>$compSteps of $totalSteps steps complete.</div>
                                    </div>
                                    <div class='labelDiv'>Item</div>
                                    <div class='dataDiv'>" . $row['WKF_item'] . "</div>
                                    <div class='labelDiv'>Description</div>
                                    <div class='dataDiv'>" . $row['WKF_desc'] . "</div>    
                                    <div class='labelDiv'>Status</div>
                                    <div class='dataDiv'>" . $row['WKF_status'] . "</div>
                                </div>
                        </div>";

            $workFlowNumber = $row['WKF_number'];
    }
}
} else { $workFlowHeader = "Bad query"; }

} else { $workFlowHeader = "Post not set"; }

echo $workFlowHeader;
echo $steps;
echo $stepDetail;



    

?>