<?php
session_start();
if (isset($_POST["logout"])) {
    if ($_POST["logout"]) {
        session_unset();
    }
}
if (empty($_SESSION["user"])) {
    header("location: login.php");
    exit;
}
$user = $_SESSION["user"];
$id = $user[0];
$first_name = $user[3];
$last_name = $user[4];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSIxMiIgY3k9IjEyIiByPSIxMiI+PC9jaXJjbGU+PC9zdmc+">
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <ul class="navbar">
        <li class="navbar-item"><a class="navbar-link" href="welcome.php">Welcome</a></li>
        <li class="navbar-item"><a class="navbar-link" href="profile.php">Profile</a></li>
        <?php echo $id == 1 ? "<li class=\"navbar-item\"><a class=\"navbar-link\" href=\"dashboard.php\">Dashboard</a></li>" : "" ?>
        <li class="logout-item">
            <form method="post"><button name="logout" value="true" class="navbar-link navbar-logout">Logout</button>
            </form>
        </li>
    </ul>
    <div class="body-container">
        <h1>Welcome
            <?php echo $first_name . ($last_name ? " " . $last_name : "") ?>
        </h1>
    </div>
</body>