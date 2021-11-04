<!DOCTYPE html>
<html lang="{{ shortLocaleCode }}">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	{% block styles %}{% endblock %}
</head>
<body>
	<div class="card text-center">
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs">
				<li class="nav-item">
					<a class="nav-link active" aria-current="true" href="#">Книги</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Авторы</a>
				</li>
				<li class="nav-item">
					<a class="nav-link">Новая книга</a>
				</li>
				<li class="nav-item">
					<a class="nav-link">Новый автор</a>
				</li>
			</ul>
		</div>
		<div class="card-body">
			{% block content %}{% endblock %}
		</div>
	</div>
	{% block scripts %}{% endblock %}
</body>
</html>