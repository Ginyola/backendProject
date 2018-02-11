<?php

function dbAddNewUser($user) {

    $query = 'INSERT INTO users (login, name, password, birthday, address, phone_number) VALUES
            ("' . dbQuote($user["email"]) . '", "' . dbQuote($user["name"]) . '", "' . dbQuote($user["password"]) .
            '", "' . dbQuote($user["birtdate"]) . '", "' . dbQuote($user["address"]) . '", "' . dbQuote($user["phone_number"]) . '");';
    $result = dbQuery($query);

    if ($result != 0) {
        echo "Пользователь добавлен в базу данных";
        return dbGetLastInserted();
    } else {
        echo "Пользователь не добавлен в базу данных";
    }
}

function dbUpdateUser($userId, $data)
{
    $query = 'UPDATE users SET name = "' . dbQuote($data["name"]). '", address = "' . dbQuote($data["address"]). '",'
            . ' phone_number = "' . dbQuote($data["phone_number"]) . '" WHERE user_id = "' . dbQuote($userId) .  '";';
    var_dump($query);
    $result = dbQuery($query);
    if ($result != 0) {
        $_SESSION["info_message"] = 10;
    } else {
        $_SESSION["info_message"] = 11;
    }
}

function dbAddNewUserAvatar($id, $path) {
    $query = 'UPDATE users SET avatar = "' . dbQuote($path) . '"'
            . 'WHERE user_id = ' . dbQuote($id) . ';';
    $result = dbQuery($query);

    if ($result != 0) {
        echo "Аватар добавлен";
    } else {
        echo "Аватар не добавлен";
    }
}

function checkUserExist($login) {
    $query = 'SELECT users.login FROM users WHERE login = "' . dbQuote($login) . '";';
    $result = dbQueryGetResult($query);
    $val = !empty($result) ? 1 : 0;
    return $val;
}

function findUserByLogin($login, $pass) {
    $userInfo = [];

    $preQuery = 'SELECT users.password FROM users WHERE login = "' . $login . '";';
    $preResult = dbQueryGetResult($preQuery);
    if (!empty($preQuery)) {
        $password = $pass . $login;
        $hash = $preResult[0]['password'];
        if (password_verify($password, $hash)) {
            $query = 'SELECT * FROM users WHERE login = "' . $login . '"'
                    . ' AND password = "' . $hash . '";';
            $result = dbQueryGetResult($query);
            $userInfo = $result[0];

            return $userInfo;
        } else {
            $_SESSION["info_message"] = 4;
        }
    } else {
        $_SESSION["info_message"] = 4; //ToDo: Дублирование
    }
}

function getUserBooks($userId) {
    $query = 'SELECT books.book_id, books.title, books.add_date, offer.offer 
        FROM offer LEFT JOIN books USING(book_id)
        WHERE offer.user_id = ' . dbQuote($userId) . ' AND books.deleted = 0;';
    $result = dbQueryGetResult($query);

    return (!empty($result) ? $result : []);
}

function getUserRole($userId)
{
    $query = 'SELECT role FROM role WHERE user_id = ' . dbQuote($userId) . ' LIMIT 1;';
    $result = dbQueryGetResult($query);
    
    return (!empty($result) ? $result[0]['role'] : []);
}

function getUserInfo($id)
{
    $query = 'SELECT name, address, avatar, phone_number, birthday, registration_time '
            . 'FROM users WHERE user_id = "' . dbQuote($id) . '";';
    $result = dbQueryGetResult($query);
    if(!empty($result))
    {
        $result[0]['birthday']=stristr($result[0]['birthday'], ' ', true);
    }
    return (!empty($result) ? $result : []);
}