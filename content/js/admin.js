$('#profileDataButton').click(function () {
    $('#profileData').slideDown('slow', function () {
        $('#profileDataButton').attr('id', '#profileDataButtonCollapse');

    });
});

$('#profileDataButtonCollapse').click(function () {
    $('#profileData').slideUp('slow', function () {
        $('#profileDataButtonCollapse').attr('id', '#profileDataButton');

    });
});

