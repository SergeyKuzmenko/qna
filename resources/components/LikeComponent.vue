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
        <div class="modal" id="who-liked" :id="'who-liked-'+ targetType + '-' + targetId" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Оценили как «Нравится»</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group" v-if="likesList.length">
                            <li class="list-group-item" v-for="user in likesList" :key="user.id">
                                <a :href="'/user/' + user.username">
                                 <img :src="user.avatar" :alt="user.full_name" class="img-circle img-size-32">
                                    <b class="ml-1">{{ user.full_name}}</b>
                                    <span class="ml-1" style="color:gray;">@{{user.username}}</span>
                                    <span class="float-right" v-if="user.is_author"><i class="far fa-star" style="color:darkgreen" title="Автор вопроса"></i></span>
                                </a>
                            </li>
                        </ul>
                        <ul class="list-group" v-else>
                            <span class="lead">Ответ никому не нравится</span>
                        </ul>
                    </div>
                </div>
            </div>
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
            likesList: []
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
                        this.likesList = response.data.likes
                        $('#who-liked-'+ this.targetType + '-' + this.targetId).modal();
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
