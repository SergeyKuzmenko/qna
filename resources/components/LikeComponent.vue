<template>
    <div class="like-button">
        <div class="btn-group float-left">
            <button
                v-if="liked"
                type="button"
                class="btn btn-outline-success active"
                :disabled="loading"
                @click="unlike"
            >
                <div class="status" v-if="!loading">
                    <i class="far fa-heart"></i>
                    {{ likedText }}
                </div>
                <div class="spinner-border spinner-border-sm" v-if="loading">
                    <span class="sr-only">Загрузка...</span>
                </div>
            </button>
            <button
                v-if="!liked"
                type="button"
                class="btn btn-outline-success"
                :disabled="loading"
                @click="like"
            >
                <div class="status" v-if="!loading">
                    <i class="far fa-heart"></i>
                    {{ notLikedText }}
                </div>
                <div class="spinner-border spinner-border-sm" v-if="loading">
                    <span class="sr-only">Загрузка...</span>
                </div>
            </button>
            <button
                type="button"
                class="btn btn-outline-success"
            >
                {{ likesCount }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "LikeComponent",
    props: {
        'answer_id': Number,
        'is_liked': Boolean,
        'likes_count': Number
    },
    data() {
        return {
            answerId: this.$props.answer_id,
            liked: this.$props.is_liked,
            likedText: 'Вам нравится',
            notLikedText: 'Нравится',
            likesCount: this.$props.likes_count,
            loading: false,
        }
    },
    methods: {
        like: function () {
            this.loading = !this.loading
            this.$http.post(`/answer/${this.answerId}/like`)
                .then((response) => {
                    if (response.status === 200) {
                        this.liked = !this.liked
                        this.likesCount = response.data.likes_count
                        this.likedText = response.data.msg
                        this.loading = !this.loading
                    }
                })
                .catch((e) => {
                    // todo
                })
        },
        unlike: function () {
            this.loading = !this.loading
            this.$http.post(`/answer/${this.answerId}/unlike`)
                .then((response) => {
                    if (response.status === 200) {
                        this.liked = !this.liked
                        this.likesCount = response.data.likes_count
                        this.likedText = response.data.msg
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
