var showModal = document.getElementsByClassName('user_contact');
for (var i = 0; i < showModal.length; i++) {
    showModal[i].addEventListener('click', function ()
    {
        var modalWindow = document.getElementById('userInfoWindow');
        modalWindow.style.zIndex = '2';
        modalWindow.style.opacity = '1';
        var cancelButton = document.getElementById('closeUserInfo');
        cancelButton.addEventListener('click', function ()
        {
            modalWindow.style.opacity = '0';
            setTimeout(function ()
            {
                modalWindow.style.zIndex = '-1';
            }, 500);
        });
    });
}

$(".user_contact").click(function (event) {
    var request;

    // Abort any pending request
    if (request) {
        request.abort();
    }

    var $owner = $(this);

    var $input = $owner.find("input");
    var $replace = "#replaceAjax";
    var $userId = $input.val();

    request = $.ajax({
        url: "/php/contact.php",
        type: "post",
        data: {userId: $userId},
        success: function (value) {
            $($replace).html(value);

        },
        error: function(){
            alert("Oops");
        }
    });
});

