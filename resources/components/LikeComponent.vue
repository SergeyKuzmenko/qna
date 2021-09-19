<template>
    <div class="like-button">
        <div class="btn-group float-left mr-2">
            <button
                v-if="liked"
                type="button"
                class="btn btn-outline-success active"
                :class="{'btn-sm': targetType === 'comment'}"
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
                :class="{'btn-sm': targetType === 'comment'}"
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
                :class="{'btn-sm': targetType === 'comment'}"
                @click="likes"
            >
                {{ likesCount }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "LikeComponent",
    props: [
        'target_type',
        'target_id',
        'is_liked',
        'likes_count'
    ],
    data() {
        return {
            targetType: this.$props.target_type,
            targetId: this.$props.target_id,
            liked: this.$props.is_liked,
            likesCount: this.$props.likes_count,
            likedText: 'Вам нравится',
            notLikedText: 'Нравится',
            loading: false,
        }
    },
    methods: {
        like: function () {
            this.loading = !this.loading
            this.$http.post('/reaction/like', {
                type: this.targetType,
                id: this.targetId
            })
                .then((response) => {
                    if (response.status === 200) {
                        this.liked = !this.liked
                        this.likesCount = response.data.likes_count
                        this.likedText = response.data.msg
                        this.loading = !this.loading
                    }
                })
                .catch((e) => {
                    alert('Нужно авторизоваться')
                    this.loading = false
                })
        },
        unlike: function () {
            this.loading = !this.loading
            this.$http.post('/reaction/unlike', {
                type: this.targetType,
                id: this.targetId
            })
                .then((response) => {
                    if (response.status === 200) {
                        this.liked = !this.liked
                        this.likesCount = response.data.likes_count
                        this.likedText = response.data.msg
                        this.loading = !this.loading
                    }
                })
                .catch((e) => {
                    console.log(e)
                    this.loading = false
                })
        },
        likes: function () {
            this.$http.post('/reaction/likes', {
                type: this.targetType,
                id: this.targetId
            })
                .then((response) => {
                    if (response.status === 200) {
                        console.log(response.data)
                    }
                })
                .catch((e) => {
                    alert('Нужно авторизоваться')
                    this.loading = false
                })
        }
    }
}
</script>

<style scoped>

</style>
