<template>
    <section class="pt-5" id="destination">

        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4" v-for="(_user, index) in users" :key="index">
                    <!--                    <div class="card overflow-hidden shadow"> <img class="card-img-top" src="assets/img/dest/dest1.jpg" alt="Rome, Italty" />-->
                    <div style="width: 200px" >
                        <div  v-html="_user.user.avatar"></div>
                        <div >{{_user.user.name }}</div>
                    </div>

                </div>
            </div>
        </div>



    </section>
    <!--    <section class="pt-5 pt-md-9" id="service">-->

    <!--        <div class="container">-->
    <!--            <div class="row">-->
    <!--                <div class="col-lg-3 col-sm-3 mb-3" style="max-width: 230px" v-for="(_user, index) in users" :key="index" >-->
    <!--                    <div class="card service-card shadow-hover rounded-3 text-center align-items-center">-->
    <!--                        <div class="card-body p-xxl-5 p-4">-->
    <!--                            <div v-html="_user.user.avatar"></div>-->
    <!--                            <p class="mb-0 fw-medium">{{_user.user.name}}</p>-->
    <!--                        </div>-->
    <!--                    </div>-->

    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>&lt;!&ndash; end of .container&ndash;&gt;-->

    <!--    </section>-->

    <!--    <div class="container"><br>-->
    <!--        <span class="alert alert-info">ADMINNNNNNNNNNN</span>-->
    <!--        <br><br><br>-->
    <!--        <div class="row">-->
    <!--            <div class="alert alert-info">{{ test.name }}</div>-->
    <!--        </div>-->
    <!--        <hr>-->
    <!--        <div class="row">-->
    <!--            <div v-for="(_user, index) in users" :key="index" class="col-3 col-xl-12">-->
    <!--                <div style="width: 100px" v-html="_user.user.avatar"></div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
</template>

<script>
export default {
    name: "TestAdmin",
    props: ['test', 'test_users', 'leave_url', 'user'],
    data() {
        return {
            users: this.test_users,
        }
    },
    created() {

        // window.addEventListener('beforeunload', function (e) {
        //     this.outUser(this.test.id);
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

        this.test_users.forEach(e => {
            console.log(e.user)
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
