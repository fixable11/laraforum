<template>
    <div v-if="signedIn">                       
        <div class="form-group" style="margin-top: 50px">
            <wysiwyg placeholder="Have to something say?" 
                     name="body" 
                     v-model="body" 
                     :shouldClear="completed"
                     @completed="completed = false"></wysiwyg>

            <button type="submit"
                    class="btn btn-info"
                    style="margin-top: 10px"
                    @click="addReply">
                    Post</button>
        </div>
    </div>
    <div v-else style="margin-top: 50px">
        <p class="text-center">
            Please <a href="/login">sign in</a> to participate in this dicussion
        </p>    
    </div>  
</template>

<script>
    export default {
        props: ['endpoint'],
        data(){
            return {
                body: '',
                completed: false,
            }
        },
        computed:{
            
        },

        methods: {
            addReply(){
                axios.post(this.endpoint, {body: this.body})
                    .then(response => {
                        this.body = '';
                        this.completed = true;

                        flash('Your reply has been posted');

                        this.$emit('created', response.data);
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });
            }
        }
    }
</script>
