(function ($) {
    'use strict';

    /**
     * All of the code for your admin-specific JavaScript source
     * should reside in this file.
     *
     * Note that this assume you're going to use jQuery, so it prepares
     * the $ function reference to be used within the scope of this
     * function.
     *
     * From here, you're able to define handlers for when the DOM is
     * ready:
     *
     * $(function() {
	 *
	 * });
     *
     * Or when the window is loaded:
     *
     * $( window ).load(function() {
	 *
	 * });
     *
     * ...and so on.
     *
     * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
     * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
     * be doing this, we should try to minimize doing that in our own work.
     */

    $(function () {

        const cleanReference = function (reference) {

            return reference.substring(1, reference.length - 1);
        };

        const load = function (action, id, selector, className, context) {

            // Load the topics.
            wp.ajax.post(action, {id: id})
                .done(function (data) {

                    $(selector, context).empty().append(
                        $.map(data, function (item) {
                            return $('<span class="' + className + '">' + item.label + ' <a href="' + cleanReference(item.reference) + '" target="_tab"><i class="fa fa-external-link" aria-hidden="true"></i></a></span>');
                        })
                    );

                })
                .fail(function () {
                    $(selector, context).text('error');
                });

        };

        wp.media.events.on('hx:attachment:details:update', function (view) {

            // Get the attachment id.
            const id = view.model.get('id');

            // Get the _description_ row in the attachment details pane.
            $('.media-modal .media-frame-content .attachment-info .settings .setting[data-setting=description]')
                .each(function () {

                    // Set a jQuery reference.
                    var $this = $(this);

                    // Add the entities row.
                    load('hx_entities', id, '[data-hx-mico-entities]', 'entity', $('<label class="setting" data-setting="entities">'
                        + '<span class="name">Entities</span>'
                        + '<span data-hx-mico-entities="hx-mico-entities">loading...</span>'
                        + '</label>').insertAfter($this));

                    load('hx_topics', id, '[data-hx-mico-topics]', 'topic', $('<label class="setting" data-setting="topics">'
                        + '<span class="name">Topics</span>'
                        + '<span data-hx-mico-topics="hx-mico-topics">loading...</span>'
                        + '</label>').insertAfter($this));

                });

        });
    });

})(jQuery);
