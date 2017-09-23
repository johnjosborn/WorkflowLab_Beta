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

        function hActive(){  
            $("#c1, #c2, #c3, #c4").slideUp();
            $("#activeContent").slideToggle("slow");
            $(".accd_header").css("background", "linear-gradient( #555, #444)");
        }

        function h0(){  
            $("#c1, #c2, #c3, #c4, #activeControl").slideUp();
        }

        function h1(){  
            $("#c0, #c2, #c3, #c4, #activeControl").slideUp();
            $("#c1").slideToggle("slow");
            $("#radio-wf-active").css("background", "#3E8553");
            getWorkflowList("Active");
        }

        function h3(){  
            $("#c0, #c1, #c2, #c4, #activeControl").slideUp();
            $("#c3").slideToggle("slow");
        }   

        function h4(){  
            $("#c0, #c1, #c2, #c3, #activeControl").slideUp();
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
                    $(".accd_header").css("background", "linear-gradient( #555, #444)");

                    $.ajax({
                        type: 'POST',
                        url: 'fp/wf_stepIndex.php',
                        dataType: 'html',
                        data: {
                            wf_id : wfID
                        },
                        success: function (html) {

                            var result = $.parseJSON(html);

                            var stepIndex = result[0];

                            $( "#stepAccordian" ).accordion({
                                active: stepIndex,
                                collapsible: true,
                                header: ".stepHeader",
                                heightStyle: "content",
                                animate: 500
                            });

                            $('#stepAccordian .stepHeader').bind('click',function(){
                                var self = this;
                                setTimeout(function() {
                                    theOffset = $(self).position();
                                    theNextOffset = $('#stepAccordian').position();
                                    $('#accordianScroll').animate({ scrollTop: theOffset.top - theNextOffset.top + 5}, 1000);
                                }, 510); // ensure the collapse animation is done
                            });

                            $(function(){
                                var self =  $('#openStep');
                                setTimeout(function() {
                                    theOffset = $(self).position();
                                    theNextOffset = $('#stepAccordian').position();
                                    $('#accordianScroll').animate({ scrollTop: theOffset.top - theNextOffset.top + 5}, 1500);
                                }, 10); // ensure the collapse animation is done
                            });


                            $(function(){
                                $('#progress').progressbar({
                                    value: result[1] / result[2] * 100
                                });
                            });

                            getWFHeader(wfID);
                        }
                    });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#contentUpdate").hide().fadeIn("slow").html("error loading new item form.");
                }
            });
        }

        function getWFHeader(wfID){
           
            $.ajax({
                type: 'POST',
                url: 'fp/wf_getHeader.php',   
                dataType: 'html',
                data: {
                    wf_id : wfID
                },
                success: function (html) {
                    $("#c1, #c3, #c4").slideUp();
                    $("#activeControl").html(html).slideDown("slow", function(){
                        $("#activeContent").slideDown("slow");
                    });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#activeControl").hide().fadeIn("slow").html("error loading new item form.");
                }
            });
        }

        function editWf(wfID){

            getModHeader(wfID);
            getModAvailOps(wfID);
            getModSteps(wfID);
        }

        function getModHeader(wfID){

            $.ajax({
                type: 'POST',
                url: 'fp/wf_mod_header.php',   
                dataType: 'html',
                data: {
                   wfl_id : wfID
                },
                success: function (html) {
                   $("#activeContent").hide().fadeIn("slow").html(html);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#contentUpdate").hide().fadeIn("slow").html("error loading workflow.");
                }
            });
        }

        function getModAvailOps(wfID){
           
            $.ajax({
                type: 'POST',
                url: 'fp/wf_mod_ops.php',   
                dataType: 'html',
                data: {
                   wfl_id : wfID
                },
                success: function (html) {
                   $("#contentUpdate").hide().fadeIn("slow").html(html);
                   opsSortable();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#contentUpdate").hide().fadeIn("slow").html("error loading available ops.");
                }
            });
        }

        function getModSteps(wfID){

            $.ajax({
                type: 'POST',
                url: 'fp/wf_mod_steps.php',   
                dataType: 'html',
                data: {
                   wfl_id : wfID
                },
                success: function (html) {
                   $("#stepsUpdate").hide().fadeIn("slow").html(html);
                   modAccordian();
                   $('.stepButtons').hide();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#contentUpdate").hide().fadeIn("slow").html("error loading available ops.");
                }
            });
        }

        function modAccordian(){

            $( "#stepAccordian" ).accordion({
                active: false,
                collapsible: true,
                header: ".stepHeader",
                heightStyle: "content",
                animate: 500
                })
            .sortable({
                items: '.s_panel',
                forceHelperSize: true,
                forcePlaceHolderSize: false,
                dropOnEmpty: true,
                tolerance: "intersect",
                placeholder: "sortable-placeholder",
                over: function (event, ui) {
                    removeIntent = false;
                    $(ui.item).find(".stepHeader").css("border-bottom", "none");
                },
                out: function (event, ui) {
                    removeIntent = true;    
                    $(ui.item).find(".stepHeader").css("border-bottom", "6px solid red");                              
                },
                beforeStop: function (event, ui) {
                    if(removeIntent == true){
                        ui.item.remove();   
                    }
                },
                stop: function (event, ui) {
                    $(ui.item).find(".stepHeader").css("border-bottom", "none");
                    $('#wfEditButtons').show();
                },
                change: function( event, ui ) {
                    $('#wfEditButtons').show();
                }
            });

            //$('#wfEditButtons').hide();
            

            $('#stepAccordian .stepHeader').bind('click',function(){
                var self = this;
                setTimeout(function() {
                    theOffset = $(self).position();
                    theNextOffset = $('#stepAccordian').position();
                    $('#accordianScroll').animate({ scrollTop: theOffset.top - theNextOffset.top + 5}, 1000);
                }, 510); // ensure the collapse animation is done
            });

            $( function() {
                $( ".datePicker" ).datepicker({
                    dateFormat: "yy-mm-dd"
                });
              } );

        }

        function opsSortable(){
            $( "#sourceOps" ).sortable({
                connectWith: ".connectedSortable",
                forceHelperSize: true,
                forcePlaceHolderSize: true,
                placeholder: "sortable-placeholder",
                scroll : false,
                dropOnEmpty: true,
                tolerance: "intersect",
                remove: function(e,tr) {
                    copyHelper= tr.item.clone().insertAfter(tr.item);
                    $(this).sortable('cancel');
                    return tr.clone();
                }     
            }).disableSelection();

            $("#sourceOps").on("click", ".s_panel", function(){
                $( this ).clone().appendTo( "#stepAccordian" );
                $('#wfEditButtons').show();
            });
        }

        $(document).on("input", "#wfContainer input.textTableInput", function () {
            this.style.backgroundColor = '#FDF19D';
            $('.editH').show();
        });

        function statusChange(e){
            var thisStatus = e.options[e.selectedIndex].value;
            $('#staStore').val(thisStatus);
            e.style.backgroundColor = '#FDF19D';
            $('.editH').show();
        }

        function cancelEdit(wfID){

            var g=document.createElement('div');
            g.setAttribute("id", wfID);
            openWorkflow(g);

        }

        function resetWf(){

            var wfID = document.getElementById("wfID").value

            $.ajax({
                type: 'POST',
                url: 'fp/wf_reset.php',
                dataType: 'html',
                data: {
                    wkf_ID: wfID
                },
                success: function (html) {
                    // alert ("Workflow Reset.");
                    // var g=document.createElement('div');
                    // g.setAttribute("id", wfID);
                    editWf(wfID)
                }
            });
        }

        function saveWfHeader(){
            
            var wkfID = $('#wfID').val();
            var wkfNum = $('#wfNum').val();
            var wkfItem = $('#wfItem').val();
            var wkfDesc = $('#wfDesc').val();
            var wkfSta = $('#staStore').val();
            var wkfRef = $('#wfRef').val();
            var wkfGrp = $('#wfGrp').val();
            var wkfNot = $('#wfNot').val();
                        
            $.ajax({
                type: 'POST',
                url: 'fp/wf_save_header.php',
                dataType: 'html',
                data: {
                    wkf_ID: wkfID,
                    wkf_Num: wkfNum,
                    wkf_Item: wkfItem,
                    wkf_Desc: wkfDesc,
                    wkf_Sta: wkfSta,
                    wkf_Ref: wkfRef,
                    wkf_Grp: wkfGrp,
                    wkf_Not: wkfNot
                },
                success: function (html) {
                    if (html == 1){
                        alert("Error updating data.");
                    } else if (html == 2){
                        alert("Error sending data.");
                    } 
                    getModHeader(wkfID);
                    modAccordian();
                }
            }); 
        }

        $(document).on("input", "#accordionHolder input.stepInput", function () {
            this.style.backgroundColor = '#FDF19D';
            var buttonDiv = '#stepEditButtons' + $(this).closest('.s_panel').attr('id');
            $(buttonDiv).show();
        });

        $(document).on("input change", "#accordionHolder input.datePicker", function () {
            this.style.backgroundColor = '#FDF19D';
            var buttonDiv = '#stepEditButtons' + $(this).closest('.s_panel').attr('id');
            $(buttonDiv).show();
        });

        function userChange(e){
            var thisUser = e.options[e.selectedIndex].value;
            var thisStep = e.id;

            document.getElementById('userStore' + thisStep).value = thisUser;
            e.style.backgroundColor = '#FDF19D';
            var buttonDiv = '#stepEditButtons' + $(e).closest('.s_panel').attr('id');
            $(buttonDiv).show();
        }

        function completeStep(stepID){
            
            var stepNoteID = stepID + "note";
            var stepNote =  document.getElementById(stepNoteID).value;

            var wfID = document.getElementById("wfIDHolder").value
            
            $.ajax({
                type: 'POST',
                url: 'fp/wf_compStep.php',
                dataType: 'html',
                data: {
                    stp_ID: stepID,
                    stp_note: stepNote
                },
                success: function (html) {
                    alert("Step Completed.");
                    if (html == "1"){
                        alert("Workflow Complete.");
                    }

                    var g=document.createElement('div');
                    g.setAttribute("id", wfID);
                    openWorkflow(g);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("error");
                }
            });
            
        }

        function saveEditedStep(stpID){

            var stpUser = $('#userStore' + stpID).val();
            var stpNotes = $('#stpNotes' + stpID).val();   
            var stpTitle = $('#stpTitle' + stpID).val();
            var stpDesc = $('#stpDesc' + stpID).val();
            var stpDetail = $('#stpDetail' + stpID).val();
            var stpDate = $('#stpDate' + stpID).val();

            var wfID = $('#wfID').val();

            $.ajax({
                type: 'POST',
                url: 'fp/wf_save_step_change.php',   
                dataType: 'html',
                data: {
                    stp_ID : stpID,
                    stp_title : stpTitle,
                    stp_desc : stpDesc,
                    stp_detail : stpDetail,
                    stp_notes : stpNotes,
                    stp_user : stpUser,
                    stp_date : stpDate
                },
                success: function (html) {
                    if (html == 1){
                        alert("Error updating data.");
                    } else if (html == 2){
                        alert("Error sending data.");
                    } 
                    getModSteps(wfID);
                }

            });
        }

        <!--
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

        -->

    </script>
</body>
</html>

_FixedHTML;

?>