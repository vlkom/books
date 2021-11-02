<?php

namespace Services;

use Exception;
use mysqli;
use mysqli_result;

/**
 * Сущность для работы с БД
 *
 * (Можно добавить плейсхолдеры, отладку)
 */
class MySql
{
	/** @var array Массив синглтон объектов */
	private static array $instances = [];

	/** @var string Название БД для подключения */
	protected string $dbName;
	/** @var mysqli|null Подключение к БД */
	protected ?mysqli $connection = null;
	/** @var string Ошибка БД */
	protected string $error = '';

	/** БД по умолчанию */
	const DEFAULT_DB = 'books';

	protected function __construct(string $dbName)
	{
		$this->dbName = $dbName;
	}

	protected function __clone() { }

	/**
	 * Возвращает уже раннее созданный объект
	 *
	 * @throws Exception
	 */
	public function __wakeup()
	{
		throw new Exception('Cannot unserialize a singleton');
	}

	/**
	 * Возвращает уже раннее созданный объект
	 *
	 * @param string $dbName Название БД для подключения
	 * @return self
	 */
	public static function getInstance(string $dbName = self::DEFAULT_DB): self
	{
		if (!isset(self::$instances[$dbName])) {
			self::$instances[$dbName] = new static($dbName);
		}

		return self::$instances[$dbName];
	}

	/**
	 * Возвращает ошибку БД
	 *
	 * @return string
	 */
	public function getError(): string
	{
		return $this->error;
	}

	/**
	 * Возвращает все записи из выборки
	 *
	 * @param string $query Запрос к БД
	 * @return array|false
	 */
	public function fetchAll(string $query)
	{
		if (!$this->connect()) {
			return false;
		}

		$MySqlResult = $this->connection->query($query);
		if ($MySqlResult instanceof mysqli_result) {
			return $MySqlResult->fetch_all(MYSQLI_ASSOC);
		}

		return false;
	}

	/**
	 * Устанавливает соединение с БД
	 *
	 * @return bool
	 */
	private function connect(): bool
	{
		if ($this->connection instanceof mysqli) {
			return true;
		}

		$config = $this->getConfig();
		$this->connection = new mysqli(
			$config['host'],
			$config['user'],
			$config['password'],
			$config['db'],
			$config['port']
		);
		if ($this->connection->connect_error) {
			$this->error = $this->connection->connect_error;
			@$this->connection->close();
			$this->connection = null;

			return false;
		}

		return true;
	}

	/**
	 * Возвращает параметры для подключения к БД
	 * (при нескольких БД это будет отдельным файлом настроек и через связь с переменными окржуния)
	 *
	 * @return array
	 */
	private function getConfig(): array
	{
		return [
			'host'     => 'mysql',
			'port'     => 3306,
			'user'     => 'vlkom',
			'password' => 'books',
			'db'       => 'books',
			'charset'  => 'utf-8',
		];
	}
}