<?php

//initiate the session (must be the first statement in the document)
session_start();

$pageTitle = 'Workflow Control Center';

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
    <link rel="stylesheet" type="text/css" href="../css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="../css/workflowLab.css">

    <script src="../js/jquery.js"></script>
    <script src="../js/jquery.tablesorter.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    
    
    <title>Work Flow Lab</title>
    
    <script>

    </script>
</head>
<body> 
    <div id='container'>
    <div id='controls'>
        <div id='controlHide' class='point'><img src='../media/hide.png'></div>
        <div id='wfTitle'><img src='../media/logo6.png' class='img1'></div>
        <div id='controlAccordian'>
        </div>
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

        window.onload = function() {
            updateControls();
        };

        function updateControls(){

            $.ajax({
                type: 'POST',
                url: 'fp/controls_update.php',   
                dataType: 'html',
                success: function (html) {
                    $("#controlAccordian").hide().fadeIn("slow").html(html);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#controlAccordian").hide().fadeIn("slow").html("error loading controls.");
                }
            });
        }

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

        $('body').on('click', '.accd_header', function() {
            $(".accd_header").css("background", "linear-gradient( #555, #444)");  
            $(this).css("background", "#2C5C83");  
        });

        $('body').on('click', '.selectRadio', function() {
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $(this).css("background", "#3E8553");  
        });

        $("#userMenu").hide();

        $('body').on('click', '#userIcon', function() {
            $("#userMenu").fadeToggle();           
        });
    
        $('body').on('click', '#controlHide', function() {
            $("#controls").toggle("slow", function(){
                $("#controlShow").fadeIn();
                $("#controlHide").hide();
            });
        });

        $('body').on('click', '#controlShow', function() {
            $("#controlShow").hide();
            $("#controls").toggle("slow", function(){
                $("#controlHide").fadeIn();
            });
        });
        
        $('body').on('change', '#wfByItem', function() {
            getWorkflowList('Item', this.value);
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $("#radio-wf-item").css("background", "#3E8553");
        })

        $('body').on('change', '#wfByGroup', function() {
            getWorkflowList('Group', this.value);
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $("#radio-wf-group").css("background", "#3E8553");
        })

        $('body').on('focus', '#stringSearchWF', function() {
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $("#radio-wf-text").css("background", "#3E8553");
        })

        function getWorkflowList(searchType, searchTerm){
            
            $.ajax({
                type: 'POST',
                url: 'fp/wf_getList.php',   
                dataType: 'html',
                data: {
                    search_type : searchType,
                    search_term : searchTerm
                },
                success: function (html) {
                    $("#contentUpdate").hide().fadeIn("slow").html(html);
                    $("#wfList").tablesorter();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#contentUpdate").hide().fadeIn("slow").html("error loading new item form.");
                }
            });
        }

        function getWorkflowListString(){
            var searchString = $("#stringSearchWF").val();
            getWorkflowList('String', searchString);
        }

        function openWorkflow(wfl){

            var wfID = wfl.id;
            $.ajax({
                type: 'POST',
                url: 'fp/wf_getWorkflow.php',   
                dataType: 'html',
                data: {
                    wf_id : wfID
                },
                success: function (html) {
                    $("#contentUpdate").hide().fadeIn("slow").html(html);

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#contentUpdate").hide().fadeIn("slow").html("error loading new item form.");
                }
            });
        }


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

        $('body').on('change', '#itemByItem', function() {
            getItemDetails(this.value);
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $("#radio-itm-detail").css("background", "#3E8553");
        })

        $('body').on('focus', '#stringSearchItem', function() {
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
                        updateControls();
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

        function getItemList(searchType){

            $.ajax({
                type: 'POST',
                url: 'fp/item_getList.php',   
                dataType: 'html',
                data: {
                    search_type : searchType
                },
                success: function (html) {
                    $("#contentUpdate").hide().fadeIn("slow").html(html);
                    $("#itemList").tablesorter();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#contentUpdate").hide().fadeIn("slow").html("error loading new item form.");
                }
            });
        }

        function getItemListString(){

            
            var textString = $("#stringSearchItem").val();

            alert(textString);
            
            $.ajax({
                type: 'POST',
                url: 'fp/item_getList.php',   
                dataType: 'html',
                data: {
                    search_type : 'String',
                    search_term : textString
                },
                success: function (html) {
                    $("#contentUpdate").hide().fadeIn("slow").html(html);
                    $("#itemList").tablesorter();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#contentUpdate").hide().fadeIn("slow").html("error loading new item form.");
                }
            });
        }

        function getItemDetails(itemID){
            
            $.ajax({
                type: 'POST',
                url: 'fp/item_details.php',   
                dataType: 'html',
                data: {
                    item_id : itemID
                },
                success: function (html) {
                    $("#contentUpdate").hide().fadeIn("slow").html(html);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#contentUpdate").hide().fadeIn("slow").html("error loading new item form.");
                }
            });
        }

        function editChangeItem(){
            $("#btnEditItemChg").hide();
            $("#btnSaveItemChg").fadeIn();
            $("#btnUndoItemChg").fadeIn();
            $('.itemEdit').prop('readonly', false);
            $('.itemEditSelect').prop('disabled', false);
        }

        function saveChangeItem(itemID){
            var itemNum = $("#item_num").val();
            var itemDesc = $("#item_desc").val();
            var itemStatus = $("#item_sta").val();
            var itemWf = $("#item_wf").val();

            itemNum = itemNum.trim();

            if (itemNum){

                $.ajax({
                    type: 'POST',
                    url: 'fp/item_change.php',   
                    dataType: 'html',
                    data: {
                        item_id: itemID,
                        item_num: itemNum,
                        item_desc: itemDesc,
                        item_sta: itemStatus,
                        item_wf: itemWf
                    },
                    success: function (html) {
                        updateControls();
                        getItemDetails(itemID)
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        $("#contentUpdate").hide().fadeIn("slow").html("error loading new item form.");
                    }
                });

            } else {

                alert("item number is required");
            }


        }

        $('body').on('change', '#itemByItem', function() {
            getItemDetails(this.value);
            $(".selectRadio").css("background", "linear-gradient( #333, #444)");  
            $("#radio-itm-detail").css("background", "#3E8553");
        })

    </script>
</body>
</html>

_FixedHTML;

?>