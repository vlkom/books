<?php

namespace Controllers;

use Common\Controller;

/**
 * Контроллер для страницы работ
 */
class BookslistController extends Controller
{
	public function getList(): void
	{
		$this->Response->sendJSON(['books' => [123, 123, 123]]);
	}
}