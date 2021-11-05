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

	/**
	 * @inheritDoc
	 */
	public function getSortList(): array
	{
		return [
			[
				'name' => 'Выбрать сортировку',
				'sortType' => self::SORT_TYPE_NUM_ASC,
				'sortBy' => '',
				'selected' => !$this->sortField
			],
			[
				'name' => 'По возрастанию года',
				'sortType' => self::SORT_TYPE_NUM_ASC,
				'sortBy' => 'publishing_year',
				'selected' => $this->sortField === 'publishing_year' && $this->sortType === self::SORT_TYPE_ASC,
			],
			[
				'name' => 'По убыванию года',
				'sortType' => self::SORT_TYPE_NUM_DESC,
				'sortBy' => 'publishing_year',
				'selected' => $this->sortField === 'publishing_year' && $this->sortType === self::SORT_TYPE_DESC,
			],
			[
				'name' => 'По названию (а-я)',
				'sortType' => self::SORT_TYPE_NUM_ASC,
				'sortBy' => 'book_name',
				'selected' => $this->sortField === 'book_name' && $this->sortType === self::SORT_TYPE_ASC,
			],
			[
				'name' => 'По названию (я-а)',
				'sortType' => self::SORT_TYPE_NUM_DESC,
				'sortBy' => 'book_name',
				'selected' => $this->sortField === 'book_name' && $this->sortType === self::SORT_TYPE_DESC,
			],
		];
	}
}