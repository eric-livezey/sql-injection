<?php
require_once "config.php";

/* Initialize variables */
$err = ["", "", ""];
$menu = "name";
$menu_text = "Enter your name";

/* On POST request */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* If first name and last name are set */
    if (isset($_POST["first_name"]) && isset($_POST["last_name"])) {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        /* If first name was empty */
        if (empty($first_name)) {
            $err[0] = "You must provide your first name";
        }
        /* If there wasn't an error */
        if (empty($err[0]) && empty($err[1]) && empty($err[2])) {
            session_start();
            $_SESSION["first_name"] = $first_name;
            $_SESSION["last_name"] = $last_name;
            $menu = "bday";
            $menu_text = "Enter your birthday and gender";
        }
        /* If year and day are set */
    } else if (isset($_POST["year"]) && isset($_POST["day"])) {
        $menu = "bday";
        $menu_text = "Enter your birthday and gender";
        $year = $_POST["year"];
        $day = $_POST["day"];
        /* If birthday and/or gender were empty */
        if (!isset($_POST["month"]) || empty($day) || empty($year)) {
            $err[0] = "You must provide your birthday";
        }
        if (!isset($_POST["gender"])) {
            $err[1] = "You must provide your gender";
        }
        /* If there wasn't an error */
        if (empty($err[0]) && empty($err[1]) && empty($err[2])) {
            session_start();
            $month = $_POST["month"];
            $gender = $_POST["gender"];
            $_SESSION["dob"] = "$year-$month-$day";
            $_SESSION["gender"] = $gender;
            $menu = "email";
            $menu_text = "Enter your email and password";
        }
        /* If emial, password, and password confirm are set */
    } else if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password_confirm"])) {
        $menu = "email";
        $menu_text = "Enter your email and password";
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password_confirm = $_POST["password_confirm"];
        /* If email and/or password or password confirm were empty */
        if (empty($email)) {
            $err[0] = "You must provide an email";
        }
        if (empty($password)) {
            $err[1] = "You must provide a password";
        } else if (empty($password_confirm)) {
            $err[2] = "Please retype your password";
        } else if ($password != $password_confirm) {
            $err[2] = "Passwords much match";
        }
        /* If there wasn't an error */
        if (empty($err[0]) && empty($err[1]) && empty($err[2])) {
            session_start();
            $first_name = $_SESSION["first_name"];
            $last_name = $_SESSION["last_name"];
            $dob = $_SESSION["dob"];
            $gender = $_SESSION["gender"];
            try {
                $password = hash("sha256", $password);
                mysqli_query($conn, "INSERT INTO user (email, password, first_name, last_name, dob, gender, address) VALUES  (\"$email\", \"$password\", \"$first_name\", \"$last_name\", \"$dob\", \"$gender\", \"Unknown\");");
                session_unset();
                header("location: login.php");
                exit;
            } catch (mysqli_sql_exception $e) {
                $err = "Something went wrong. Try <a href=\"createaccount.php\">re-entering your info.</a>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create an Account</title>
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSIxMiI+PC9jaXJjbGU+PC9zdmc+">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="form-wrapper">
        <h2>Create an Account</h2>
        <p>
            <?php echo $menu_text ?>
        </p>
        <form method="post">
            <div class="form-group">
                <?php
                switch ($menu) {
                    case "name":
                        echo "<input type=\"text\" class=\"form-input\" placeholder=\"First Name\" autocomplete=\"off\" spellcheck=\"false\" name=\"first_name\" autocapitalize=\"none\">";
                        break;
                    case "bday":
                        echo "<select class=\"form-select month-select\" name=\"month\" onchange=\"this.style.color='#202124'\"><option value selected disabled hidden>Month</option><option value=\"1\">January</option><option value=\"2\">February</option><option value=\"3\">March</option><option value=\"4\">April</option><option value=\"5\">May</option><option value=\"6\">June</option><option value=\"7\">July</option><option value=\"8\">August</option><option value=\"9\">September</option><option value=\"10\">October</option><option value=\"11\">November</option><option value=\"12\">December</option></select><input type=\"number\" class=\"form-input day-input\" placeholder=\"Day\" autocomplete=\"off\" spellcheck=\"false\"name=\"day\" autocapitalize=\"none\"><input type=\"number\" class=\"form-input year-input\" placeholder=\"Year\" autocomplete=\"off\" spellcheck=\"false\" name=\"year\" autocapitalize=\"none\">";
                        break;
                    case "email":
                        echo "<input type=\"email\" class=\"form-input\" placeholder=\"Email\" autocomplete=\"off\" spellcheck=\"false\" name=\"email\" autocapitalize=\"none\">";
                        break;
                }
                ?>
            </div>
            <?php echo !empty($err[0]) ? "<p class=\"form-error\">" . $err[0] . "</p>" : "" ?>
            <div class="form-group">
                <?php
                switch ($menu) {
                    case "name":
                        echo "<input type=\"text\" class=\"form-input\" placeholder= \"Last Name (optional)\" autocomplete=\"off\" spellcheck=\"false\" name=\"last_name\" autocapitalize=\"none\">";
                        break;
                    case "bday":
                        echo "<select class=\"form-select\" name=\"gender\" onchange=\"this.style.color='#202124'\"><option value selected disabled hidden>Gender</option><option value=\"male\">Male</option><option value=\"female\">Female</option><option value=\"other\">Other</option></select>";
                        break;
                    case "email":
                        echo "<input type=\"password\" class=\"form-input\" placeholder=\"Password\" autocomplete=\"off\" spellcheck=\"false\" name=\"password\" autocapitalize=\"none\">";
                        break;
                }
                ?>
            </div>
            <?php echo !empty($err[1]) != "" ? "<p class=\"form-error\">" . $err[1] . "</p>" : "" ?>
            <?php echo $menu == "email" ? "<div class=\"form-group\"><input type=\"password\" class=\"form-input\" placeholder=\"Confirm Password\" autocomplete=\"off\" spellcheck=\"false\" name=\"password_confirm\" autocapitalize=\"none\"></div>" : ""; ?>
            <?php echo !empty($err[2]) != "" ? "<p class=\"form-error\">" . $err[2] . "</p>" : "" ?>
            <div class="form-group">
                <a class="form-link" href="login.php">Login</a>
                <button class="form-submit-button" type="submit" value="next">Next</button>
            </div>
        </form>
    </div>
</body>

</html>