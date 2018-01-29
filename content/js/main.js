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

function GetURLParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}
