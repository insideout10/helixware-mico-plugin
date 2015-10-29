(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
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
},{"./controllers/test-controller":2,"./models/face-detection-fragment":3,"./models/face-detection-fragments":4,"./views/fragment-view":5,"./views/fragments-view":6}],2:[function(require,module,exports){
var x = 10;

var fragments = new helixware.model.FaceDetectionFragments( [] );
fragments.fetch();

var fragmentsView = new helixware.view.FragmentsView( fragments );


},{}],3:[function(require,module,exports){
var FaceDetectionFragment = Backbone.Model.extend( {} );

module.exports = FaceDetectionFragment;
},{}],4:[function(require,module,exports){
var FaceDetectionFragments = Backbone.Collection.extend( {
    model: helixware.model.FaceDetectionFragment,
    url: '/wp-admin/admin-ajax.php?action=hw_face_detection_fragments&id=191'
} );

module.exports = FaceDetectionFragments;
},{}],5:[function(require,module,exports){
var FragmentView = Backbone.View.extend( {

    tagName: 'li',

    template: _.template( '<#= start #>' ),

    initialize: function ( options ) {

        options = options || {};

        this.model = options.model || null;
        this.parentView = options.parentView || null;

    },

    render: function () {

        this.$el.html( this.template( this.model.attributes ) );

    }

} );

module.exports = FragmentView;
},{}],6:[function(require,module,exports){
var FragmentView = helixware.view.FragmentView;

var FragmentsView = Backbone.View.extend( {

    el: 'body',

    initialize: function () {

        this.listenTo( this.model, 'change', this.render );

    },

    render: function () {

        _.each( this.model, function ( item ) {
            this.$el.append( new FragmentView( item.attributes ) );
        } );

    }

} );

module.exports = FragmentsView;
},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset:utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9ncnVudC1icm93c2VyaWZ5L25vZGVfbW9kdWxlcy9icm93c2VyaWZ5L25vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJzcmMvYWRtaW4vanMvc3JjL2FkbWluLm1hbmlmZXN0LmpzIiwic3JjL2FkbWluL2pzL3NyYy9jb250cm9sbGVycy90ZXN0LWNvbnRyb2xsZXIuanMiLCJzcmMvYWRtaW4vanMvc3JjL21vZGVscy9mYWNlLWRldGVjdGlvbi1mcmFnbWVudC5qcyIsInNyYy9hZG1pbi9qcy9zcmMvbW9kZWxzL2ZhY2UtZGV0ZWN0aW9uLWZyYWdtZW50cy5qcyIsInNyYy9hZG1pbi9qcy9zcmMvdmlld3MvZnJhZ21lbnQtdmlldy5qcyIsInNyYy9hZG1pbi9qcy9zcmMvdmlld3MvZnJhZ21lbnRzLXZpZXcuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7QUNBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDWEE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUNQQTtBQUNBO0FBQ0E7O0FDRkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQ0xBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUN2QkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uIGUodCxuLHIpe2Z1bmN0aW9uIHMobyx1KXtpZighbltvXSl7aWYoIXRbb10pe3ZhciBhPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7aWYoIXUmJmEpcmV0dXJuIGEobywhMCk7aWYoaSlyZXR1cm4gaShvLCEwKTt2YXIgZj1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK28rXCInXCIpO3Rocm93IGYuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixmfXZhciBsPW5bb109e2V4cG9ydHM6e319O3Rbb11bMF0uY2FsbChsLmV4cG9ydHMsZnVuY3Rpb24oZSl7dmFyIG49dFtvXVsxXVtlXTtyZXR1cm4gcyhuP246ZSl9LGwsbC5leHBvcnRzLGUsdCxuLHIpfXJldHVybiBuW29dLmV4cG9ydHN9dmFyIGk9dHlwZW9mIHJlcXVpcmU9PVwiZnVuY3Rpb25cIiYmcmVxdWlyZTtmb3IodmFyIG89MDtvPHIubGVuZ3RoO28rKylzKHJbb10pO3JldHVybiBzfSkiLCJ2YXIgJCA9IGpRdWVyeTtcblxudmFyIGhlbGl4d2FyZSA9IHdpbmRvdy5oZWxpeHdhcmUgPSB3aW5kb3cuaGVsaXh3YXJlIHx8IHt9O1xuaGVsaXh3YXJlLm1vZGVsID0gaGVsaXh3YXJlLm1vZGVsIHx8IHt9O1xuaGVsaXh3YXJlLmNvbnRyb2xsZXIgPSBoZWxpeHdhcmUuY29udHJvbGxlciB8fCB7fTtcbmhlbGl4d2FyZS52aWV3ID0gaGVsaXh3YXJlLnZpZXcgfHwge307XG5cbmhlbGl4d2FyZS5tb2RlbC5GYWNlRGV0ZWN0aW9uRnJhZ21lbnQgPSByZXF1aXJlKCAnLi9tb2RlbHMvZmFjZS1kZXRlY3Rpb24tZnJhZ21lbnQnICk7XG5oZWxpeHdhcmUubW9kZWwuRmFjZURldGVjdGlvbkZyYWdtZW50cyA9IHJlcXVpcmUoICcuL21vZGVscy9mYWNlLWRldGVjdGlvbi1mcmFnbWVudHMnICk7XG5oZWxpeHdhcmUudmlldy5GcmFnbWVudFZpZXcgPSByZXF1aXJlKCAnLi92aWV3cy9mcmFnbWVudC12aWV3JyApO1xuaGVsaXh3YXJlLnZpZXcuRnJhZ21lbnRzVmlldyA9IHJlcXVpcmUoICcuL3ZpZXdzL2ZyYWdtZW50cy12aWV3JyApO1xuaGVsaXh3YXJlLmNvbnRyb2xsZXIuVGVzdCA9IHJlcXVpcmUoICcuL2NvbnRyb2xsZXJzL3Rlc3QtY29udHJvbGxlcicgKTsiLCJ2YXIgeCA9IDEwO1xuXG52YXIgZnJhZ21lbnRzID0gbmV3IGhlbGl4d2FyZS5tb2RlbC5GYWNlRGV0ZWN0aW9uRnJhZ21lbnRzKCBbXSApO1xuZnJhZ21lbnRzLmZldGNoKCk7XG5cbnZhciBmcmFnbWVudHNWaWV3ID0gbmV3IGhlbGl4d2FyZS52aWV3LkZyYWdtZW50c1ZpZXcoIGZyYWdtZW50cyApO1xuXG4iLCJ2YXIgRmFjZURldGVjdGlvbkZyYWdtZW50ID0gQmFja2JvbmUuTW9kZWwuZXh0ZW5kKCB7fSApO1xuXG5tb2R1bGUuZXhwb3J0cyA9IEZhY2VEZXRlY3Rpb25GcmFnbWVudDsiLCJ2YXIgRmFjZURldGVjdGlvbkZyYWdtZW50cyA9IEJhY2tib25lLkNvbGxlY3Rpb24uZXh0ZW5kKCB7XG4gICAgbW9kZWw6IGhlbGl4d2FyZS5tb2RlbC5GYWNlRGV0ZWN0aW9uRnJhZ21lbnQsXG4gICAgdXJsOiAnL3dwLWFkbWluL2FkbWluLWFqYXgucGhwP2FjdGlvbj1od19mYWNlX2RldGVjdGlvbl9mcmFnbWVudHMmaWQ9MTkxJ1xufSApO1xuXG5tb2R1bGUuZXhwb3J0cyA9IEZhY2VEZXRlY3Rpb25GcmFnbWVudHM7IiwidmFyIEZyYWdtZW50VmlldyA9IEJhY2tib25lLlZpZXcuZXh0ZW5kKCB7XG5cbiAgICB0YWdOYW1lOiAnbGknLFxuXG4gICAgdGVtcGxhdGU6IF8udGVtcGxhdGUoICc8Iz0gc3RhcnQgIz4nICksXG5cbiAgICBpbml0aWFsaXplOiBmdW5jdGlvbiAoIG9wdGlvbnMgKSB7XG5cbiAgICAgICAgb3B0aW9ucyA9IG9wdGlvbnMgfHwge307XG5cbiAgICAgICAgdGhpcy5tb2RlbCA9IG9wdGlvbnMubW9kZWwgfHwgbnVsbDtcbiAgICAgICAgdGhpcy5wYXJlbnRWaWV3ID0gb3B0aW9ucy5wYXJlbnRWaWV3IHx8IG51bGw7XG5cbiAgICB9LFxuXG4gICAgcmVuZGVyOiBmdW5jdGlvbiAoKSB7XG5cbiAgICAgICAgdGhpcy4kZWwuaHRtbCggdGhpcy50ZW1wbGF0ZSggdGhpcy5tb2RlbC5hdHRyaWJ1dGVzICkgKTtcblxuICAgIH1cblxufSApO1xuXG5tb2R1bGUuZXhwb3J0cyA9IEZyYWdtZW50VmlldzsiLCJ2YXIgRnJhZ21lbnRWaWV3ID0gaGVsaXh3YXJlLnZpZXcuRnJhZ21lbnRWaWV3O1xuXG52YXIgRnJhZ21lbnRzVmlldyA9IEJhY2tib25lLlZpZXcuZXh0ZW5kKCB7XG5cbiAgICBlbDogJ2JvZHknLFxuXG4gICAgaW5pdGlhbGl6ZTogZnVuY3Rpb24gKCkge1xuXG4gICAgICAgIHRoaXMubGlzdGVuVG8oIHRoaXMubW9kZWwsICdjaGFuZ2UnLCB0aGlzLnJlbmRlciApO1xuXG4gICAgfSxcblxuICAgIHJlbmRlcjogZnVuY3Rpb24gKCkge1xuXG4gICAgICAgIF8uZWFjaCggdGhpcy5tb2RlbCwgZnVuY3Rpb24gKCBpdGVtICkge1xuICAgICAgICAgICAgdGhpcy4kZWwuYXBwZW5kKCBuZXcgRnJhZ21lbnRWaWV3KCBpdGVtLmF0dHJpYnV0ZXMgKSApO1xuICAgICAgICB9ICk7XG5cbiAgICB9XG5cbn0gKTtcblxubW9kdWxlLmV4cG9ydHMgPSBGcmFnbWVudHNWaWV3OyJdfQ==
