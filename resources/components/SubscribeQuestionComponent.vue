<template>
    <div class="subscribe-button">
        <div class="btn-group float-left" v-if="!isSubscribed">
            <button
                type="button"
                class="btn btn-outline-primary float-left btn-block btn-sm"
                :disabled="loading"
                @click="subscribe"
            >
                <div class="status" v-if="!loading">
                    <i class="fa fa-bell"></i> {{ notSubscribedText }}
                </div>
                <div class="spinner-border spinner-border-sm" v-if="loading">
                    <span class="sr-only">Загрузка...</span>
                </div>
            </button>
            <button type="button"
                    class="btn btn-outline-primary float-left">
                {{ subscribersCount }}
            </button>
        </div>
        <div class="btn-group float-left" v-if="isSubscribed">
            <button
                type="button"
                class="btn btn-outline-primary float-left btn-block btn-sm active"
                :disabled="loading"
                @click="unsubscribe"
            >
                <div class="status" v-if="!loading">
                    <i class="fa fa-bell"></i> {{ subscribedText }}
                </div>
                <div class="spinner-border spinner-border-sm" v-if="loading">
                    <span class="sr-only">Загрузка...</span>
                </div>
            </button>
            <button type="button"
                    class="btn btn-outline-primary float-left">
                {{ subscribersCount }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "SubscribeComponent",
    props: {
        'question_id': Number,
        'is_subscribed': Boolean,
        'subscribers_count': Number
    },
    data() {
        return {
            questionId: this.$props.question_id,
            isSubscribed: this.$props.is_subscribed,
            subscribersCount: this.$props.subscribers_count,
            subscribedText: 'Отписаться',
            notSubscribedText: 'Подписаться',
            loading: false
        }
    },
    methods: {
        subscribe: function () {
            this.loading = !this.loading
            this.$http.post(`/question/${this.questionId}/subscribe`)
                .then((response) => {
                    if (response.status === 200) {
                        this.isSubscribed = !this.isSubscribed
                        this.subscribersCount = response.data.count_subscribers
                        this.subscribedText = response.data.msg
                        this.loading = !this.loading
                    }
                })
                .catch((e) => {
                    // todo
                })
        },
        unsubscribe: function () {
            this.loading = !this.loading
            this.$http.post(`/question/${this.questionId}/unsubscribe`)
                .then((response) => {
                    if (response.status === 200) {
                        this.isSubscribed = !this.isSubscribed
                        this.subscribersCount = response.data.count_subscribers
                        this.subscribedText = response.data.msg
                        this.loading = !this.loading
                    }
                })
                .catch((e) => {
                    // todo
                })
        }
    }
}
</script>

<style scoped>

</style>
