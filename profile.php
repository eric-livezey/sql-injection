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
$dob = $user[5];
$gender = $user[6];
$salary = $user[7];
$address = $user[8];
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
        <h1>Profile</h1>
        <table>
            <tbody>
                <tr>
                    <th>First Name</th>
                    <td>
                        <?php echo $first_name ?>
                    </td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td>
                        <?php echo $last_name ? $last_name : "Unknown" ?>
                    </td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td>
                        <?php echo $dob ?>
                    </td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>
                        <?php echo $gender ?>
                    </td>
                </tr>
                <tr>
                    <th>Salary</th>
                    <td>
                        <?php echo $salary ?>
                    </td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>
                        <?php echo $address ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>