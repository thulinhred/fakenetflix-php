<?php
require_once("includes/header.php");

$preview = new PreviewProvider($conn, $userLoggedin);
echo $preview->createPreviewVideo(null);

$containers = new CategoryContainers($conn, $userLoggedin);
echo $containers->showAllCategories(null);
?>
