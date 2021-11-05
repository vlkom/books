<?php

namespace Controllers;

use Common\Authors\Authors;
use Common\Books\Books;
use Common\Validator\BookValidator;
use Common\Controller;
use Common\IErrors;

/**
 * Контроллер для страницы редактирования книги
 */
class BookController extends Controller
{
	/**
	 * Construct
	 */
	public function __construct()
	{
		parent::__construct();
		$this->Validator = new BookValidator();
	}

	/**
	 * Страница редактирования
	 */
	public function edit(): void
	{
		$this->setTemplate('book/edit.tpl');
		$bookId = $this->params ? array_pop($this->params) : 0;

		$this->data['book'] = Books::getBookById($bookId);
		$this->data['genres'] = Books::getAllGenres();
		$this->data['authors'] = Authors::getAllAuthors();
		if ($this->data['book']) {
			Books::markSaved($this->data['genres'], (int) $this->data['book']['genre_id']);
			Authors::markSaved($this->data['authors'], $this->data['book']['authorIds']);
		}

		$this->render();
	}

	/**
	 * Сохраняет книгу
	 *
	 * @return void
	 */
	public function save(): void
	{
		$FilterData = $this->Request->postData();
		$bookId = $FilterData->int('bookId');
		$bookName = $FilterData->str('bookName');
		$genreId = $FilterData->int('genreId');
		$publishingYear = $FilterData->int('publishingYear');
		$authorIds = $FilterData->arr('authorIds');
		$saveData = compact('bookId', 'bookName', 'genreId', 'publishingYear', 'authorIds');

		if (!$this->Validator->validate($saveData)) {
			$this->Response->sendJSON([
				'success' => false,
				'validateErrorData' => $this->Validator->getErrorMessage($saveData),
			], IErrors::ERROR_VALIDATION_FAILED);
		}

		if (!Books::saveBook($saveData)) {
			$this->Response->sendJSON(['success' => false], IErrors::ERROR_SAVE);
		}

		$this->Response->sendJSON(['success' => true]);
	}

	/**
	 * Удаляет книгу
	 *
	 * @return void
	 */
	public function delete(): void
	{
		$bookId = $this->Request->postData()->int('bookId');
		if ($bookId && Books::deleteBook($bookId)) {
			$this->Response->sendJSON(['success' => true]);
		}

		$this->Response->sendJSON(['success' => false], IErrors::ERROR_DELETE);
	}
}