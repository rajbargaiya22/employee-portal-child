jQuery(document).ready(function($) {
    $('#pdf_upload_button').click(function(e) {
        e.preventDefault();
        var custom_uploader = wp.media({
            title: 'Choose PDF',
            button: {
                text: 'Use this PDF'
            },
            multiple: false,
            library: {
                type: 'application/pdf'
            }
        })
        .on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#pdf_url').val(attachment.url);
        })
        .open();
    });
});