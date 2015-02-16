<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// Database
function connect_db() {
	$server = 'localhost'; // this may be an ip address instead
	$user = 'user';
	$pass = 'pass';
	$database = 'gym';
	$connection = new mysqli($server, $user, $pass, $database);

	return $connection;
}

// GET route
$app->get('/', function() use ($app){
	$db = connect_db();
    
    $result = $db->query( 'SELECT id, name, job FROM friends;' );
	while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
		$data[] = $row;
	}

	$app->render('friends.php', array(
			'page_title' => "Your Friends",
			'data' => $data
		)
	);
});


$app->get('/friend/:id', function ($id) use ($app) {
    //Show book identified by $id
    $db = connect_db();

    $result = $db->query( "SELECT id, name, job FROM friends WHERE id = '$id'" );
	while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
		$data[] = $row;
	}
    $app->render('friends.php', array(
			'page_title' => "Your Friends",
			'data' => $data
		)
	);
});

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
