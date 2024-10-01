jQuery(document).ready(function($) {

    jQuery('.newsletter-carousel').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
      });

    var searchInput = $('#s');
    var suggestionsContainer = $('#search-suggestions');
    var timer;

    searchInput.on('input', function() {
        clearTimeout(timer);
        var query = $(this).val();

        if (query.length < 2) {
            suggestionsContainer.empty();
            suggestionsContainer.removeClass('show');
            return;
        }

        timer = setTimeout(function() {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_search_suggestions',
                    query: query
                },
                success: function(response) {
                    if (response.success) {
                        var results = response.data;
                        var html = '';
                        
                        for (var postType in results) {
                            if (results.hasOwnProperty(postType)) {
                                // html += '<h3>' + capitalizeFirstLetter(postType) + '</h3>';
                                html += '<ul>';
                                results[postType].forEach(function(result) {
                                    html += '<li>';
                                    html += '<a href="' + result.url + '">';
                                    html += '<strong>' + result.title + '</strong>';
                                    // html += '<br><small>' + result.excerpt + '</small>';
                                    html += '</a>';
                                    html += '</li>';
                                });
                                html += '</ul>';
                            }
                        }
                        
                        suggestionsContainer.html(html);
                        suggestionsContainer.addClass('show');
                    } else {
                        suggestionsContainer.html('<p>No results found</p>');
                    }
                }
            });
        }, 300);
    });

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

});


jQuery(document).ready(function($) {
    $('#vendor-searchform').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();

        $.ajax({
            url: ajaxurl,
            type: 'GET',
            data: formData + '&action=vendor_search',
            success: function(response) {
                $('#rj-vendor-list').html(response); 
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});


// document.addEventListener('DOMContentLoaded', function() {
//     const canvas = document.getElementById('pdf-canvas');
//     if (canvas) {
//         const url = canvas.dataset.pdfUrl;
//         console.log("PDF URL:", url);

//         // Set the worker source
//         pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';

//         // Load the PDF
//         pdfjsLib.getDocument(url).promise
//             .then(function(pdf) {
//                 return pdf.getPage(1);
//             })
//             .then(function(page) {
//                 const scale = 1.5;
//                 const viewport = page.getViewport({ scale: scale });

//                 canvas.height = viewport.height;
//                 canvas.width = viewport.width;

//                 const context = canvas.getContext('2d');
//                 const renderContext = {
//                     canvasContext: context,
//                     viewport: viewport
//                 };
//                 return page.render(renderContext);
//             })
//             .catch(function(error) {
//                 console.error('Error loading PDF:', error);
//                 canvas.insertAdjacentHTML('afterend', '<p>Error loading PDF. Please try again later.</p>');
//             });
//     }
// });