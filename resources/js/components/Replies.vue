<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>

        <paginator :limit="1" :dataSet="dataSet" @changed="fetch"></paginator>

        <p v-if="$parent.locked">
            This thread is locked. No more replies are allowed.
        </p>

        <new-reply :endpoint="endpoint" @created="add" v-else></new-reply>
    </div>
</template>

<script>
    import Reply from "./Reply.vue";
    import NewReply from "./NewReply.vue";
    import collection from "../mixins/collection";

    export default {
        components: { Reply, NewReply },

        mixins: [collection],
        data(){
            return {
                dataSet: {}, //false,
                endpoint: location.pathname + '/replies'
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