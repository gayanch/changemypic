<?php
session_start();

$uid = $_POST['uid'];

if (!file_exists('profileImgs/'.$uid)) {
    mkdir('profileImgs/'.$uid, 0777, true);
}

$input = $_POST["image"];
$output = 'profileImgs/'.$uid.'/'.$uid.'.jpg';
file_put_contents($output, file_get_contents($input));
//echo "saved";


// randy <- who the fuck is randy?
$img = imagecreatefromjpeg($output);

//cover should be loaded according to campaign id
require_once 'campaign/campaign.php';
$campaign = new Campaign();
$campaign_data = $campaign->get_campaign_by_id($_SESSION['campaign_id']);

$cover = imagecreatefrompng($campaign_data['image']);

imagecopy($img, $cover, 0, 0, 0, 0, imagesx($cover), imagesy($cover));

header('Content-type: image/jpeg');
imagejpeg($img,"profileImgs/".$uid."/customImgs.jpg");
imagedestroy($img);

echo true;
?>
