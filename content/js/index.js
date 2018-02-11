var $pagination = $('#indexPagination');
var $recentBooks = $('#recentBooks');
var genre = GetURLParameter("genre");
var sstr = GetURLParameter("sstr");
var defaultOpts = parseInt($('#indexPagination').attr("pages"));

$pagination.twbsPagination({
    totalPages: defaultOpts,
    visiblePages: 10,
    onPageClick: function (event, page) {
        $('#page-content').text('Page ' + page);
    }
});


$(document).on('click', '.page-link', function (event)
{
    var $object = $(this);
    var request;

    var newPage = $pagination.twbsPagination('getCurrentPage');

    request = $.ajax({
        url: "/php/index_pagination.php",
        type: "post",
        data: {page: newPage, genre: genre, sstr: sstr},
        success: function (value) {
            $($recentBooks).html(value);
            $('div.rateit').rateit();
        },
        error: function () {
            alert("Oops");
        }
    });
}
);