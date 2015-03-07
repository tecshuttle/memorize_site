<div id="contents">
    <p v-on="click: onNew" class="blog-item" style="text-align: center;">新建blog</p>

    <p v-repeat="items" v-on="click: onClick" v-text="text | title" class="blog-item {{active ? 'active' : ''}}"></p>
</div>

<div id="blog">
    <div class="blog-toolbar">
        <span v-on="click: onEdit" class="btn">编辑</span>
        <span v-on="click: onDelete" class="btn">删除</span>
    </div>

    <div class="preview">
        <div v-html="text | marked" class="blog-content"></div>
    </div>
</div>


<div id="editor">


    <div id="textarea">
        <div class="edit-toolbar">
            <span v-on="click: onCancel" class="btn">返回</span>
            <span v-on="click: onSave" class="btn">保存</span>
        </div>
        <textarea v-model="input" class="form-control"></textarea>
    </div>

    <div v-html="input | marked" class="preview"></div>
</div>