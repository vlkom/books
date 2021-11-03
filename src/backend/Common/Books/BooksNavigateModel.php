<?php

namespace Common\Books;

use Common\Model;

/**
 * Модель для навигации по книгам
 */
class BooksNavigateModel extends Model
{
	/** Размер пачки для выдачи (берем с запасом ) */
	const PACK_SIZE = 11;

	/**
	 * Возвращает данные для пачки книг
	 *
	 * @param int $from Начальное значение для выборки
	 * @param int $limit Ограничение выборки
	 * @return array
	 */
	public static function getBooksPack(int $from, int $limit = self::PACK_SIZE): array
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
			$limit
		);
		if ($books === false) {
			self::triggerError();
		}

		return $books ?: [];
	}
}