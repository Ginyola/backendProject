$(document).ready(function ()
{
    var bookId = GetURLParameter("id");
    var $object = $('#book_rating_div');
    console.log($object);
    var request;

    // Abort any pending request
    if (request) {
        request.abort();
    }

    // Fire off the request to /form.php
    request = $.ajax({
        url: "/php/rating.php",
        type: "post",
        data: {book_id: bookId},
        success: function (value) {
            $object.rateit('value', value);
            console.log(value);

        },
        error: function () {
            alert("Oops");
        }
    });
});

$('#book_rating_div').click(function (event)
{
    var bookId = GetURLParameter("id");
    var newRating = $('#book_rating_div').rateit('value');
    console.log(newRating);
    var $object = $('#book_rating_div');

    var request;

    if (request) {
        request.abort();
    }

    request = $.ajax({
        url: "/php/rating.php",
        type: "post",
        data: {book_id: bookId,
            set_rating: newRating},
        success: function (value) {
            $object.rateit('value', value);
            console.log(value);

        },
        error: function () {
            alert("Oops");
        }
    });
});