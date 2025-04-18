<?php
session_start();
include("db.php");

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    var_dump($_POST); // Debugging: Check received data
    echo "</pre>";
}
    */

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);
    $city = $_POST["city"]; // Dropdown value
    $profession = $_POST["profession"];

    if (!empty($username) && !empty($email) && !empty($password) && !empty($city)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        
        $fileName = $_FILES["image"]["name"]; 
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        $tempName = $_FILES["image"]["tmp_name"];
        $targetPath = "upload/" . $fileName;

        if (in_array($ext, $allowedTypes)) {
            if (move_uploaded_file($tempName, $targetPath)) {
                $image = $fileName; // Correctly assign image name before inserting into DB

                
                $sql = "INSERT INTO users (username, email, password, phone, image, city, profession) 
        VALUES ('$username', '$email', '$hash', '$phone', '$image', '$city', '$profession')";

                // Execute the query
                if (mysqli_query($conn, $sql)) {
                    header("location:confirm.html");
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Invalid file type. Allowed formats: jpg, jpeg, png, gif.";
        }
    } else {
        echo "Please fill in all required fields.";
    }

?>