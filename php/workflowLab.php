<?php

//initiate the session (must be the first statement in the document)
session_start();

$pageTitle = 'Workflow Control Center';

//DEBUG
$custID = '1';

//linked files
require_once 'fp/dbConnect.php';
//require_once 'fp/logInValidation.php'; //$userID, $custID

//get list of items for select boxes
$itemSelect = "<div class='inputControl'><select class='inputField controlSelect' id='wfByItem'><option disabled selected>Select Item</option>";
$itemSelect2 = "<div class='inputControl'><select class='inputField controlSelect' id='itemByItem'><option disabled selected>Select Item</option>";

$sql = "SELECT DISTINCT ITM_id, ITM_num
        FROM ITM
        WHERE ITM_CUS_id = '$custID'";

$result = mysqli_query($conn,$sql);

if($result){
    
    if($result->num_rows != 0){

        while($row = $result->fetch_assoc()){

            $item = $row['ITM_num'];
            $itemID = $row['ITM_id'];

            $itemSelect .= "<option value ='$itemID'>$item</option>";
            $itemSelect2 .= "<option value ='$itemID'>$item</option>";
        }

    }
}

$itemSelect .= "</select></div>";
$itemSelect2 .= "</select></div>";

//get list of items for select box
$groupSelect = "<div class='inputControl'><select class='inputField controlSelect' id='wfByGroup'><option disabled selected>Select Group</option>";

$sql = "SELECT WKO_name
        FROM WKO
        WHERE WKO_CUS_id = '$custID' & WKO_status = 'Active'
        ORDER BY WKO_name";

$result = mysqli_query($conn,$sql);

if($result){
    
    if($result->num_rows != 0){

        while($row = $result->fetch_assoc()){

            $item = $row['WKO_name'];

            $groupSelect .= "<option value ='$item'>$item</option>";
        }

    }
}

$groupSelect .= "</select></div>";

$ctrlWf = "<div class='listLabel'>WORKFLOWS BY STATUS</div>
    <div id='radio-wf-active' onclick='getWorkflowList('Active')' class='selectRadio'>Active</div>
    <div id='radio-wf-comp' onclick='getWorkflowList('Complete')' class='selectRadio'>Completed</div>
    <div id='radio-wf-pend' onclick='getWorkflowList('Pending')' class='selectRadio'>Pending</div>
    <div id='radio-wf-all' onclick='getWorkflowList('%')' class='selectRadio'>All</div>
    <hr>
    <div id='radio-wf-temp' onclick='getWorkflowList('Template')' class='selectRadio'>Templates</div>
    <hr>
    <div id='radio-wf-item' onclick='itemClick()' class='selectRadio'>Item Details</div>
        $itemSelect
    <div id='radio-wf-group' onclick='groupClick()' class='selectRadio'>View by Group</div>
        $groupSelect
    <hr>
    <div id='radio-wf-text' class='selectRadio'>Text Search</div>
    <div class='inputControl'>
        <input type='text' id='stringSearchWF' class='inputField2'>
        <button onclick='getWorkflowListString()' class='button1'>Search</button>
    </div>";

$ctrlItem = "  
    <div class='listLabel'>ITEMS BY STATUS</div>
    <div id='radio-itm-active' onclick='getWorkflowList('Active')' class='selectRadio'>Active</div>
    <div id='radio-itm-inactive' onclick='getWorkflowList('Inactive')' class='selectRadio'>Inactive</div>
    <div id='radio-itm-all' onclick='getWorkflowList('Inactive')' class='selectRadio'>All Items</div>
    <hr>
    <div id='radio-itm-detail' onclick='itemClick()' class='selectRadio'>Item Details</div>
        $itemSelect2
    <hr>
    <div id='radio-itm-text' class='selectRadio'>Text Search</div>
    <div class='inputControl'>
        <input type='text' id='stringSearchItem' class='inputField2'>
        <button onclick='getItemListString()' class='button1'>Search</button>
    </div>
    <div id='radio-itm-new' class='selectRadio' onclick='addNewItem()'>New Item</div> ";


