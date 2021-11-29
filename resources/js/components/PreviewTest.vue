<template>
    <div class="container">
        <div class="row" style="margin: 0 auto">
            <div class="col-12">
                <h1 class="display-5">{{test.name}}</h1>
                <br>
                <span class=" p-2 border shadow"> ID: {{test.id}}</span>
                <hr>
                <br>
                <div>
                    <ul class="list-group shadow">
                        <li class="list-group-item" v-for="(question, index) in test.questions">
                            <div v-html="question.description" class="border border-rounded rounded p-3 shadow"></div>
                            <br>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PreviewTest",
    props: ['test', 'answerimages'],
   created() {
       console.log(this.answerimages)
   }
}
</script>

<style scoped>

</style>
