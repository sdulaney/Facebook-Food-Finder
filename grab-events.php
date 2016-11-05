<?php
  	# Autoload the required vendor files
    require_once __DIR__ . '/vendor/autoload.php';
  	# Set up the app with default parameters
    $fb = new Facebook\Facebook([ 'app_id' => '1317451708266257', 'app_secret' => 'c9040880aa33c4c1bbad64f8e78cc974', 'default_graph_version' => 'v2.8' ]);
	$fb->setDefaultAccessToken($_SESSION['fb_access_token']);
	$request = $fb->request('GET', '/me/events');
	// Send the request to Graph
	try {
	  $response = $fb->getClient()->sendRequest($request);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
      // This will hit if Graph returns error
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
      // This will hit if validation fails
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}
	$graphEdge = $response->getGraphEdge();
	// Print the event Details by looping through each one
	foreach ($graphEdge as $graphNode) {
		try {
			$description = strtolower($graphNode->getField('description'));
			if (strpos($description, 'food') === true or strpos($description, 'free')){
				$event_link = "https://www.facebook.com/events/".$graphNode->getField('id');
				$event = "Event: <a href='$event_link'><span class='acm-cerulean'>".$graphNode->getField('name')."</span></a><br>";
				$location = "Location: <span class='acm-cerulean'>".$graphNode->getField('place')->getField('name')."</span><br>";
				$start = $graphNode->getField('start_time')->format('g:i A');
				// $end = $graphNode->getField('end_time')->format('g:i A');
				// $time = "Time: <span class='acm-cerulean'>".$start."-".$end."</span><br>";
				$time = "Time: <span class='acm-cerulean'>".$start."</span><br>";
				$description = "Description: <span class='acm-jet'>".substr($graphNode->getField('description'), 0, 300)."...</span><br><br>";
				echo "
					<div class='col-md-6 col-md-offset-3'>
                        <div class='portfolio-item event'>
	                    	".$event."
	                    	".$location."
	                    	".$time."
	                    	".$description."
                        </div>
                    </div>
				";
			}
		}
		catch(Facebook\Exceptions\FacebookSDKException $e) {
		  continue;
		}
	}
?>
