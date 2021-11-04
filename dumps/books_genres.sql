create table genres
(
    genre_id int auto_increment comment 'Уникальный идентификатор жанра',
    genre    varchar(255) default '' not null comment 'Название жанра',
    constraint genres_genre_id_uindex
        unique (genre_id)
)
    comment 'Жанры для книг';

alter table genres
    add primary key (genre_id);

INSERT INTO books.genres (genre_id, genre) VALUES (1, 'Сказка');
INSERT INTO books.genres (genre_id, genre) VALUES (2, 'Роман');
INSERT INTO books.genres (genre_id, genre) VALUES (3, 'Антиутопия');
INSERT INTO books.genres (genre_id, genre) VALUES (4, 'Поэма');
INSERT INTO books.genres (genre_id, genre) VALUES (5, 'Нехудожественная литература');
INSERT INTO books.genres (genre_id, genre) VALUES (6, 'Сатирическая проза');
INSERT INTO books.genres (genre_id, genre) VALUES (7, 'Рассказ');
INSERT INTO books.genres (genre_id, genre) VALUES (8, 'Фантастический боевик');
INSERT INTO books.genres (genre_id, genre) VALUES (9, 'Мистика');
INSERT INTO books.genres (genre_id, genre) VALUES (10, 'Фэнтези');
INSERT INTO books.genres (genre_id, genre) VALUES (11, 'Драма');
INSERT INTO books.genres (genre_id, genre) VALUES (12, 'Фантастика');