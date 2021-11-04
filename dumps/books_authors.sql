create table authors
(
    author_id   int auto_increment comment 'Уникальный идентификатор автора',
    author_name varchar(255) default '' not null comment 'Название автора',
    constraint book_authors_author_id_uindex
        unique (author_id),
    constraint book_authors_author_name_uindex
        unique (author_name)
) default charset=utf8
    comment 'Авторы книг';

alter table authors
    add primary key (author_id);

INSERT INTO books.authors (author_id, author_name) VALUES (10, 'Алексей Пехов');
INSERT INTO books.authors (author_id, author_name) VALUES (3, 'Ауд Далсегг');
INSERT INTO books.authors (author_id, author_name) VALUES (6, 'Евгений Петров');
INSERT INTO books.authors (author_id, author_name) VALUES (11, 'Елена Бычкова');
INSERT INTO books.authors (author_id, author_name) VALUES (5, 'Илья Ильф');
INSERT INTO books.authors (author_id, author_name) VALUES (4, 'Ингер Вессе');
INSERT INTO books.authors (author_id, author_name) VALUES (12, 'Наталья Турчанинова');
INSERT INTO books.authors (author_id, author_name) VALUES (16, 'Нил Гейман');
INSERT INTO books.authors (author_id, author_name) VALUES (14, 'Питер Страуб');
INSERT INTO books.authors (author_id, author_name) VALUES (1, 'Пушкин А.C.');
INSERT INTO books.authors (author_id, author_name) VALUES (17, 'Стивен Бакстер');
INSERT INTO books.authors (author_id, author_name) VALUES (13, 'Стивен Кинг');
INSERT INTO books.authors (author_id, author_name) VALUES (2, 'Сьюзен Коллинз');
INSERT INTO books.authors (author_id, author_name) VALUES (15, 'Терри Пратчетт');