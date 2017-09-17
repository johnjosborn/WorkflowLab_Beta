<?php

//initiate the session (must be the first statement in the document)
session_start();

$pageTitle = 'Workflow Control Center';

//DEBUG
$custID = '1';

//linked files
require_once 'fp/dbConnect.php';
//require_once 'fp/logInValidation.php'; //$userID, $custID

//get list of items for select box
$itemSelect = "<div class='inputControl'><select class='inputField' id='wfByItem'><option disabled selected>Select Item</option>";

$sql = "SELECT DISTINCT WKF_item
        FROM WKF
        WHERE WKF_CUS_id = '$custID'";

$result = mysqli_query($conn,$sql);

if($result){
    
    if($result->num_rows != 0){

        while($row = $result->fetch_assoc()){

            $item = $row['WKF_item'];

            $itemSelect .= "<option value ='$item'>$item</option>";
        }

    }
}

$itemSelect .= "</select></div>";

$ctrlWf = "<div class='listLabel'>WORKFLOWS BY STATUS</div>
            <div id='radio-1' onclick='getWorkflowList('Active')' class='selectRadio'>Active</div>
            <div id='radio-2' onclick='getWorkflowList('Complete')' class='selectRadio'>Completed</div>
            <div id='radio-7' onclick='getWorkflowList('Pending')' class='selectRadio'>Pending</div>
            <div id='radio-3' onclick='getWorkflowList('%')' class='selectRadio'>All</div>
            <hr>
            <div id='radio-4' onclick='getWorkflowList('Template')' class='selectRadio'>Templates</div>
            <hr>
            <div id='radio-5' onclick='itemClick()' class='selectRadio'>View by Item</div>
                $itemSelect
            <hr>
            <div id='radio-6' class='selectRadio'>Text Search</div>
            <div class='inputControl'>
                <input type='text' id='stringSearchTerm' class='inputField2'>
                <button onclick='getWorkflowListString()' class='button1'>Search</button>
            </div>";


$controls = "
            <div id='controlAccordian'>
                <div class='accd_header'>
                    Home
                </div>
                <div id='accordianContentNull'>
                </div>
                <div class='accd_header accd_header_selected'>
                    Workflows
                </div>
                <div class='accordianContent'>
                    $ctrlWf
                </div>
                <div class='accd_header'>
                    Items
                </div>
                <div class='accordianContent'>
                </div>
                <div class='accd_header'>
                    Steps
                </div>
                <div class='accordianContent'>
                </div>
                <div class='accd_header'>
                    Users
                </div>
                <div class='accordianContent'>
                </div>
            </div>";

            // <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            // <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

            
echo <<<_FixedHTML

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/workflowLab.css">

    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui.min.css">
    
    <title>Work Flow Lab</title>
    
    <script>

    </script>
</head>
<body> 
    <div id='container'>
    <div id='controls'>
        <div id='controlHide' class='point'><img src='../media/hide.png'></div>
        <div id='wfTitle'><img src='../media/logo6.png' class='img1'></div>
        $controls
    </div>
    <div id="content">
        <div id='controlShow'  class='point'><img src='../media/show.png'></div>
        <div id='info'>
            <div id='userIcon' class='point'>
                <img src='../media/user.png'> 
            </div>
            <div id='userMenu'>
                <div class='listItem'>Item number 1</div>
                <div class='listItem'>Item2</div>
            </div>
        </div>   
        <div id='contentUpdate'>
            
        </div>
    </div>
        
        </div>
    </div>
    <script>

        $("#controlShow").hide();

        $(".accd_header").click(function(){
            $(".accd_header").css("background", "linear-gradient( #555, #444)");  
            $(this).css("background", "#2C5C83");  
        });

        $(".selectRadio").click(function(){
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $(this).css("background", "#7A0909");  
        });

        $("#userMenu").hide();

        $("#userIcon").click(function(){
            $("#userMenu").fadeToggle();           
        });
    
        $("#controlHide").click(function(){
            $("#controls").toggle("slow", function(){
                $("#controlShow").fadeIn();
                $("#controlHide").hide();
            });
        });

        $("#controlShow").click(function(){
            $("#controlShow").hide();
            $("#controls").toggle("slow", function(){
                $("#controlHide").fadeIn();
            });
        });
        
        $('#wfByItem').on('change', function() {
            //getWorkflowListItem(this.value);

        })

        $('#stringSearchTerm').on('focus', function() {
 
        })

    </script>
</body>
</html>

_FixedHTML;

?>