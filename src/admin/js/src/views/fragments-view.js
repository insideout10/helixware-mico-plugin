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