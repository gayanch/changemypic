<?php
    include 'header.php';

    session_start();

    require_once 'campaign/campaign.php';
    $campaign = new Campaign();

    if (isset($_SESSION['campaign_id'])) {
        $selected_campaign = $campaign->get_campaign_by_id($_SESSION['campaign_id']);
    } else {
        header('Location: index.php');
    }
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '',
            cookie: true,
            xfbml: true,
            version: 'v2.6'
        });

    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "http://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function fb_login() {
        FB.login(function (response) {

            if (response.authResponse) {
                access_token = response.authResponse.accessToken;
                user_id = response.authResponse.userID;
                getData();

            } else {
                console.log('User cancelled login or did not fully authorize.');

            }
        }, {
            scope: 'public_profile,email,publish_actions'
        });
    }

    function getData() {
        FB.api('/me', {locale: 'en_US', fields: 'name, email'}, function (response) {

        $('#profileImage').hide();
        $('#imgcontainer').css('padding-top', '80px');
        $('#loader').show();
        $.ajax({
            type: 'post',
            url: 'process.php',
            data: {
                image: 'http://graph.facebook.com/' + response.id + '/picture?width=720&height=720',
                uid: response.id
            },
            success: function (s) {
                if (s) {
                    $('#loader').hide();
                    $('#imgcontainer').css('padding-top', '0px');
                    $('#profileImage').show();
                    $('#profileImage').attr("src", 'profileImgs/' + response.id + '/customImgs.jpg');
                    $('#fbBtn span').html("Share");
                }
            }

        });

        //saving user data into database
        $.ajax({
            url: "save_user.php",
            type: "post",
            data: {'id': response.id, 'name': response.name, 'email': response.email}
        });
        });
    }


    function uploadPhoto() {
        $('#fbBtn').addClass('disabled');
        $('#status').html("<img src='img/progress_bar.gif'>")
        $.ajax({
            url: 'share_photo.php',
            type: 'POST',
            data: {
                source: 'profileImgs/' + user_id + '/customImgs.jpg',
                message: 'fgjfg',
                access_token: access_token
            },
            success: function (s) {
                if(s) {
                    $('#fbBtn').removeClass('disabled');
                    $('#status').html("Your photo successfully uploaded");

                }
            }
        });
    }

</script>


<h4 class="center blue-text"> <?= $selected_campaign['title'] ?> </h4>
<h6 class="center blue-text text-lighten-1"> <?= $selected_campaign['description'] ?> </h6>

<div id="imgcontainer">
    <img src=<?= $selected_campaign['sample'] ?> id="profileImage">
    <div class="cssload-thecube" id="loader">
        <div class="cssload-cube cssload-c1"></div>
        <div class="cssload-cube cssload-c2"></div>
        <div class="cssload-cube cssload-c4"></div>
        <div class="cssload-cube cssload-c3"></div>
    </div>
</div>


<button class="btn btn-large  indigo darken-3"  id="fbBtn">
    <i class="fa fa-facebook" aria-hidden="true"></i> <span>Login</span>
</button>
<span id="status" class="center"></span>

<?php
include 'footer.php'
?>

<script>
    $(document).ready(function(){
        $("#fbBtn").click(function(){
            if($("#fbBtn span").html()=="Login"){
                fb_login();
            }else{
                uploadPhoto();
            }
        })
    })
</script>
