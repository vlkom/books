<?php

namespace Common\Navigate;

use Common\Validator\IValidator;

/**
 * Абстрактный фильтр
 */
abstract class Filter implements IValidator
{
	/** @var array Массив полей и их значений для фильтрации */
	protected array $filteredData = [];

	/**
	 * Устанавливает поле для фильтрации
	 *
	 * @param string $field Название поля
	 * @param string $value Значение поля
	 */
	public function setField(string $field, string $value): void
	{
		if ($value && $this->validate($field)) {
			$this->filteredData[$field] = $value;
		}
	}

	/**
	 * Возвращает данные для фильтрации
	 *
	 * @return array
	 */
	public function getFilteredData(): array
	{
		return $this->filteredData;
	}

	/**
	 * Помечает выбранные поля
	 *
	 * @param array $data Данные для выдачи
	 * @param string $checkField Поле для проверки
	 */
	public function markSelectedFields(array &$data, string $checkField): void
	{
		if (!isset($this->filteredData[$checkField])) {
			return;
		}

		$filteredAuthorIds = explode(',', $this->filteredData[$checkField]);
		foreach ($data as &$element) {
			if ($filteredAuthorIds && in_array($element[$checkField], $filteredAuthorIds)) {
				$element['selected'] = true;
			}
		}
	}
}