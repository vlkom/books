<?php

namespace Controllers;

use Common\Books\Books;
use Common\Controller;

class AuthorslistController extends Controller
{
	public static function index(): void
	{
		// todo данные готовы
		var_dump(Books::getBooksCountForAuthors());die();
	}
}