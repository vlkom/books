{% extends '/base.tpl' %}
{% from '/plural.tpl' import plural %}
{% block styles %}
{% endblock %}
{% block content %}
<div class="list-group">
	{% for author in authors %}
		<div class="list-group-item list-group-item-action">
			<div class="d-flex w-100 justify-content-between">
				<h5 class="mb-1 w-25"></h5>
				<a href="/author/edit/{{ author.author_id }}" class="link-secondary">
					<small class="text-muted">Изменить</small>
				</a>
			</div>
			<p class="mb-1">{{ author.author_name }}</p>
			<small class="text-muted">
				{{ author.books_count ~ ' ' ~ plural('книга', 'книги', 'книг', author.books_count) }}
			</small>
		</div>
	{% endfor %}
</div>
{% endblock %}
{% block scripts %}
{% endblock %}