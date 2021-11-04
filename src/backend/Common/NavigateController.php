<?php

namespace Common;

use Common\Books\BooksNavigateModel;
use Common\Navigate\Navigate;

/**
 * Контроллер навигации
 */
abstract class NavigateController extends Controller
{
	/** @var Navigate Поставщик данных при навигации */
	protected Navigate $Navigate;

	/** Тип навигации: следующая страница */
	const TYPE_NEXT = 1;
	/** Тип навигации: предыдущая страница страница */
	const TYPE_PREVIOUS = 2;
	/** Тип навигации: последняя страница */
	const TYPE_LAST = 3;
	/** Тип навигации: первая страница */
	const TYPE_FIRST = 4;

	/**
	 * Сравнивает определенные поля при сортировке двумерного массива
	 *
	 * @param array $current Текущий элемент
	 * @param array $next Следующий элемент
	 * @return bool
	 */
	abstract protected function checkSortCondition(array $current, array $next): bool;

	/**
	 * Получает данные для фильтрации из GET
	 *
	 * @return array
	 */
	abstract protected function getFilteredData(): array;

	/**
	 * Устанавливает сущность для навигации
	 *
	 * @param Navigate $Navigate Поставщик данных при навигации
	 * @return void
	 */
	protected function setNavigate(Navigate $Navigate): void
	{
		$this->Navigate = $Navigate;
	}

	/**
	 * Главная страница
	 */
	public function index(): void
	{
		$GetFilter = $this->Request->getData();
		$this->Navigate->from = $GetFilter->int('from');
		$this->Navigate->fromSort = $GetFilter->str('fromSort');
		$sortType = (bool) $GetFilter->int('sortType');
		$sortField = $GetFilter->str('sortBy');
		$filteredData = $this->getFilteredData();

		$this->Navigate->Sort->setSortType($sortType);
		$this->Navigate->Sort->setField($sortField);
		foreach ($filteredData as $filterName => $filterValue) {
			$this->Navigate->Filter->setField($filterName, $filterValue);
		}

		$data = $this->getData();
		$hasContinuation = $this->hasContinuation($data);

		usort($data, function(array $a, array $b) {
			return $this->checkSortCondition($a, $b);
		});

		var_dump($hasContinuation, $data);
	}

	/**
	 * Возвращает данные
	 *
	 * @return array
	 */
	protected function getData(): array
	{
		$navigateType = $this->Request->getData()->int('type');
		switch ($navigateType) {
			case self::TYPE_NEXT:
				return $this->Navigate->getNext();
			case self::TYPE_PREVIOUS:
				return $this->Navigate->getPrevious();
			case self::TYPE_LAST:
				return $this->Navigate->getLast();
			case self::TYPE_FIRST:
			default:
				return $this->Navigate->getFirst();
		}
	}

	/**
	 * Определяет, существует ли следующая страница
	 *
	 * @param array $data Данные
	 * @return bool
	 */
	protected function hasContinuation(array &$data): bool
	{
		if (count($data) !== BooksNavigateModel::PACK_SIZE) {
			return false;
		}

		array_pop($data);

		return true;
	}
}