<?php

namespace Common\Validator;

interface IValidatorMessage
{
	/**
	 * Возвращает данные с ошибкой валидации
	 *
	 * @param mixed $data Данные для валидации
	 * @return array
	 */
	public function getErrorMessage($data): array;
}