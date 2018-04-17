<link rel="stylesheet" href="//codemirror.net/lib/codemirror.css">
<link rel="stylesheet" href="https://codemirror.net/addon/hint/show-hint.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//codemirror.net/lib/codemirror.js"></script>
<script src="http://codemirror.net/mode/css/css.js"></script>
<script src="https://codemirror.net/addon/hint/show-hint.js"></script>
<script src="https://codemirror.net/addon/hint/javascript-hint.js"></script>

<form action="" method="post" id="css-ed">

  <textarea style="background-color: #a6d6c7; font-size: 20px" name="css" id="csseditor" cols="100" rows="25"
            class="codemirror-textarea">
    <?= $data ?>
</textarea>

    <br>
    <input type="submit" value="Save">
</form>
<script>
    //    var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('csseditor'), {
    //        mode:  "css"
    //    });
    $(document).ready(function () {

        var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("csseditor"), {
            extraKeys: {"Ctrl-Space": "autocomplete"}

        });
        myCodeMirror.setSize(1000, 600);

        $(document).bind('keydown', function(e) {
            if(e.ctrlKey && (e.which == 83)) {
                $('#css-ed').submit();
                e.preventDefault();

                return false;
            }
        });
        setTimeout(function () {
            $('.CodeMirror-scroll').scrollTop(9999)
            $('.CodeMirror').scrollTop = 10000;
            $('.CodeMirror-vscrollbar').scrollTop = 10000;
        },500)

    })

</script>