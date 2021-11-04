<?php

namespace Common\Books;

use Common\Navigate\Navigate;

/**
 * Поставщик книг при навигации
 */
class BooksNavigate extends Navigate
{
	/**
	 * Construct
	 */
	public function __construct()
	{
		$this->Sort = new BooksSort();
		$this->Filter = new BooksFilter();
	}

	/**
	 * @inheritDoc
	 */
	public function getNext(): array
	{
		$books = BooksNavigateModel::getNext($this);

		return Books::getStructuredBooks($books, $this->Filter);
	}

	/**
	 * @inheritDoc
	 */
	public function getPrevious(): array
	{
		$books = BooksNavigateModel::getPrevious($this);

		return Books::getStructuredBooks($books, $this->Filter);
	}

	/**
	 * @inheritDoc
	 */
	public function getFirst(): array
	{
		$books = BooksNavigateModel::getFirst($this);

		return Books::getStructuredBooks($books, $this->Filter);
	}

	/**
	 * @inheritDoc
	 */
	public function getLast(): array
	{
		$books = BooksNavigateModel::getLast($this);

		return Books::getStructuredBooks($books, $this->Filter);
	}
}