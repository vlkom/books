<?php

namespace Controllers;

use Common\Authors\Authors;
use Common\Books\Books;
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
		$this->setTemplate('bookslist/index.tpl');
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
		$genre = $GetFilter->str('filter_genre');
		$publishingYear = $GetFilter->str('filter_publishing_year');
		$authorId = $GetFilter->str('filter_author_id');

		return [
			'genre' => $genre,
			'publishing_year' => $publishingYear,
			'author_id' => $authorId,
		];
	}

	/**
	 * @inheritDoc
	 */
	protected function getFromByElement(array $element): int
	{
		return $element['book_id'] ?? 0;
	}

	/**
	 * @inheritDoc
	 */
	protected function setAdditionalData(): void
	{
		$this->data['genres'] = Books::getAllGenres();
		$this->data['years'] = Books::getAllYears();
		$this->data['authors'] = Authors::getAllAuthors();
	}
}