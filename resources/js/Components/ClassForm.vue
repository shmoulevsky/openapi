<template>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <success-text :is-show="this.success.is_show" :text="this.success.text"></success-text>
                <error-text :text="this.errors"></error-text>
                <form>
                    <div class="mb-3">
                        <label for="title" class="form-label">Class name</label>
                        <input type="text" v-model="title" class="form-control" id="title" aria-describedby="title-desc">
                        <div id="title-desc" class="form-text">Example ProductResponse, ProductRequest</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" v-model="description" class="form-control" id="description" aria-describedby="description-desc">
                        <div id="description-desc" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="json" class="form-label">Json</label>
                        <textarea  class="form-control textarea" v-model="json" id="json" aria-describedby="json-desc"></textarea>
                        <div id="json-desc" class="form-text">Paste json here</div>
                    </div>
                    <button type="button" @click="this.send()" class="btn btn-primary">Create</button>
                </form>
            </div>
            <div class="col-6">
                <div class="mb-1">
                    <button type="button" @click="this.copy()" class="btn btn-primary">Copy</button>
                </div>
                <div contenteditable="true" id="result-class" class="result">{{this.result}}</div>
            </div>
        </div>
    </div>
</template>

<script>
import axiosInstance from "../services/axios";
import ErrorText from "./ErrorText.vue";
import SuccessText from "./SuccessText.vue";

export default {
    name: "ClassForm",
    components: {SuccessText, ErrorText},
    data() {
        return {
            title: 'Response',
            description: 'Desc',
            json: '',
            result: '',
            errors: '',
            success: {
                text : "Success",
                is_show : false
            },
        };
    },
    methods : {
        copy(){

        },
        send() {

            axiosInstance({
                method: 'post',
                url : '/scheme/item',
                data : {
                    title : this.title,
                    description : this.description,
                    json : JSON.parse(this.json)
                }
            })
                .then(response => {
                    this.errors = '';
                    this.success.is_show = true;
                    this.result = response.data.scheme;
                    setTimeout(() =>{this.success.is_show = false;}, 3000);
                })
                .catch(error => {

                    this.errors = '';

                    if(error.response.status === 500){
                        this.errors = error.response.data.message;
                    }else{
                        for(let i in error.response.data.errors){
                            this.errors +=  error.response.data.errors[i] ?? null;
                        }
                    }

                });
        }
    }
}
</script>

<style scoped>
.textarea{
    height: 600px;
}

.result {
    background-color: #333;
    color: #fff;
    padding: 20px;
    white-space: pre-wrap;
    word-wrap: break-word;
    font-family: inherit;
}

</style>
