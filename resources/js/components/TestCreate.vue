<template>
    <div v-if="!test_created" class="container">
        <div class="row d-flex justify-content-center align-items-center mt-8">
            <div class="col-lg-6 col-sm-12 col-md-6 border rounded shadow">
                <br>
                <div class="card">
                    <div style="margin: 0 auto">
                        <h3 class="display-5">Create Test</h3>
                    </div>
                    <div class="card-body">
                        <form>

                            <div class="form-group border rounded p-3 shadow-sm">
                                <label class="display-6" for="name">Name</label>
                                <input type="text" class="form-control bg-white" v-model="test.name" id="name" name="name"
                                       placeholder="Enter name">
                            </div>
                            <br>

                            <div class="border shadow-sm rounded p-3">
                                <label class="display-6">Select type of Answers</label>
                                <div class="form-group" v-for="(variant, index) in variants" :key="index">
                                    <label>
                                        <input type="radio" :value="variant.id" :id="index" v-model="test.type_id"
                                               name="radio">
                                        <span v-html="variant.img"></span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <button type="button"
                                    class="btn btn-outline-primary display-4 border rounded float-right"

                                    @click="createTest()">Submit</button>
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
