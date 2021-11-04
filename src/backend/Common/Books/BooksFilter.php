<?php

namespace Common\Books;

use Common\Navigate\Filter;

/**
 * Фильтр для книг
 */
class BooksFilter extends Filter
{
	/**
	 * @inheritDoc
	 */
	public function validate($fieldName): bool
	{
		switch ($fieldName) {
			case 'author_id':
			case 'genre':
			case 'publishing_year':
				return true;
			default:
				return false;
		}
	}
}