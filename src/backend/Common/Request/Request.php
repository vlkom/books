<?php

namespace Common\Request;

use Common\IErrors;
use Common\Response\Response;

/**
 * Класс обработки входящих запросов
 */
class Request
{
	/** @var array|string Все параметры обращения */
	private $params;
	/** @var string Имя контроллера */
	private string $controller;
	/** @var string Метод вызываемый в контроллере */
	private string $action;
	/** @var array Дополнительные параметры */
	private array $addParams;
	/** @var array Заголовки запроса */
	private array $headers;
	/** @var FilterData Объект с данными GET */
	private FilterData $GetData;
	/** @var FilterData Объект с данными POST */
	private FilterData $PostData;

	/**
	 * Request constructor.
	 */
	public function __construct()
	{
		$this->params = isset($_SERVER['REDIRECT_URL']) && $_SERVER['REDIRECT_URL'] !== $_SERVER['REQUEST_URI']
			? $_SERVER['REDIRECT_URL']
			: $_SERVER['REQUEST_URI'];
		$this->setParams();
		$this->parsingData();
	}

	/**
	 * Устанавливает параметры
	 * (это очень костыльный метод, но не придумал, как по-другому парсить все)
	 *
	 * @return void
	 */
	private function setParams(): void
	{
		$params = explode('/', $this->params);
		$params = array_slice($params, 1);

		if (!$params[count($params) - 1]) {
			array_pop($params);
		}

		$controller = isset($params[0]) && $params[0] ? explode('?', ucfirst($params[0])) : '';
		$this->controller = array_shift($controller);
		$this->action = $params[1] ?? '';
		$this->addParams = array_slice($params, 2);
		$this->headers = array_change_key_case(getallheaders(), CASE_LOWER);
	}

	/**
	 * Парсит данные для запроса с application/json
	 *
	 * @return void
	 */
	private function parsingData(): void
	{
		$postData = $this->getPostData();
		$getData = $_SERVER['REQUEST_METHOD'] !== 'POST' ? $_GET : [];
		$this->PostData = new FilterData(array_change_key_case($postData, CASE_LOWER));
		$this->GetData = new FilterData(array_change_key_case($getData, CASE_LOWER));
	}

	/**
	 * Возвращает данные с POST
	 *
	 * @return array|mixed
	 */
	private function getPostData()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return [];
		}

		$headerContent = $this->headers['content-type'];
		if (strpos($headerContent, 'application/json') === false) {
			return $_POST;
		}

		$input = file_get_contents('php://input');
		$postData = $input ? json_decode($input, true) : [];
		if ($postData === null) {
			(new Response())->sendJSON([], IErrors::ERROR_UNEXPECTED);
		}

		return $postData;
	}

	/**
	 * Возвращает имя контроллера
	 * 
	 * @return string
	 */
	public function getController(): string
	{
		return $this->controller;
	}

	/**
	 * Возвращает имя метода к которому обращаемся в контроллере
	 * 
	 * @return string
	 */
	public function getAction(): string
	{
		return $this->action;
	}

	/**
	 * Возвращает доп параметры
	 * 
	 * @return array
	 */
	public function getAddParams(): array
	{
		return $this->addParams;
	}

	/**
	 * Возвращает значение переданного заголовка запроса
	 * 
	 * @param string $header Ключ заголовка запроса
	 * @return string
	 */
	public function getHeader(string $header): string
	{
		return $this->headers[$header] ?? '';
	}

	/**
	 * Возвращает объект с данными для фильтрации из GET
	 *
	 * @return FilterData
	 */
	public function getData(): FilterData
	{
		return $this->GetData;
	}

	/**
	 * Возвращает объект с данными для фильтрации из POST
	 * 
	 * @return FilterData
	 */
	public function postData(): FilterData
	{
		return $this->PostData;
	}
}