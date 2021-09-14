<template>
    <div class="answer-form">
        <div class="row">
            <div class="col-md-12">
                <div class="card" v-if="!answer_is_written">
                    <form action="#" method="post">
                        <div class="card-header">
                            <h3 class="card-title">Ваш ответ на вопрос</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <answer-editor
                                    v-model="content"
                                    :editor-toolbar="toolbar"
                                    :editorOptions="editorOptions"
                                ></answer-editor>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="button" class="btn btn-default mr-2">
                                    <i class="far fa-eye"></i> Предпросмотр
                                </button>
                                <button type="button" class="btn btn-primary" @click="sendAnswer">
                                    <i class="far fa-envelope"></i> Опубликовать
                                </button>
                            </div>
                            <button type="reset" class="btn btn-default" @click="resetEditor">
                                <i class="fas fa-times"></i> Очистить
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card" v-if="answer_is_written">
                    <div class="card-body">
                        <h3 class="lead mt-2">
                            Вы уже ответили на вопрос
                        </h3>
                        <h5 class="lead mt-2">
                            Если хотите что-то добавить, то можете отредактировать свой ответ.
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {VueEditor} from "vue2-editor";

export default {
    name: "AnswerForm",
    components: {
        'answer-editor': VueEditor
    },
    props: {
        question_id: Number,
        answer_is_written: Boolean
    },
    data() {
        return {
            content: '',
            questionId: this.$props.question_id,
            answerIsWritten: this.$props.answer_is_written,
            toolbar: [
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code"],
                [{list: "ordered"}, {list: "bullet"}],
                ["image", "link", "code-block"]
            ],
            editorOptions: {
                modules: {}
            }
        }
    },
    methods: {
        sendAnswer: function () {
            this.$http.post(`/question/${this.questionId}/new-answer`, {
                question_id: this.question_id,
                body: this.content
            })
                .then(((response) => {
                    if (response.data.success) {
                        //this.$root.$data.newAnswers= response.data.answer_html
                        $('.new-answer').append(response.data.answer_html).show('slow');
                        this.content = ''
                        this.answer_is_written = true
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
