App = Ember.Application.create({
    LOG_TRANSITIONS: true,
    LOG_TRANSITIONS_INTERNAL: true
});

App.ApplicationView = Ember.View.extend({
    templateName: 'application'
});


App.Router.map(function() {
    this.route("index", {path: "/"});
    this.route("detail", {path: "/detail"});
});

App.ApplicationAdapter = DS.RESTAdapter.extend({
    host: '/days/update'
});

App.IndexRoute = Ember.Route.extend({
    model: function () {
        return Ember.$.getJSON('/days').then(function (data) {
            return data;
        });
    }
});

App.Day = DS.Model.extend({
    date: DS.attr('string'),
    feat: DS.attr('string')
});


App.IndexController = Ember.ObjectController.extend({
    actions: {
        save: function () {
            this.set('isEdit', false);


            var post = this.store.createRecord('day', {
                date: 123,
                feat: 'Lorem ipsum'
            });

            post.save();
        },
        click: function () {
            this.set('isEdit', true);
        }
    }
});