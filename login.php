<?php
    # Autoload the required vendor files
    require_once __DIR__ . '/vendor/autoload.php';
    # Set up the app with default parameters
    $fb = new Facebook\Facebook([ 'app_id' => '1317451708266257', 'app_secret' => 'c9040880aa33c4c1bbad64f8e78cc974', 'default_graph_version' => 'v2.8' ]);
    # Create the login helper object
    $helper = $fb->getRedirectLoginHelper();
    // Ask permission to retrieve user's email and events
    $permissions  = ['email', 'user_events'];
    // Redirect to callback which will set everything up
    $loginUrl = $helper->getLoginUrl('http://localhost:8000/fb-callback.php', $permissions);
    // Display clickable button ui
    echo '<button class="btn-transparent"><a href="' . $loginUrl . '"><img src="./img/facebook-login.png" width="300" height="75"/></a></button>';
?>
