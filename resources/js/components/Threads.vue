<template>
    <div style="position: relative">
        <div class="loader" v-show="preloadShow">
            <div class="loader-frame">
                <img class="svg-loader" src="/svg/loader.svg" alt="circle-loader">
            </div>
        </div>
        <div v-for="thread in items" :key="thread.id">
            <thread :thread="thread"></thread>
        </div>

        <div v-if="!items.length">
            <p>There are no relevant result</p>
        </div>

        <div>
            <paginator :limit="1" :dataSet="dataSet" @changed="fetch"></paginator>
        </div>
    </div>
</template>

<script>
    import Thread from "./Thread.vue";
    export default {
        components: { Thread },

        data(){
            return {
                dataSet: {}, //false,
                endpoint: location.pathname + '',
                items : [true],
                show: false,
            }
        },

        mounted() {
            this.fetch();
        },

        methods: {
            fetch(page){
                this.preloadShow();
                
                if(!page){
                    let query = window.common.getParameterByName('page');
                    
                    page = query ? query : 1;
                }

                let url = this.endpoint + '?page=' + page;

                let params = window.common.getParameters();
                url = window.common.addParams(params, url);
                
                axios.get(url)
                    .then(this.refresh);

                this.preloadHide();
            },
            refresh({data}){
                this.dataSet = data;
                this.dataSet.endpoint = this.endpoint;
                this.items = data.data;

                window.scrollTo(0, 0);
            },

            preloadHide() {
                $('.loader').delay(400).fadeOut(400, () => {
                    this.show = false;
                });
            },

            preloadShow(){
                $('.loader').fadeIn(400, () => {
                    this.show = true;
                });
            }
            
        }
    }
</script>