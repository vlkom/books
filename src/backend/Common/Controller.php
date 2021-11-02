<?php

namespace Common;

use Common\Request\Request;
use Common\Response\Response;

/**
 * Базовый контроллер
 */
class Controller
{
	/** @var Request Объект Request */
	protected Request $Request;
	/** @var Response Объект Response */
	protected Response $Response;
	/** @var array Массив параметров */
	protected array $params;

	/**
	 * Конструктор
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->Request = new Request();
		$this->Response = new Response();
		$this->params = $this->Request->getAddParams();
	}
}