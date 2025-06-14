$(function () {

    $('[data-toggle="tooltip"]').tooltip();

    // https://www.jqueryscript.net/text/string-url-slug.html
    $("input#title").stringToSlug({
        getPut: 'input.slug'
    });

    $('.select2').select2();

    bsCustomFileInput.init();

    $('.summernote').summernote({
        height: 300
    });

    $('.del-item').on('click', function () {
        return confirm('Are you sure?');
    });

    // https://www.jqueryscript.net/text/advanced-clipboard-copy-click.html
    $('.btn-copy').copyOnClick({
        confirmText: "Copied",
        confirmTime: 1,
    });

});
