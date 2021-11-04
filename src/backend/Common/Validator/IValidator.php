<?php

namespace Common\Validator;

/**
 * Интерфейс валидатора
 */
interface IValidator
{
	/**
	 * Выполняет валидацию
	 *
	 * @param mixed $data Данные для валидации
	 * @return bool
	 */
	public function validate($data): bool;
}