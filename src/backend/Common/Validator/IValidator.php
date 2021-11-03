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
	 * @param array $data Данные для валидации
	 * @return bool
	 */
	public function validate(array $data): bool;
}