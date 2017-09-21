<?php

//initiate the session (must be the first statement in the document)
session_start();

//linked files
require_once 'dbConnect.php';
//require_once 'logInValidation.php'; //$userID, $custID

//DEBUG
$custID = '1';


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['wfl_id'])){

    $wfID = $_POST['wfl_id'];

    //Query Workflow

    $sql = "SELECT WFL_id, WFL_item, WFL_num, WFL_desc, WFL_status, WFL_ref, WFL_group
            FROM WFL
            WHERE WFL_CUS_id = '$custID' AND WFL_id = '$wfID'";
        
    $result = mysqli_query($conn,$sql);

    if($result){

        if($result->num_rows != 0){

            while($row = $result->fetch_assoc()){

                $wfNumber = $row['WFL_num'];
                $wfItem =  $row['WFL_item'];
                $wfDesc = $row['WFL_desc'];
                $wfSta = $row['WFL_status'];
                $wfRef = $row['WFL_ref'];
                $wfGrp = $row['WFL_group'];
            

                $wfStaC = "";
                $wfStaA = "";
                $wfStaP = "";
                $wfStaX = "";

                switch ($wfSta){
                    case "Complete":
                    $wfStaC = "selected ='selected'";
                    break;
                    case "Active":
                    $wfStaA = "selected ='selected'";
                    break;
                    case "Pending":
                    $wfStaP = "selected ='selected'";
                    break;
                    case "Cancelled":
                    $wfStaX = "selected ='selected'";
                    break;

                }

                $statusSelect = "<select id='wfSta' class='textTableInput' onchange='statusChange(this)'>
                                    <option value='Active' $wfStaA>Active</option>
                                    <option value='Complete' $wfStaC>Complete</option>
                                    <option value='Pending' $wfStaP>Pending</option>
                                    <option value='Cancelled' $wfStaX>Cancelled</option>                
                                </select>
                                <input type='hidden' id='staStore' value='$wfSta'>";

                //Workflow header
                $workFlowHeader = "
                                    <div id='wfContainer' class='container'>
                                        <div class='titleDiv'>WORKFLOW INFO</div>
                                        <div class='labelDiv'>Number</div>
                                        <div class='dataInputDiv'>
                                            <input id='wfNum' value='$wfNumber' class='textTableInput'></div>
                                        <div class='labelDiv'>Item</div>
                                        <div class='dataInputDiv'>
                                            <input id='wfItem' value='$wfItem' class='textTableInput'></div>
                                        <div class='labelDiv'>Description</div>
                                        <div class='dataInputDiv'>
                                            <input id='wfDesc' value='$wfDesc' class='textTableInput'></div>
                                        <div class='labelDiv'>Reference</div>
                                        <div class='dataInputDiv'>
                                            <input id='wfRef' value='$wfRef' class='textTableInput'></div>   
                                        <div class='labelDiv'>Group</div>
                                        <div class='dataInputDiv'>
                                            <input id='wfGrp' value='$wfGrp' class='textTableInput'></div>      
                                        <div class='labelDiv'>Status</div>
                                        <div class='dataDiv'>$statusSelect</div>
                                        <div id='headerEditButtons' class='headerItems'>
                                            <input type='button' class='button1' onclick='saveWfHeader($wfID)' value='Save'>
                                            <input type='button' class='button1' onclick='undoWfHeader($wfID)' value='Undo'>
                                        </div>
                                            <input type='button' class='button1' onclick='resetWf($wfID)' value='Reset'>
                                    </div>
                                    ";

            }
        }
    } else { $workFlowHeader = "Bad query"; }


        echo $workFlowHeader;

}

?>