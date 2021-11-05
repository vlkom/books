<?php

namespace Controllers;

use Common\Authors\Authors;
use Common\Controller;
use Common\IErrors;
use Common\Validator\AuthorValidator;

/**
 * Контроллер для страницы редактирования автора
 */
class AuthorController extends Controller
{

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->Validator = new AuthorValidator();
	}

	/**
	 * Страница редактирования
	 */
	public function edit(): void
	{
		$this->setTemplate('author/edit.tpl');
		$authorId = $this->params ? array_pop($this->params) : 0;
		$authorName = $authorId ? Authors::getAuthorName($authorId) : '';
		$this->data['author'] = [
			'author_id' => $authorName ? $authorId : 0,
			'author_name' => $authorName
		];

		$this->render();
	}

	/**
	 * Сохраняет автора
	 *
	 * @return void
	 */
	public function save(): void
	{
		$Filter = $this->Request->postData();
		$authorId = $Filter->int('authorId');
		$authorName = $Filter->str('authorName');
		$saveData = compact('authorId', 'authorName');
		if (!$this->Validator->validate($saveData)) {
			$this->Response->sendJSON([
				'success' => false,
				'validateErrorData' => $this->Validator->getErrorMessage($saveData),
			], IErrors::ERROR_VALIDATION_FAILED);
		}

		if (!Authors::saveAuthor($saveData)) {
			$this->Response->sendJSON(['success' => false], IErrors::ERROR_SAVE);
		}

		$this->Response->sendJSON(['success' => true]);
	}

	/**
	 * Удаляет автора
	 *
	 * @return void
	 */
	public function delete(): void
	{
		$authorId = $this->Request->postData()->int('authorId');
		if ($authorId && Authors::deleteAuthor($authorId)) {
			$this->Response->sendJSON(['success' => true]);
		}

		$this->Response->sendJSON(['success' => false], IErrors::ERROR_DELETE);
	}
}