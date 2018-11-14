<template>
    <div>
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
                items : [],
            }
        },

        mounted() {
            
            this.fetch();
        },

        methods: {
            fetch(page){
                if(!page){
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }
                let url = this.endpoint + '?page=' + page;
                axios.get(url)
                    .then(this.refresh);
            },
            refresh({data}){
                this.dataSet = data;
                this.dataSet.endpoint = this.endpoint;
                this.items = data.data;

                window.scrollTo(0, 0);
            },
            
        }
    }
</script>