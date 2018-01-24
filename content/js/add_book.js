/*window.onload = initCatalogPage;
 
 function initCatalogPage()
 {
 var refreshLink = document.getElementById("refresh");
 refreshLink.onclick = onRefreshClick;
 }
 
 function onRefreshClick()
 {
 var data = {"genre": "Management", "page": "2"};
 postRequest("/response_add_book.php", data, onCatalogResponse);
 }*/

function onCatalogResponse(response)
{
    if (response) {
        var html = "";
        for (var i = 0; i < response.books.length; ++i) {
            var book = response.books[i];
            html += "<li>" +
                    "<span>" + book.author + "</span> &dash; " +
                    "<span>" + book.title + "</span>" +
                    "</li>";
        }
        document.getElementById("catalog").innerHTML = html;
    }
}

//my function
//function onClickAddBook()
//{
//    var bookData = [];
//    bookData[0] = document.getElementById("book_title").value;
//    bookData[1] = document.getElementById("book_desc").value;
//    bookData[2] = document.getElementById("book_img").value;
//    var data = {"title": bookData[0], "description": bookData[1], "image": bookData[2]};
//    console.log(data);
//    postRequest("/project/response_add_book.php", data, function () {});
//}

$('#previewInputId').change(function () {
    var file = this.files[0];
    var reader = new FileReader();
    reader.onloadend = function () {
        $('#previewImageId').css('background-image', 'url("' + reader.result + '")');
    }
    if (file) {
        reader.readAsDataURL(file);
    }
});