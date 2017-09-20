<?php

//DEBUG
$custID = '1';

//linked files
require_once 'dbConnect.php';
//require_once 'fp/logInValidation.php'; //$userID, $custID

//get list of items for select boxes
$itemSelect = "<div class='inputControl'><select class='inputField controlSelect' id='wfByItem'><option disabled selected>Select Item</option>";
$itemSelect2 = "<div class='inputControl'><select class='inputField controlSelect' id='itemByItem'><option disabled selected>Select Item</option>";

$sql = "SELECT DISTINCT WFL_item, ITM_num
        FROM ITM
        WHERE ITM_CUS_id = '$custID'
        ORDER BY ITM_num";

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

$sql = "SELECT WKO_name, WKO_id
        FROM WKO
        WHERE WKO_CUS_id = '$custID' AND WKO_status = 'Active' AND WKO_id NOT LIKE '0'
        ORDER BY WKO_name";

$result = mysqli_query($conn,$sql);

if($result){
    
    if($result->num_rows != 0){

        while($row = $result->fetch_assoc()){

            $woName = $row['WKO_name'];
            $woID = $row['WKO_id'];

            $groupSelect .= "<option value ='$woID'>$woName</option>";
        }

    }
}

$groupSelect .= "</select></div>";

$ctrlWf = "<div class='listLabel'>WORKFLOWS BY STATUS</div>
    <div id='radio-wf-active' onclick='getWorkflowList(\"Active\")' class='selectRadio'>Active</div>
    <div id='radio-wf-comp' onclick='getWorkflowList(\"Complete\")' class='selectRadio'>Completed</div>
    <div id='radio-wf-pend' onclick='getWorkflowList(\"Pending\")' class='selectRadio'>Pending</div>
    <div id='radio-wf-all' onclick='getWorkflowList(\"%\")' class='selectRadio'>All</div>
    <hr>
    <div id='radio-wf-temp' onclick='getWorkflowList(\"Template\")' class='selectRadio'>Templates</div>
    <hr>
    <div id='radio-wf-item' class='selectRadio'>View by Item</div>
        $itemSelect
    <div id='radio-wf-group' class='selectRadio'>View by Group</div>
        $groupSelect
    <hr>
    <div id='radio-wf-text' class='selectRadio'>Text Search</div>
    <div class='inputControl'>
        <input type='text' id='stringSearchWF' class='inputField2'>
        <button onclick='getWorkflowListString()' class='button1'>Search</button>
    </div>";

$ctrlItem = "  
    <div class='listLabel'>ITEMS BY STATUS</div>
    <div id='radio-itm-active' onclick='getItemList(\"Active\")' class='selectRadio'>Active</div>
    <div id='radio-itm-inactive' onclick='getItemList(\"Inactive\")' class='selectRadio'>Inactive</div>
    <div id='radio-itm-all' onclick='getItemList(\"%\")' class='selectRadio'>All Items</div>
    <hr>
    <div id='radio-itm-detail' class='selectRadio'>Item Details</div>
        $itemSelect2
    <hr>
    <div id='radio-itm-text' class='selectRadio'>Text Search</div>
    <div class='inputControl'>
        <input type='text' id='stringSearchItem' class='inputField2'>
        <button onclick='getItemListString()' class='button1'>Search</button>
    </div>
    <div id='radio-itm-new' class='selectRadio' onclick='addNewItem()'>New Item</div> ";


$controls = "
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
    </div>";

echo $controls;

?>