<?php

//verify ownership of workflow
function verifyWfCust($wfl, $custID, $conn){

    $sql = "SELECT WFL_id
    FROM WFL
    WHERE WFL_CUS_id = '$custID' AND WFL_id = $wfl";

    $result = mysqli_query($conn,$sql);

    if($result){

        if($result->num_rows != 0){

            //match
            return true;
        } 

    }

    return false;

}


?>