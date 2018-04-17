$(document).ready(function () {
    $('.save-form').click(function () {
        var form_name = $('#form-name').val();
        var user_last_name = $('.demo .user-last-name').length;
        var user_first_name = $('.demo .user-first-name').length;
        var user_email_name = $('.demo .user-email-name').length;
        var flag = true;
        if (!form_name) {
            flag = false;
            alert('Please add "Form name"')
        } else if (!user_first_name) {
            flag = false;
            alert('Please add field "User First Name"')
        } else if (!user_last_name) {
            flag = false;
            alert('Please add field "User Last Name"')
        } else if (!user_email_name) {
            flag = false;
            alert('Please add field "User Email"')
        }
        if (flag) {
            SetItemName();
			 SetMaxCharacter();
            setTimeout(function () {
                SaveForm()
            }, 500)
        }
    });
});

function SetItemName() {
    $('.demo .column .view').each(function () {
        var ob = $(this);
        if (ob.find('textarea').length > 0) {
            out('textarea');
            ob.find('textarea').attr('name', NameGenerator('textarea', ob));
            ob.find('textarea').addClass('gen-name')
        }
        if (ob.find('.gen-text').length > 0) {
            out('text');
            ob.find('.gen-text').attr('name', NameGenerator('text', ob));
            ob.find('.gen-text').addClass('gen-name')
        }
        if (ob.find('.gen-checkbox').length > 0) {
            out('checkbox');
            ob.find('.gen-checkbox').attr('name', NameGenerator('checkbox', ob));
            ob.find('.gen-checkbox').addClass('gen-name')
        }
        if (ob.find('select').length > 0) {
            out('select');
            ob.find('select').attr('name', NameGenerator('select'));
            ob.find('select').addClass('gen-name')
        }
        if (ob.find('.gen-redio').length > 0) {
            out('redio');
            // ob.find('.gen-redio').attr('name', NameGenerator('radio'))
            ob.find('.gen-redio').addClass('gen-name', ob)
        }
        if (ob.find('.gen-file').length > 0) {
            out('file');
            ob.find('.gen-file').attr('name', NameGenerator('file', ob));
            ob.find('.gen-file').addClass('gen-name')
        }
        if (ob.find('table textarea').length > 0) {
            out('table');
            ob.find('table th textarea').each(function () {
                $(this).attr('name', NameGenerator('table', ob));
                $(this).addClass('gen-name')
            })

        }
    })
}

function SaveForm() {
    var data = {};
    data.id = _Id;
    data.html = $('#html-data').html();
    data.name = $('#form-name').val();
    var form_id;
    $.ajax({
        type: "POST",
        url: _baseUrl + "/ajax/save-form",
        data: data,
        success: function (res) {
            if (res != undefined) {
                var ob_name = [];
                var item = {};
                $('.demo .gen-name').each(function () {
                    item = {};
                    item.type = ($(this).attr('type') == 'number') ? 'int' : 'string';
                    item.name = $(this).attr('name');
                    item.id = res;
                    form_id = item.id;
                    if ($(this).hasClass('search-on')) {
                        item.search = 'search';
                        item.c_name = $(this).closest('.box-element').find('#column-name-l').val();
                        item.c_name = item.c_name ? item.c_name : 'Name';
                    }
                    ob_name.push(item)
                });
                $.ajax({
                    type: "POST",
                    url: _baseUrl + "/ajax/create-table-by-data",
                    data: toObject(ob_name),
                    success: function (data) {
                        var href = location.protocol + "//" + document.domain + _baseUrl + '/forms';
                        window.location.href = href;
                    }
                });
            }
        }
    });
}

function toObject(arr) {
    var rv = {};
    for (var i = 0; i < arr.length; ++i)
        rv[i] = arr[i];
    return rv;
}


function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function SetMaxCharacter() {

    $('.demo #max-character').each(function () {
        $(this).closest('.box-element').find('.view input').attr('max-character', $(this).val())
        $(this).closest('.box-element').find('.view textarea').attr('max-character', $(this).val())
    })

}