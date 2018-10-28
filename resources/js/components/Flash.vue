<template>
    <div class="alert alert-success alert-flash" v-show="show">
        <strong>Success!</strong> {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data(){
            return {
                body: '',
                show: false,
            }
        },

        created(){
            window.events.$on('flash', (message) => {
                this.flash(message);
            });
        }, 

        mounted(){
            if(this.message){
                this.flash(this.message);
            }
        },

        methods: {

            flash(message){
                this.body = message;
                //this.show = true;
                this.flashShow();
                this.flashHide();
            },

            flashHide() {
                // setTimeout(() => {
                //     this.show = false;
                // }, 3000);
                $(this.$el).delay(3000).fadeOut(400, () => {
                    this.show = false;
                });

            },

            flashShow(){
                $(this.$el).fadeIn(400, () => {
                    this.show = true;
                });
            }
        },
    }
</script>

<style>
    .alert-flash{
        position: fixed;
        left: 25px;
        bottom: 25px;
    }
</style>