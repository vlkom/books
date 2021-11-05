{% extends '/base.tpl' %}
{% block styles %}
{% endblock %}
{% block content %}
<div class="w-100 d-flex flex-column align-items-center">
	<h4 class="mb-4">
		{{ author.author_id ? 'Редактирование автора' : 'Создание автора' }}
	</h4>
	<form class="w-100 needs-validation d-flex flex-column align-items-center" id="form-data" novalidate data-id="{{ author.author_id }}">
		<div class="mb-3 col-3">
			<label for="author-name" class="form-label">Имя автора</label>
			<input
					type="text"
					value="{{ author.author_name }}"
					class="form-control"
					id="author-name"
					placeholder="Имя автора"
					required
			>
			<div class="invalid-feedback js-invalid-feedback" id="author-name-error">
				Заполните имя (макс. длина 250 символов)
			</div>
		</div>

		<div class="d-flex flex-row justify-content-around w-25">
			{% if author.author_id %}
				<button class="btn btn-primary" id="delete-btn" type="button">Удалить</button>
			{% endif %}
			<button class="btn btn-primary mr-4" type="submit">Сохранить</button>
		</div>
	</form>
</div>


{% endblock %}
{% block scripts %}
	<script src="/js/author/edit.js"></script>
{% endblock %}