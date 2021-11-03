<?php

namespace Controllers;

use Common\Books\Books;
use Common\Controller;

/**
 * Контроллер для страницы работ
 */
class BookslistController extends Controller
{
	public function index(): void
	{
		$from = $this->Request->getData()->int('from');
		var_dump(Books::getBooks($from));die();
	}

	public function getList(): void
	{
		$this->Response->sendJSON(['books' => [123, 123, 123]]);
	}
}