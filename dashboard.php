<?php
session_start();
if (isset($_POST["logout"])) {
    if ($_POST["logout"]) {
        session_unset();
    }
}
if (!isset($_SESSION["user"])) {
    header("location: login.php");
    exit;
}
$user = $_SESSION["user"];
$id = $user[0];
if ($id != 1) {
    header("location: login.php");
    exit;
}
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
        <li class="navbar-item"><a class="navbar-link" href="dashboard.php">Dashboard</a></li>
        <li class="logout-item">
            <form method="post"><button name="logout" value="true" class="navbar-link navbar-logout">Logout</button>
            </form>
        </li>
    </ul>
    <div class="body-container">
        <h1>Dashboard</h1>
        <?php
        require_once "config.php";
        /* Get all users from the database */
        $result = mysqli_query($conn, "SELECT * FROM user;");
        for ($i = 0; $i < mysqli_num_rows($result); $i++) { /* Iterate through each user */
            $row = mysqli_fetch_row($result); 
            /* Output a table representing the user */
            echo "<table><tbody><tr><th>ID</th><td>"
                . $row[0] .
                "<tr><th>Email</th><td>"
                . $row[1] .
                "<tr><th>First Name</th><td>"
                . $row[3] .
                "</td></tr><tr><th>Last Name</th><td>"
                . ($row[4] ? $row[4] : "Unknown") .
                "</td></tr><tr><th>Date of Birth</th><td>"
                . $row[5] .
                "</td></tr><tr><th>Gender</th><td>"
                . $row[6] .
                "</td></tr><tr><th>Salary</th><td>"
                . $row[7] .
                "</td></tr><tr><th>Address</th><td>"
                . $row[8] .
                "</td></tr></tbody></table>";
        }
        ?>
    </div>
</body>