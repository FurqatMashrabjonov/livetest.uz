<template>
    <div class="container mb-12">
        <div class="row m-5">
            <div class="col-lg-6 col-sm-12 col-md-6 border rounded shadow" v-if="!created_question" style="margin: 0 auto">
                <div class="border rounded shadow-sm p-3 mt-2">
                    <h1 class="display-6">Question</h1>
                    <Vueditor class="border rounded p-2" style="height: 180px" ref="question"></Vueditor>
                </div>
                <br>
               <div class="border shadow-sm rounded p-3">
                   <h1 class="display-6">Answer (Select each one)</h1>
                   <div v-if="test.type_id === 1" class="d-flex">
                       <div v-for="(variant, index) in variants"
                            class="m-2" :key="index"
                            @click="selected_answer = index">
                           <label>
                               <input type="radio" :value="variant.value" :id="index" v-model="question.value"
                                      name="radio">
                               <span v-html="variant.img"></span>
                           </label>
                       </div>
                   </div>
               </div>
                <br>

                    <div class="form-group mb-2">
                        <button type="button" class="btn btn-outline-primary display-4 border rounded float-right mb-2" @click="storeQuestion">Send</button>
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
            myHTML: '',
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

<style lang="scss" scoped>
*,
*:after,
*:before {
    box-sizing: border-box;
}

$primary-color: #FFBD86; // Change color here. C'mon, try it!
$text-color: mix(#000, $primary-color, 64%);


label {
    display: flex;
    cursor: pointer;
    font-weight: 500;
    position: relative;
    overflow: hidden;
    margin-bottom: 0.375em;
    /* Accessible outline */
    /* Remove comment to use */
    /*
        &:focus-within {
                outline: .125em solid $primary-color;
        }
    */
    input {
        position: absolute;
        left: -9999px;

        &:checked + span {
            background-color: mix(#fff, $primary-color, 84%);

            &:before {
                box-shadow: inset 0 0 0 0.4375em $primary-color;
            }
        }
    }

    span {
        display: flex;
        align-items: center;
        padding: 0.375em 0.75em 0.375em 0.375em;
        border-radius: 99em; // or something higher...
        transition: 0.25s ease;

        &:hover {
            background-color: mix(#fff, $primary-color, 84%);
        }

        &:before {
            display: flex;
            flex-shrink: 0;
            content: "";
            background-color: #fff;
            width: 1.5em;
            height: 1.5em;
            border-radius: 50%;
            margin-right: 0.375em;
            transition: 0.25s ease;
            box-shadow: inset 0 0 0 0.125em $primary-color;
        }
    }
}

// Codepen spesific styling - only to center the elements in the pen preview and viewport

</style>

