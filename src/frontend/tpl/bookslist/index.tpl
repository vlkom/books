{% extends '/base.tpl' %}

{% block content %}
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