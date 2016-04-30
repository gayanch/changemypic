<?php
	/* this file acts as the campaign selector.
	 * extracts the campaign_id for url parameter and put it in the session
	 * if no id is provided, user will be redirected to home,
	 * otherwise, redirect to app.php
	 * And also checks whether campaign is valid one.
	 */

	session_start();

	require_once 'campaign.php';

	if (isset($_GET['id'])) {

		//check for campaigns availability
		$campaign = new Campaign();
		if ($campaign->is_campaign_available($_GET['id'])) {
			$_SESSION['campaign_id'] = $_GET['id'];
			header('Location: ../app.php');
		} else {
			//campaing not available, return to home (or somewhere else?)
			header('Location: ../');
		}		
	} else {
		header('Location: ../');
	}
?>
