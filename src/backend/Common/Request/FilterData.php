<?php

namespace Common\Request;

use Services\MySql;

/**
 * Фильтр данных
 */
class FilterData
{
	/** @var array Данные для фильтрации */
	protected array $data;

	/**
	 * FilterData constructor.
	 *
	 * @param array $data
	 */
	public function __construct(array $data = [])
	{
		$this->data = $data;
	}

	/**
	 * Возвращает данные по ключу в int
	 *
	 * @param string $key Ключ данных, переданных в конструктор
	 * @return int
	 */
	final public function int(string $key): int
	{
		$key = mb_strtolower($key);

		return isset($this->data[$key]) ? (int) $this->data[$key] : 0;
	}

	/**
	 * Возвращает данные по ключу в string
	 *
	 * @param string $key Ключ данных переданных в конструктор
	 * @param bool $useHtmlSpecialChars Флаг использования htmlspecialchars
	 * @return string
	 */
	final public function str(string $key, bool $useHtmlSpecialChars = true): string
	{
		$key = mb_strtolower($key);

		return isset($this->data[$key]) ? $this->xss((string) $this->data[$key], $useHtmlSpecialChars) : '';
	}

	/**
	 * Возвращает данные по ключу в array
	 *
	 * @param string $key Ключ данных переданных в конструктор
	 * @return array
	 */
	final public function arr(string $key): array
	{
		$key = mb_strtolower($key);

		return isset($this->data[$key]) ? $this->xss($this->data[$key]) : [];
	}

	/**
	 * Метод для получения данных json или array
	 *
	 * @param string $key Ключ данных переданных в конструктор
	 * @return array
	 */
	final public function jsonOrArr(string $key): array
	{
		$key = mb_strtolower($key);
		if (!isset($this->data[$key])) {
			return [];
		}

		return $this->xss(is_string($this->data[$key]) ? json_decode($this->data[$key], true) : $this->data[$key]);
	}

	/**
	 * Метод для обработки от xss и sql уязвимости
	 *
	 * @param string|array $data Данные для обработки
	 * @param bool $useHtmlSpecialChars Флаг использования htmlspecialchars
	 * @return array|string
	 */
	private function xss($data, bool $useHtmlSpecialChars = true)
	{
		if (!is_array($data)) {
			if ($useHtmlSpecialChars) {
				$data = htmlspecialchars($data);
			}

			return MySql::getInstance()->realEscapeString($data);
		}

		$escaped = [];
		foreach ($data as $key => $value) {
			$escaped[$key] = $this->xss($value);
		}

		return $escaped;
	}
}