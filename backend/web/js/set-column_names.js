$(document).ready(function () {
    if (_Id) {
        var data = {};
        data.form_id = _Id;
        $.ajax({
            type: "POST",
            url: _baseUrl + "/ajax/get-column-names",
            data: data,
            success: function (res) {
                $.each(res, function(index, val) {
                    $('.gen-name[name="' + index + '"]').closest('.box-element').find('#column-name-l').val(val)
                })
            }
        })
    }
});

