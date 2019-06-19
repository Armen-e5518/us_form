function SavePdfContentFile(content) {
    var data = {};
    data.id = _Id;
    data.form_id = _Form_id;
    data.content = content;
    $.ajax({
        type: "POST",
        url: _baseUrl + "/ajax/save-pdf-content",
        data: data,
        success: function (res) {
            if (_Pdf == 1) {
                // /admin/site/set-pdf?fid=198&id=15
                var href = location.protocol + "//" + document.domain + _baseUrl + '/site/set-pdf?fid=' + _Form_id + '&id=' + _Id;
                window.location.href = href;
            }
            if (_Zip == 1) {
                // /admin/site/set-pdf?fid=198&id=15
                var href = location.protocol + "//" + document.domain + _baseUrl + '/site/save-zip-file?fid=' + _Form_id + '&id=' + _Id;
                win = window.open(href);
                var timer = setInterval(checkChild, 500);
                function checkChild() {
                    if (win.closed) {
                        var href = location.protocol + "//" + document.domain + _baseUrl + '/site';
                        window.location.href = href;
                    }
                }
            }
        }
    })
}

