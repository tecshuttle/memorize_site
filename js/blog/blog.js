Vue.filter('title', function (blog) {
    return blog.split('\n')[0].substr(1);
});

var contents = new Vue({
    el: '#contents',
    data: {
        loading: false,
        loadAll: false,
        items: []
    },
    created: function () {
        var me = this;

        this.$watch('items', function () {
            var mark_pos = $("#load-mark").position();
            var win_height = $(window).height();

            if (mark_pos.top < win_height) {
                this.load();
            }
        })

        $('#contents-list').scroll(function () {
            var mark_pos = $("#load-mark").position();
            var win_height = $(window).height();

            if (mark_pos.top < win_height) {
                if (!me.loading) {
                    me.load();
                }
            }
        });
    },
    methods: {
        load: function () {
            var me = this;

            if (me.loadAll) return;

            me.loading = true;

            $.ajax({
                url: "vue/getList",
                type: "POST",
                data: {
                    start: me.items.length,
                    limit: 10
                },
                dataType: "json",
                success: function (result) {
                    console.log();


                    $.each(result.data, function (i, item) {
                        me.items.push(item);
                    });

                    me.loading = false;

                    if (result.data.length == 0) {
                        me.loadAll = true;
                    }
                }
            });
        },

        onClick: function (e) {
            console.log($("#load-mark").is(":visible"));
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
                url: "vue/delete",
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
                url: "vue/save",
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
                url: "vue/save",
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