$('#previewAvatarInput').change(function () {
    var file = this.files[0];
    var reader = new FileReader();
    reader.onloadend = function () {
        $('#previewAvatar').css('background-image', 'url("' + reader.result + '")');
    }
    if (file) {
        reader.readAsDataURL(file);
    }
});

