<?php
Route::get('social/{action?}',array(
	"as" => "hybridauth",
	"uses" => "HybridauthController@auth"
));