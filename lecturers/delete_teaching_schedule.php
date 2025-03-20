<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

    include "../lecturers/connect.php"; // Kết nối đến cơ sở dữ liệu

    // Get the schedule ID from the query string
    $id = $_GET['id'];

    // Fetch the lecturer ID before deleting the schedule
    $sql = "SELECT lecturer_id FROM teaching_schedule WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $lecturer_id = $row['lecturer_id'];

    // Delete the schedule
    $sql = "DELETE FROM teaching_schedule WHERE id='$id'";
    mysqli_query($con, $sql);

    // Redirect back to lecturer_schedule.php after deleting the schedule
    header('location: lecturer_schedule.php?lecturer_id='.$lecturer_id);
?>