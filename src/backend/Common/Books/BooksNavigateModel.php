<?php

namespace Common\Books;

use Common\Model;
use Common\Navigate\Sort;

/**
 * Модель для навигации по книгам
 */
class BooksNavigateModel extends Model
{
	/** Размер пачки для выдачи (берем с запасом, чтобы определять доступность следующей и предыдущей страниц) */
	const PACK_SIZE = 11;

	/**
	 * Возвращает данные для следующей пачки книг
	 *
	 * @param BooksNavigate $Navigate Сущность для навигации
	 * @return array
	 */
	public static function getNext(BooksNavigate $Navigate): array
	{
		$sortField = $Navigate->Sort->getSortField();
		$orderBy = $sortField
			? 'ORDER BY ' . $sortField . ' ' . $Navigate->Sort->getSortType()
			: 'ORDER BY b.book_id DESC';
		$sortDirection = $Navigate->Sort->getSortType() === Sort::SORT_TYPE_ASC ? '>' : '<';

		$books = self::db()->fetchAll(
			'SELECT
				b.book_id,
				b.book_name,
				b.publishing_year,
				g.genre
			FROM books b
			INNER JOIN genres g ON b.genre_id = g.genre_id
			%s
			%s
			LIMIT %d',
			self::getWhereCondition($Navigate, $sortDirection),
			$orderBy,
			self::PACK_SIZE
		);
		if ($books === false) {
			self::triggerError();
		}

		return $books ?: [];
	}

	/**
	 * Возвращает данные для предыдущей пачки книг
	 *
	 * @param BooksNavigate $Navigate Сущность для навигации
	 * @return array
	 */
	public static function getPrevious(BooksNavigate $Navigate): array
	{
		$sortField = $Navigate->Sort->getSortField();
		$orderBy = $sortField
			? 'ORDER BY ' . $sortField . ' ' . $Navigate->Sort->getReverseSortType()
			: 'ORDER BY b.book_id DESC';
		$sortDirection = $Navigate->Sort->getSortType() === Sort::SORT_TYPE_ASC ? '<' : '>';

		$books = self::db()->fetchAll(
			'SELECT
				b.book_id,
				b.book_name,
				b.publishing_year,
				g.genre
			FROM books b
			INNER JOIN genres g ON b.genre_id = g.genre_id
			%s
			%s
			LIMIT %d',
			self::getWhereCondition($Navigate, $sortDirection),
			$orderBy,
			self::PACK_SIZE
		);
		if ($books === false) {
			self::triggerError();
		}

		return $books ?: [];
	}

	/**
	 * Возвращает данные для последней пачки книг
	 *
	 * @param BooksNavigate $Navigate Сущность для навигации
	 * @return array
	 */
	public static function getLast(BooksNavigate $Navigate): array
	{
		$sortField = $Navigate->Sort->getSortField();
		$orderBy = $sortField
			? 'ORDER BY ' . $sortField . ' ' . $Navigate->Sort->getReverseSortType()
			: 'ORDER BY b.book_id DESC';

		$books = self::db()->fetchAll(
			'SELECT
				b.book_id,
				b.book_name,
				b.publishing_year,
				g.genre
			FROM books b
			INNER JOIN genres g ON b.genre_id = g.genre_id
			%s
			%s
			LIMIT %d',
			self::getFilterWhere($Navigate, true),
			$orderBy,
			self::PACK_SIZE
		);
		if ($books === false) {
			self::triggerError();
		}

		return $books ?: [];
	}

	/**
	 * Возвращает данные для первой пачки книг
	 *
	 * @param BooksNavigate $Navigate Сущность для навигации
	 * @return array
	 */
	public static function getFirst(BooksNavigate $Navigate): array
	{
		$sortField = $Navigate->Sort->getSortField();
		$orderBy = $sortField
			? 'ORDER BY ' . $sortField . ' ' . $Navigate->Sort->getSortType()
			: 'ORDER BY b.book_id';

		$books = self::db()->fetchAll(
			'SELECT
				b.book_id,
				b.book_name,
				b.publishing_year,
				g.genre
			FROM books b
			INNER JOIN genres g ON b.genre_id = g.genre_id
			%s
			%s
			LIMIT %d',
			self::getFilterWhere($Navigate, true),
			$orderBy,
			self::PACK_SIZE
		);
		if ($books === false) {
			self::triggerError();
		}

		return $books ?: [];
	}

	/**
	 * Возвращает условие для запроса
	 *
	 * @param BooksNavigate $Navigate Сущность для навигации
	 * @param string $sortDirection Направление сортировки
	 * @return string
	 */
	private static function getWhereCondition(BooksNavigate $Navigate, string $sortDirection): string
	{
		$sortField = $Navigate->Sort->getSortField();
		$where = $sortField
			? sprintf(
				'WHERE (b.%s %s %s) OR (b.%s = %s AND b.book_id %s %d)',
				$sortField,
				$sortDirection,
				$Navigate->fromSort,
				$sortField,
				$Navigate->fromSort,
				$sortDirection,
				$Navigate->from
			)
			: sprintf('WHERE b.book_id > %d', $Navigate->from);

		return $where . self::getFilterWhere($Navigate, false);
	}

	/**
	 * Возвращает условие для фильтров
	 *
	 * @param BooksNavigate $Navigate Сущность для навигации
	 * @param bool $newWhere Флаг новое ли условие
	 * @return string
	 */
	private static function getFilterWhere(BooksNavigate $Navigate, bool $newWhere): string
	{
		$filteredWhere = '';
		$filteredData = $Navigate->Filter->getFilteredData();
		if (isset($filteredData['publishing_year'])) {
			$filteredWhere .= $newWhere
				? sprintf('WHERE b.publishing_year IN (%s)', $filteredData['publishing_year'])
				: sprintf(' AND b.publishing_year IN (%s)', $filteredData['publishing_year']);
		}
		if (isset($filteredData['genre'])) {
			$filteredWhere .= $filteredWhere || !$newWhere
				? sprintf(' AND g.genre_id IN (%s)', $filteredData['genre'])
				: sprintf('WHERE g.genre_id IN (%s)', $filteredData['genre']);
		}

		return $filteredWhere;
	}
}