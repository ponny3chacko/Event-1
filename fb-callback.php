<?php
if(!session_id()) {
    session_start();
}

require_once __DIR__ . '/requested/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
'app_id' => '292470247797392', // Replace {app-id} with your app id
'app_secret' => 'a2f83a6932d3a19eaa21d3d8d6ccc483',
'default_graph_version' => 'v2.7',
    'default_access_token' => '292470247797392|a2f83a6932d3a19eaa21d3d8d6ccc483',
    'http_client_handler' => 'curl',
    'persistent_data_handler' => 'session'
]);

$helper = $fb->getRedirectLoginHelper();

//echo $_REQUEST['state'];
$_SESSION['FBRLH_state'] = $_REQUEST['state'];

//var_dump($_GET["state"]);
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

// Logged in

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('292470247797392'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
    }

}

$_SESSION['fb_access_token'] = (string) $accessToken;

if(isset($_SESSION['fb_access_token']) && $_SESSION['fb_access_token'] != '')
{
    header('Location: fblogin.php');
}
// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');
?>