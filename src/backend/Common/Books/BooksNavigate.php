<?php

namespace Common\Books;

use Common\Navigate\Navigate;

/**
 * Поставщик книг при навигации
 */
class BooksNavigate extends Navigate
{
	/**
	 * @inheritDoc
	 */
	public function getNext(int $fromId): array
	{
		$books = BooksNavigateModel::getNext($fromId);

		return Books::getStructuredBooks($books);
	}

	/**
	 * @inheritDoc
	 */
	public function getPrevious(int $fromId): array
	{
		$books = BooksNavigateModel::getPrevious($fromId);

		return Books::getStructuredBooks($books);
	}

	/**
	 * @inheritDoc
	 */
	public function getFirst(): array
	{
		$books = BooksNavigateModel::getFirst();

		return Books::getStructuredBooks($books);
	}

	/**
	 * @inheritDoc
	 */
	public function getLast(): array
	{
		$books = BooksNavigateModel::getLast();

		return Books::getStructuredBooks($books);
	}
}