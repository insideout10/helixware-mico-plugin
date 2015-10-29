var FaceDetectionFragments = Backbone.Collection.extend( {
    model: helixware.model.FaceDetectionFragment,
    url: '/wp-admin/admin-ajax.php?action=hw_face_detection_fragments&id=191'
} );

module.exports = FaceDetectionFragments;