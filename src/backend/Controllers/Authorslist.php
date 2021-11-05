<?php

namespace Controllers;

use Common\Books\Books;
use Common\Controller;

class AuthorslistController extends Controller
{
	public function index(): void
	{
		$this->setTemplate('authorslist/index.tpl');
		$this->data['authors'] = Books::getBooksCountForAuthors();
		$this->render();
	}
}