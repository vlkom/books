{% extends '/base.tpl' %}
{% block styles %}
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{% endblock %}
{% block content %}
	<div class="w-100 d-flex flex-column align-items-center">
		<h4 class="mb-4">
			{{ book.book_id ? 'Редактирование книги' : 'Создание книги' }}
		</h4>
		<form class="w-100 needs-validation d-flex flex-column align-items-center" id="form-data" novalidate data-id="{{ book.book_id }}">
			<div class="mb-3 col-3">
				<label for="book-name" class="form-label">Название книги</label>
				<input
					type="text"
					value="{{ book.book_name }}"
					class="form-control"
					id="book-name"
					placeholder="Название книги"
					required
				>
				<div class="invalid-feedback js-invalid-feedback" id="book-name-error">
					Заполните имя (макс. длина 250 символов)
				</div>
			</div>
			<div class="mb-3 col-3">
				<label for="book-year" class="form-label">Год издания</label>
				<input type="number" value="{{ book.publishing_year }}" class="form-control" id="book-year" placeholder="Год издания" required>
				<div class="invalid-feedback js-invalid-feedback" id="book-year-error">
					Заполните год
				</div>
			</div>

			<div class="p-2 col-3">
				<div class="form-label">Авторы</div>
				<label for="id-multiple-authors" class="w-100">
					<select class="js-multiple-authors js-states form-control" id="id-multiple-authors" multiple="multiple" required>
						{% for author in authors %}
							<option value="{{ author.author_id }}"{{ author.selected ? ' selected' }}>{{ author.author_name }}</option>
						{% endfor %}
					</select>
				</label>
				<div class="invalid-feedback js-invalid-feedback" id="book-authors-error">
					Заполните год
				</div>
			</div>

			<div class="p-2 col-3">
				<div class="form-label">Жанр</div>
				<select class="form-select js-genre-list" aria-label="Default select" required>
					{% if not book.book_id %}
						<option disabled selected value></option>
					{% endif %}
					{% for genre in genres %}
						<option value="{{ genre.genre_id }}" {{ genre.selected ? ' selected' }}>
							{{ genre.genre }}
						</option>
					{% endfor %}
				</select>
				<div class="invalid-feedback js-invalid-feedback" id="book-genre-error">
					Выберите жанр
				</div>
			</div>

			<div class="d-flex flex-row justify-content-around w-25">
				{% if book.book_id %}
					<button class="btn btn-primary" id="delete-btn" type="button">Удалить</button>
				{% endif %}
				<button class="btn btn-primary mr-4" type="submit">Сохранить</button>
			</div>
		</form>
	</div>


{% endblock %}
{% block scripts %}
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="/js/book/edit.js"></script>
{% endblock %}