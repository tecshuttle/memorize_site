App = Ember.Application.create({
    //LOG_TRANSITIONS: true,
    //LOG_TRANSITIONS_INTERNAL: true
});

App.ApplicationView = Ember.View.extend({
    templateName: 'application'
});


App.Router.map(function () {
    this.route("index", {path: "/"});
    this.route("detail", {path: "/detail"});
});

App.IndexController = Ember.ObjectController.extend({
    actions: {
        click: function () {
            this.transitionToRoute('detail');
        }
    }
});