<template>
    <div class="card">
        <div class="card-body">
            <article>
                <div class="level">
                    <div class="thread__left">
                        <h4>
                            <a :href="thread.path">
                                {{ thread.title }}
                            </a>
                        </h4>
                        <h5 class="thread__creator">Posted By:
                            <a :href="creatorPath">
                                {{ thread.creator.name }}
                            </a>
                        </h5>
                    </div>
                    <div class="thread__right">
                        <a :href="thread.path">
                            {{ thread.replies_count }} {{ thread.replies_count == 1 ? 'reply' : 'replies' }}
                        </a>
                    </div>
                </div>
                <div class="level__hr"></div>
                <div class="body" v-html="thread.body"></div>
            </article>
        </div>
        <div class="card-footer">
            {{ thread.visits }} Visits
        </div>
    </div>
</template>


<script>

    export default {
        props: ['thread'],

        components: {  },

        data(){
            return {
                creatorPath:  '/profiles/' + this.thread.name,
            }
        },
        computed: {
        },

        created(){

        },

        methods: {
    
        }
    }
</script>