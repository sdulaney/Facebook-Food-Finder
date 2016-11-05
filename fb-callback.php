<?php
  date_default_timezone_set('UTC');
  require_once __DIR__ . '/vendor/autoload.php';
  session_start();
  # Set up the app with default parameters
  $fb = new Facebook\Facebook([ 'app_id' => '1317451708266257', 'app_secret' => 'c9040880aa33c4c1bbad64f8e78cc974', 'default_graph_version' => 'v2.8' ]);
  # Create the login helper object
  $helper = $fb->getRedirectLoginHelper();
  # Get the access token and catch the exceptions if there are any
  try {
    $accessToken = $helper->getAccessToken();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
  # If the access token is not set, means we have errors
  if (! isset($accessToken)) {
    if ($helper->getError()) {
      header('HTTP/1.0 401 Unauthorized');
      echo "Error: " . $helper->getError() . "\n";
      echo "Error Code: " . $helper->getErrorCode() . "\n";
      echo "Error Reason: " . $helper->getErrorReason() . "\n";
      echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
      header('HTTP/1.0 400 Bad Request');
      echo 'Bad request';
    }
    exit;
  }
  // Store the access token in a global variable
  $_SESSION['fb_access_token'] = (string) $accessToken;
  // Redirect to the events page
  header('Location: http://localhost:8000/events.php');
?>
