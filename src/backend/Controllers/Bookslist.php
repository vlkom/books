<?php

namespace Controllers;

use Common\Books\BooksNavigate;
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
		return ($current['bookId'] > $next['bookId']);
	}
}