<?php
session_start();
if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])) { 
    header("location:auth/login.php");
    exit(); // Make sure to exit after redirecting to prevent further execution of the script.
}
?>

<?php
include 'database/connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Validate and sanitize data (you can add more validation as needed)
    $name = htmlspecialchars($name);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $phone = preg_replace('/\D/', '', $phone); // Remove non-numeric characters from phone number

    // Insert data into the database
    $sql = "INSERT INTO contact_form_data (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- connect with css file  -->
    <link rel="stylesheet" href="css/styleconact.css">
</head>
<body>
    <div class="wrapper">
        <div class="content">
          <h1>CONTACT us</h1>
          <p>Connect with us by sending your answer.</p>
        </div>
      
        <div class="form">
        <form class="form" id="login" method="post">
          <div class="top-form">
            <div class="inner-form">
              <div class="label">name</div>
              <input type="text" placeholder="Jhon" name="name">
            </div>
            <div class="inner-form">
              <div class="label">email</div>
              <input type="text" placeholder="Example@gmail.com"  name="email">
            </div>
            <div class="inner-form">
              <div class="label">phone</div>
              <input type="text" placeholder="1234567890" name="phone">
            </div>
          </div>
      
      
          <div class="bottom-form">
            <div class="inner-form">
              <div class="label">message</div>
              <textarea placeholder="Your message"  name="message"></textarea>
            </div>
          </div>
          <button class="btn" type="submit">send the message</button>

          <!-- <div class="btn" onClick="showMessage()">send the message</div> -->
      </form>
      </div>

        </div>
      
      
      
</body>
</html>