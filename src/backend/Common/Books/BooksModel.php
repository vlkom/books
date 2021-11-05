<?php

namespace Common\Books;

use Common\Model;

/**
 * Модель для работы с книгами
 */
class BooksModel extends Model
{
	/**
	 * Возвращает авторов по идентификаторам книг
	 *
	 * @param array $bookIds Идентификаторы книг
	 * @return array
	 */
	public static function getAuthorsByAuthorsIds(array $bookIds): array
	{
		if (!$bookIds) {
			return [];
		}

		$authors = self::db()->fetchAll(
			'SELECT
				ba.book_id,
				ba.author_id,
				a.author_name
			FROM books_authors ba
			INNER JOIN authors a ON ba.author_id = a.author_id
			WHERE ba.author_id IN (%s)',
			implode(',', $bookIds)
		);
		if ($authors === false) {
			self::triggerError();
		}

		return $authors ?: [];
	}

	/**
	 * Возвращает авторов по идентификатору книги
	 *
	 * @param int $bookId Идентификатор книги
	 * @return array
	 */
	public static function getAuthorsByBookId(int $bookId): array
	{
		if (!$bookId) {
			return [];
		}

		$authors = self::db()->fetchAll(
			'SELECT
				ba.book_id,
				ba.author_id,
				a.author_name
			FROM books_authors ba
			INNER JOIN authors a ON ba.author_id = a.author_id
			WHERE book_id = %d',
			$bookId,
		);
		if ($authors === false) {
			self::triggerError();
		}

		return $authors ?: [];
	}

	/**
	 * Возвращает авторов по идентификатору книги
	 *
	 * @param int $bookId Идентификатор книги
	 * @return array
	 */
	public static function getAuthorIdsByBookId(int $bookId): array
	{
		$authors = self::db()->fetchColumn(
			'authorId',
			'SELECT
				author_id AS authorId
			FROM books_authors
			WHERE book_id = %d',
			$bookId
		);
		if ($authors === false) {
			self::triggerError();
		}

		return $authors ?: [];
	}

	/**
	 * Получение данных книги по ее идентификатору
	 *
	 * @param int $bookId Идентификатор книги
	 * @return array
	 */
	public static function getBookById(int $bookId): array
	{
		$book = self::db()->fetchFirstRow(
			'SELECT
				b.book_id,
				b.book_name,
				b.publishing_year,
				g.genre,
				g.genre_id
			FROM books b
			INNER JOIN genres g ON b.genre_id = g.genre_id
			WHERE b.book_id = %d',
			$bookId
		);
		if ($book === false) {
			self::triggerError();
		}

		return $book ?: [];
	}

	/**
	 * Возвращает количество книг для авторов
	 *
	 * @return array
	 */
	public static function getBooksCountForAuthors(): array
	{
		$authorsCount = self::db()->fetchAll(
			'SELECT
				a.author_name,
				a.author_id,
				COUNT(ba.book_id) AS books_count
			FROM authors a
			LEFT JOIN books_authors ba ON ba.author_id = a.author_id
			GROUP BY a.author_id'
		);
		if (!$authorsCount) {
			self::triggerError();
		}

		return $authorsCount ?: [];
	}

	/**
	 * Получает все существующие жанры
	 *
	 * @return array
	 */
	public static function getAllGenres(): array
	{
		$genres = self::db()->fetchAll(
			'SELECT
				genre_id AS genre_id,
				genre
			FROM genres'
		);
		if ($genres === false) {
			self::triggerError();
		}

		return $genres ?: [];
	}

	/**
	 * Проверяет название на уникальность
	 *
	 * @param string $name Название
	 * @param int $bookId Идентификатор текущей книги
	 * @return bool
	 */
	public static function checkUniqueName(string $name, int $bookId): bool
	{
		return !((bool) self::db()->fetchFirstField(
			'SELECT 1
			FROM books
			WHERE book_name LIKE ("%s")
			AND book_id != %d',
			$name,
			$bookId
		));
	}

	/**
	 * Сохраняет основную информацию по книге
	 *
	 * @param array $saveData Данные для сохранения
	 * @return int
	 */
	public static function saveBookData(array $saveData): int
	{
		if ($saveData['bookId']) {
			$result = self::db()->query(
				'UPDATE books
				SET book_name = "%s", genre_id = %d, publishing_year = %d
				WHERE book_id = %d',
				$saveData['bookName'], $saveData['genreId'], $saveData['publishingYear'],
				$saveData['bookId']
			);
		} else {
			$result = self::db()->query(
				'INSERT INTO books (book_name, genre_id, publishing_year) VALUES ("%s", %d, %d)',
				$saveData['bookName'], $saveData['genreId'], $saveData['publishingYear']
			);
		}

		if (!$result) {
			self::triggerError();

			return 0;
		}

		return $saveData['bookId'] ?: self::db()->getInsertId();
	}

	/**
	 * Сохраняет авторов для книги
	 *
	 * @param int $bookId Идентификатор книги
	 * @param array $authorIds Идентификаторы авторов
	 * @return bool
	 */
	public static function saveBookAuthors(int $bookId, array $authorIds): bool
	{
		$sqlData = '';
		foreach ($authorIds as $authorId) {
			$sqlData .= sprintf('(%d, %d),', $bookId, $authorId);
		}
		$sqlData = mb_substr($sqlData, 0, -1);

		return self::db()->query(
			'INSERT INTO books_authors (book_id, author_id) VALUES %s
			ON DUPLICATE KEY UPDATE book_id = VALUES(book_id), author_id = VALUES(author_id)',
			$sqlData
		);
	}

	/**
	 * Удаляет книгу
	 *
	 * @param int $bookId Идентификатор книги
	 * @return bool
	 */
	public static function deleteBook(int $bookId): bool
	{
		return self::db()->query(
			'DELETE FROM books WHERE book_id = %d',
			$bookId
		);
	}

	/**
	 * Удаляет соотношение книги и авторов
	 *
	 * @param int $bookId Идентификатор книги
	 * @param array $authorsIds Идентификаторы авторов
	 * @return bool
	 */
	public static function deleteBookAuthors(int $bookId, array $authorsIds): bool
	{
		if (!$authorsIds) {
			return true;
		}

		return self::db()->query(
			'DELETE FROM books_authors WHERE book_id = %d AND author_id IN (%s)',
			$bookId, implode(',', $authorsIds)
		);
	}

	/**
	 * Возвращает список всех доступных годов
	 *
	 * @return array
	 */
	public static function getAllYears(): array
	{
		$years = self::db()->fetchAll(
			'SELECT
				publishing_year
			FROM books
			GROUP BY publishing_year
			ORDER BY publishing_year'
		);
		if ($years === false) {
			self::triggerError();
		}

		return $years ?: [];
	}
}