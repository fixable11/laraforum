<template>
    <div class="alert alert-flash" :class="'alert-' + level" v-show="show" v-text="body">
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data(){
            return {
                body: this.message,
                level: 'success',
                show: false,
            }
        },

        created(){
            window.events.$on('flash', (data) => {
                this.flash(data);
            });
        }, 

        mounted(){
            if(this.message){
                this.flash();
            }
        },

        methods: {

            flash(data = false){
                if(data){
                    this.body = data.message;
                    this.level = data.level;
                }
                
                this.flashShow();
                this.flashHide();
            },

            flashHide() {
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