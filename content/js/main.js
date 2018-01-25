$('#profileDataButton').click(function () {
    if ($('#profileData').css('display') == 'none') {
        $('#profileData').slideDown('slow');
    } else {
        $('#profileData').slideUp('slow');
    }
});

//
//$.ajax({
//    url: 'rating.php',
//    data: {book_id: productID},
//    type: 'POST',
//    success: function (results) {
//        $('.rateit').rateit('value', (results));
//    }
//
//});


