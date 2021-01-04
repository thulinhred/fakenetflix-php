<?php
require_once("includes/header.php");

if(!isset($_GET["id"])) {
    ErrorMessage::show("No ID pass into page");
}
$entityId = $_GET['id'];
$entity = new Entity($conn, $entityId);

$preview = new PreviewProvider($conn, $userLoggedin);
echo $preview->createPreviewVideo($entity);

$seasonProvider = new SeasonProvider($conn, $userLoggedin);
echo $seasonProvider->create($entity);

$categoryContainers = new CategoryContainers($conn, $userLoggedin);
echo $categoryContainers->showCategory($entity->getCategoryId()); 
?>