<template>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <success-text :is-show="this.success.is_show" :text="this.success.text"></success-text>
                <error-text :text="this.errors"></error-text>
                <form>
                    <div class="mb-3">
                        <label for="operation_id" class="form-label">Operation ID</label>
                        <input type="text" v-model="operation_id" class="form-control" id="operation_id" aria-describedby="operation_id-desc">
                        <div id="operation_id-desc" class="form-text">Example ProductList</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" v-model="description" class="form-control" id="description" aria-describedby="description-desc">
                        <div id="description-desc" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">Url</label>
                        <input type="text" v-model="url" class="form-control" id="url" aria-describedby="url-desc">
                        <div id="url-desc" class="form-text">Example, api/v1/categories/find?name=shoes</div>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">Tags</label>
                        <input type="text" v-model="tags" class="form-control" id="tags" aria-describedby="tags-desc">
                        <div id="tags-desc" class="form-text">Example, Category</div>
                    </div>
                    <div class="mb-3">
                        <label for="response_class" class="form-label">Response class</label>
                        <input type="text" v-model="response_class" class="form-control" id="response_class" aria-describedby="response_class-desc">
                        <div id="response_class-desc" class="form-text">Example, CategoryItem</div>
                    </div>

                    <button type="button" @click="this.send()" class="btn btn-success">Create</button>
                </form>
            </div>
            <div class="col-6">
                <div class="mb-1">
                    <button type="button" @click="this.copy()" class="btn btn-success">Copy</button>
                </div>
                <div contenteditable="true" class="result">{{this.result}}</div>
            </div>
        </div>
    </div>
</template>

<script>
import axiosInstance from "../services/axios";
import ErrorText from "./ErrorText.vue";
import SuccessText from "./SuccessText.vue";

export default {
    name: "RouteAnnotationForm",
    components: {SuccessText, ErrorText},
    data() {
        return {
            operation_id: 'Response',
            description: 'Desc',
            url: '',
            tags: '',
            response_class: '',
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
            navigator.clipboard.writeText(this.result).then(() => {

            },() => {

            });
        },
        send() {

            axiosInstance({
                method: 'post',
                url : '/scheme/route-annotation',
                data : {
                    operation_id : this.operation_id,
                    description : this.description,
                    url : this.url,
                    tags : this.tags,
                    response_class : this.response_class,
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
    white-space: pre-wrap;
    word-wrap: break-word;
    font-family: inherit;
    background-color: #333;
    color: #fff;
    padding: 20px;
}

</style>
