$(document).ready(function () {
    $('#admin').click(function () {
        var href = location.protocol + "//" + document.domain + '/admin';
        window.location.href = href;
    });

    $(document).on('contextmenu', '[contenteditable="true"]', function () {
        return false;
    });

    $(document).on('mouseover', '[contenteditable="true"]', function () {
        $(this).css('color', 'red');
        $(this).css('cursor', 'auto');
        $('.right-text').show();
    });
    $(document).on('mouseleave', '[contenteditable="true"]', function () {
        $(this).css('color', 'black');
        if ($(this).hasClass('btn')) {
            $(this).css('color', 'white')
        }
        $('.right-text').hide();
    });

    $('.new-group').click(function () {
        $(this).closest('.box-element').find('.view input').attr('name', NameGenerator('radio'))
    })

    $(document).on("mousemove", function (event) {
        $('.right-text').css('left', event.pageX + 'px')
        $('.right-text').css('top', event.pageY * 1 - 20 + 'px')
    })
    $("#table-g").on("change paste keyup", function () {
        var val = $(this).val();
        var arr = val.split(" ");
        if (arr[0] * 1 > 0 && arr[1] * 1 > 0) {
            var t = TableGeneratorByTextBox(arr[0] * 1 + 1, arr[1] * 1 + 1);
            $(this).parent().parent().find('.view').html(t);
            $(this).parent().parent().find('.drag').show()
        } else {
            $(this).parent().parent().find('.drag').hide()
        }
    });

    $('#drop-down-g').on('change paste keyup', function () {
        var val = $(this).val();
        var html = '';
        if (val * 1 > 0) {
            $(this).parent().find('span').html('');
            for (var i = 0; i < val * 1; i++) {
                $(this).parent().find('span').append('<input type="text"  placeholder="Row ' + (i + 1) + '" class="form-control drop-down-val">')
            }
        } else {
            $(this).parent().find('span').html('')
        }
    });

    $(document).on('change paste keyup', '.boxes .drop-down-val', function () {
        var flag = true;
        var ob = $(this).parent().parent().parent();
        $('.drop-down-val').each(function () {
            if (!$(this).val()) {
                flag = false;
            }
        });
        if (flag) {
            var html = '';
            ob.find('.view').html('');
            html += '<select>';
            $('.boxes .drop-down-val').each(function () {
                html += '<option value="' + $(this).val() + '">' + $(this).val() + '</option>'
            });
            html += '</select>';
            ob.find('.view').html(html);
            ob.find('.drag').show()
        } else {
            ob.find('.drag').hide()
        }
    });

    $(document).on('click', '.edit-text', function () {
        var flag = $(this).hasClass('active') ? true : false;
        FindElementEdit($(this), flag)
        $(this).toggleClass('active')
    });

    $(document).on('click', '.reverse', function () {
        Reverse($(this))
    });

    $(document).on('click', '.text-box li', function () {
        SetTypeInInput($(this))
    })

    $(document).on('change', '.n-empty input', function () {
        if ($(this).is(":checked")) {
            $(this).closest('.box-element').find('.view textarea').addClass('not-empty')
            $(this).closest('.box-element').find('.view input').addClass('not-empty')
        } else {
            $(this).closest('.box-element').find('.view textarea').removeClass('not-empty')
            $(this).closest('.box-element').find('.view input').removeClass('not-empty')
        }
    });

    $(document).on('change', '.f-search input', function () {
        if ($(this).is(":checked")) {
            $(this).closest('.box-element').find('.view textarea').addClass('search-on')
            $(this).closest('.box-element').find('.view input').addClass('search-on')
        } else {
            $(this).closest('.box-element').find('.view textarea').removeClass('search-on')
            $(this).closest('.box-element').find('.view input').removeClass('search-on')
        }
    });


});

function SetTypeInInput(ob) {
    var input = ob.closest('.box-element').find('.view input');
    var type = ob.find('a').attr('rel');
    input.attr('type', type)
}

function TableGenerator(row, col) {
    var html = '<table class="table">';
    for (var i = 0; i < row; i++) {
        html += '<tr>';
        for (var j = 0; j < col; j++) {
            html += '<th class="ui-sortable">text</th>'
        }
        html += '</tr>'
    }
    html += '</table>';
    return html;
}

function TableGeneratorByTextBox(row, col) {
    var html = '<table class="table">';
    var text = 'text';
    for (var i = 0; i < row; i++) {
        html += '<tr>';
        for (var j = 0; j < col; j++) {
            if (i == 0) {
                text = 'text'
            } else {
                if (j == 0) {
                    text = 'text'
                } else {
                    text = '<input class="text-box-table gen-name" name="' + NameGenerator('table') + '" type="text">'
                }
            }
            html += '<th class="success">' + text + '</th>'
        }
        html += '</tr>'
    }
    html += '</table>';
    return html;
}

function FindElementEdit(ob, isEditable) {
    console.log(isEditable);
    ob.closest('.box-element').find('.view').find('h1').prop('contenteditable', !isEditable).toggleClass('editable');
    ob.closest('.box-element').find('.view').find('h2').prop('contenteditable', !isEditable).toggleClass('editable');
    ob.closest('.box-element').find('.view').find('h3').prop('contenteditable', !isEditable).toggleClass('editable');
    ob.closest('.box-element').find('.view').find('h').prop('contenteditable', !isEditable).toggleClass('editable');
    ob.closest('.box-element').find('.view').find('p').prop('contenteditable', !isEditable).toggleClass('editable');
    ob.closest('.box-element').find('.view').find('a').prop('contenteditable', !isEditable).toggleClass('editable');
    ob.closest('.box-element').find('.view').find('span').prop('contenteditable', !isEditable).toggleClass('editable');
    ob.closest('.box-element').find('.view').find('en').prop('contenteditable', !isEditable).toggleClass('editable');
    ob.closest('.box-element').find('.view').find('th').prop('contenteditable', !isEditable).toggleClass('editable');
    ob.closest('.box-element').find('.view').find('button').prop('contenteditable', !isEditable).toggleClass('editable');
}

function Reverse(ob) {
    var e1 = ob.parent().parent().find('.view span:first')['0']['outerHTML'];
    var e2 = ob.parent().parent().find('.view span:last')['0']['outerHTML'];
    ob.parent().parent().find('.view').html(e2 + e1)
}

function out(x) {
    console.log(x)
}

function NameGenerator(text, ob) {
    var title = 'name'
    // if (ob) {
    //      title = ob.find('.name-title').html();
    //      if(title == undefined){
    //          title = ob.find('h1').html();
    //      }
    //      if(title == undefined){
    //          title = 'name'
    //      }else {
    //          title = GetNormalName(title);
    //      }
    // }
    var text = text + '_' + title + '_';
    var possible = "7418529630215478963205147852014679580312945";
    for (var i = 0; i < 3; i++)text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}

function GetNormalName(string) {
    var s1 = string.replace(/\ /g, "_");
    // s1 = s1.replace(/[^-0-9]/gim,'');
    // s1 = s1.replace(' ', "_");
    s1 = s1.replace(':', "");
    return s1;
}
