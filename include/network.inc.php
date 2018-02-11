<?php

function dbUploadImage($uploadedFiles, $newId, $from) {
    $tmp_name = $uploadedFiles["tmp_name"];
    $name = stristr(basename($uploadedFiles["name"]), '.');
    $path = UPLOAD_DIR . $newId . $name; 
//TODO: create additional function to compare files
    if (file_exists($path)) {
        unlink($path);
//        $tmp_hash = hash_file('md5', $tmp_name);
//        $path_hash = hash_file('md5', $path);
//
//        if ($tmp_hash != $path_hash) {
//            $path = UPLOAD_DIR . $path_hash . $newId . $name;
//        }
    }

    $uploadResult = move_uploaded_file($tmp_name, $path);

    if (!$uploadResult) {
        echo "Upload ERROR";
    } else {
        if ($from == "avatar") {
            dbAddNewUserAvatar($newId, $path);
        }
        if ($from == "cover") {
            dbAddCover($newId, $path);
        }
        if ($from == "update_cover") {
            dbUpdateCover($newId, $path);
        }
        if ($from == "update_avatar") {
            dbUpdateAvatar($newId, $path);
        }
    }
    
}
