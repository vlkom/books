create table books
(
    book_id         int auto_increment comment 'Уникальный идентификатор книги',
    book_name       varchar(255) default ''   not null comment 'Название книги',
    genre_id        int          default 0    not null comment 'Идентификатор жанра книги',
    publishing_year int          default 1900 not null comment 'Год издания',
    constraint books_book_id_uindex
        unique (book_id)
) default charset=utf8
    comment 'Таблица с книгами';

alter table books
    add primary key (book_id);

INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (1, 'Сказка о рыбаке и рыбке', 1, 1835);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (2, 'Руслан и Людмила', 4, 1820);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (3, 'Голодные игры', 3, 2008);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (4, 'На крючке', 5, 2020);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (5, '12 стульев', 2, 1928);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (6, 'Записные книжки', 6, 1961);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (7, 'Для будущего человека', 7, 1929);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (12, 'Страж', 2, 2010);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (13, 'Заклинатели', 8, 2011);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (14, 'Лучезарный', 2, 2007);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (15, 'Талисман', 9, 2005);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (16, 'Оно', 9, 1986);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (17, 'История с привидениями', 9, 1979);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (18, 'Обитель Теней', 9, 1980);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (19, 'Благие знамения', 10, 1990);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (20, 'Мор ученик Смерти', 10, 1987);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (21, 'Зеленая миля', 11, 1996);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (22, 'Бесконечная земля', 12, 2014);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (23, 'Бесконечная война', 12, 2015);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (24, 'Бесконечный Марс', 12, 2017);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (25, 'Яблоки Тьюринга', 7, 2009);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (26, 'Мрачный Жнец', 2, 1991);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (27, 'Крадущийся в тени', 10, 2002);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (28, 'Ловушка для духа', 2, 2014);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (29, 'Основатель', 2, 2009);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (30, 'Американские боги', 10, 2001);
INSERT INTO books.books (book_id, book_name, genre_id, publishing_year) VALUES (31, 'Звездная пыль', 10, 1998);