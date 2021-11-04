<?php

namespace Common\Validator;

use Common\Authors\AuthorsModel;

/**
 * Валидатор для автора
 */
class AuthorValidator implements IValidator
{
	/**
	 * {@inheritDoc}
	 */
	public function validate($data): bool
	{
		return $data['authorName']
			&& ($data['authorId'] || AuthorsModel::checkUniqueName($data['authorName']));
	}
}