<?php
session_start();
require_once 'db_connect.php';

if (isset($_SESSION['user_id'])&&$_SESSION['role']==1) {
    header('Location: add_user_order.php');
} elseif($_SESSION['role']==2) {
    header('Location: admin_order_add.php');
}else{
	header('Location: login.php');
}
exit();
?>
