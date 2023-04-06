<template>
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                App generates classes and annotations for Laravel swagger from json and by url.
            </div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Class</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Route</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <class-form></class-form>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <route-annotation-form></route-annotation-form>
                        </div>
                    </div>
                </div>
        </div>
    </div>

</template>

<script>
import ClassForm from "./js/Components/ClassForm.vue";
import RouteAnnotationForm from "./js/Components/RouteAnnotationForm.vue";

export default {
    name: "App",
    components: {RouteAnnotationForm, ClassForm}
}
</script>

<style scoped>

</style>
