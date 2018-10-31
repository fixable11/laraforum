<template>
    <div class="replyWrap">
        <div :id="'reply-' + id" class="card-header" style="margin-top: 50px">
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
        <div class="card reply">

            <div class="card-body">

                <div v-if="editState">
                    <textarea class="form-control" name="" v-model="body"></textarea>
                    <div class="reply__buttonsArea">

                        <button type="submit" class="btn-update btn btn-info btn-sm"
                        @click="update">Update</button>

                        <button class="btn-cancel btn btn-secondary btn-sm"
                        @click="editing">Cancel</button>

                    </div> 
                </div>
                <div v-else v-text="body"></div>
            </div>

                <div class="card-footer card-footer_own" v-if="canUpdate">

                    <button class="btn-edit btn btn-sm btn-primary" 
                    @click="editing">Edit</button>

                    <button type="submit" class="btn-delete btn btn-danger btn-sm"
                    @click="destroy">Delete</button>

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
            }
        },
        computed: {
            signedIn(){
                return window.App.signedIn;
            },

            canUpdate(){
                return this.authorize(user => this.data.user_id == user.id);
                //return this.data.user_id == window.App.user.id
            },
            ago(){
                return moment(this.data.created_at).fromNow();
            }
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
                
            }
        }
    }
</script>