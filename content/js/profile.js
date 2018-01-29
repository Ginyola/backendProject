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
    // setup some local variables
    var $owner = $(this);
    console.log($owner);

    // Let's select and cache all the fields
    var $input = $owner.find("input");
    var $replace = "#replaceAjax";
    console.log($input);
    var $userId = $input.val();
    console.log($userId);

    // Fire off the request to /form.php
    request = $.ajax({
        url: "/php/contact.php",
        type: "post",
        data: {userId: $userId},
        success: function (value) {
            $($replace).html(value);
            console.log(value);
        
        },
        error: function(){
            alert("Oops");
        }
    });
});

