<?php

namespace Common;

use Services\MySql;

/**
 * Базовая модель
 */
class Model
{
	/**
	 * Возвращает объект для работы с БД
	 *
	 * @param string $dbName Название БД
	 * @return MySql
	 */
	protected static function db(string $dbName = MySql::DEFAULT_DB): MySql
	{
		return MySql::getInstance($dbName);
	}

	/**
	 * Триггерит ошибку
	 *
	 * @return void
	 */
	protected static function triggerError(): void
	{
		trigger_error('MySql Error: ' . self::db()->getError());
	}
}