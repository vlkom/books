<?php

namespace Common\Books;

use Common\Navigate\Sort;

/**
 * Класс сортировки для книг
 */
class BooksSort extends Sort
{
	/**
	 * @inheritDoc
	 */
	public function validate($fieldName): bool
	{
		switch ($fieldName) {
			case 'book_name':
			case 'publishing_year':
				return true;
			default:
				return false;
		}
	}
}