<?php

namespace Services;

use Exception;
use mysqli;
use mysqli_result;
use mysqli_stmt;

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
	/** @var int|null Идентификатор последней вставленной записи */
	protected ?int $insertId;

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
	 * Возвращает идентификатор последней вставленной записи
	 *
	 * @return int|null
	 */
	public function getInsertId()
	{
		return $this->insertId;
	}

	/**
	 * Возвращает все записи из выборки
	 *
	 * @param string $query Запрос к БД
	 * @param mixed ...$args
	 * @return array|false
	 */
	public function fetchAll(string $query, ...$args)
	{
		if (!$this->connect()) {
			return false;
		}

		$MySqlResult = $this->connection->query(sprintf($query, ...$args));
		if ($MySqlResult instanceof mysqli_result) {
			return $MySqlResult->fetch_all(MYSQLI_ASSOC);
		}

		$this->error = $this->connection->error;

		return false;
	}

	/**
	 * Возвращает первую запись из выборки
	 *
	 * @param string $query Запрос к БД
	 * @param mixed ...$args
	 * @return array|false
	 */
	public function fetchFirstRow(string $query, ...$args)
	{
		$data = $this->fetchAll($query, ...$args);
		if ($data === false) {
			return false;
		}

		return array_shift($data);
	}

	/**
	 * Возвращает значение первого поля запроса
	 *
	 * @param string $query Запрос к БД
	 * @param mixed ...$args
	 * @return mixed
	 */
	public function fetchFirstField(string $query, ...$args)
	{
		$data = $this->fetchAll($query, ...$args);
		if ($data === false) {
			return false;
		}

		$firstRow = array_shift($data);
		if (!$firstRow) {
			return $firstRow;
		}

		return array_shift($firstRow);
	}

	/**
	 * Выбирает определенный столбец из запроса
	 *
	 * @param string $column Название столбца
	 * @param string $query Запрос к БД
	 * @param mixed ...$args
	 * @return array|false
	 */
	public function fetchColumn(string $column, string $query, ...$args)
	{
		$data = $this->fetchAll($query, ...$args);
		if ($data === false) {
			return false;
		}

		return array_column($data, $column);
	}

	/**
	 * Выполняет запрос к БД, используется для UPDATE, INSERT, DELETE
	 *
	 * @param string $query Запрос к БД
	 * @param mixed ...$args
	 * @return bool
	 */
	public function query(string $query, ...$args): bool
	{
		if (!$this->connect()) {
			return false;
		}

		$stmt = $this->connection->prepare(sprintf($query, ...$args));
		if (!$stmt instanceof mysqli_stmt || !$stmt->execute()) {
			$this->error = $this->connection->error;
			return false;
		}

		$this->insertId = $stmt->insert_id;

		return true;
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
	 * Функция экранирования строки
	 *
	 * @param string $value Экранируемая строка
	 * @return string
	 */
	public function realEscapeString(string $value): string
	{
		if ($this->connect()) {
			return $this->connection->real_escape_string($value);
		}

		return '';
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
			'charset'  => 'utf8',
		];
	}
}