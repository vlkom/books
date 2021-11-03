<?php

namespace Common\Books;

use Common\Model;

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
	 * @param int $from Начальное значение для выборки
	 * @return array
	 */
	public static function getNext(int $from): array
	{
		$books = self::db()->fetchAll(
			'SELECT
				b.book_id AS bookId,
				b.book_name AS bookName,
				g.genre
			FROM books b
			INNER JOIN genres g ON b.genre_id = g.genre_id
			WHERE b.book_id > %d
			ORDER BY bookId
			LIMIT %d',
			$from,
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
	 * @param int $from Начальное значение для выборки
	 * @return array
	 */
	public static function getPrevious(int $from): array
	{
		$books = self::db()->fetchAll(
			'SELECT
				b.book_id AS bookId,
				b.book_name AS bookName,
				g.genre
			FROM books b
			INNER JOIN genres g ON b.genre_id = g.genre_id
			WHERE b.book_id < %d
			ORDER BY bookId DESC
			LIMIT %d',
			$from,
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
	 * @return array
	 */
	public static function getLast(): array
	{
		$books = self::db()->fetchAll(
			'SELECT
				b.book_id AS bookId,
				b.book_name AS bookName,
				g.genre
			FROM books b
			INNER JOIN genres g ON b.genre_id = g.genre_id
			ORDER BY bookId DESC
			LIMIT %d',
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
	 * @return array
	 */
	public static function getFirst(): array
	{
		$books = self::db()->fetchAll(
			'SELECT
				b.book_id AS bookId,
				b.book_name AS bookName,
				g.genre
			FROM books b
			INNER JOIN genres g ON b.genre_id = g.genre_id
			ORDER BY bookId
			LIMIT %d',
			self::PACK_SIZE
		);
		if ($books === false) {
			self::triggerError();
		}

		return $books ?: [];
	}
}