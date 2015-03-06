<div id="editor">
    <textarea v-model="input"></textarea>
    <div v-html="input | marked"></div>
</div>