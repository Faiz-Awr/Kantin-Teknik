<?php
    session_start();
    $tempDir = '../img_temp/';
    
        // Check if the directory exists
        if (is_dir($tempDir)) {
            // Get all files in the directory
            $files = glob($tempDir . '*'); // Grabs all files in the directory

            // Loop through each file and delete it
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
    unset($_SESSION['temp_menu_data']);
    session_destroy();
    header("Location: login");
    exit;
?>
