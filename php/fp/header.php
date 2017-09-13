<?php

$menuBar = "<div class='menu' id='menu'>
                <a href='home.php'><img src='../media/logo2.png' alt='Workflow Lab' width='200px'></a>
                <div class='dropdown'>
                    <div class='dropbtn'>Workflow</div>
                    <div class='dropdown-content'>
                        <a href='workFlowControl.php'>Control Center</a>
                        <a href='createWorkFlow.php'>Add New Workflow</a>
                    </div>
                </div> 
                <div class='dropdown'>
                    <div class='dropbtn'>Steps</div>
                    <div class='dropdown-content'>
                        <a href='manageSteps.php'>Step Management</a>
                        <a href=''>Add New Steps</a>
                    </div>
                </div> 
                <div class='dropdown'>
                    <div class='dropbtn'>Reports</div>
                    <div class='dropdown-content'>
                        <a href=''>Reports 1</a>
                        <a href=''>Reports 2</a>
                    </div>
                </div> 
                <div class='dropdown'>
                    <div class='dropbtn'>$userName</div>
                    <div class='dropdown-content'>
                        <a href=''>Account Settings</a>
                        <a href=''>Manage Users</a>
                    </div>
                </div> 
                <div class='dropdown'>
                    <div class='dropbtn'>Help</div>
                    <div class='dropdown-content'>
                        <a href=''>Tutorials</a>
                        <a href=''>FAQ</a>
                        <a href=''>Contact Us</a>
                    </div>
                </div> 
                <a href='fp/logout.php'>Log Out</a>
                <img src='../media/banner1.png' class='floatRight'>
             </div>";

$header =  "<div class='wfHeader'>
                $menuBar
            </div>";

?>