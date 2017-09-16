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
$itemSelect = "<select class='inputField' id='wfByItem'><option disabled selected>Select Item</option>";

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

$itemSelect .= "</select>";

$ctrlWf = "<div class='listLabel'>WORKFLOWS BY STATUS</div>
            <label for='radio-1' class='selectRadio'>Active</label>
            <input type='radio' name='radio-1' id='radio-1' onclick='getWorkflowList('Active')'>
            <br>
            <label for='radio-2' class='selectRadio'>Completed</label>
            <input type='radio' name='radio-1' id='radio-2' onclick='getWorkflowList('Complete')'>
            <br>
            <label for='radio-7' class='selectRadio'>Pending</label>
            <input type='radio' name='radio-1' id='radio-7' onclick='getWorkflowList('Pending')'>
            <br>
            <label for='radio-3' class='selectRadio'>All</label>
            <input type='radio' name='radio-1' id='radio-3' onclick='getWorkflowList('%')'>
            <br>
            <hr>
            <label for='radio-4' class='selectRadio'>Templates</label>
            <input type='radio' name='radio-1' id='radio-4' onclick='getWorkflowList('Template')'>
            <hr>
            <label for='radio-5' class='selectRadio'>View by Item</label>
            <input type='radio' name='radio-1' id='radio-5' onclick='itemClick()'>
                $itemSelect
            <hr>
            <label for='radio-6' class='selectRadio'>Text Search</label>
            <input type='radio' name='radio-1' id='radio-6'>
            <input type='text' id='stringSearchTerm' class='inputField2'><button onclick='getWorkflowListString()' class='button1'>Search</button>";


$controls = "
            <div id='controlAccordian'>
                <div class='accd_header'>
                    Home
                </div>
                <div id='accordianContentNull'>
                </div>
                <div class='accd_header'>
                    Workflows
                </div>
                <div class='accordianContent'>
                    $ctrlWf
                </div>
                <div class='accd_header'>
                    Items
                </div>
                <div class='accordianContent'>
                    <div>Item1</div>
                    <div>Item2</div>
                </div>
                <div class='accd_header'>
                    Steps
                </div>
                <div class='accordianContent'>
                    <div>Step1</div>
                    <div>Step2</div>
                </div>
                <div class='accd_header'>
                    Users
                </div>
                <div class='accordianContent'>
                    <div>User1</div>
                    <div>User2</div>
                </div>
            </div>";

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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
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
            Content to be updated
        </div>
    </div>
        
        </div>
    </div>
    <script>

        $("#controlShow").hide();

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

        $( "#controlAccordian" ).accordion({
                active: 0,
                collapsible: true,
                header: ".accd_header",
                heightStyle: "content",
                animate: 500
        });

        $( "input[type='radio']" ).checkboxradio({
            icon: false
        });

        $("#radio-1").attr("checked","checked").change();
        
        $('#wfByItem').on('change', function() {
            //getWorkflowListItem(this.value);
            $("#radio-5").attr("checked","checked").change();
        })

        $('#stringSearchTerm').on('focus', function() {
            $("#radio-6").attr("checked","checked").change();
        })

    </script>
</body>
</html>

_FixedHTML;

?>