<?php

namespace Common\Authors;

class Authors
{
	/**
	 * Возвращает всех авторов
	 *
	 * @return array
	 */
	public static function getAllAuthors(): array
	{
		return AuthorsModel::getAllAuthors();
	}

	/**
	 * Возвращает имя автора
	 *
	 * @param int $authorId Идентификатор автора
	 * @return string
	 */
	public static function getAuthorName(int $authorId): string
	{
		return AuthorsModel::getAuthorName($authorId);
	}

	/**
	 * Сохраняет данные автора
	 *
	 * @param array $saveData Данные для сохранения
	 * @return bool
	 */
	public static function saveAuthor(array $saveData): bool
	{
		return AuthorsModel::saveAuthor($saveData);
	}

	/**
	 * Удаляет автора
	 *
	 * @param int $authorId Идентификатор автора
	 * @return bool
	 */
	public static function deleteAuthor(int $authorId): bool
	{
		if (!AuthorsModel::deleteAuthor($authorId)) {
			return false;
		}

		$bookIds = AuthorsModel::getBookIdsByAuthorId($authorId);

		return AuthorsModel::deleteAuthorBooks($authorId, $bookIds);
	}
}