{% extends '/base.tpl' %}
{% block styles %}
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{% endblock %}
{% block content %}
	<div class="row mb-2">
		{% if authors %}
			<div class="p-2 col-3">
				<span>Фильтр по автору</span>
				<label for="id-multiple-authors" class="w-100">
					<select class="js-multiple-authors js-states form-control" id="id-multiple-authors" multiple="multiple">
						{% for author in authors %}
							<option value="{{ author.author_id }}"{{ author.selected ? ' selected' }}>{{ author.author_name }}</option>
						{% endfor %}
					</select>
				</label>
			</div>
		{% endif %}

		{% if genres %}
			<div class="p-2 col-3">
				<span>Фильтр по жанру</span>
				<label for="id-multiple-genres" class="w-100">
					<select class="js-multiple-genres js-states form-control" id="id-multiple-genres" multiple="multiple">
						{% for genre in genres %}
							<option value="{{ genre.genre_id }}"{{ genre.selected ? ' selected' }}>{{ genre.genre }}</option>
						{% endfor %}
					</select>
				</label>
			</div>
		{% endif %}

		{% if years %}
			<div class="p-2 col-3">
				<span>Фильтр по году</span>
				<label for="id-multiple-years" class="w-100">
					<select class="js-multiple-years js-states form-control" id="id-multiple-years" multiple="multiple">
						{% for year in years %}
							<option value="{{ year.publishing_year }}"{{ year.selected ? ' selected' }}>{{ year.publishing_year }}</option>
						{% endfor %}
					</select>
				</label>
			</div>
		{% endif %}

		<div class="p-2 col-3 d-flex">
			<select class="form-select js-sort-list" aria-label="Default select">
				{% for field in sortList %}
					<option data-sort-type="{{ field.sortType }}" data-sort-by="{{ field.sortBy }}"{{ field.selected ? ' selected' }}>
						{{ field.name }}
					</option>
				{% endfor %}
			</select>
		</div>
	</div>

	<div class="list-group">
		{% for book in elements %}
			<div class="list-group-item list-group-item-action">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1 w-25">{{ book.book_name }}</h5>
					<a href="/book/edit/{{ book.book_id }}" class="link-secondary">
						<small class="text-muted">Изменить</small>
					</a>
				</div>
				<p class="mb-1">{{ book.authorsStr }}</p>
				<small class="text-muted">{{ book.genre }}, ({{ book.publishing_year }})</small>
			</div>
		{% endfor %}
	</div>

	<nav aria-label="Page navigation">
		<ul class="pagination justify-content-center">
			<li class="page-item">
				<a class="page-link" href="{{ links.first }}">First</a>
			</li>
			<li class="page-item{{ (not hasPrevious) ? ' disabled' }}">
				<a class="page-link" href="{{ links.previous }}">Previous</a>
			</li>
			<li class="page-item{{ (not hasNext) ? ' disabled' }}">
				<a class="page-link" href="{{ links.next }}">Next</a>
			</li>
			<li class="page-item">
				<a class="page-link" href="{{ links.last }}">Last</a>
			</li>
		</ul>
	</nav>
{% endblock %}
{% block scripts %}
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="/js/bookslist/index.js"></script>
{% endblock %}