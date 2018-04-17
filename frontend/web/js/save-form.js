$(document).ready(function () {

    // $(document).on('mousedown', '.drag', function () {
    //     var ob = $(this).closest('.box-element').find('.view');
    //     if (ob.find('textarea')) {
    //         ob.find('textarea').attr('name', NameGenerator('textarea',ob))
    //         ob.find('textarea').addClass('gen-name')
    //     }
    //     if (ob.find('.gen-text')) {
    //         ob.find('.gen-text').attr('name', NameGenerator('text',ob))
    //         ob.find('.gen-text').addClass('gen-name')
    //     }
    //     if (ob.find('.gen-checkbox')) {
    //         ob.find('.gen-checkbox').attr('name', NameGenerator('checkbox',ob))
    //         ob.find('.gen-checkbox').addClass('gen-name')
    //     }
    //     if (ob.find('select')) {
    //         ob.find('select').attr('name', NameGenerator('select'))
    //         ob.find('select').addClass('gen-name')
    //     }
    //     if (ob.find('.gen-redio')) {
    //         // ob.find('.gen-redio').attr('name', NameGenerator('radio'))
    //         ob.find('.gen-redio').addClass('gen-name',ob)
    //     }
    //     if (ob.find('.gen-file')) {
    //         ob.find('.gen-file').attr('name', NameGenerator('file',ob))
    //         ob.find('.gen-file').addClass('gen-name')
    //     }
    // });

    $('.save-form').click(function () {
        var form_name = $('#form-name').val();
        var user_last_name = $('.demo .user-last-name').length;
        var user_first_name = $('.demo .user-first-name').length;
        var user_email_name = $('.demo .user-email-name').length;
        var flag = true;
        if (!form_name) {
            flag = false;
            alert('Please add "Form name"')
        } else if(!user_first_name){
            flag = false;
            alert('Please add field "User First Name"')
        }else if(!user_last_name){
            flag = false;
            alert('Please add field "User Last Name"')
        }else if(!user_email_name){
            flag = false;
            alert('Please add field "User Email"')
        }
        if (flag) {
            SetItemName();
            setTimeout(function () {
                SaveForm()
            }, 500)
        }
    })
    $('#save-data').click(function () {
        if (CheckNotEmpty()) {
            $('#data-form').submit();
        }
    })
})
function SetItemName() {
    $('.demo .column .view').each(function () {
        var ob = $(this)
        if (ob.find('textarea').length > 0) {
            out('textarea')
            ob.find('textarea').attr('name', NameGenerator('textarea',ob))
            ob.find('textarea').addClass('gen-name')
        }
        if (ob.find('.gen-text').length > 0) {
            out('text')
            ob.find('.gen-text').attr('name', NameGenerator('text', ob))
            ob.find('.gen-text').addClass('gen-name')
        }
        if (ob.find('.gen-checkbox').length > 0) {
            out('checkbox')
            ob.find('.gen-checkbox').attr('name', NameGenerator('checkbox', ob))
            ob.find('.gen-checkbox').addClass('gen-name')
        }
        if (ob.find('select').length > 0) {
            out('select')
            ob.find('select').attr('name', NameGenerator('select'))
            ob.find('select').addClass('gen-name')
        }
        if (ob.find('.gen-redio').length > 0) {
            out('redio')
            // ob.find('.gen-redio').attr('name', NameGenerator('radio'))
            ob.find('.gen-redio').addClass('gen-name', ob)
        }
        if (ob.find('.gen-file').length > 0) {
            out('file')
            ob.find('.gen-file').attr('name', NameGenerator('file', ob))
            ob.find('.gen-file').addClass('gen-name')
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
        url: "/admin/ajax/save-form",
        data: data,
        success: function (res) {
            if (res != undefined) {
                var ob_name = [];
                var item = {};
                $('.demo .gen-name').each(function () {
                    item = {};
                    item.type = ($(this).attr('type') == 'number') ? 'int' : 'string';
                    item.search = ($(this).hasClass('search-on')) ? 'search' : null;
                    item.name = $(this).attr('name');
                    item.id = res;
                    form_id = item.id;
                    ob_name.push(item)
                });
                $.ajax({
                    type: "POST",
                    url: "/admin/ajax/create-table-by-data",
                    data: toObject(ob_name),
                    success: function (data) {
                        var href = location.protocol + "//" + document.domain + '/admin/form/view?id=' + form_id;
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

function CheckNotEmpty() {
    var flag = true;
    $('.not-empty').each(function () {
        var val = $(this).val();
        if (!val) {
            flag = false;
            $(this).addClass('empty-active')
        } else {
            $(this).removeClass('empty-active')
        }
    });
    return flag;
}