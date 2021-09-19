<template>
    <div class="comment-form">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="#" method="post">
                        <div class="card-header">
                            <h3 class="card-title">Добавить комментарий</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <comment-editor v-model="content" :editor-toolbar="toolbar"></comment-editor>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="reset" class="btn btn-default" @click="resetEditor">
                                <i class="fas fa-times"></i> Очистить
                            </button>
                            <div class="float-right">
                                <button type="button" @click="send" class="btn btn-primary">
                                    Отправить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {VueEditor} from "vue2-editor";

export default {
    name: "CommentForm",
    components: {
        'comment-editor': VueEditor
    },
    props: [
        'type',
        'id'
    ],
    data() {
        return {
            content: '',
            commentId: this.$props.id,
            commentType: this.$props.type,
            toolbar: [
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code"],
                [{list: "ordered"}, {list: "bullet"}],
                ["image", "link", "code-block"]
            ]
        }
    },
    methods: {
        send: function () {
            this.$http.post('/comment/store', {
                type: this.commentType,
                id: this.commentId,
                text: this.content
            })
                .then(((response) => {
                    if (response.status === 200) {
                        console.log(response.data)
                        this.content = ''
                    }
                }))
        },
        resetEditor: function () {
            this.content = ''
        }
    }
}
</script>

<style scoped>

</style>
