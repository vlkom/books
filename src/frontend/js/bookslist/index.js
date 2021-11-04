const init = () => {
	const authorsFilter = $(".js-multiple-authors");
	const genresFilter = $(".js-multiple-genres");
	const yearsFilter = $(".js-multiple-years");

	authorsFilter.select2();
	genresFilter.select2();
	yearsFilter.select2();

	authorsFilter.on('change', () => {
		const authorsData = authorsFilter.select2('data');
		const SearchParams = new URLSearchParams(location.search);
		let authorIds = [];
		if (authorsData) {
			authorsData.forEach(author => {
				authorIds.push(author.id);
			});
		}
		authorIds = authorIds.join(',');
		SearchParams.set('filter_author_id', authorIds);
		location.href = location.pathname + '?' + SearchParams.toString();
	});

	genresFilter.on('change', () => {
		const genresData = genresFilter.select2('data');
		const SearchParams = new URLSearchParams(location.search);
		let genreIds = [];
		if (genresData) {
			genresData.forEach(genre => {
				genreIds.push(genre.id);
			});
		}
		genreIds = genreIds.join(',');
		SearchParams.set('filter_genre_id', genreIds);
		location.href = location.pathname + '?' + SearchParams.toString();
	});

	yearsFilter.on('change', () => {
		const yearsData = yearsFilter.select2('data');
		const SearchParams = new URLSearchParams(location.search);
		let yearIds = [];
		if (yearsData) {
			yearsData.forEach(year => {
				yearIds.push(year.id);
			});
		}
		yearIds = yearIds.join(',');
		SearchParams.set('filter_publishing_year', yearIds);
		location.href = location.pathname + '?' + SearchParams.toString();
	});
};

document.addEventListener('DOMContentLoaded', init, false);