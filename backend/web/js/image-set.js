$(document).ready(function () {
    $(document).on('change paste keyup', '#image-url', function () {
        $(this).closest('.box-element').find('.view img').attr('src', $(this).val())
    });

    $(document).on('change paste keyup', '#image-width', function () {
        $(this).closest('.box-element').find('.view img').css('width', $(this).val())
    });
})