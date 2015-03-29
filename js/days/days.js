App = Ember.Application.create({
    //LOG_TRANSITIONS: true,
    //LOG_TRANSITIONS_INTERNAL: true
});


App.ApplicationAdapter = DS.FixtureAdapter.extend();

App.IndexRoute = Ember.Route.extend({
    model: function () {
        return this.store.find('day');
    }
});

App.Day = DS.Model.extend({
    date: DS.attr('string'),
    feat: DS.attr('string'),
    isEdit: DS.attr('boolean')
});

App.Day.FIXTURES = [
    {
        id: 1,
        date: '23',
        feat: 'Learn Ember.js',
        isEdit: true
    },
    {
        id: 2,
        date: '24',
        feat: 'Make a Sample',
        isEdit: false
    },
    {
        id: 3,
        date: '25',
        feat: 'Profit!',
        isEdit: false
    }
];

App.IndexController = Ember.ObjectController.extend({
    actions: {
        save: function () {
            this.set('isEdit', false)
        },
        click: function () {
            this.set('isEdit', true);
        }
    }
});