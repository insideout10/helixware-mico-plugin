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