<?php

namespace Common\Validator;

use Common\Authors\AuthorsModel;

/**
 * Валидатор для автора
 */
class AuthorValidator implements IValidator, IValidatorMessage
{
	/**
	 * {@inheritDoc}
	 */
	public function validate($data): bool
	{
		return $data['authorName']
			&& AuthorsModel::checkUniqueName($data['authorName'], $data['authorId']);
	}

	/**
	 * @inheritDoc
	 */
	public function getErrorMessage($data): array
	{
		$message = '';
		if (!$data['authorName']) {
			$message = 'Заполните имя автора';
		}

		if (!AuthorsModel::checkUniqueName($data['authorName'], $data['authorId'])) {
			$message = 'Такой автор уже существует';
		}

		return [
			'message' => $message,
			'id' => 'author-name-error'
		];
	}
}