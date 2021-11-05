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

	/** Все типы навигации */
	const ALL_TYPES = [
		self::TYPE_NEXT => 'next',
		self::TYPE_PREVIOUS => 'previous',
		self::TYPE_LAST => 'last',
		self::TYPE_FIRST => 'first',
	];

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
	 * Возвращает уникальный идентификатор для пагинации
	 *
	 * @param array $element Элемент для пагинации
	 * @return int
	 */
	abstract protected function getFromByElement(array $element): int;

	/**
	 * Устанавливает дополнительные параметры в шаблон
	 *
	 * @return void
	 */
	abstract protected function setAdditionalData(): void;

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
		if ($hasContinuation) {
			array_pop($data);
		}

		usort($data, function(array $a, array $b) {
			return $this->checkSortCondition($a, $b);
		});

		$this->data['links'] = $this->getLinksForNavigate($data);
		$this->data['elements'] = $data;
		$this->data['sortList'] = $this->Navigate->Sort->getSortList();
		$this->setActivityLinks($hasContinuation);
		$this->setAdditionalData();

		$this->render();
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

	/**
	 * Возвращает ссылки для навигации
	 *
	 * @param array $data Основные данные для вывода
	 * @return array
	 */
	protected function getLinksForNavigate(array $data): array
	{
		$link = '';
		foreach ($this->Navigate->Filter->getFilteredData() as $filterName => $value) {
			$link .= '&filter_' . $filterName . '=' . str_replace(',', '%2C', $value);
		}

		$sortField = $this->Navigate->Sort->getSortField();
		if ($sortField) {
			$link .= '&sortBy=' . $sortField . '&sortType=' . $this->Navigate->Sort->getSortTypeInt();
		}

		$links = [];
		foreach (self::ALL_TYPES as $navigateType => $navigateName) {
			$links[$navigateName] = '?type=' . $navigateType . $link;

			switch ($navigateType) {
				case self::TYPE_NEXT:
					$needElement = $data[count($data) - 1] ?? [];
					break;
				case self::TYPE_PREVIOUS:
					$needElement = $data[0] ?? [];
					break;
				default:
					$needElement = [];
					break;
			}

			$fromSort = $needElement && $sortField ? $needElement[$sortField] : '';
			if ($fromSort) {
				$links[$navigateName] .= '&fromSort=' . $fromSort;
			}

			$from = $this->getFromByElement($needElement);
			if ($from) {
				$links[$navigateName] .= '&from=' . $from;
			}
		}

		return $links;
	}

	/**
	 * Устанавливает активность ссылкам
	 *
	 * @param bool $hasContinuation Существует ли следующая страница
	 * @return void
	 */
	protected function setActivityLinks(bool $hasContinuation): void
	{
		$navigateType = $this->Request->getData()->int('type');
		switch ($navigateType) {
			case self::TYPE_NEXT:
				$this->data['hasPrevious'] = true;
				$this->data['hasNext'] = $hasContinuation;
				break;
			case self::TYPE_PREVIOUS:
				$this->data['hasNext'] = true;
				$this->data['hasPrevious'] = $hasContinuation;
				break;
			case self::TYPE_LAST:
				$this->data['hasNext'] = false;
				$this->data['hasPrevious'] = $hasContinuation;
				break;
			case self::TYPE_FIRST:
			default:
				$this->data['hasNext'] = $hasContinuation;
				$this->data['hasPrevious'] = false;
				break;
		}

	}
}