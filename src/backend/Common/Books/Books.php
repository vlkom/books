<?php

namespace Common\Books;

/**
 * Класс для работы с книгами
 */
class Books
{
	/**
	 * Возвращает структурированные данные для пачки книг
	 *
	 * @param array $books Базовые данные по книгам
	 * @param BooksFilter $Filter Объект фильтра
	 * @return array
	 */
	public static function getStructuredBooks(array $books, BooksFilter $Filter): array
	{
		$authors = BooksModel::getAuthorsByBookIds(array_column($books, 'book_id'), $Filter);
		if (!$authors) {
			return [];
		}

		return self::structureData($books, $authors);
	}

	/**
	 * Получение данных книги по ее идентификатору
	 *
	 * @param int $bookId Идентификатор книги
	 * @return array
	 */
	public static function getBookById(int $bookId): array
	{
		if (!$bookId) {
			return [];
		}

		$book = BooksModel::getBookById($bookId);
		if (!$book) {
			return [];
		}

		$authors = BooksModel::getAuthorsByBookId($book['book_id']);
		if (!$authors) {
			return [];
		}

		$structureBook = self::structureData([$book], $authors);

		return array_shift($structureBook);
	}

	/**
	 * Получает все существующие жанры
	 *
	 * @return array
	 */
	public static function getAllGenres(): array
	{
		return BooksModel::getAllGenres();
	}

	/**
	 * Возвращает количество книг для авторов
	 *
	 * @return array
	 */
	public static function getBooksCountForAuthors(): array
	{
		return BooksModel::getBooksCountForAuthors();
	}

	/**
	 * Сохраняет книгу
	 *
	 * @param array $saveData Данные для сохранения
	 * @return bool
	 */
	public static function saveBook(array $saveData): bool
	{
		$bookId = BooksModel::saveBookData($saveData);
		if (!$bookId) {
			return false;
		}

		$oldAuthors = BooksModel::getAuthorIdsByBookId($bookId);
		$result = BooksModel::saveBookAuthors($bookId, $saveData['authorIds']);
		if ($result && $oldAuthors) {
			$result = BooksModel::deleteBookAuthors($bookId, array_diff($oldAuthors, $saveData['authorIds']));
		}

		return $result;
	}

	/**
	 * Удаляет книгу
	 *
	 * @param int $bookId Идентификатор книги
	 * @return bool
	 */
	public static function deleteBook(int $bookId): bool
	{
		if (!BooksModel::deleteBook($bookId)) {
			return false;
		}

		$authorIds = BooksModel::getAuthorIdsByBookId($bookId);

		return BooksModel::deleteBookAuthors($bookId, $authorIds);
	}

	/**
	 * Структурирует данные
	 *
	 * @param array $books Данные по книгам
	 * @param array $authors Данные по авторам
	 * @return array
	 */
	private static function structureData(array $books, array $authors): array
	{
		foreach ($books as $key => &$book) {
			foreach ($authors as $author) {
				if ($book['book_id'] === $author['book_id']) {
					$book['authors'][] = $author['author_name'];
				}
			}

			if (!isset($book['authors'])) {
				unset($books[$key]);
				continue;
			}

			$book['authors'] = implode(', ', $book['authors']);
		}

		return $books;
	}

	/**
	 * Возвращает список всех доступных годов
	 *
	 * @return array
	 */
	public static function getAllYears(): array
	{
		return BooksModel::getAllYears();
	}
}