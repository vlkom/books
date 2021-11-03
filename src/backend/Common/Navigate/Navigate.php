<?php

namespace Common\Navigate;

/**
 * Абстрактный класс навигации
 */
abstract class Navigate
{
	/**
	 * Возвращает данные для следующей страницы
	 *
	 * @param int $fromId Идентификатор, ограничивающий выборку
	 * @return array
	 */
	abstract public function getNext(int $fromId): array;

	/**
	 * Возвращает данные для предыдущей страницы
	 *
	 * @param int $fromId Идентификатор, ограничивающий выборку
	 * @return array
	 */
	abstract public function getPrevious(int $fromId): array;

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