<script>
    import Replies from "../components/Replies.vue";
    import SubscribeButton from "../components/SubscribeButton.vue";

    export default {
        props: ['thread'],

        components: { Replies, SubscribeButton },

        computed: {

        },
        data(){
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                editState: false,
                form: {
                    title: this.thread.title,
                    body: this.thread.body,
                }
            }
        },
        methods: {
            toggleLock(){
                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);
                this.locked = !this.locked;
            },
            editing(){
                this.editState = !this.editState;
                if(this.editState == false){
                    this.form.title = this.thread.title;
                    this.form.body = this.thread.body;
                }
            },
            update(){
                axios.put('/threads/' + this.thread.channel.slug + '/' + this.thread.slug, {
                    title: this.form.title,
                    body: this.form.body,
                }).then((response) => {
                    flash('Your thread has been updated.');
                }).catch(error => {
                    flash(error.response.data, 'danger');
                });

                this.thread.title = this.form.title;
                this.thread.body = this.form.body;
                this.editState = false;
            }
        },
    }
</script>