<?php
	if (!file_exists('../app/Http/Controllers/Auth/RegisterController.php')) {
		echo "Please first install Users using the in-built Laravel function.\n";
		exit;
	}

	require('../vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php');
	require('../vendor/laravel/framework/src/Illuminate/Support/Facades/Schema.php');
	require('../vendor/laravel/framework/src/Illuminate/Support/Traits/Macroable.php');
	require('../vendor/laravel/framework/src/Illuminate/Database/Schema/Blueprint.php');

	// Create routes
	$routes = fopen('../routes/web.php', 'a');
	$route_array = array(
		"// Premium Content functions",
		"Route::get('/members/premium/{content_id}', 'PremiumContentController@read');",
		"Route::get('/admin/premium/view', 'PremiumContentController@view_premium_content');",
		"Route::get('/admin/premium/edit/{post_id}', 'PremiumContentController@edit_premium_content');",
		"Route::get('/admin/premium/new', 'PremiumContentController@new_premium_content');",
		"Route::post('/admin/premium/create', 'PremiumContentController@create');",
		"Route::post('/admin/premium/update', 'PremiumContentController@update');",
		"Route::post('/admin/premium/delete', 'PremiumContentController@delete');"
	);

	// Write to routes.php
	fwrite($routes, "\n");
	foreach($route_array as $route) {
		fwrite($routes, $route . "\n");
	}
	fclose($routes);

	// Create controller by copying over
	copy(dirname(__FILE__) . '/PremiumContentController.php', '../app/Http/Controllers/PremiumContentController.php');

	// Create model by copying over
	copy(dirname(__FILE__) . '/PremiumContent.php', '../app/PremiumContent.php');

	// Create Custom folder if does not exist
	$dir = "../app/Custom";
	if (!file_exists($dir) && !is_dir($dir)) {
	    mkdir($dir);
	}

	// Create helper class
	copy(dirname(__FILE__) . '/PremiumContentHelper.php', $dir . '/PremiumContentHelper.php');

	// Create pages folder if does not exist
	$dir = "../resources/views/pages";
	if (!file_exists($dir) && !is_dir($dir)) {
	    mkdir($dir);
	}

	// Create public views
	copy(dirname(__FILE__) . '/views/view-premium-content.blade.php', $dir . "/view-premium-content.blade.php");

	// Create admin folder if does not exist
	$dir = "../resources/views/admin/premium-content";
	if (!file_exists($dir) && !is_dir($dir)) {
	    mkdir($dir);
	}

	// Create admin views
	copy(dirname(__FILE__) . '/views/view.blade.php', $dir . "/view.blade.php");
	copy(dirname(__FILE__) . '/views/edit.blade.php', $dir . "/edit.blade.php");	
	copy(dirname(__FILE__) . '/views/new.blade.php', $dir . "/new.blade.php");

	// Create modals folder if does not exist
	$dir = "../resources/views/admin/premium-content/modals";
	if (!file_exists($dir) && !is_dir($dir)) {
	    mkdir($dir);
	}

	// Create modals views
	copy(dirname(__FILE__) . '/views/delete.blade.php', $dir . "/delete.blade.php");

	// Create table
	copy(dirname(__FILE__) . '/2018_12_29_103740_create_premium_content_table.php', '../database/migrations/2018_12_29_103740_create_premium_content_table.php');

?>