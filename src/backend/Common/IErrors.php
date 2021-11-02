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

	/** Сообщения для ошибок */
	const MESSAGES = [
		self::ERROR_UNEXPECTED => 'Непредвиденная ошибка',
	];
}