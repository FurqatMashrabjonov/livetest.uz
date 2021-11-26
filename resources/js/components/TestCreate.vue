<template>
    <div v-if="!test_created" class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Create Test</h3>
                    </div>
                    <div class="card-body">
                        <form>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="test.name" id="name" name="name"
                                       placeholder="Enter name">
                            </div>
                            <hr>
                            <br>
                            <label>Select type of Answers</label>
                            <div class="form-group" v-for="(variant, index) in variants" :key="index">
                                <input type="radio" :value="variant.id" :id="index" v-model="test.type_id"
                                       name="variants"

                                >
                                <label :for="index">
                                    <img width="100" :src="variant.img" alt="">
                                </label>

                            </div>

                            <button type="button" class="btn btn-primary" @click="createTest()">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <test-details-create :test="test"></test-details-create>
    </div>
</template>

<script>

export default {
    name: "TestCreate",
    props: ['variants'],
    data() {
        return {
            test: {
                name: '',
                type_id: null,
            },
            test_created: false
        }
    },
    created() {
        this.test = localStorage.getItem('test') ?
            JSON.parse(localStorage.getItem('test')) :
            {
                name: '',
                type_id: null,
            }
        console.log(this.variants)
    },
    methods: {
        changed(e) {
            console.log(e)
        },
        createTest() {
            axios.post('/test/store', this.test)
                .then(res => {
                    if (res.data.success) {
                        this.test = res.data.test
                        this.test_created = true
                    }
                })
        }
    },
    watch: {
        test() {

            localStorage.setItem('test', JSON.stringify(this.test))
        }
    }
}
</script>

<style scoped>

</style>
