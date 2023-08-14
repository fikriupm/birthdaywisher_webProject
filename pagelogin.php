<?php
require_once('connection/getConnection.php');

session_start(); // Start the session

$failure = false; // If we have no POST data

//reset button click
if (isset($_POST['reset'])) {
    // Clear the session
    session_destroy();
    session_start();

}

// Check to see if we have some POST data, if we do process it
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    unset($_SESSION["name"]);  // Logout current user
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $failure = "User name and password are required";
    } else {
        // Check if the login attempts session variable is set
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }

        // Retrieve the stored hashed password from the database
        $query = "SELECT hashed_password FROM users WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $stored_hash = $result['hashed_password'];

            // Hash the user-entered password
            $entered_password = $_POST['password'];
            $entered_hash = hash('sha256', $entered_password);

            if ($entered_hash === $stored_hash) {
                // Passwords match
                // Reset login attempts
                $_SESSION['login_attempts'] = 0;

                // Redirect the browser to pagedashboard.php
                header("Location: pagedashboard.php?name=" . urlencode($_POST['username']));
                exit();
            } else {
                $failure = "Incorrect username or password";
                $_SESSION['login_attempts']++; // Increment login attempts
            }
        } else {
            $failure = "Incorrect username or password";
            $_SESSION['login_attempts']++; // Increment login attempts
        }
    }
}

$attempts = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] : 0; // Get the updated login attempts count

if ($attempts >= 3) {
    $failure = "Maximum login attempts reached. Please try again later. Click button reset to reset session. ";
    $submit_disabled = true;
    $password_disabled = true;
    $username_disabled = true;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Joyboy Login Page</title>
    <link rel="stylesheet" type="text/css" href="style/pagelogin.css">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
    <style> 
        body {
	        font-family: sans-serif;
	        display: flex;
	        align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: url("images/lgbg.jpg"); /* Replace with the path or URL of your background image */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
	}
    </style>
</head>

<form method="post" class="form">
    <!-- Border Animation -->
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <!-- Login Form Area -->
    <div class="form-inner">
        <img src="images/Logo2.png" alt="Logo" class="logo">
        <h2>LOGIN</h2>
        <!-- Input Place -->
        <div class="content">
            <input class="input" name="username" type="text" placeholder="Username" required
                value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>"
                <?php if (isset($username_disabled) && $username_disabled)
                    echo 'disabled'; ?>><br>
            <input class="input" name="password" type="password" placeholder="Password"
                value="<?php echo ''; ?>"
                <?php if (isset($password_disabled) && $password_disabled)
                    echo 'disabled'; ?>><br>
            <button class="btn">LOGIN
                <?php if (isset($submit_disabled) && $submit_disabled)
                    echo 'DISABLED'; ?>
            </button>
            <?php if ($attempts >= 3): ?>
                <button class="btn" name="reset">RESET</button>
            </div>
        <?php endif; ?>
</form>
</div>

<?php
if ($failure) {
    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
    echo '<script>';
    echo 'swal("Sorry", "' . $failure . '", "error");';
    echo '</script>';
}
?>

</body>

</html>