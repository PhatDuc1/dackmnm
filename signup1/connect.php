<?php
    $HOSTNAME='localhost';
    $USERNAME='root'; 
    $PASSWORD='';
    $DATABaSE='quanlisinhvien';

    $con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABaSE);

    if($con){
        // die(mysqli_error($con));
    }

?>