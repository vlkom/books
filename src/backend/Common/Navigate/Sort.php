<?php

namespace Common\Navigate;

use Common\Validator\IValidator;

/**
 * Абстрактный класс для сортировки
 */
abstract class Sort implements IValidator
{
	/** @var string Тип сортировки */
	private string $sortType = self::SORT_TYPE_ASC;
	/** @var string Поле для сортировки */
	private string $sortField = '';

	/** Тип сортировки: сортировка по возрастанию */
	const SORT_TYPE_ASC = 'ASC';
	/** Тип сортировки: сортировка по убыванию */
	const SORT_TYPE_DESC = 'DESC';

	/**
	 * Устанавливает поле для сортировки
	 *
	 * @param string $fieldName Название поля
	 * @return void
	 */
	public function setField(string $fieldName): void
	{
		if ($this->validate($fieldName)) {
			$this->sortField = $fieldName;
		}
	}

	/**
	 * Возвращает поля для сортировки для вставки в запрос
	 *
	 * @return string
	 */
	public function getSortField(): string
	{
		return $this->sortField;
	}

	/**
	 * Устанавливает тип сортировки
	 *
	 * @param bool $sortDesc Флаг сортировки по убыванию
	 * @return void
	 */
	public function setSortType(bool $sortDesc): void
	{
		$this->sortType = $sortDesc ? self::SORT_TYPE_DESC : self::SORT_TYPE_ASC;
	}

	/**
	 * Возвращает тип сортировки в числовом виде
	 *
	 * @return int
	 */
	public function getSortTypeInt(): int
	{
		return (int) ($this->sortType === self::SORT_TYPE_DESC);
	}

	/**
	 * Возвращает тип сортировки
	 *
	 * @return string
	 */
	public function getSortType(): string
	{
		return $this->sortType;
	}

	/**
	 * Возвращает обратный текущему тип сортировки
	 *
	 * @return string
	 */
	public function getReverseSortType(): string
	{
		return $this->sortType === self::SORT_TYPE_ASC
			? self::SORT_TYPE_DESC
			: self::SORT_TYPE_ASC;
	}
}