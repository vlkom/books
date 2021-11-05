const initFilter = (filter, fieldName) => {
	if (filter) {
		filter.select2();
		filter.on('change', () => {
			const filterData = filter.select2('data');
			const SearchParams = new URLSearchParams(location.search);
			let filterIds = [];
			if (filterData) {
				filterData.forEach(filterElement => {
					filterIds.push(filterElement.id);
				});
			}
			filterIds = filterIds.join(',');
			if (filterIds) {
				SearchParams.set(fieldName, filterIds);
			} else {
				SearchParams.delete(fieldName);
			}

			const params = SearchParams.toString();
			location.href = params ? location.pathname + '?' + params : location.pathname;
		});
	}
};

const init = () => {
	initFilter($('.js-multiple-authors'), 'filter_author_id');
	initFilter($('.js-multiple-genres'), 'filter_genre_id');
	initFilter($('.js-multiple-years'), 'filter_publishing_year');

	const sortList = $('.js-sort-list');
	if (sortList) {
		sortList.on('change', () => {
			const selectedOption = $('.js-sort-list option:selected');
			const sortBy = selectedOption.data('sortBy');
			const sortType = selectedOption.data('sortType');
			const SearchParams = new URLSearchParams(location.search);
			if (sortBy) {
				SearchParams.set('sortBy', sortBy);
				SearchParams.set('sortType', sortType);
			} else {
				SearchParams.delete('sortBy');
				SearchParams.delete('sortType');
			}

			const params = SearchParams.toString();
			location.href = params ? location.pathname + '?' + params : location.pathname;
		});
	}
};

document.addEventListener('DOMContentLoaded', init, false);