create table books_authors
(
    book_id   int default 0 not null comment 'Идентификатор книги',
    author_id int default 0 not null comment 'Идентификатор автора',
    primary key (book_id, author_id)
)
    comment 'Связь книг и их акторов';

INSERT INTO books.books_authors (book_id, author_id) VALUES (1, 1);
INSERT INTO books.books_authors (book_id, author_id) VALUES (2, 1);
INSERT INTO books.books_authors (book_id, author_id) VALUES (3, 2);
INSERT INTO books.books_authors (book_id, author_id) VALUES (4, 3);
INSERT INTO books.books_authors (book_id, author_id) VALUES (4, 4);
INSERT INTO books.books_authors (book_id, author_id) VALUES (5, 5);
INSERT INTO books.books_authors (book_id, author_id) VALUES (5, 6);
INSERT INTO books.books_authors (book_id, author_id) VALUES (6, 5);
INSERT INTO books.books_authors (book_id, author_id) VALUES (7, 6);
INSERT INTO books.books_authors (book_id, author_id) VALUES (12, 10);
INSERT INTO books.books_authors (book_id, author_id) VALUES (12, 11);
INSERT INTO books.books_authors (book_id, author_id) VALUES (13, 10);
INSERT INTO books.books_authors (book_id, author_id) VALUES (13, 11);
INSERT INTO books.books_authors (book_id, author_id) VALUES (13, 12);
INSERT INTO books.books_authors (book_id, author_id) VALUES (14, 11);
INSERT INTO books.books_authors (book_id, author_id) VALUES (14, 12);
INSERT INTO books.books_authors (book_id, author_id) VALUES (15, 13);
INSERT INTO books.books_authors (book_id, author_id) VALUES (15, 14);
INSERT INTO books.books_authors (book_id, author_id) VALUES (16, 13);
INSERT INTO books.books_authors (book_id, author_id) VALUES (17, 14);
INSERT INTO books.books_authors (book_id, author_id) VALUES (18, 14);
INSERT INTO books.books_authors (book_id, author_id) VALUES (19, 15);
INSERT INTO books.books_authors (book_id, author_id) VALUES (19, 16);
INSERT INTO books.books_authors (book_id, author_id) VALUES (20, 15);
INSERT INTO books.books_authors (book_id, author_id) VALUES (21, 13);
INSERT INTO books.books_authors (book_id, author_id) VALUES (22, 15);
INSERT INTO books.books_authors (book_id, author_id) VALUES (22, 17);
INSERT INTO books.books_authors (book_id, author_id) VALUES (23, 15);
INSERT INTO books.books_authors (book_id, author_id) VALUES (23, 17);
INSERT INTO books.books_authors (book_id, author_id) VALUES (24, 15);
INSERT INTO books.books_authors (book_id, author_id) VALUES (24, 17);
INSERT INTO books.books_authors (book_id, author_id) VALUES (25, 17);
INSERT INTO books.books_authors (book_id, author_id) VALUES (26, 15);
INSERT INTO books.books_authors (book_id, author_id) VALUES (27, 10);
INSERT INTO books.books_authors (book_id, author_id) VALUES (28, 11);
INSERT INTO books.books_authors (book_id, author_id) VALUES (29, 10);
INSERT INTO books.books_authors (book_id, author_id) VALUES (30, 16);
INSERT INTO books.books_authors (book_id, author_id) VALUES (31, 16);