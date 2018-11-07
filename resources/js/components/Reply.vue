<template>
    <div class="replyWrap">
        <div :id="'reply-' + id" class="card-header" style="margin-top: 50px" :class="isBest ? 'bg-success' : ''">
            <div class="cardOwn">
                <div class="cardOwn__left">
                    <a class="cardOwn__link" :href="'/profiles/' + data.owner.name"
                    v-text="data.owner.name">
                    </a>
                    said <span v-text="ago"></span>
                </div>
                <div class="cardOwn__right" v-if="signedIn">                    
                    <favorite :reply="data" ></favorite>
                </div>
            </div>
        </div>
        <div class="card card__reply reply">

            <div class="card-body">

                <div v-if="editState">
                    <form @submit.prevent="update">
                        <textarea class="form-control" name="" v-model="body" required></textarea>
                        <div class="reply__buttonsArea">

                            <button type="submit" class="btn-update btn btn-info btn-sm">Update</button>

                            <button class="btn-cancel btn btn-secondary btn-sm" type="button"
                            @click="editing">Cancel</button>

                        </div> 
                    </form>
                </div>
                <div v-else v-html="body"></div>
            </div>

                <div class="card-footer card-footer_own">
                    <div v-if="authorize('updateReply', reply)">
                        <button class="btn-edit btn btn-sm btn-primary" 
                        @click="editing">Edit</button>
                        <button type="submit" class="btn-delete btn btn-danger btn-sm"
                        @click="destroy">Delete</button>
                    </div>

                    <button type="submit" class="btn__bestReply btn-delete btn btn-success btn-sm"
                    @click="markBestReply">Best Reply</button>

                </div>
            
        </div>
    </div>
</template>


<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['data'],

        components: { Favorite },

        data(){
            return {
                editState: false,
                id: this.data.id,
                body: this.data.body,
                isBest: this.data.isBest,
                reply: this.data
            }
        },
        computed: {
            ago(){
                return moment(this.data.created_at).fromNow();
            }
        },

        created(){
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {
            editing(){
                this.editState = !this.editState;
                if(this.editState == false){
                    this.body = this.data.body;
                }
            },
            update(){
                axios.put('/replies/' + this.data.id, {
                    body: this.body
                }).then(response => {
                    if(response.data.success){
                        flash(response.data.status);
                    }
                }).catch(error => {
                    flash(error.response.data, 'danger');
                });

                this.data.body = this.body;
                this.editState = false;
            },
            destroy(){
                axios.delete('/replies/' + this.data.id).then(response => {
                    if(response.data.success){
                        this.$emit('deleted', this.data.id);
                        // $(this.$el).fadeOut(300, () => {
                        //     flash(response.data.status);
                        // });
                    }
                });

                this.editState = false;
                
            },
            markBestReply(){
                axios.post('/replies/' + this.data.id + '/best');

                window.events.$emit('best-reply-selected', this.data.id);
            }
        }
    }
</script>