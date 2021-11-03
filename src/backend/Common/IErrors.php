<?php

namespace Common;

interface IErrors
{
	/** Код ошибки: ошибки нет */
	const ERROR_ZERO = 0;
	/** Запрашиваемый ресурс не найден */
	const ERROR_NOT_FOUND = 1;
	/** Непредвиденная ошибка */
	const ERROR_UNEXPECTED = 2;

	/** Код ошибки: валидация не пройдена */
	const ERROR_VALIDATION_FAILED = 100;
	/** Код ошибки: ошибка сохранения */
	const ERROR_SAVE = 101;
	/** Код ошибки: ошибка удаления */
	const ERROR_DELETE = 102;

	/** Сообщения для ошибок */
	const MESSAGES = [
		self::ERROR_UNEXPECTED => 'Непредвиденная ошибка',
		self::ERROR_VALIDATION_FAILED => 'Валидация не пройдена',
		self::ERROR_SAVE => 'Ошибка сохранения, попробуйте позже',
		self::ERROR_DELETE => 'Ошибка удаления, попробуйте позже',
	];
}