<template>
    <div class="container mb-12">
        <div class="row m-5">
            <div class="col-6" v-if="!created_question" style="margin: 0 auto">
                <h1 class="display-4">Question</h1>
                <Vueditor ref="question"/>
                <hr>
                <h1 class="display-4">Answer (Select each one)</h1>
                <div v-if="test.type_id === 1" class="d-flex">
                    <div v-for="(variant, index) in variants"
                         class="m-2" :key="index"
                         @click="selected_answer = index"
                         :class="{'border border-primary shadow-xs p-2 mb-1 bg-white rounded' : selected_answer === index}"
                    >

                        <label :for="index">
                            <img :src="variant.img"
                                 width="60" alt="">
                        </label>
                        <input type="radio"
                               :id="index"
                               class="d-none"
                               :value="variant.value"
                               v-model="question.value"
                               name="variant">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-outline-primary" @click="storeQuestion">Send</button>
                    </div>
                </div>
            </div>
            <div class="col-6" v-if="created_question" style="margin: 0 auto">
               <div>
                   <div v-html="question.description"></div>
                   <hr>
                   <div>Answer: {{question.value === 1 ? 'TRUE' : 'FALSE'}}</div>
               </div>
                <hr>
                <br>
                <div class="d-flex justify-content-center align-items-center">
                    <button type="button" @click="created_question = false" class="btn btn-outline-primary m-2">Back to Create Question</button>
                    <button type="button" @click="stopCreating" class="btn btn-outline-danger m-2">Stop Create Questions</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TestDetailsCreate",
    props: ['test'],
    data() {
        return {
            variants: null,
            question: {
                value: null,
                description: null,
            },
            selected_answer: null,
            created_question: false
        }
    },
    created() {
        this.getVariants()
    },
    methods: {
        stopCreating(){
          location.href = '/test/get_test_with_details/' + this.test.id
        },
        getQuestion() {
            return this.$refs.question.getContent()
        },
        storeQuestion() {
            axios.post('/question', {
                test_id: this.test.id,
                value: this.question.value,
                description: this.getQuestion(),
            }).then(res => {
                console.log(res)
                this.question = res.data.data
                this.created_question = true
            }).catch(error => {
                console.log(error)
            })
        },
        getVariants() {
            axios.get('/test/variants')
                .then(res => {
                    if (res.data.success)
                        this.variants = res.data.variants
                })
        }
    }
    ,
}
</script>

<style scoped>

</style>
