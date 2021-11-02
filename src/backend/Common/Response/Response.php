<?php

namespace Common\Response;

use Common\IErrors;

/**
 * Класс для ответов
 */
class Response implements IErrors
{
	/**
	 * Response constructor.
	 */
	public function __construct()
	{
		header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
		header('Access-Control-Allow-Headers: Content-Type, X-Launch-Params, Authorization');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
	}

	/**
	 * Отправляет ответ в формате json
	 * 
	 * @param array $responseData Данные для отправки в ответе
	 * @param int $errorCode Ошибка
	 * @return void
	 */
	public function sendJSON(array $responseData = [], int $errorCode = self::ERROR_ZERO): void
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode([
			'data' => $responseData,
			'error_code' => $errorCode,
			'error_message' => self::MESSAGES[$errorCode] ?? '',
		]);
		exit;
	}
}