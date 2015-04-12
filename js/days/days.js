$(function () {
    FastClick.attach(document.body);
});

var bounce_forward = new Bounce();
var bounce_return = new Bounce();

Ember.Handlebars.helper('getDate', function (time) {
    var date = new Date(time * 1000);

    if (moment(date).format('D') == '1') {
        return moment(date).format('YYYY-M-D');
    } else {
        return moment(date).format('D');
    }
});

Ember.Handlebars.helper('getWeek', function (time) {
    var date = new Date(time * 1000);

    var e = moment(date).format('e');

    var week = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];

    return week[e];
});

Ember.Handlebars.helper('toHtml', function (feat) {
    return feat ? feat.replace(/\n/g, "<br/>") : '';
});

App = Ember.Application.create({
    //LOG_TRANSITIONS: true,
    //LOG_TRANSITIONS_INTERNAL: true
});

App.ApplicationView = Ember.View.extend({
    templateName: 'application'
});


App.Router.map(function () {
    this.route("index", {path: "/"});
    this.resource('detail', { path: '/detail/:detail_id' }, function () {
    });
});

App.ApplicationAdapter = DS.RESTAdapter.extend({
    host: '/days'
});

App.IndexRoute = Ember.Route.extend({
    model: function () {
        return Ember.$.getJSON('/days').then(function (data) {
            return data;
        });
    }
});

App.Day = DS.Model.extend({
    id: DS.attr(),
    time: DS.attr(),
    feat: DS.attr()
});

App.IndexView = Ember.View.extend({
    templateName: 'index',
    didInsertElement: function () {
        var view = this;
        var $view = this.$();

        bounce_return.translate({
            from: { x: -($(window).width()), y: 0 },
            to: { x: 0, y: 0 },
            duration: 800,
            bounces: 0,
            stiffness: 5
        });

        bounce_return.applyTo($view);
    },
    willDestroyElement: function () {
        //console.log('destroy');
    }
});

App.ItemController = Ember.ObjectController.extend({
    actions: {
        click: function () {
            this.set('old', this.get('feat'));
            this.transitionTo('detail', this);
        }
    }
});

App.DetailView = Ember.View.extend({
    templateName: 'detail',
    didInsertElement: function () {
        $('textarea').autosize({append: ""});
        $('textarea').focus();

        var view = this;
        var $view = this.$();

        bounce_forward.translate({
            from: { x: ($(window).width()), y: 0 },
            to: { x: 0, y: 0 },
            duration: 800,
            bounces: 0,
            stiffness: 5
        });

        bounce_forward.applyTo($view);
    },
    willDestroyElement: function () {
        //console.log('destroy');
    }
});

App.DetailController = Ember.ObjectController.extend({
    actions: {
        cancel: function (item) {
            this.set('feat', this.get('old'));
            this.transitionTo('index');
        },

        save: function () {
            var me = this;

            $.ajax({
                url: "/days/update",
                type: "POST",
                data: {
                    id: me.get('id'),
                    feat: me.get('feat')
                },
                dataType: "json",
                success: function (result) {
                    console.log(result);
                }
            });

            this.transitionTo('index');
        }
    }
});

//end file