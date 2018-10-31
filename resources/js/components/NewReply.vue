<template>
    <div v-if="signedIn">                       
        <div class="form-group" style="margin-top: 50px">
            <textarea   rows="5" 
                        placeholder="Body" 
                        name="body" 
                        class="form-control" 
                        id="body" 
                        required 
                        v-model="body"></textarea>
        

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
            }
        },
        computed:{
            signedIn(){
                return window.App.signedIn;
            }
        },

        methods: {
            addReply(){
                axios.post(this.endpoint, {body: this.body})
                    .then(response => {
                        this.body = '';

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
