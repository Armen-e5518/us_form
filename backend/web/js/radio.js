function StopDrag() {
    $('.demo input.gen-redio').each(function (index) {
        $(this).attr('value', index + 1)
    })
}

$(document).on('change', '#radio-required', function () {
    if ($(this).is(":checked")) {
        $(this).closest('.box-element').find('.view input').addClass('checked-required')
        $(this).closest('.box-element').find('.view input').attr('name-required', NameGenerator('required'))
    } else {
        $(this).closest('.box-element').find('.view input').removeClass('checked-required')
        $(this).closest('.box-element').find('.view input').removeAttr('name-required')
    }
});