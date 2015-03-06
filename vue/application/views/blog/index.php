<div id="contents">
    <p v-repeat="items"
       v-on="click: onClick"
       class="blog-item {{active ? 'active' : ''}}">
        {{title}}
    </p>
</div>

<div id="blog">
    <div class="blog-toolbar">
        <span v-on="click: onEdit" class="btn">编辑</span>
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