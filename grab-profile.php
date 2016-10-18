<?php
    # Autoload the required event vendor files
    require_once __DIR__.'/vendor/autoload.php';
    # Set up the app with default parameters
    $fb = new Facebook\Facebook(['app_id'=>'1317451708266257', 'app_secret'=>'c9040880aa33c4c1bbad64f8e78cc974', 'default_graph_version'=>'v2.8', ]);
    # grab the access token from the session variable before
    $fb->setDefaultAccessToken($_SESSION['fb_access_token']);
    // $fb->setDefaultAccessToken('28EtysHWa2zSLXzA214734127392965');
    try {
        $response = $fb->get('/me?fields=email,name,gender,age_range');
        $userNode = $response->getGraphUser();
    }
    catch (Facebook\Exceptions\FacebookResponseException $e){
        // This will hit if Graph returns error
        echo 'Graph returned an error:'.$e->getMessage();
        exit;
    }
    catch (Facebook\Exceptions\FacebookSDKException $e){
        // This will hit if validation fails
        echo 'Facebook SDF returned an error:'.$e->getMessage();
        exit;
    }
    // Print the user Details
    echo "<br><h1>Welcome,".$userNode->getName()."!</h1><br><br>";
    $image = 'https://graph.facebook.com/'.$userNode->getId().'/picture?width=200';
    echo "<img class='img-portfolio img-responsive img-circle' src='$image'>";
    $min = $userNode->getProperty('age_range')->getProperty('min');
    $max = $userNode->getProperty('age_range')->getProperty('max');
    $gender = ucfirst($userNode->getProperty('gender'));
    if($max !== null and $min !== null){
    	echo '<h3>'.$gender.' | '.$min."-".$max.' years old</h3>';
    }
    else if($max !== null){
    	echo '<h3>'.$gender.' | '.$max.' years old</h3>';
    }
    else if($min !== null){
    	echo '<h3>'.$gender.' | '.$min.' years old</h3>';
    }
    echo '<h3>'.$userNode->getProperty('email').'</h3>';
    echo '<br>';











 ?>
