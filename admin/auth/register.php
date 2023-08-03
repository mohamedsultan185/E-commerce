<?php
session_start();
if (!(isset($_SESSION['admin_username']))) { 
    header("location: login.php");
    exit(); // Make sure to exit after redirecting to prevent further execution of the script.
}
?>
<?php
// Include the database connection file
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form data (add more validation as needed)
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if the email is already registered
        $sql = "SELECT id FROM admins WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Username (Email) is already registered.";
        } else {
            // Hash the password before storing it in the database (add more security measures as needed)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new admin account into the database
            $sql = "INSERT INTO admins (name, username, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss', $name, $email, $hashed_password);
            if ($stmt->execute()) {
                // Registration successful, redirect to login page or dashboard
                header("Location: ../index.php");
                exit();
            } else {
                $error_message = "Error registering the account. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/stylecreat.css">
    <title>Register an Account</title>
    <!-- This Is Description For Register Page -->
</head>
<body>
    <form class="honda" action="register.php" method="post">
        <fieldset style="background-color: rgb(255, 255, 255);">
            <legend>Register an account</legend>
          
            <?php if (isset($error_message)) : ?>
                <p><?php echo $error_message; ?></p>
            <?php endif; ?>
            <label>Name</label>
            <input type="text" placeholder="First name" name="name">
          
            <label>Email</label>
            <input type="email" name="email" placeholder="@gmail" value="<?php echo isset($email) ? $email : ''; ?>">
            <br><br>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password">

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm Password">

            <input type="submit" value="SIGN IN">
            <br><br>
        </fieldset>
    </form>
</body>
</html>
