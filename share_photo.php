<?php
session_start();
	require_once __DIR__ . '/src/Facebook/autoload.php';

	require_once 'campaign/campaign.php';


	//try {
	$access_token = "";
	if (isset($_POST['access_token'])) {
		$access_token = $_POST['access_token'];
		$_SESSION['fb_access_token'] = (string) $access_token;
	} else {
		die ("No access token provided");
	}

	$source = '';
	if (isset($_POST['source'])) {
		$source = $_POST['source'];
	} else {
		die ('No image provided');
	}

	$message = '';
	if (isset($_POST['message'])) {
		$message = $_POST['message'];
	}

	$fb = new Facebook\Facebook([
	  'app_id' => '',
	  'app_secret' => '',
	  'default_graph_version' => 'v2.6',
	]);

	//getting campaign url to message
	$campaign = new Campaign();
	$detail = $campaign->get_campaign_by_id($_SESSION['campaign_id']);
	$url = $campaign->get_campaign_url($_SESSION['campaign_id']);

	$data = [
		'message' => $detail['title'].'. Created with '.$url,
		'source' => $fb->fileToUpload($source),
	];

	try {
	  // Returns a `Facebook\FacebookResponse` object
	  $response = $fb->post('/me/photos', $data, $access_token);
	  echo "ok";
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}
?>
