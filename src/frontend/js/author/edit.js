const init = () => {
	const deleteBtn = $('#delete-btn');
	if (deleteBtn) {
		deleteBtn.on('click', () => {
			deleteBook();
		});
	}

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
		url: '/author/save',
		type: 'POST',
		data: getData()
	}).done(function(response) {
		if (response.data.success) {
			location.href = '/authorslist';
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

const deleteBook = () => {
	const authorId = $('#form-data').data('id');
	$.ajax({
		url: '/author/delete',
		type: 'POST',
		data: {
			authorId
		}
	}).done(function(response) {
		if (response.data.success) {
			location.href = '/authorslist';
			return;
		}

		alert(response.error_message);
	});
};

const getData = () => {
	let data = {};
	data.authorName = $('#author-name').val();
	data.authorId = $('#form-data').data('id');

	return data;
}

document.addEventListener('DOMContentLoaded', init, false);