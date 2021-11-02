<?php

/**
 * Класс для автоматического подключения файлов
 */
class Autoloader
{
	/**
	 * Метод запускает авторегистрацию классов
	 *
	 * @return void
	 */
	public static function register(): void
	{
		spl_autoload_register([new self(), 'autoload']);
	}

	/**
	 * Метод загружает файлы классов
	 *
	 * @param string $className Название класса
	 * @return void
	 *
	 */
	public function autoload(string $className): void
	{
		$namespace = $this->getNamespace($className);
		$this->requireFile(__DIR__ . DIRECTORY_SEPARATOR . $namespace . $className . '.php');
	}

	/**
	 * Возвращает неймспейс класса
	 *
	 * @param string $className Название класса
	 * @return string
	 */
	private function getNamespace(string &$className): string
	{
		$className = trim($className, '\\');
		if (strpos($className, '\\') !== false) {
			$pathParts = explode('\\', $className);
			if ($pathParts) {
				$className = array_pop($pathParts);
				return implode(DIRECTORY_SEPARATOR, $pathParts) . DIRECTORY_SEPARATOR;
			}
		}

		return '';
	}

	/**
	 * Подключает файл
	 *
	 * @param string $filePath Путь до подключаемого файла
	 * @return void
	 */
	private function requireFile(string $filePath): void
	{
		if (is_file($filePath)) {
			require_once $filePath;
		}
	}
}