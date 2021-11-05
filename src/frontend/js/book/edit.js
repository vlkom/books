const init = () => {
	const authorsFilter = $('.js-multiple-authors');
	if (authorsFilter) {
		authorsFilter.select2();
	}

	submitInit();

	const deleteBtn = $('#delete-btn');
	if (deleteBtn) {
		deleteBtn.on('click', () => {
			deleteBook();
		});
	}
};

const submitInit = () => {
	const forms = document.querySelectorAll('.needs-validation');
	Array.prototype.slice.call(forms)
		.forEach(function (form) {
			form.addEventListener('submit', function (event) {
				const invalidFeedbacks = document.querySelectorAll('.js-invalid-feedback');
				Array.prototype.slice.call(invalidFeedbacks)
					.forEach(function (invalidFeedback) {
						invalidFeedback.classList.add('d-none');
						invalidFeedback.classList.remove('d-block');
					});

				if (!form.checkValidity()) {
					event.preventDefault();
					event.stopPropagation();
				}

				form.classList.add('was-validated');
				event.preventDefault();

				save();

			}, false)
		});
};

const save = () => {
	$.ajax({
		url: '/book/save',
		type: 'POST',
		data: getData()
	}).done(function(response) {
		if (response.data.success) {
			location.href = '/bookslist';
			return;
		}

		if (response.data.validateErrorData) {
			const errorElement = $('#' + response.data.validateErrorData.id);
			if (!errorElement) {
				alert(response.data.validateErrorData.message);

				return;
			}

			errorElement.text(response.data.validateErrorData.message);
			errorElement.addClass('d-block');
			errorElement.removeClass('d-none');

			return;
		}

		alert(response.error_message);
	});
}

const getData = () => {
	let data = {};

	const authorsFilter = $('.js-multiple-authors');
	const authorsData = authorsFilter.select2('data');
	let authorIds = [];
	if (authorsData) {
		authorsData.forEach(author => {
			authorIds.push(author.id);
		});
	}
	data.authorIds = authorIds;
	data.bookName = $('#book-name').val();
	data.publishingYear = $('#book-year').val();
	data.genreId = $('.js-genre-list option:selected').val();
	data.bookId = $('#form-data').data('id');

	return data;
}

const deleteBook = () => {
	const bookId = $('#form-data').data('id');
	$.ajax({
		url: '/book/delete',
		type: 'POST',
		data: {
			bookId
		}
	}).done(function(response) {
		if (response.data.success) {
			location.href = '/bookslist';
			return;
		}

		alert(response.error_message);
	});
};

document.addEventListener('DOMContentLoaded', init, false);