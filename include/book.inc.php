<?php

function dbAddBookToLibary($book, $userId) {

    $query = 'INSERT INTO books (title, author_id, genre_id, add_info, print_date ,description) VALUES
            ("' . dbQuote($book["title"]) . '", "' . dbQuote($book["author_id"]) . '", "' . dbQuote($book["genre_id"]) .
            '", "' . dbQuote($book["add_info"]) . '", "' . dbQuote($book["print_date"]) .
            '", "' . dbQuote($book["description"]) . '");';
    $result = dbQuery($query);

    if ($result != 0) {
        echo "Книга добавлена в базу данных";
        $bookId = dbGetLastInserted();
        tieUserWithBook($bookId, $userId);
        return $bookId;
    } else {
        echo "Книга не добавлена в базу данных";
    }
    //return (!empty($result) ? 0 : 1);//ToDo always empty
}

function tieUserWithBook($bookId, $userId)
{
    $query = 'INSERT INTO offer (user_id, book_id) VALUES (' . dbQuote($userId) . ',' . dbQuote($bookId) . ');';
    $result = dbQuery($query);
}

function dbAddCover($id, $path) {
    $query = 'UPDATE books SET image = "' . dbQuote($path) . '"'
            . 'WHERE book_id = ' . dbQuote($id) . ';';
    $result = dbQuery($query);

    if ($result != 0) {
        echo "Картинка добавлена";
    } else {
        echo "Картинка не добавлена";
    }
}

function getRecentBooks() {
    $query = 'SELECT books.* FROM books ORDER BY book_id DESC;'; //ToDo Add time filter
//    $query = dbQuote($query);
    $books = dbQueryGetResult($query);

    return (!empty($books) ? $books : []);
}

function getBooksGenre($limit) {
    $query = 'SELECT genre.* FROM genre ORDER BY genre_id LIMIT ' . dbQuote($limit) . ';';
    $genre = dbQueryGetResult($query);

    return (!empty($genre) ? $genre : []);
}

function getBooksById($id) {
    $query = 'SELECT books.* FROM books WHERE book_id = ' . dbQuote($id) . ';';
    $genre = dbQueryGetResult($query);

    return (!empty($genre) ? $genre : []);
}

function getBooksByGenre($id) {
    $query = 'SELECT books.* FROM books LEFT JOIN genre USING (genre_id) WHERE genre_id = ' . dbQuote($id) . ';';
    $genre = dbQueryGetResult($query);

    return (!empty($genre) ? $genre : []);
}

function getBooksBySubString($str) {
    $substr = mb_strtolower($str);
    $query = "SELECT books.book_id, books.title, books.description, books.image "
            . "FROM books LEFT JOIN genre USING (genre_id) "
            . "WHERE CONCAT_WS"
            . "('', genre.genre_ru, genre.genre_en, books.title, books.description) "
            . "LIKE '%" . dbQuote($substr) . "%';"; //add author 
    $books = dbQueryGetResult($query);

    return (!empty($books) ? $books : []);
}
