<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Minhas fotos</div>

                    <div class="panel-body">
                        <div class="row text-center text-lg-left">
                            <div class="col-lg-3 col-md-4 col-xs-6" v-for="post in posts">
                                <a :href="post.image" class="d-block mb-4 h-100">
                                    <img class="img-fluid img-thumbnail" :src="post.image" :alt="post.title">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: []
            }
        },
        created: function() {
            this.fetchPosts();
        },
        methods: {
            fetchPosts() {
                this.axios.get('/posts').then((response) => {
                    this.posts = response.data;
                });
            },
            deletePost(id)
            {
                this.posts.splice(id, 1);
                this.axios.delete(`/posts/${id}`);
            }
        }
    }
</script>
