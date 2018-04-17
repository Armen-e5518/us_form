$(document).ready(function () {
    if (_Id && _Form_id) {
        var data = {};
        data.id = _Id;
        data.form_id = _Form_id;
        $.ajax({
            type: "POST",
            url: _baseUrl + "/ajax/get-form-data-by-id",
            data: data,
            success: function (res) {
                if (res) {
                    SetHtmlData(res)
                } else {
                    $('.content-user-data').html('');
                    $('.content-user-data').html('<h1>No data</h1>');
                }
            }
        })
    } else {
        $('.content-user-data').html('');
        $('.content-user-data').html('<h1>No data</h1>');
    }
});

function SetHtmlData(data) {
    var val = $.map(data, function (el) {
        return (el == null) ? 0 : el;
    });
    var index = $.map(data, function (el, i) {
        return i
    });
    out(val);
    out(index);
    $.each(index, function (index, value) {
        var form_name = value;
        var form_value = val[index];

        if (form_name.indexOf('textarea') >= 0
            || form_name.indexOf('text') >= 0
            || form_name.indexOf('table') >= 0
            || form_name.indexOf('user') >= 0
        ) {
            $('[name="' + form_name + '"]').val(SpecialCharacters(form_value))
        } else if (form_name.indexOf('checkbox') >= 0) {
            if (form_value == 'on') {
                $('[name="' + form_name + '"]').prop('checked', true)
            }
        } else if (form_name.indexOf('radio') >= 0) {
            if (form_value) {
                $('#user-view input.gen-redio[value="' + form_value + '"]').prop('checked', true);
                $('#pdf-content input.gen-redio[value="' + form_value + '"]').attr('name', NameGenerator('pdf'));
                $('#pdf-content input.gen-redio[value="' + form_value + '"]').prop('checked', true);
            }
        } else if (form_name.indexOf('select') >= 0) {
            $('[name="' + form_name + '"]').val(form_value)
        } else if (form_name.indexOf('file') >= 0) {
            if (form_value) {
                var href = location.protocol + "//" + document.domain + _baseUrl + '/forms/download?file=' + form_value;
                $('[name="' + form_name + '"]').parent().html('<a href="' + href + '">Download File</a>')
                $('[name="' + form_name + '"]').remove();
            }
            $('[name="' + form_name + '"]').parent().html('<a>No File</a>')
            $('[name="' + form_name + '"]').remove();
        }
        InactiveAllElements()
    });
    SavePdfContent()
}
function SavePdfContent() {
    $('#pdf-content .drag').remove();
    $('#pdf-content .configuration').remove();
    $('#pdf-content .remove').remove();
    $('#pdf-content .preview').remove();
    $('#pdf-content .edit-text').remove();

    $('#pdf-content .column').each(function () {
        if ($(this).hasClass('col-md-4')) {
            SetDivPos($(this), '58mm')
        }
        if ($(this).hasClass('col-md-8')) {
            SetDivPos($(this), '119mm')
        }
        if ($(this).hasClass('col-md-6')) {
            SetDivPos($(this), '89.2mm')
        }
        if ($(this).hasClass('col-md-12')) {
            SetDivPos($(this), '250mm')
        }
    });
    $('#pdf-content input').each(function () {
        if (!$(this).hasClass('text-box-table')) {
            var type = $(this).attr('type');
            if (type == 'text' || type == 'email' || type == 'number' || type == 'tel') {
                $(this).after('<br><div style="width: 100%; border: 1px solid black; padding: 1px 6px;"><span  style="display: block;  ">' + $(this).val() + '</span> </div>');
                $(this).remove();
            }
            if (type == 'radio') {
                if ($(this).is(':checked')) {
                    $(this).after('<span><img src="' + _baseUrl + '/images/form-img/active-radio.png" width="15px" alt=""></span>');
                    $(this).remove();
                } else {
                    $(this).after('<span><img src="' + _baseUrl + '/images/form-img/empty-radio.png" width="15px" alt=""></span>');
                    $(this).remove();
                }
            }
            if (type == 'checkbox') {
                if ($(this).is(':checked')) {
                    $(this).after('<span><img style="margin-right: 3px; margin-top: 2px" src="' + _baseUrl + '/images/form-img/active-che.png" width="15px" alt=""></span>');
                    $(this).remove();
                } else {
                    $(this).after('<span><img style="margin-right: 3px; margin-top: 2px"src="' + _baseUrl + '/images/form-img/empty-che.png" width="15px" alt=""></span>');
                    $(this).remove();
                }
            }
        } else {
            var type = $(this).attr('type');
            if (type == 'text' || type == 'email' || type == 'number' || type == 'tel') {
                $(this).after('<span  style="display: block; ">' + $(this).val() + '</span>');
                $(this).remove();
            }
        }
    })

    $('#pdf-content select').each(function () {
        $(this).after('<div style="width: 100%; border: 1px solid black;"><span style="display: block; " >' + $(this).val() + '</span></div>');
        $(this).remove();
    })

    $('#pdf-content .text-title').css('display', 'block');
    $('#pdf-content .text-title').css('padding-right', '100px');
    $('#pdf-content .view h1').css('font-size', '25px');
    $('#pdf-content .view h1').css('padding', '2px 6px 2px 10px');
    $('#pdf-content .view h1').css('background-color', '#003875');
    $('#pdf-content .view h1').css('color', '#fff');
    $('#pdf-content .view h2').css('font-size', '20px');
    $('#pdf-content .view h2').css('padding', '2px 6px 2px 10px');
    $('#pdf-content .view h2').css('background-color', '#ddd');
    $('#pdf-content .view h2').css('color', '#003875');
    $('#pdf-content .view h3').css('font-size', '15px');
    $('#pdf-content .view h3').css('padding', '2px 6px 2px 10px');
    $('#pdf-content .view h3').css('background-color', '#ddd');
    $('#pdf-content .view h3').css('color', '#003875');
    $('#pdf-content .view h4').css('font-size', '10px');
    $('#pdf-content .view h4').css('padding', '2px 6px 2px 10px');
    $('#pdf-content .view h4').css('background-color', '#ddd');
    $('#pdf-content .view h4').css('color', '#003875');
    $('#pdf-content .success').removeClass('success');
    $('#pdf-content table th').css('border', '1px solid #ddd');
    $('#pdf-content table th').css('text-align', 'center');
    $('#pdf-content table th').css('font-weight', 'normal');
    $('#pdf-content table').css('width', '96%');
    $('#pdf-content .row').css('display', '-webkit-box');
    $('#pdf-content .row').css('display', '-webkit-flex');
    $('#pdf-content .row').css('display', 'flex');
    $('#pdf-content .column').css('border', 'none');

    $('#pdf-content textarea').each(function () {
        $(this).after('<div style="width: 100%;  padding: 1px 6px;"><span>' + $(this).val() + '</span></div>');
        $(this).remove();
    })
    var content = $('#pdf-content').html();
    SavePdfContentFile(content)
}

function InactiveAllElements() {
    $('#user-view input').attr('disabled', true);
    $('#user-view textarea').attr('disabled', true);
    $('#user-view select').attr('disabled', true);
}

function SetDivPos(ob, proc) {
    ob.css('display', 'block')
    ob.css('border', '1px solid #ccc')
    ob.css('float', 'left')
    ob.css('width', proc)
    ob.css('padding-top', '10px')
    ob.css('padding-bottom', '10px')
    ob.css('margin-left', '0px')
    ob.css('margin-right', '0px')
    ob.css('padding-right', '0')
    ob.css('padding-right', '0')
}

function SpecialCharacters(mystring) {
    return mystring.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
}