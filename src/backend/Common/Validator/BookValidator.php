<?php

namespace Common\Validator;

use Common\Books\BooksModel;

/**
 * Валидатор для книг
 */
class BookValidator implements IValidator, IValidatorMessage
{
	/** Максимальная длина названия книги */
	const MAX_LENGTH_NAME = 250;

	/**
	 * {@inheritDoc}
	 */
	public function validate($data): bool
	{
		return $data['authorIds']
			&& $data['bookName']
			&& $data['genreId']
			&& strlen($data['bookName']) <= self::MAX_LENGTH_NAME
			&& $data['publishingYear'] <= ((int) date('Y'))
			&& BooksModel::checkUniqueName($data['bookName'], $data['bookId']);
	}

	/**
	 * @inheritDoc
	 */
	public function getErrorMessage($data): array
	{
		$message = '';
		$id = '';

		if (!$data['bookName']) {
			$message = 'Заполните название книги';
			$id = 'book-name-error';
		}

		if (!$data['genreId']) {
			$message = 'Выберите жанр';
			$id = 'book-genre-error';
		}

		if (!$data['authorIds']) {
			$message = 'Выберите автора';
			$id = 'book-authors-error';
		}

		if (strlen($data['bookName']) > self::MAX_LENGTH_NAME) {
			$message = 'Слишком длинное название';
			$id = 'book-name-error';
		}

		if ($data['publishingYear'] > ((int) date('Y'))) {
			$message = 'Год больше текущего';
			$id = 'book-year-error';
		}

		if (!BooksModel::checkUniqueName($data['bookName'], $data['bookId'])) {
			$message = 'Такая книга уже существует';
			$id = 'book-name-error';
		}

		return [
			'message' => $message,
			'id' => $id,
		];
	}
}