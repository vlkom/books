<?php

namespace Common;

use Common\Request\Request;
use Common\Response\Response;
use Common\Validator\IValidator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Базовый контроллер
 */
abstract class Controller
{
	/** @var Request Объект Request */
	protected Request $Request;
	/** @var Response Объект Response */
	protected Response $Response;
	/** @var IValidator Валидатор данных */
	protected IValidator $Validator;
	/** @var array Массив параметров */
	protected array $params;
	/** @var string Путь до шаблона */
	protected string $templatePath;
	/** @var array Данные для шаблона */
	public array $data = [];

	const MOVED_PERMANENTLY = 'HTTP/1.1 301 Moved Permanently';

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
		$this->data['currentController'] = $this->Request->getController();
	}

	/**
	 * Устанавливает шаблон
	 *
	 * @param string $templatePath Путь до шаблона
	 * @return void
	 */
	public function setTemplate(string $templatePath): void
	{
		$this->templatePath = $templatePath;
	}

	/**
	 * Выводит шаблон
	 *
	 * @return void
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 */
	public function render(): void
	{
		$loader = new FilesystemLoader( __DIR__ . '/../../frontend/tpl');
		$twig = new Environment($loader, []);
		$template = $twig->load($this->templatePath);

		echo $template->render($this->data);
	}

	/**
	 * Метод для редиректа по относительной ссылке
	 *
	 * @param string $location URL для редиректа
	 * @param bool $condition Условие по которому произойдет редирект
	 * @param array $addHeaders Массив заголовков для установки
	 * @return void
	 */
	public function redirect(
		string $location,
		bool $condition = true,
		array $addHeaders = [self::MOVED_PERMANENTLY]
	): void
	{
		if (!$condition) {
			return;
		}

		if (!empty($addHeaders)) {
			foreach($addHeaders as $header) {
				header($header);
			}
		}

		header('Location: ' . $location);
		exit;
	}
}