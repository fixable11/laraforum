<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['attributes'],

        components: { Favorite },

        data(){
            return {
                editState: false,
                body: this.attributes.body,
            }
        },
        methods: {
            editing(){
                this.editState = !this.editState;
                if(this.editState == false){
                    this.body = this.attributes.body;
                }
            },
            update(){
                axios.put('/replies/' + this.attributes.id, {
                    body: this.body
                }).then(response => {
                    if(response.data.success){
                        flash(response.data.status);
                    }
                });

                this.attributes.body = this.body;
                this.editState = false;
            },
            destroy(){
                axios.delete('/replies/' + this.attributes.id).then(response => {
                    if(response.data.success){
                        $(this.$el).fadeOut(300, () => {
                            flash(response.data.status);
                        });
                    }
                });

                

                this.editState = false;
                
            }
        }
    }
</script>