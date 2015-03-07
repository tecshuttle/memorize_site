Vue.filter('title', function (blog) {
    return blog.split('\n')[0].substr(1);
});

var contents = new Vue({
    el: '#contents',
    data: {
        items: []
    },
    methods: {
        load: function () {
            var me = this;
            $.ajax({
                url: "blog/getList",
                type: "POST",
                data: {start: 0, limit: 1},
                dataType: "json",
                success: function (result) {
                    var items = [];

                    $.each(result.data, function (i, item) {
                        items.push(item);
                    });

                    me.items = items;
                }
            });
        },
        onClick: function (e) {
            blog.load(e.target.__vue__);
        },

        onNew: function () {
            blog.vue = '';
            blog.onEdit();
        },

        onDelete: function (cid) {
            for (var i in this.items) {
                if (this.items[i].cid == cid) {
                    this.items.splice(i, 1)
                    break;
                }
            }

            $.ajax({
                url: "blog/delete",
                type: "POST",
                data: {
                    cid: cid
                },
                dataType: "json",
                success: function (result) {

                }
            });
        }
    }
});

contents.load();

var blog = new Vue({
    el: '#blog',
    vue: '',
    data: {
        active: false,
        text: ''
    },
    filters: {
        marked: marked
    },
    methods: {
        load: function (vue) {
            this.text = vue.$get('text');
            $('#blog').show();

            if (this.vue !== undefined && this.vue !== '') {
                this.vue.$set('active', false);
            }

            this.vue = vue;
            this.vue.$set('active', true);
        },

        onEdit: function () {
            $('#contents').hide();
            $('#blog').hide();
            $('#editor').show();

            editor.load(this.vue);
        },

        onDelete: function () {
            $('#blog').hide();

            contents.onDelete(this.vue.$get('cid'));

            this.vue = '';
        }
    }
});

var editor = new Vue({
    el: '#editor',
    data: {
        input: '# hello'
    },
    filters: {
        marked: marked
    },
    methods: {
        load: function (vue) {
            if (vue === '') {
                this.input = '# hello';
            } else {
                this.input = vue.$get('text');
            }
        },

        onCancel: function () {
            $('#contents').show();
            $('#blog').show();
            $('#editor').hide();

        },

        onSave: function () {
            if (blog.vue === '') {
                this.onNew();
                return;
            }

            var cid = blog.vue.$get('cid');
            var input = this.input;

            blog.vue.$set('text', input);
            blog.text = input;

            $.ajax({
                url: "blog/save",
                type: "POST",
                data: {
                    cid: cid,
                    text: input
                },
                dataType: "json",
                success: function (result) {

                }
            });

            this.onCancel();
        },
        onNew: function () {
            var input = this.input;

            $.ajax({
                url: "blog/save",
                type: "POST",
                data: {
                    cid: 0,
                    text: input
                },
                dataType: "json",
                success: function (result) {
                    contents.items.unshift({
                        cid: result.cid,
                        text: input
                    });
                }
            });

            this.onCancel();
        }
    }
});

//end file