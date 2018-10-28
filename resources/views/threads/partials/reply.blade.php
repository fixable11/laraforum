<reply :data="{{ $reply }}" inline-template v-cloak>
    <div class="replyWrap">
        <div id="reply-{{ $reply->id }}" class="card-header" style="margin-top: 50px">
            <div class="cardOwn">
                <div class="cardOwn__left">
                    <a class="cardOwn__link" href="{{ route('profile', $reply->owner->name) }}">{{ $reply->owner->name }}</a>
                    said {{ $reply->created_at->diffForHumans() }}
                </div>
                <div class="cardOwn__right">
                    @if (Auth::check())                     
                        <favorite :reply="{{ $reply }}" ></favorite>
                    @endif
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

            @can('update', $reply)
                <div class="card-footer card-footer_own">

                    <button class="btn-edit btn btn-sm btn-primary" 
                    @click="editing">Edit</button>

                    <button type="submit" class="btn-delete btn btn-danger btn-sm"
                    @click="destroy">Delete</button>

                </div>
            @endcan
            
        </div>
    </div>
</reply>