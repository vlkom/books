<?php

namespace Common\Validator;

use Common\Books\BooksModel;

/**
 * Валидатор для книг
 */
class BookValidator implements IValidator
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
			&& strlen($data['bookName']) <= self::MAX_LENGTH_NAME
			&& $data['publishingYear'] <= date('Y')
			&& ($data['bookId'] || BooksModel::checkUniqueName($data['bookName']));
	}
}