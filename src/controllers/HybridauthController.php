<?php namespace Angel\Hybridauth;

use App, View, Config, Hybrid_Auth, Hybrid_Endpoint;

class HybridauthController extends \BaseController {
	function auth($action = NULL) {
		// check URL segment
		if ($action == "auth") {
			// process authentication
			try {
				Hybrid_Endpoint::process();
			}
			catch (Exception $e) {
				// redirect back to 'hybridauth' route (/social)
				return Redirect::route('hybridauth');
			}
			return;
		}
		try {
			// create a HybridAuth object
			$socialAuth = new Hybrid_Auth(Config::get('hybridauth::config'));
			// authenticate with Google
			$provider = $socialAuth->authenticate("facebook");
			// fetch user profile
			$userProfile = $provider->getUserProfile();
		}
		catch(Exception $e) {
			// exception codes can be found on HybBridAuth's web site
			return $e->getMessage();
		}
		// access user profile data
		echo "Connected with: <b>{$provider->id}</b><br />";
		echo "As: <b>{$userProfile->displayName}</b><br />";
		echo "<pre>" . print_r( $userProfile, true ) . "</pre><br />";
	
		// logout
		$provider->logout();
	}
}