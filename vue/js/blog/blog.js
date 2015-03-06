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

            if (this.vue !== undefined) {
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
            this.input = vue.$get('text');
        },
        onCancel: function () {
            $('#contents').show();
            $('#blog').show();
            $('#editor').hide();

        },
        onSave: function () {
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
        }
    }
});

//end file