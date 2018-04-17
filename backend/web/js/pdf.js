var form = $('#pdf'),
    cache_width = 1000,
    a4 = [595.28, 841.89];

$(document).ready(function () {
    setTimeout(function () {
        createPDF();
    },1000)
});

function createPDF() {
    getCanvas().then(function (canvas) {
        var img = canvas.toDataURL("image/png"),
            doc = new jsPDF({
                unit: 'px',
                format: 'a4'
            });
        doc.addImage(img, 'JPEG', 5, 8);
        doc.save('form-html-to-pdf.pdf');
        setTimeout(function () {
            close();
        },1000)
    });
}

function getCanvas() {
    form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
    return html2canvas(form, {
        imageTimeout: 2000,
        removeContainer: true
    });
}

