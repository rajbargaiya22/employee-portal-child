(function($) {
    wp.customize.bind('ready', function() {
        var portalCount = wp.customize('custom_portals_count')();
        var container = $('#customize-control-custom_portals_fields');

        function createPortalFields(index) {
            var fieldGroup = $('<div class="portal-field-group"></div>');
            fieldGroup.append('<label>Portal ' + (index + 1) + ' Title</label>');
            fieldGroup.append('<input type="text" data-customize-setting-link="custom_portal_' + index + '_title">');
            fieldGroup.append('<label>Portal ' + (index + 1) + ' Icon (SVG)</label>');
            fieldGroup.append('<textarea data-customize-setting-link="custom_portal_' + index + '_icon"></textarea>');
            fieldGroup.append('<label>Portal ' + (index + 1) + ' Link Text</label>');
            fieldGroup.append('<input type="text" data-customize-setting-link="custom_portal_' + index + '_link">');
            return fieldGroup;
        }

        function updatePortalFields() {
            container.empty();
            for (var i = 0; i < portalCount; i++) {
                container.append(createPortalFields(i));
            }
        }

        updatePortalFields();

        wp.customize('custom_portals_count', function(value) {
            value.bind(function(newval) {
                portalCount = parseInt(newval);
                updatePortalFields();
            });
        });
    });
})(jQuery);