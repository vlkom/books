<!DOCTYPE html>
<html lang="{{ shortLocaleCode }}">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	{% block styles %}{% endblock %}
</head>
<body>
	<div class="container-fluid">
		<div class="card text-center">
			<div class="card-header">
				<ul class="nav nav-tabs card-header-tabs">
					<li class="nav-item">
						<a class="nav-link{{ currentController == 'Bookslist' ? ' active' }}" href="/bookslist">Книги</a>
					</li>
					<li class="nav-item">
						<a class="nav-link{{ currentController == 'Authorslist' ? ' active' }}" href="/authorslist">Авторы</a>
					</li>
					<li class="nav-item">
						<a class="nav-link{{ currentController == 'Book' ? ' active' }}" href="/book/edit">Новая книга</a>
					</li>
					<li class="nav-item">
						<a class="nav-link{{ currentController == 'Author' ? ' active' }}" href="/author/edit">Новый автор</a>
					</li>
				</ul>
			</div>
			<div class="card-body">
				{% block content %}{% endblock %}
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
	<script
			src="https://code.jquery.com/jquery-3.6.0.min.js"
			integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			crossorigin="anonymous"></script>
	{% block scripts %}{% endblock %}
</body>
</html>