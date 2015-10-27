<?php

/**
 * Manage templates.
 *
 * @since 1.3.0
 */
class Helixware_Mico_Template_Service {

	public function __construct() {

		add_action( 'admin_footer-upload.php', array(
			$this,
			'admin_footer_upload'
		) );

	}

	public function admin_footer_upload() {

?>

		<script type="text/html" id="tmpl-helixware-mico-attachment-details-two-column">
			<div class="attachment-media-view {{ data.orientation }}">
				<div class="thumbnail thumbnail-{{ data.type }}">

					<a class='nav-tab nav-tab-active' href='#tab-1'>Chapters</a>
					<a class='nav-tab' href='#tab-2'>Faces</a>

					<# _.each(data.faceDetectionFragments, function(fragment){ #>
						{{fragment.start}}
					<# }); #>
				</div>
			</div>
			<div class="attachment-info">
			<span class="settings-save-status">
				<span class="spinner"></span>
				<span class="saved"><?php esc_html_e('Saved.'); ?></span>
			</span>
				<div class="details">
					<div class="filename"><strong><?php _e( 'File type:' ); ?></strong> {{ data.mime }}</div>
					<div class="uploaded"><strong><?php _e( 'Uploaded on:' ); ?></strong> {{ data.dateFormatted }}</div>

					<# if ( 'image' === data.type && ! data.uploading ) { #>
						<# if ( data.width && data.height ) { #>
							<div class="dimensions"><strong><?php _e( 'Dimensions:' ); ?></strong> {{ data.width }} &times; {{ data.height }}</div>
							<# } #>
								<# } #>

									<# if ( data.fileLength ) { #>
										<div class="file-length"><strong><?php _e( 'Length:' ); ?></strong> {{ data.fileLength }}</div>
										<# } #>

											<# if ( 'audio' === data.type && data.meta.bitrate ) { #>
												<div class="bitrate">
													<strong><?php _e( 'Bitrate:' ); ?></strong> {{ Math.round( data.meta.bitrate / 1000 ) }}kb/s
													<# if ( data.meta.bitrate_mode ) { #>
														{{ ' ' + data.meta.bitrate_mode.toUpperCase() }}
														<# } #>
												</div>
												<# } #>

													<div class="compat-meta">
														<# if ( data.compat && data.compat.meta ) { #>
															{{{ data.compat.meta }}}
															<# } #>
													</div>
				</div>

				<div class="settings">
					<label class="setting" data-setting="url">
						<span class="name"><?php _e('URL'); ?></span>
						<input type="text" value="{{ data.url }}" readonly />
					</label>
					<# var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly'; #>
						<?php if ( post_type_supports( 'attachment', 'title' ) ) : ?>
							<label class="setting" data-setting="title">
								<span class="name"><?php _e('Title'); ?></span>
								<input type="text" value="{{ data.title }}" {{ maybeReadOnly }} />
							</label>
						<?php endif; ?>
						<# if ( 'audio' === data.type ) { #>
							<?php foreach ( array(
								'artist' => __( 'Artist' ),
								'album' => __( 'Album' ),
							) as $key => $label ) : ?>
								<label class="setting" data-setting="<?php echo esc_attr( $key ) ?>">
									<span class="name"><?php echo $label ?></span>
									<input type="text" value="{{ data.<?php echo $key ?> || data.meta.<?php echo $key ?> || '' }}" />
								</label>
							<?php endforeach; ?>
							<# } #>
								<label class="setting" data-setting="caption">
									<span class="name"><?php _e( 'Caption' ); ?></span>
									<textarea {{ maybeReadOnly }}>{{ data.caption }}</textarea>
								</label>
								<# if ( 'image' === data.type ) { #>
									<label class="setting" data-setting="alt">
										<span class="name"><?php _e( 'Alt Text' ); ?></span>
										<input type="text" value="{{ data.alt }}" {{ maybeReadOnly }} />
									</label>
									<# } #>
										<label class="setting" data-setting="description">
											<span class="name"><?php _e('Description'); ?></span>
											<textarea {{ maybeReadOnly }}>{{ data.description }}</textarea>
										</label>
										<label class="setting">
											<span class="name"><?php _e( 'Uploaded By' ); ?></span>
											<span class="value">{{ data.authorName }}</span>
										</label>
										<# if ( data.uploadedToTitle ) { #>
											<label class="setting">
												<span class="name"><?php _e( 'Uploaded To' ); ?></span>
												<# if ( data.uploadedToLink ) { #>
													<span class="value"><a href="{{ data.uploadedToLink }}">{{ data.uploadedToTitle }}</a></span>
													<# } else { #>
														<span class="value">{{ data.uploadedToTitle }}</span>
														<# } #>
											</label>
											<# } #>
												<div class="attachment-compat"></div>
				</div>

				<div class="actions">
					<a class="view-attachment" href="{{ data.link }}"><?php _e( 'View attachment page' ); ?></a>
					<# if ( data.can.save ) { #> |
						<a href="post.php?post={{ data.id }}&action=edit"><?php _e( 'Edit more details' ); ?></a>
						<# } #>
							<# if ( ! data.uploading && data.can.remove ) { #> |
								<?php if ( MEDIA_TRASH ): ?>
								<# if ( 'trash' === data.status ) { #>
									<button type="button" class="button-link untrash-attachment"><?php _e( 'Untrash' ); ?></button>
									<# } else { #>
										<button type="button" class="button-link trash-attachment"><?php _ex( 'Trash', 'verb' ); ?></button>
										<# } #>
											<?php else: ?>
												<button type="button" class="button-link delete-attachment"><?php _e( 'Delete Permanently' ); ?></button>
											<?php endif; ?>
											<# } #>
				</div>

			</div>
		</script>
		<script>
			(function ($) {

				var TwoColumn = wp.media.view.Attachment.Details.TwoColumn.extend({
					initialize: function () {
						_.extend(this.events, wp.media.view.Attachment.Details.TwoColumn.prototype.events);

						this.templates = [
							wp.template('attachment-details-two-column'),
							wp.template('helixware-mico-attachment-details-two-column')
						];

						view = this;

						// Load the face fragments.
						wp.ajax.post('hw_face_detection_fragments', {id: this.model.get('id')}).done(function (fragments) {
							view.model.set({faceDetectionFragments: fragments});
							// Finally render.
							view.render();
						}).fail(function () {
							// controller.trigger('hw:media:attachment:facefragments');
						});


					},
					render: function () {

						// If it's not a HelixWare asset, just call the superclass
						// render method on the standard template.
						if (!helixware.isHelixWare(this.model.get('mime'))) {
							this.template = this.templates[0];
							// Call the superclass render.
							TwoColumn.__super__.render.apply(this, arguments);
							return;
						}

						// Set the HelixWare template.
						this.template = this.templates[1];

						console.log(this.model);
						TwoColumn.__super__.render.apply(view, arguments);

					}

				});

				// Override the TwoColumn view.
				wp.media.view.Attachment.Details.TwoColumn = TwoColumn;
			})(jQuery);
		</script>
<?php

	}

}
