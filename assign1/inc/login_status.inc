<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php
    session_start(); 
    $data = $_SESSION['form_data'] ?? [];
?>