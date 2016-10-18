<?php
    # Autoload the required vendor files
    require_once __DIR__ . '/vendor/autoload.php';    # Set up the app with the default parameters
    $fb = new Facebook\Facebook(['app_id'=>'1317451708266257', 'app_secret'=>'c9040880aa33c4c1bbad64f8e78cc974', 'default_graph_version'=>'v2.8', ]);
    # set up the redirect url
    $redirect = 'http://www.localhost:8000/events.php';
    # Create the login helper object
    $helper = $fb->getRedirectLoginHelper();
    # Get the access token and catch the exceptions if there are any
    try {
        $accessToken = $helper->getAccessToken();
    }
    catch (Facebook\Exceptions\FacebookResponseException $e) {
        // This will hit if Graph returns an error
        echo 'Graph returned an error:'.$e->getMessage();
        Exit;
    }
    catch(Facebook\Exceptions\FacebookSDKException $e){
        // This will hit if the validation fails
        echo 'Facebook SDK returned an error:'.$e->getMessage();
        Exit;
    }
    # If the access token is set, means we have logged in!
    if (isset($accessToken)){
        // Now you can redirect to another page but first let's store the access token
        // in a global variable
        $_SESSION['fb_access_token'] = (string) $accessToken;
    }
    else {
        // we want to be able to retrieve user's email and events
        $permissions = ['email', 'user_events'];
        $loginUrl = $helper->getLoginUrl($redirect, $permissions);
        // we want to create clickable button ui
        echo '<button class="btn-transparent"><a href="' . $loginUrl . '"><img src="./img/facebook-login.png" width="300" height="75"/></a></button>';
    }










 ?>
