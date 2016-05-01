<?php
include 'header.php';
?>
    <div class="row">
        <div class="col-md-12">
            <h4 id="title" class="center">Celebrate the most precious events with your friends</h4>

            <h5 id="sub-title" class="center"> Why not wearing the same cover and let the others know</h5>

            <h6 class="center" id="t-text">Change my pic app is your handy buddy to share your events in Facebook and celebrate with your friends the most precious events of your life</h6>

            <?php
                require_once 'campaign/campaign.php';
                $camp = new Campaign();
                $latest = $camp->get_latest_campaigns();

                foreach ($latest as $key => $value) {
            ?>
                <div class="col-md-4">
                    <div class="card">
                        <span class="card-title"> <?= $value['title'] ?> </span>

                        <div class="card-image">
                            <img src=<?=$value['sample']?>>
                        </div>
                        <div class="card-action">
                            <a href="campaign?id=<?= $value['id'] ?>">Check the campaign</a>
                        </div>
                    </div>
                </div>

            <?php
                }
            ?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4 id="title" class="center">Create Your Own Campaign</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <a href="#" class="btn btn-danger" style="margin-left: 36px;">Create Campaign</a>
        </div>
    </div>

<?php
include 'footer.php';
?>
