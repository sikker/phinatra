Phinatra
========

Phinatra is a lightweight URI router written to be vaguely similar to Sinatra from Ruby. It provides the Controller layer of Model-View-Controller, and can form an MVC application if joined by for instance Doctrine for models and Twig for views. 

Example of usage:
-----------------

	<?php

	require 'vendor/autoload.php';

	use Sikker\Phinatra\Request;
	use Sikker\Phinatra\Response;
	use Sikker\Phinatra\Router\Router;
	use Sikker\Phinatra\Router\RouterException;
	use Sikker\Phinatra\Router\Route;
	use Sikker\Phinatra\Router\Path;

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


