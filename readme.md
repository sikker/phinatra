Phinatra
========

Phinatra is an exercise in PHP 5.3+ techniques such as namespaces, type hinting and closures, written as a PHP implementation of Sinatra. It provides the Controller segment of Model-View-Controller, and can form an MVC application if joined by, for instance, Doctrine for models and Smarty for views. 

Example of usage:
-----------------

	<?php

	include 'phinatra/bootstrap.php';
	use Phinatra\Request;
	use Phinatra\Response;
	use Phinatra\Router\Router;
	use Phinatra\Router\RouterException;
	use Phinatra\Router\Route;
	use Phinatra\Router\Path;

	$router = new Router(Path::instance());

	$router->attach(new Route('/menu/for/tonight', function(Request $request, Response $response){
		$response->setOutput('Spam, egg, sausage and spam');
		return $response;
	}));

	try {
		$response = $router->route(new Request(Path::instance()), new Response());
	} catch (RouterException $e) {
		$response = new Response();
		$response->setStatusCode(404);
		$response->setOutput( $e->getMessage() );
	}

	$response->handle();


