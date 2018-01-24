var showModal = document.getElementsByClassName('danger_book_button');
showModal[0].addEventListener('click', function ()
{
    var modalWindow = document.getElementById('deleteBookPopup');
    modalWindow.style.zIndex = '0';
    modalWindow.style.opacity = '1';
    var cancelButton = document.getElementById('cancelDelete');
    cancelButton.addEventListener('click', function ()
    {
       modalWindow.style.opacity = '0';
       setTimeout(function ()
       {
           modalWindow.style.zIndex = '-1';
       }, 500);
    });
});
