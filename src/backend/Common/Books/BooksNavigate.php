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
		return [1]; //todo
	}

	/**
	 * @inheritDoc
	 */
	public function getPrevious(int $fromId): array
	{
		return [2]; //todo
	}

	/**
	 * @inheritDoc
	 */
	public function getFirst(): array
	{
		return [4]; //todo
	}

	/**
	 * @inheritDoc
	 */
	public function getLast(): array
	{
		return [3]; //todo
	}
}