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

    //All the steps
    $sql = "SELECT STP_id, STP_title, STP_desc, STP_order, STP_status, STP_note, STP_detail, STP_USR_id, STP_date
            FROM STP
            WHERE STP_WFL_id = '$activeWkf'
            ORDER By STP_order";
            
    $result = mysqli_query($conn,$sql);

    if($result){
    
        $steps = "";

        if($result->num_rows != 0){

            while($row = $result->fetch_assoc()){

                $thisStatus = $row['STP_status'];

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
                    break;
                }

                $stpID = $row['STP_id'] . 'x';
                $stpTitle = $row['STP_title'];
                $stpDesc = $row['STP_desc'];
                $stpDetails = $row['STP_detail'];
                $stpOrder = $row['STP_order'];
                $stpUsr = $row['STP_USR_id'];
                $stpDate = $row['STP_date'];
                $stpNotes = $row['STP_note'];

                $steps .= "<div class='s_panel' id='$stpID'>
                    <div class='stepHeader $class' $markOpen>
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
                    $sqlUsr = "SELECT USR_name
                    FROM USR
                    WHERE USR_id = '$stpUsr'";
                    
                    $resultUsr = mysqli_query($conn,$sqlUsr);

                    if($resultUsr){

                        if($resultUsr->num_rows != 0){

                            while($row = $resultUsr->fetch_assoc()){

                                $stpName = $row['USR_name'];
                            }
                        }
                    }

                    $steps .= " <div class='detLabel'>Notes</div>
                                <div class='detData minHeight'>$stpNotes</div>
                                <div class='detLabel'>Completed By:</div>
                                <div class='detData'>$stpName on  $stpDate</div>
                                <button class='button1'>Re-Set</button>
                                ";

                } else if ($thisStatus == "Open"){
                    $steps .= " <div class='detLabel'>Notes</div>
                                <div class='detData minHeight'>
                                    $stpNotes
                                </div>";
                }

                $steps .= "<button class='button1'>Edit</button></div></div>";

            }
        }
    } else { $steps = "Bad query"; }

} else { $steps = "Post not set"; }

echo $steps;

?>