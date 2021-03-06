<?php

use Common\IErrors;
use Common\Request\Request;
use Common\Response\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/Autoloader.php';

Autoloader::register();

require_once __DIR__ . '/../vendor/autoload.php';

$Request = new Request();
$Response = new Response();

$controllerName = $Request->getController();
$path = __DIR__ . DIRECTORY_SEPARATOR;
$controllerPathFile = $path . '/Controllers/' . $Request->getController() . '.php';

if (is_file($controllerPathFile)) {
	require_once($controllerPathFile);

	$action = $Request->getAction() ?: 'index';
	$controllerPath = '\\Controllers\\' . $controllerName . 'Controller';
	try {
		$Controller = new $controllerPath();
		if (
			$Controller instanceof $controllerPath
			&& method_exists($Controller, $action)
		) {
			$Controller->$action();
		}
	} catch (Exception $exception) {
		trigger_error($exception->getMessage());
		$Response->sendJSON([], IErrors::ERROR_UNEXPECTED);
	} catch (Throwable $throwable) {
		trigger_error($throwable->getMessage());
		$Response->sendJSON([], IErrors::ERROR_UNEXPECTED);
	}
}