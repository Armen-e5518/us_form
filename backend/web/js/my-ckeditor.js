var editor_ob;

$(document).ready(function () {

    $(document).on('mouseover',
        '.view table',
        function () {
            $(this).closest('.box-element').find('.configuration').show();
        });

    $(document).on('mouseover',
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
            editor_ob = $(this);
        });

    $('#html-data').mouseenter(function () {
        $('.i_background_color').ColorPicker({
            onChange: function (hsb, hex, rgb) {
                editor_ob.closest('.box-element').find('.view .editable_object').css('backgroundColor', '#' + hex);
                editor_ob.css('color', '#' + hex);
            }
        })
    })

    $('#html-data').mouseenter(function () {
        $('.i_text_color').ColorPicker({
            onChange: function (hsb, hex, rgb) {
                editor_ob.closest('.box-element').find('.view .editable_object').css('color', '#' + hex);
                editor_ob.css('color', '#' + hex);
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
            }
        })
    });
    $('#html-data').mouseenter(function () {
        $('.table_background_color').ColorPicker({
            onChange: function (hsb, hex, rgb) {
                editor_ob.closest('.ui-draggable').find('.view th').css("cssText", "background-color: #"+hex+" !important;");
                // editor_ob.closest('.ui-draggable').find('.view').css('backgroundColor', '#' + hex);
                // editor_ob.closest('.ui-draggable').find('.view .row').css('backgroundColor', '#' + hex);
                editor_ob.css('color', '#' + hex);
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


