var editor_ob;

$(document).ready(function () {

    SetCssParamsTopBar()

    $(document).on('mouseover',
        '.view table',
        function () {
            $(this).closest('.box-element').find('.configuration').show();
        });

    // $(document).on('mouseover',
    //     ' .i_background_color, ' +
    //     ' .i_text_color ,' +
    //     ' .i_font_size , ' +
    //     ' .i_font_weight ,' +
    //     ' .i_font_style , ' +
    //     ' .i_description,' +
    //     ' .i_background_ley,' +
    //     ' .table_background_color,' +
    //     ' .i_fonts',
    //     function () {
    //         editor_ob = $(this);
    //     });.mouseup
    $(document).on('mouseup',
        ' .i_background_color, ' +
        ' .i_text_color ,' +
        ' .i_font_size , ' +
        ' .i_font_weight ,' +
        ' .i_font_style , ' +
        ' .i_description,' +
        ' .i_background_ley,' +
        ' .table_background_color,' +
        ' .i_fonts',
        function () {
        console.log($(this).attr('class'))
            editor_ob = $(this);
        });
    $('#html-data').mouseenter(function () {
        $('.i_background_color').ColorPicker({
            onChange: function (hsb, hex, rgb) {
                editor_ob.closest('.box-element').find('.view .editable_object').css('backgroundColor', '#' + hex);
                editor_ob.css('color', '#' + hex);
                editor_ob.attr('backgroundColor', '#' + hex);
            },
            onBeforeShow: function () {
                if (editor_ob.attr('backgroundColor')) {
                    $(this).ColorPickerSetColor(editor_ob.attr('backgroundColor'));
                }
            }
        })
    })

    $('#html-data').mouseenter(function () {
        $('.i_text_color').ColorPicker({
            onChange: function (hsb, hex, rgb) {
                editor_ob.closest('.box-element').find('.view .editable_object').css('color', '#' + hex);
                editor_ob.css('color', '#' + hex);
                editor_ob.attr('color', '#' + hex);
            },
            onBeforeShow: function () {
                if (editor_ob.attr('color')) {
                    $(this).ColorPickerSetColor(editor_ob.attr('color'));
                }
            }
        })
    })

    $('#html-data').mouseenter(function () {
        $('.i_background_ley').ColorPicker({
            onChange: function (hsb, hex, rgb) {
                editor_ob.closest('.ui-draggable').find('.view .column').css('backgroundColor', '#' + hex);
                editor_ob.closest('.ui-draggable').find('.view').css('backgroundColor', '#' + hex);
                editor_ob.closest('.ui-draggable').find('.view .row').css('backgroundColor', '#' + hex);
                editor_ob.css('color', '#' + hex);
                editor_ob.attr('color', '#' + hex);
            },
            onBeforeShow: function () {
                if (editor_ob.attr('color')) {
                    $(this).ColorPickerSetColor(editor_ob.attr('color'));
                }
            }
        })
    });
    $('#html-data').mouseenter(function () {
        $('.table_background_color').ColorPicker({
            onChange: function (hsb, hex, rgb) {
                editor_ob.closest('.ui-draggable').find('.view th').css("cssText", "background-color: #" + hex + " !important;");
                editor_ob.css('color', '#' + hex);
                editor_ob.attr('color', '#' + hex);
            },
            onBeforeShow: function () {
                if (editor_ob.attr('color')) {
                    $(this).ColorPickerSetColor(editor_ob.attr('color'));
                }
            }
        })
    });
    $('#html-data').on('change paste keyup', '.i_font_size', function () {
        editor_ob.closest('.box-element').find('.view .editable_object').css('font-size', $(this).val() + 'px')
    })
    $('#html-data').on('change paste keyup', '.i_description', function () {
        editor_ob.closest('.box-element').find('.view .editable_object').attr('title', $(this).val())
    })

    $('#html-data').on('change', '.i_font_weight', function () {
        editor_ob.closest('.box-element').find('.view .editable_object').css('font-weight', $(this).val())
    })
    $('#html-data').on('change', '.i_font_style', function () {
        editor_ob.closest('.box-element').find('.view .editable_object').css('font-style', $(this).val())
    })
    $('#html-data').on('change', '.i_fonts', function () {
        editor_ob.closest('.box-element').find('.view .editable_object').css('font-family', $(this).val())
    })
});

// ' .i_background_color, ' +
// ' .i_text_color ,' +
// ' .i_font_size , ' +
// ' .i_font_weight ,' +
// ' .i_font_style , ' +
// ' .i_description,' +
// ' .i_background_ley,' +
// ' .table_background_color,' +
// ' .i_fonts',
function SetCssParamsTopBar() {
    $('#html-data .editable_object').each(function () {
        var style = $(this).attr('style');
        var ob_style = GetCssObject(style.split(";"));
        console.log(ob_style);
        console.log(GetValueByKay(ob_style,'font-size'));
        console.log(GetValueByKay(ob_style,'font-weight'));
        console.log(GetValueByKay(ob_style,'font-family'));
        console.log(GetValueByKay(ob_style,'font-style'));

        $(this).closest('.box-element').find('.configuration .i_description').val($(this).attr('title'));
        $(this).closest('.box-element').find('.configuration .i_font_size').val(parseInt(GetValueByKay(ob_style, 'font-size')) * 1);
        $(this).closest('.box-element').find('.configuration .i_font_weight').val(GetValueByKay(ob_style, 'font-weight'));
        $(this).closest('.box-element').find('.configuration .i_fonts').val(GetValueByKay(ob_style, 'font-family'));
        $(this).closest('.box-element').find('.configuration .i_font_style').val(GetValueByKay(ob_style, 'font-style'));

    })


}

function GetCssObject(ob) {
    var new_ob = [];
    ob.forEach(function (val) {
        if (val) {
            var a = val.split(":");
            new_ob.push(
                {
                    'index': a[0].replace(/\s/g, ''),
                    'val': a[1].trim().replace(/"/g , '')
                }
            )
        }
    });
    return new_ob;
}

function GetValueByKay(ob, kay) {
    var v = '';
    ob.forEach(function (val) {
        if (val.index == kay) {
            v = val.val;
        }
    })
    return v;
}