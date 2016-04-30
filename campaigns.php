<?php
    include 'header.php';

    require_once 'campaign/campaign.php';

    $campaign = new Campaign();

    $page = $campaign->get_campaign_list();

    foreach ($page as $key => $value) {
        echo $value['title'].'<br>';
        echo '<img src='.$value['image'].' width=200 height=200>';
    }
?>

<?php
    include 'footer.php';
?>
