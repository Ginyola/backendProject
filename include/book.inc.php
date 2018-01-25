<?php

function dbAddBookToLibary($book, $userId) {

    $query = 'INSERT INTO books (title, author, genre_id, add_info, print_date ,description) VALUES
            ("' . dbQuote($book["title"]) . '", "' . dbQuote($book["author"]) . '", "' . dbQuote($book["genre_id"]) .
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

function dbUpdateBookToLibary($book){
    $query = 'UPDATE books SET title="' . dbQuote($book["title"]) . '",'
            . ' author="' . dbQuote($book["author"]) . '",'
            . ' genre_id="' . dbQuote($book["genre_id"]) . '",'
            . ' add_info = "' . dbQuote($book["add_info"]) . '",'
            . ' print_date = "' . dbQuote($book["print_date"]) . '",'
            . ' description = "' . dbQuote($book["description"]). '" ' 
            . 'WHERE book_id = "' . dbQuote($book["book_id"]) . '";';

    $result = dbQuery($query);
    
    if ($result != 0) {
        echo "Книга обновлена";
    } else {
        echo "Книга не обновлена";
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

function getBookOwners($bookId)
{
    $query = 'SELECT user_id, name, avatar FROM offer LEFT JOIN users USING(user_id) WHERE book_id = "' . dbQuote($bookId) . '";';
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

function dbUpdateCover ($id, $path){
    $query = 'UPDATE image SET image ="'. dbQuote($path) . '"'
            . 'WHERE book_id = "'. dbQuote($id). '";';
    $result = dbQuery($query);
    if ($result != 0) {
        echo "Ссылка картинки обновлена";
    } else {
        echo "Ссылка картинки не обновлена";
    }
}

function getRecentBooks() {
    $query = 'SELECT books.book_id, books.title, books.author, books.print_date, image.image, rate'
            . ' FROM books '
            . ' LEFT JOIN image USING (book_id)'
            . ' LEFT JOIN ('
            . ' SELECT book_id, AVG(rating) as rate FROM rating GROUP BY book_id'
            . ') as sub_table'
            . ' USING (book_id)'
            . ' WHERE books.deleted = 0'
            . ' ORDER BY book_id DESC;';
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
    $query = 'SELECT AVG(rating) FROM rating WHERE book_id = ' . dbQuote($id) . ';';
    $result = dbQueryGetResult($query);
    
    return (!empty($result) ? $result : 0);
}

function getBooksById($id) {
    $query = 'SELECT * FROM books LEFT JOIN image USING (book_id) WHERE book_id = ' . dbQuote($id) . ' AND books.deleted = 0;';
    $result = dbQueryGetResult($query);

    return (!empty($result) ? $result : []);
}

function getBooksByGenre($id) {
    $query = 'SELECT * FROM books LEFT JOIN image USING (book_id)'
            . 'LEFT JOIN genre USING (genre_id) WHERE genre_id = ' . dbQuote($id) . ' AND books.deleted = 0;';
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

function bookInPosession($userId, $bookId)
{
    $query = 'SELECT offer_id FROM offer WHERE user_id =' . dbQuote($userId) . ' AND book_id = ' . dbQuote($bookId) . ';';
    $result = dbQueryGetResult($query);
    
    return (!empty($result) ? 1 : 0);
}

function deleteBook($bookId) //1 -deleted, 2 - not
{
    $query ='UPDATE books SET deleted = 1 WHERE book_id = "'. dbQuote($bookId).'";';
    $result = dbQuery($query);
    
    $result = ($result != 0) ? 1 : 2;
    
    return $result;
}