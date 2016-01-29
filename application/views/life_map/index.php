<!DOCTYPE html>
<html lang="en">
<head>
    <title>Life Map</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap-3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/life_map.css">
</head>

<body>
<div id="lifeMap"></div>
<div id="yearMap"></div>
<div id="monthMap"></div>
</body>

<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/css/bootstrap-3.1.1/js/bootstrap.min.js"></script>
<script src="/js/react/react.js"></script>
<script src="/js/react/react-dom.js"></script>
<script src="/js/react/director.js"></script>
<script src="/js/react/browser.min.js"></script>
<script src="/js/moment.js"></script>
<script src="/js/life_map/index.js"></script>

<script type="text/babel">
    var app = app || {};

	app.ALL_TODOS = 'all';
	app.ACTIVE_TODOS = 'active';
	app.COMPLETED_TODOS = 'completed';

    var LifeMap = React.createClass({
        getInitialState: function() {
            var month = [];

            for(var i=0; i<lifeSpanMonth; i++) {
                var birthDay = moment(new Date('1979-03-12'));

                month.push({
                    time: parseInt(birthDay.add(i, 'M').format('X'))
                });
            }

            return {
                user: null,           //用户数据，判断操作权限
                lifeMapMonth: month,
                viewType: 'life'      //life|year|month
            };
        },

        componentDidMount: function () {
			var setState = this.setState;
			var router = Router({
				'/': setState.bind(this, {nowShowing: app.ALL_TODOS}),
				'/active': setState.bind(this, {nowShowing: app.ACTIVE_TODOS}),
				'/completed': setState.bind(this, {nowShowing: app.COMPLETED_TODOS}),
				'/life': setState.bind(this, {viewType: 'life'}),
				'/year': setState.bind(this, {viewType: 'year'}),
				'/month': setState.bind(this, {viewType: 'month'})
			});
			router.init('/');

			win_resize();
		},

		handleChange: function (event) {
			this.setState({newTodo: event.target.value});
		},

        render: function() {
            var me = this;
            var life = '';
            var year = '';
            var month = '';

            if (this.state.viewType === 'life') {
                var culMonthFirstDay = parseInt(moment(moment().format('YYYY-MM')+'-01').format('X'));
                var passToday = false;

                var life = this.state.lifeMapMonth.map(function(m, i){
                    var clsName = 'month ';

                    if (m.time < culMonthFirstDay) {
                        clsName += 'past';
                    } else {
                        if (passToday) {
                            clsName += 'future';
                        } else {
                            clsName += 'present';
                            passToday = true;
                        }
                    }

                    return <a href="#/month">
                        <div className={clsName} key={i+1} onClick={me._viewMonth.bind(null, i)}> &nbsp; </div>
                    </a>;
                });
            }

            if (this.state.viewType === 'year') {
                year = 'year';
            }

            if (this.state.viewType === 'month') {
                month = 'month';
            }

            return (
                <div>
                    <div id="toolBar">
                        <a href="#/"> All </a>
                        <a href="#/active"> Active </a>
                        <a href="#/completed"> Completed </a>
                        <a href="#/life"> Life </a>
                        <a href="#/year"> Year </a>
                        <a href="#/month"> Month </a>
                        <h1>life map - {this.state.nowShowing}</h1>
                    </div>

                    <div>{life}</div>
                    <div>{year}</div>
                    <div>{month}</div>
                </div>
            );
        },

        _viewMonth: function(idx) {
            console.log(idx);

            this.setState({
                viewType: 'month'
            });
        }
    });

    ReactDOM.render(
        <LifeMap />,
        document.getElementById('lifeMap')
    );
</script>

</html>