var FlagFileSize = true;

$(document).ready(function () {

    $('body').click(function () {
        CheckNotEmptyAndEmailVal(false)
    })
    $('#save-data').click(function () {
        var ob = $(this);
        ob.find('.loading').show();
        ob.prop('disabled', true)
        if (CheckNotEmptyAndEmailVal(true)) {
            $('#data-form').submit();
        } else {
            ob.find('.loading').hide();
            ob.prop('disabled', false)
            console.log('Not Valid')
        }
    })

    $('#user-view textarea').on('keydown , paste', function () {
        var el = this;
        setTimeout(function () {
            el.style.cssText = 'height:auto; padding:0';
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
        }, 0);
    })
});

function CheckNotEmptyAndEmailVal(scroll_flag, FlagFileSize) {
    var flag = true;
    var MaxFileSize = 60*1000*1000;
    var MaxFileSizeHtml = '60Mb';
    $('#user-view .not-empty').each(function () {
        var val = $(this).val();
        if (!val) {
            flag = false;
            out('not-empty');
            $(this).addClass('empty-active');
            $(this).closest('.view').find('.error-pop').remove()
            $(this).after('<span class="error-pop">Required field...</span>')
            if (scroll_flag) {
                $('body').scrollTop($(this).offset().top - 80);
            }
        } else {
            $(this).removeClass('empty-active')
            $(this).closest('.view').find('.error-pop').remove()
        }
    });

    // if (flag) {
    $('#user-view input[type="email"]').each(function () {
        if (!validateEmail($(this).val())) {
            flag = false;
            out('email');
            $(this).addClass('empty-active')
            $(this).closest('.view').find('.error-pop').remove();
            $(this).after('<span class="error-pop">Incorrect email address...</span>')
            if (scroll_flag) {
                $('body').scrollTop($(this).offset().top - 80);
            }
        } else {
            $(this).removeClass('empty-active')
            $(this).closest('.view').find('.error-pop').remove()
        }
    })
    // }

    // if (flag) {
    $('#user-view .gen-name[max-character]').each(function () {
        if ($(this).val().length * 1 > 0) {
            var max_character = $(this).attr('max-character');
            if (max_character) {
                if ($(this).val().length * 1 > max_character * 1) {
                    flag = false;
                    out('character')
                    $(this).addClass('empty-active')
                    $(this).closest('.view').find('.error-pop').remove()
                    $(this).after('<span class="error-pop">Text should contain at most ' + max_character + ' characters...</span>')
                    if (scroll_flag) {
                        $('body').scrollTop($(this).offset().top - 80);
                    }
                } else {
                    $(this).removeClass('empty-active')
                    $(this).closest('.view').find('.error-pop').remove()
                }
            }
        }
    });

    $('#user-view .gen-file[type="file"]').each(function () {
        var ob = $(this);
        console.log('File');
        $(this).bind('change', function () {
            console.log(this.files[0].size);
            if (typeof this.files[0].size != 'undefined') {
                if (this.files[0].size > MaxFileSize) {
                    ob.attr('file-size','false');
                    out('MaxFileSizeHtml');
                    $(this).addClass('empty-active')
                    $(this).closest('.view').find('.error-pop').remove();
                    $(this).after('<span class="error-pop">File should be a maximum ' + MaxFileSizeHtml + '</span>')
                    if (scroll_flag) {
                        $('body').scrollTop($(this).offset().top - 80);
                    }
                } else {
                    ob.attr('file-size','true');
                    $(this).removeClass('empty-active')
                    $(this).closest('.view').find('.error-pop').remove()
                }
            }
        });
    });
    // }
    var Rad_names = [];
    var Rad_name = '';

    $('#user-view .checked-required').each(function () {
        if (Rad_name != $(this).attr('name-required')) {
            Rad_names.push($(this).attr('name-required'));
            Rad_name = $(this).attr('name-required');
        }
    });

    if (Rad_names) {
        Rad_names.forEach(function (val, index) {
            var rad_flag = false;
            $('#user-view .checked-required[name-required="' + val + '"]').each(function () {
                if ($(this).is(':checked')) {
                    rad_flag = true;
                }
            });
            if (!rad_flag) {
                flag = false;
                var checked_required_ob = $('#user-view .checked-required[name-required="' + val + '"]');
                checked_required_ob.closest('div').find('.name-title').addClass('radio-active')
                if (scroll_flag) {
                    $('body').scrollTop(checked_required_ob.offset().top - 80);
                }
            } else {
                $('#user-view .checked-required[name-required="' + val + '"]').closest('div').find('.name-title').removeClass('radio-active')
            }
        })
    }
    $('#user-view .gen-file[type="file"]').each(function () {
        if(flag){
            if($(this).attr('file-size') == 'false'){
                flag = false;
            }
        }
    })
    console.log('Flag', flag);
    return flag;
}


function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}