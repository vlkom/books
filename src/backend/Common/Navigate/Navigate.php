<?php

namespace Common\Navigate;

/**
 * Абстрактный класс навигации
 */
abstract class Navigate
{
	/** @var Sort Сущность для сортировки */
	public Sort $Sort;
	/** @var Filter Фильтр данных */
	public Filter $Filter;
	/** @var int Идентификатор, ограничивающий выборку */
	public int $from;
	/** @var string Значение сортировки ограничивающее выборку */
	public string $fromSort;

	/**
	 * Возвращает данные для следующей страницы
	 *
	 * @return array
	 */
	abstract public function getNext(): array;

	/**
	 * Возвращает данные для предыдущей страницы
	 *
	 * @return array
	 */
	abstract public function getPrevious(): array;

	/**
	 * Возвращает данные для первой страницы
	 *
	 * @return array
	 */
	abstract public function getFirst(): array;

	/**
	 * Возвращает данные для последней страницы
	 *
	 * @return array
	 */
	abstract public function getLast(): array;
}