<template>
    <button  @click="subscribe" :class="classes" class="btn">{{ text }}</button>
</template>

<script>
    export default {
        props: ['initialState'],
        data(){
            return {
                activeState: this.initialState,
            }
        },
        computed: {
            classes(){
                return ['btn', this.active ? 'btn-primary' : 'btn-default' ];
            },
            active(){
                return this.activeState;
            },
            text(){
                return this.activeState ? 'Unsubscribe' : 'Subscribe';
            }
        },
        watch: {

        },

        methods: {
            subscribe(){
                let requestType = this.active ? 'delete' : 'post';

                axios[requestType](location.pathname + '/subscriptions')
                        .then((data) => {
                            this.$emit('activetrigger', this.active);
                            this.activeState = !this.activeState;
                        });
            }
        }
    }
</script>
