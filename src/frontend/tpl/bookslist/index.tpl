{% extends '/base.tpl' %}
{% block styles %}
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{% endblock %}
{% block content %}
	<div class="row mb-2">
		<label for="id-multiple-authors" class="p-2 col-3">
			<select class="js-multiple-authors js-states form-control" id="id-multiple-authors" multiple="multiple">
				{% for author in authors %}
					<option value="{{ author.author_id }}"{{ author.selected ? ' selected' }}>{{ author.author_name }}</option>
				{% endfor %}
			</select>
		</label>
		<label for="id-multiple-genres" class="p-2 col-3">
			<select class="js-multiple-genres js-states form-control" id="id-multiple-genres" multiple="multiple">
				{% for genre in genres %}
					<option value="{{ genre.genre_id }}"{{ genre.selected ? ' selected' }}>{{ genre.genre }}</option>
				{% endfor %}
			</select>
		</label>
		<label for="id-multiple-years" class="p-2 col-3">
			<select class="js-multiple-years js-states form-control" id="id-multiple-years" multiple="multiple">
				{% for year in years %}
					<option value="{{ year.publishing_year }}"{{ year.selected ? ' selected' }}>{{ year.publishing_year }}</option>
				{% endfor %}
			</select>
		</label>
		<div class="p-2 col-3">
			<select class="form-select" aria-label="Default select example">
				<option selected>Выбрать сортировку></option>
				<option value="1">По возрастанию года</option>
				<option value="2">По убыванию года</option>
				<option value="3">По названию (а-я)</option>
				<option value="3">По названию (я-а)</option>
			</select>
		</div>
	</div>

	<div class="list-group">
		{% for book in elements %}
			<a href="#" class="list-group-item list-group-item-action">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">{{ book.book_name }}</h5>
					<small class="text-muted">Изменить</small>
				</div>
				<p class="mb-1">{{ book.authors }}</p>
				<small class="text-muted">{{ book.genre }}, ({{ book.publishing_year }})</small>
			</a>
		{% endfor %}
	</div>

	<nav aria-label="Page navigation example">
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
	<script
		src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
		integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="/js/bookslist/index.js"></script>
{% endblock %}