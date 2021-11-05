<?php

namespace Common\Authors;

use Common\Model;

class AuthorsModel extends Model
{
	/**
	 * Возвращает всех авторов
	 *
	 * @return array
	 */
	public static function getAllAuthors(): array
	{
		$authors = self::db()->fetchAll(
			'SELECT
				author_id AS author_id,
				author_name AS author_name
			FROM authors'
		);
		if ($authors === false) {
			self::triggerError();
		}

		return $authors ?: [];
	}

	/**
	 * Возвращает имя автора
	 *
	 * @param int $authorId Идентификатор автора
	 * @return string
	 */
	public static function getAuthorName(int $authorId): string
	{
		$name = self::db()->fetchFirstField(
			'SELECT author_name FROM authors WHERE author_id = %d',
			$authorId
		);
		if ($name === false) {
			self::triggerError();
		}

		return $name ?: '';
	}

	/**
	 * Проверяет имя автора на уникальность
	 *
	 * @param string $name Имя автора
	 * @param int $authorId Идентификатор текущего автора
	 * @return bool
	 */
	public static function checkUniqueName(string $name, int $authorId): bool
	{
		return !((bool) self::db()->fetchFirstField(
			'SELECT 1
			FROM authors
			WHERE author_name LIKE ("%s")
			AND author_id != %d',
			$name,
			$authorId
		));
	}

	/**
	 * Сохраняет данные автора
	 *
	 * @param array $saveData Данные для сохранения
	 * @return bool
	 */
	public static function saveAuthor(array $saveData): bool
	{
		if ($saveData['authorId']) {
			$result = self::db()->query(
				'UPDATE authors SET author_name = "%s"
				WHERE author_id = %d',
				$saveData['authorName'],
				$saveData['authorId']
			);
		} else {
			$result = self::db()->query(
				'INSERT INTO authors SET author_name = "%s"',
				$saveData['authorName']
			);
		}

		if (!$result) {
			self::triggerError();
		}

		return $result;
	}

	/**
	 * Удаляет автора
	 *
	 * @param int $authorId Идентификатор автора
	 * @return bool
	 */
	public static function deleteAuthor(int $authorId): bool
	{
		return self::db()->query(
			'DELETE FROM authors WHERE author_id = %d',
			$authorId
		);
	}

	/**
	 * Удаляет соотношение автора и книг
	 *
	 * @param int $authorId Идентификатор автора
	 * @param array $bookids Идентификаторы книг
	 * @return bool
	 */
	public static function deleteAuthorBooks(int $authorId, array $bookids): bool
	{
		if (!$bookids) {
			return true;
		}

		return self::db()->query(
			'DELETE FROM books_authors WHERE author_id = %d AND book_id IN (%s)',
			$authorId, implode(',', $bookids)
		);
	}

	/**
	 * Возвращает идентификаторы книг по идентификатору автора
	 *
	 * @param int $authorId Идентификатор автора
	 * @return array
	 */
	public static function getBookIdsByAuthorId(int $authorId): array
	{
		$bookIds = self::db()->fetchColumn(
			'bookId',
			'SELECT
				book_id AS bookId
			FROM books_authors
			WHERE author_id = %d',
			$authorId
		);
		if ($bookIds === false) {
			self::triggerError();
		}

		return $bookIds ?: [];
	}
}