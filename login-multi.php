<?php
require_once "config.php";

/* Initialize variables */
$err = ["", ""];
$email = $password = "";

/* On POST request */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* If the POST has a valid body */
    if (isset($_POST["email"]) || isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        /* If email and/or password were empty */
        if (empty($email)) {
            $err[0] = "You must provide a email";
        }
        if (empty($password)) {
            $err[1] = "You must provide a password";
        }
        /* If There wasn't an error */
        if (empty($err[0]) && empty($err[1])) {
            /* Send SQL query */
            try {
                mysqli_multi_query($conn, "SELECT * FROM user WHERE email='$email' AND password='" . hash("sha256", $password) . "';");
                $result = mysqli_store_result($conn);
                /* If number of returned rows are greater than 1 */
                if (mysqli_num_rows($result) > 0) {
                    /* Save user to session and move to welcome.php */
                    session_start();
                    $_SESSION["user"] = mysqli_fetch_row($result);
                    header("location: welcome.php");
                    exit;
                } else {
                    /* Show that the account could not be found */
                    $err[1] = "Invalid email and/or password";
                }
            } catch (mysqli_sql_exception $e) {
                /* SQL query threw an error */
                $err[1] = "Something went wrong";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSIxMiI+PC9jaXJjbGU+PC9zdmc+">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form-wrapper">
        <h2>Login</h2>
        <p>Enter your credentials to login.</p>
        <form method="post">
            <div class="form-group">
                <input class="form-input" type="text" name="email" placeholder="Email" autocomplete="off"
                    autocapitalize="off" spellcheck="false" <?php echo !empty($email) ? " value=\"" . $email . '"' : "" ?>>
            </div>
            <?php echo !empty($err[0]) ? "<p class=\"form-error\">" . $err[0] . "</p>" : "" ?>
            <div class="form-group">
                <input class="form-input" type="password" name="password" placeholder="Password" autocomplete="off"
                    autocapitalize="off" spellcheck="false" <?php echo !empty($password) ? " value=\"" . $password . '"' : "" ?>>
            </div>
            <?php echo !empty($err[1]) ? "<p class=\"form-error\">" . $err[1] . "</p>" : "" ?>
            <div class="form-group">
                <a class="form-link" href="createaccount.php">Create account</a>
                <button class="form-submit-button" type="submit" value="login">Login</button>
            </div>
        </form>
    </div>
</body>

</html>