$controls = "
            <div id='controlAccordian'>
                <div class='accd_header accd_header_selected' onclick='h0()'>
                    Home
                </div>
                <div class='accd_header' onclick='h1()'>
                    Workflows
                </div>
                <div class='accd_content' id='c1' hidden>
                    $ctrlWf
                </div>
                <div class='accd_header'  onclick='h2()'>
                    Items
                </div>
                <div class='accd_content' id='c2' hidden>
                    $ctrlItem
                </div>
                <div class='accd_header'  onclick='h3()'>
                    Steps
                </div>
                <div class='accd_content' id='c3' hidden>
                    Content 3
                </div>
                <div class='accd_header'  onclick='h4()'>
                    Users
                </div>
                <div class='accd_content' id='c4' hidden>
                    Content 4
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
        <div id='contentContainer'>
            <div id='contentUpdate'>
                
            </div>
        </div>
    </div>
        
        </div>
    </div>
    <script>

        function h0(){  
            $("#c1, #c2, #c3, #c4").slideUp();
        }

        function h1(){  
            $("#c0, #c2, #c3, #c4").slideUp();
            $("#c1").slideToggle("slow");
        }

        function h2(){  
            $("#c0, #c1, #c3, #c4").slideUp();
            $("#c2").slideToggle("slow");
        }

        function h3(){  
            $("#c0, #c1, #c2, #c4").slideUp();
            $("#c3").slideToggle("slow");
        }   

        function h4(){  
            $("#c0, #c1, #c2, #c3").slideUp();
            $("#c4").slideToggle("slow");
        }

        $("#controlShow").hide();

        $(".accd_header").click(function(){
            $(".accd_header").css("background", "linear-gradient( #555, #444)");  
            $(this).css("background", "#2C5C83");  
        });

        $(".selectRadio").click(function(){
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $(this).css("background", "#3E8553");  
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
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $("#radio-wf-item").css("background", "#3E8553");
        })

        $('#wfByGroup').on('change', function() {
            //getWorkflowListItem(this.value);
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $("#radio-wf-group").css("background", "#3E8553");
        })

        $('#stringSearchWF').on('focus', function() {
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $("#radio-wf-text").css("background", "#3E8553");
        })

        function addNewItem() {

            $.ajax({
                type: 'POST',
                url: 'fp/item_new.php',   
                dataType: 'html',
                success: function (html) {
                    $("#contentUpdate").hide().fadeIn("slow").html(html);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#contentUpdate").hide().fadeIn("slow").html("error loading new item form.");
                }
            });
        }

        $('#itemByItem').on('change', function() {
            //getWorkflowListItem(this.value);
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $("#radio-itm-detail").css("background", "#3E8553");
        })

        $('#stringSearchItem').on('focus', function() {
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $("#radio-itm-text").css("background", "#3E8553");
        })

        function saveNewItem(){
            var itemNum = $("#item_num").val();
            var itemDesc = $("#item_desc").val();
            var itemStatus = $("#item_sta").val();
            var itemWf = $("#item_wf").val();

            itemNum = itemNum.trim();

            if (itemNum){

                $.ajax({
                    type: 'POST',
                    url: 'fp/item_save.php',   
                    dataType: 'html',
                    data: {
                        item_num: itemNum,
                        item_desc: itemDesc,
                        item_sta: itemStatus,
                        item_wf: itemWf
                    },
                    success: function (html) {
                        $("#contentUpdate").hide().fadeIn("slow").html(html);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        $("#contentUpdate").hide().fadeIn("slow").html("error loading new item form.");
                    }
                });

            } else {

                alert("item number is required");
            }


        }

        function clearNewItem(){
            $("#item_num").val("");
            $("#item_desc").val("");
            $("#item_sta").val("Active");
            $("#item_wf").val("0");
        }
    </script>
</body>
</html>

_FixedHTML;

?>