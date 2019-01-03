<?php
	if (!file_exists('../app/Http/Controllers/AdminController.php')) {
		echo "Please first install the Admin dependency.\n";
		exit;
	}

	require('../vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php');
	require('../vendor/laravel/framework/src/Illuminate/Support/Facades/Schema.php');
	require('../vendor/laravel/framework/src/Illuminate/Support/Traits/Macroable.php');
	require('../vendor/laravel/framework/src/Illuminate/Database/Schema/Blueprint.php');

	// Create routes
	$routes = fopen('../routes/web.php', 'a');
	$route_array = array(
		"// Tool functions",
		"Route::get('/tools/{slug}', 'ToolsController@read');",
		"Route::get('/admin/tools/view', 'ToolsController@view_tools');",
		"Route::get('/admin/tools/edit/{post_id}', 'ToolsController@edit_tool');",
		"Route::get('/admin/tools/new', 'ToolsController@new_tool');",
		"Route::post('/admin/tools/create', 'ToolsController@create');",
		"Route::post('/admin/tools/update', 'ToolsController@update');",
		"Route::post('/admin/tools/delete', 'ToolsController@delete');"
	);
	foreach($route_array as $route) {
		fwrite($routes, $route . "\n");
	}
	fclose($routes);

	// Create controller by copying over
	copy(dirname(__FILE__) . '/ToolsController.php', '../app/Http/Controllers/ToolsController.php');

	// Create model by copying over
	copy(dirname(__FILE__) . '/Tool.php', '../app/Tool.php');

	// Create Custom folder if does not exist
	$dir = "../app/Custom";
	if (!file_exists($dir) && !is_dir($dir)) {
	    mkdir($dir);
	}

	// Create helper class
	copy(dirname(__FILE__) . '/ToolHelper.php', $dir . '/ToolHelper.php');

	// Create pages folder if does not exist
	$dir = "../resources/views/pages";
	if (!file_exists($dir) && !is_dir($dir)) {
	    mkdir($dir);
	}

	// Create public views
	copy(dirname(__FILE__) . '/views/view-tool.blade.php', $dir . "/view-tool.blade.php");

	// Create admin folder if does not exist
	$dir = "../resources/views/admin/tools";
	if (!file_exists($dir) && !is_dir($dir)) {
	    mkdir($dir);
	}

	// Create admin views
	copy(dirname(__FILE__) . '/views/view.blade.php', $dir . "/view.blade.php");
	copy(dirname(__FILE__) . '/views/edit.blade.php', $dir . "/edit.blade.php");	
	copy(dirname(__FILE__) . '/views/new.blade.php', $dir . "/new.blade.php");

	// Create modals folder if does not exist
	$dir = "../resources/views/admin/tools/modals";
	if (!file_exists($dir) && !is_dir($dir)) {
	    mkdir($dir);
	}

	// Create modals views
	copy(dirname(__FILE__) . '/views/delete.blade.php', $dir . "/delete.blade.php");

	// Create table
	copy(dirname(__FILE__) . '/2019_01_02_013501_create_tools_table.php', '../database/migrations/2019_01_02_013501_create_tools_table.php');

?>