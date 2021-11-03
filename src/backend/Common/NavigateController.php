<?php

namespace Common;

use Common\Books\BooksNavigateModel;
use Common\Navigate\Navigate;

/**
 * Контроллер навигации
 */
class NavigateController extends Controller
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
		$from = $this->Request->getData()->int('from');
		$navigateType = $this->Request->getData()->int('type');
		switch ($navigateType) {
			case self::TYPE_NEXT:
				$data = $this->Navigate->getNext($from);
				break;
			case self::TYPE_PREVIOUS:
				$data = $this->Navigate->getPrevious($from);
				break;
			case self::TYPE_LAST:
				$data = $this->Navigate->getLast();
				break;
			case self::TYPE_FIRST:
			default:
				$data = $this->Navigate->getFirst();
		}

		$hasContinuation = false;
		if (count($data) === BooksNavigateModel::PACK_SIZE) {
			$hasContinuation = true;
			array_pop($data);
		}

		if ($navigateType === self::TYPE_PREVIOUS) {
			usort($data, function(array $a, array $b) {
				return $this->checkSortCondition($a, $b);
			});
		}

		var_dump($hasContinuation, $data);
	}

	/**
	 * Сравнивает определенные поля при сортировке двумерного массива
	 *
	 * @param array $current Текущий элемент
	 * @param array $next Следующий элемент
	 * @return bool
	 */
	protected function checkSortCondition(array $current, array $next): bool
	{
		return ($current['id'] > $next['id']);
	}
}