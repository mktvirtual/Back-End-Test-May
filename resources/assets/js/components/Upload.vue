<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Selecione uma foto</div>

                    <div class="panel-body">
                        <div v-if="!image">
                            <input type="file" accept="image/*" @change="onFileChange">
                        </div>
                        <div v-else>
                            <img :src="image" style="width:100%;margin:auto;display:block;margin-bottom:20px;" />
                            <button @click="uploadImage" class="btn btn-success">
                                Salvar foto
                            </button>
                            <button @click="removeImage" class="btn btn-primary">
                                Remover foto
                            </button>
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
                image: ''
            }
        },
        methods: {
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(e) {
                var data = { photo : this.image };

                this.axios.post('/posts', data).then((response) => {
                    this.image = '';
                });
            },
            removeImage(e) {
                this.image = '';
            }
        }
    }
</script>
