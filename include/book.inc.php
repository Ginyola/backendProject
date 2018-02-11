<?php

function dbAddBookToLibary($book, $userId) {

    $query = 'INSERT INTO books (title, author, genre_id, add_info, print_date ,description) VALUES
            ("' . dbQuote($book["title"]) . '", "' . dbQuote($book["author"]) . '", "' . dbQuote($book["genre_id"]) .
            '", "' . dbQuote($book["add_info"]) . '", "' . dbQuote($book["print_date"]) .
            '", "' . dbQuote($book["description"]) . '");';
    $result = dbQuery($query);

    if ($result != 0) {
        $_SESSION["info_message"] = 6;
        $bookId = dbGetLastInserted();
        tieUserWithBook($bookId, $userId);
        return $bookId;
    } else {
        $_SESSION["info_message"] = 5;
    }
    //return (!empty($result) ? 0 : 1);//ToDo always empty
}

function dbUpdateBookToLibary($book) {
    $query = 'UPDATE books SET title="' . dbQuote($book["title"]) . '",'
            . ' author="' . dbQuote($book["author"]) . '",'
            . ' genre_id="' . dbQuote($book["genre_id"]) . '",'
            . ' add_info = "' . dbQuote($book["add_info"]) . '",'
            . ' print_date = "' . dbQuote($book["print_date"]) . '",'
            . ' description = "' . dbQuote($book["description"]) . '" '
            . 'WHERE book_id = "' . dbQuote($book["book_id"]) . '";';

    $result = dbQuery($query);

    if ($result != 0) {
        $_SESSION["info_message"] = 7;
    } else {
        $_SESSION["info_message"] = 8;
    }
}

function tieUserWithBook($bookId, $userId) {
    $query = 'INSERT INTO offer (user_id, book_id) VALUES ("' . dbQuote($userId) . '","' . dbQuote($bookId) . '");';
    $result = dbQuery($query);
}

function untieUserWithBook($bookId, $userId) {
    $query = 'DELETE FROM offer WHERE user_id = "' . dbQuote($userId) . '" AND book_id = "' . dbQuote($bookId) . '";';
    $result = dbQuery($query);
}

function getBookOwners($bookId, $offer) {
    $query = 'SELECT user_id, name, avatar FROM offer LEFT JOIN users USING(user_id)'
            . ' WHERE book_id = "' . dbQuote($bookId) . '" AND offer = "' . dbQuote($offer) . '";';
    $result = dbQueryGetResult($query);

    return (!empty($result) ? $result : []);
}

function dbAddCover($id, $path) {
    $query = 'INSERT INTO image (book_id, image) VALUES (' . dbQuote($id) . ', "' . dbQuote($path) . '")';
    $result = dbQuery($query);

    if ($result != 0) {
        echo "Картинка добавлена";
    } else {
        echo "Картинка не добавлена";
    }
}

function dbUpdateCover($id, $path) {
    $query = 'UPDATE image SET image = "' . dbQuote($path) . '"'
            . ' WHERE book_id = "' . dbQuote($id) . '";';
    $result = dbQuery($query);
    if ($result != 0) {
        echo "Ссылка картинки обновлена";
    } else {
        echo "Ссылка картинки не обновлена";
    }
}

function dbUpdateAvatar($newId, $path) {
    $query = 'UPDATE users SET avatar ="' . dbQuote($path) . '"'
            . ' WHERE user_id = "' . dbQuote($newId) . '";';
    $result = dbQuery($query);
    if ($result != 0) {
        echo "Аватар обновлён";
    } else {
        echo "Аватар не обновлён";
    }
}

function getRecentBooks($page) {
    $startPoint = ($page - 1) * MAX_BOOKS_PAGE;
    $query = 'SELECT books.book_id, books.title, books.author, YEAR(books.print_date) as print_date, image.image, rate, genre.genre_ru'
            . ' FROM books '
            . ' LEFT JOIN image USING (book_id)'
            . ' LEFT JOIN genre USING (genre_id)'
            . ' LEFT JOIN ('
            . ' SELECT book_id, AVG(rating) as rate FROM rating GROUP BY book_id'
            . ') as sub_table'
            . ' USING (book_id)'
            . ' WHERE books.deleted = 0'
            . ' ORDER BY book_id DESC'
            . ' LIMIT ' . MAX_BOOKS_PAGE . ' OFFSET ' . dbQuote($startPoint) . ';';
    $books = dbQueryGetResult($query);

    return (!empty($books) ? $books : []);
}

//function getBooksGenre($limit) {
//    $query = 'SELECT genre.* FROM genre ORDER BY genre_id LIMIT ' . dbQuote($limit) . ';';
//    $genre = dbQueryGetResult($query);
//
//    return (!empty($genre) ? $genre : []);
//}

function getBooksGenre() {
    $query = 'SELECT genre.* FROM genre ORDER BY genre_id;';
    $genre = dbQueryGetResult($query);

    return (!empty($genre) ? $genre : []);
}

function getBookRating($id) {
    $query = 'SELECT AVG(rating) as rate FROM rating WHERE book_id = "' . dbQuote($id) . '";';
    $result = dbQueryGetResult($query);

    return (!empty($result) ? $result : 0);
}

function getBooksById($id) {
    $query = 'SELECT * FROM books LEFT JOIN image USING (book_id) WHERE book_id = "' . dbQuote($id) . '" AND books.deleted = 0;';
    $result = dbQueryGetResult($query);

    return (!empty($result) ? $result : []);
}

function getBooksByGenre($id) {
    $query = 'SELECT books.book_id, books.title, books.author, YEAR(books.print_date) as print_date, image.image, rate, genre.genre_ru'
            . ' FROM books '
            . ' LEFT JOIN image USING (book_id)'
            . ' LEFT JOIN genre USING (genre_id)'
            . ' LEFT JOIN ('
            . ' SELECT book_id, AVG(rating) as rate FROM rating GROUP BY book_id'
            . ') as sub_table'
            . ' USING (book_id)'
            . ' WHERE books.deleted = 0 AND books.genre_id = "' . dbQuote($id) . '"'
            . ' ORDER BY book_id DESC;';
    $genre = dbQueryGetResult($query);

    return (!empty($genre) ? $genre : []);
}

function getBooksBySubString($str) {
    $substr = mb_strtolower($str);
    $query = "SELECT books.book_id, books.title, books.description, image.image "
            . "FROM books LEFT JOIN image USING (book_id)"
            . " LEFT JOIN genre USING (genre_id) "
            . "WHERE CONCAT_WS"
            . "('', genre.genre_ru, genre.genre_en, books.title, books.description, books.author) "
            . "LIKE '%" . dbQuote($substr) . "%' AND books.deleted = 0;";
    $books = dbQueryGetResult($query);

    return (!empty($books) ? $books : []);
}

function bookInPosession($userId, $bookId) {
    $query = 'SELECT offer_id FROM offer WHERE user_id =' . dbQuote($userId) . ' AND book_id = ' . dbQuote($bookId) . ';';
    $result = dbQueryGetResult($query);

    return (!empty($result) ? 1 : 0);
}

function deleteBook($bookId) { //1 -deleted, 2 - not
    $query = 'UPDATE books SET deleted = 1 WHERE book_id = "' . dbQuote($bookId) . '";';
    $result = dbQuery($query);

    $result = ($result != 0) ? 1 : 2;

    return $result;
}

function updateBookRating($userId, $bookId, $rating) {
    $query = 'SELECT * FROM rating WHERE user_id = "' . dbQuote($userId) . '" AND book_id = "' . dbQuote($bookId) . '";';
    $result = dbQueryGetResult($query);

    if (!empty($result)) {
        $query = 'UPDATE rating SET rating = ' . dbQuote($rating) . ' WHERE'
                . ' book_id = "' . dbQuote($bookId) . '" AND '
                . ' user_id = "' . dbQuote($userId) . '";';
    } else {
        $query = 'INSERT INTO rating (user_id, book_id, rating) VALUES'
                . ' ("' . dbQuote($userId) . '","' . dbQuote($bookId) . '", "' . dbQuote($rating) . '")';
    };
    dbQuery($query);
}

function changeBookStatus($userId, $bookId, $offer) {
    $query = 'UPDATE offer SET offer = "' . dbQuote($offer) . '" WHERE'
            . ' user_id = "' . dbQuote($userId) . '" AND book_id = "' . dbQuote($bookId) . '";';
    $result = dbQuery($query);
//    $result = ($result != 0) ? 3 : 4;
//    return $result;
}

function addComment($userId, $bookId, $comment) {
    $query = 'INSERT INTO comment (user_id, book_id, comment) VALUES '
            . '("' . dbQuote($userId) . '", "' . dbQuote($bookId) . '" , "' . dbQuote($comment) . '");';
    $result = dbQuery($query);
}

function getComments($id) {
    $query = 'SELECT t1.comment_id, t1.user_id, t1.name, t2.rating, t1.date, t1.comment, t1.avatar FROM 
    (SELECT comment.*, users.name, users.avatar FROM comment
    LEFT JOIN users USING(user_id) WHERE book_id = "' . dbQuote($id) . '") as t1 LEFT JOIN  
    (SELECT user_id, rating FROM rating WHERE book_id = "' . dbQuote($id) . '")
    as t2 USING (user_id) ORDER BY comment_id DESC;';

    $result = dbQueryGetResult($query);

    return (!empty($result) ? $result : []);
}

function countPagesPagination() {
    $query = 'SELECT COUNT(book_id) as c FROM books WHERE deleted = 0;';
    $result = dbQueryGetResult($query)[0]["c"];

    $pages = intdiv($result, MAX_BOOKS_PAGE);
    if ($result % MAX_BOOKS_PAGE != 0) {
        $pages += 1;
    }
    return $pages;
}
