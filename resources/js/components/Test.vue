<template>

    <section id="booking" style="padding-top: 0 !important;">

        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 d-flex justify-content-center align-items-start">
                    <div class="card position-relative shadow  border" style="max-width: 370px;">
                        <div class="card-body p-3">
                            <div class="mb-4 mt-2 rounded-2 w-100" v-html="user.avatar"></div>
                            <div>
                                <h5 class="fw-medium">{{user.name}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex align-items-start">
                        <div class="flex-1">
                            <h5 class="text-secondary fw-bold fs-0">Choose Destination</h5>
                            <p>Choose your favourite place. No matter <br class="d-none d-sm-block"> where you travel inside the World.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end of .container-->

    </section>


<!--    <div class="container">-->
<!--&lt;!&ndash;        <button type="button" class="btn btn-danger" @click="outUser()">X</button>&ndash;&gt;-->
<!--        <div class="row">-->
<!--            <div class="alert alert-info">{{ test.name }}</div>-->
<!--            <br>-->
<!--            <div class="col-6">-->
<!--                <span>{{user.name}}</span>-->
<!--                <div style="width: 200px" v-html="user.avatar"></div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>

<script>
export default {
    name: "Test",
    props: ['test', 'leave_url', 'user'],
    data() {
        return {
            users: this.test_users,
        }
    },
    created() {

        // window.addEventListener('beforeunload',  e => {
        //     this.outUser(this.test.id);
        //     console.log(e)
        //     e.preventDefault();
        //     e.returnValue = '';
        // });

        window.Echo.private('test.' + this.test.id)
            .listen('TestUserCreated', (e) => {
                console.log(e)
                this.users.push(e.user);
            }).listen('TestUserOut', e => {
            for (let i = 0; i < this.users.length; i++) {
                if (this.users[i].user_id === e.user_id) {
                    this.users.splice(i, 1);
                }
            }
            if (e.user_id === this.user.id)
                location.href = '/'
        })


    },

    methods: {
        outUser() {
            axios.post('/test/out', {
                test_id: this.test.id
            }).then(res => {
                if (res.data.status === 'success') {

                }
            })
        }
    }
}
</script>

<style scoped>

</style>
