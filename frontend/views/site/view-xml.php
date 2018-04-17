<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>


<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileForUpload">
    <!--    <input type="submit" value="Upload Image" name="submit">-->
    <p id="submit">submit</p>
</form>
<p id="fileContents"></p>
<script>

    $(document).ready(function () {

        $('#submit').click(function () {
            var file = document.getElementById("fileForUpload").files[0];
            if (file) {
                var reader = new FileReader();
                reader.readAsText(file, "UTF-8");
                reader.onload = function (evt) {
                    var content = evt.target.result;
                    var data = {};
                    data.content = content;
                    $.ajax({
                        type: "POST",
                        url: "/ajax/save-pdf-content",
                        data: data,
                        success: function (res) {

                        }
                    })
                };

            }
        })

    })

</script>

</body>
</html>