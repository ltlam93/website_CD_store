<?php
//lay ma md5 : localhost/demo/_md5.php?k=text (text la noi dung can lay ma md5)
$hash = md5($_GET['k']);
echo $hash;
?>