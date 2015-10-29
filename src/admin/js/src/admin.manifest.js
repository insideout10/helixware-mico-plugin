var $ = jQuery;

var helixware = window.helixware = window.helixware || {};
helixware.model = helixware.model || {};
helixware.controller = helixware.controller || {};
helixware.view = helixware.view || {};

helixware.model.FaceDetectionFragment = require( './models/face-detection-fragment' );
helixware.model.FaceDetectionFragments = require( './models/face-detection-fragments' );
helixware.view.FragmentView = require( './views/fragment-view' );
helixware.view.FragmentsView = require( './views/fragments-view' );
helixware.controller.Test = require( './controllers/test-controller' );