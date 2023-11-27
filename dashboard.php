<?php

session_start();

require_once('util/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

include('util/header.php');

if ($user['type'] == "admin") {
    include('util/dashboard_admin.php');

} else {
    include('util/dashboard_client.php');

}

include('util/footer.php');