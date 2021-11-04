<?php

namespace Controllers;

use Common\Books\BooksNavigate;
use Common\Navigate\Sort;
use Common\NavigateController;

/**
 * Контроллер для страницы книг
 */
class BookslistController extends NavigateController
{
	public function __construct()
	{
		parent::__construct();
		$this->setNavigate(new BooksNavigate());
	}

	/**
	 * @inheritDoc
	 */
	protected function checkSortCondition(array $current, array $next): bool
	{
		$fieldName = $this->Navigate->Sort->getSortField() ?: 'book_id';

		return $this->Navigate->Sort->getSortType() === Sort::SORT_TYPE_ASC
			? ($current[$fieldName] > $next[$fieldName])
			: ($current[$fieldName] < $next[$fieldName]);
	}

	/**
	 * @inheritDoc
	 */
	protected function getFilteredData(): array
	{
		$GetFilter = $this->Request->getData();
		// С фронта передать для всех фильтров в виде data.join('%2C')
		$genre = $GetFilter->str('filterGenre');
		$publishingYear = $GetFilter->str('filterYear');
		$authorId = $GetFilter->str('filterAuthor');

		return [
			'genre' => $genre,
			'publishing_year' => $publishingYear,
			'author_id' => $authorId,
		];
	}
}