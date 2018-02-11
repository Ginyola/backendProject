$('#profileDataButton').click(function () {
    if ($('#profileData').css('display') == 'none') {
        $('#profileData').slideDown('slow');
    } else {
        $('#profileData').slideUp('slow');
    }
});

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
    
    return "";
}

function ReloadPage()
{
    setTimeout(function () {
              window.location.reload();
          }, 10);
}