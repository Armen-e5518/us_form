$(document).ready(function () {

    console.log('Run Upload')

    $('#xml-submit').click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        $('#xml-submit .loading').show()
        var file = document.getElementById("xml-file").files[0];
        if (file) {
            var reader = new FileReader();
            reader.readAsText(file, "UTF-8");
            reader.onload = function (evt) {
                var content = evt.target.result;
                var data = {};
                var flag = false;
                data.content = content;
                $.ajax({
                    type: "POST",
                    url: "/forms/site/get-json",
                    data: data,
                    success: function (res) {
                        $('#xml-submit .loading').hide()
                        var keys = Object.keys(res);
                        for (var i = 0; i < keys.length; i++) {
                            var form_name = keys[i];
                            var form_value = res[form_name];
                            if (i == 0) {
                                if ($('input[name="form_id"]').val() == form_value) {
                                    flag = true;
                                } else {
                                    alert('this file does not match the form');
                                    break;
                                }
                            }
                            if (flag) {
                                if (form_name.indexOf('textarea') >= 0
                                    || form_name.indexOf('text') >= 0
                                    || form_name.indexOf('table') >= 0
                                    || form_name.indexOf('user') >= 0
                                ) {
                                    $('[name="' + form_name + '"]').val(form_value)
                                } else if (form_name.indexOf('checkbox') >= 0) {
                                    if (form_value == 'on') {
                                        $('[name="' + form_name + '"]').prop('checked', true)
                                    }
                                } else if (form_name.indexOf('radio') >= 0) {
                                    if (form_value) {
                                        $('#user-view input.gen-redio[value="' + form_value + '"]').prop('checked', true);
                                    }
                                } else if (form_name.indexOf('select') >= 0) {
                                    $('[name="' + form_name + '"]').val(form_value)
                                }
                            }
                        }
                        $('#xml-file')[0].value = '';
                        CheckNotEmptyAndEmailVal(false)
                    }
                })
            };
        }
    });

    $('#save-xml').click(function (e) {
        var form_data = [{
            name: 'form-id',
            val: $('input[name="form_id"]').val()
        }];
        $('#user-view .gen-name').each(function () {
            var form_name = $(this).attr('name');
            if ((
                    form_name.indexOf('text') >= 0
                    || form_name.indexOf('user') >= 0
                    || form_name.indexOf('select') >= 0)
                && $(this).val()
            ) {
                form_data.push({
                    name: form_name,
                    val: $(this).val()
                })
            } else if (
                form_name.indexOf('checkbox') >= 0
                || form_name.indexOf('radio') >= 0
            ) {
                if ($(this).is(':checked')) {
                    form_data.push({
                        name: form_name,
                        val: $(this).val()
                    })
                }
            } else if (form_name.indexOf('table') >= 0) {
                if ($(this).html() || $(this).val()) {
                    var val_t = $(this).html() ? $(this).html() : $(this).val()
                    form_data.push({
                        name: form_name,
                        val: val_t
                    })
                }
            }
            else if (form_name.indexOf('textarea') >= 0) {
                if ($(this).html()) {
                    form_data.push({
                        name: form_name,
                        val: $(this).html()
                    })
                }
            }
        });
        var data = {};
        data.data = form_data;
        data.name = __Form_name;
        $.ajax({
            type: "POST",
            url: "/forms/site/get-xml-file-name",
            data: data,
            success: function (res) {
                window.location = "/forms/site/download-xml?xml=" + res;
            }
        })
    })

})