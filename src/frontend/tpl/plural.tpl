{% macro plural(single, plural, plural2, n) %}
	{%- if (n % 10 == 1) and (n % 100 != 11) -%}
		{{ single }}
	{%- elseif (n % 10 >= 2) and (n % 10 <= 4) and (n % 100 < 10 or n % 100 >= 20) -%}
		{{ plural }}
	{%- else -%}
		{{ plural2 }}
	{% endif %}
{% endmacro %}