<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header__flex">

            <div class="card-header__left" v-if="!editState">
                <img class="card-header__leftImg" src="{{ $thread->creator->avatar_path }}" alt="">
                <a class="card-header__leftName" href="{{ route('profile', $thread->creator->name) }}">
                    {{ $thread->creator->name }}
                </a>
                <span class="card-header__leftTitle">posted: <span v-text="form.title"></span></span>
            </div>

            <div class="card-header__left w-100" v-else>
                <textarea class="form-control" rows="1" v-model="form.title"></textarea>
            </div>

            <div class="card-header__right"></div>
        </div>
        <div class="card-body">

            <div v-if="!editState" class="thread__desc" v-text="form.body"></div>

            <div class="" v-else>
                <form @submit.prevent="update">
                    <textarea v-model="form.body" rows="6" class="form-control"></textarea>
                    <div class="reply__buttonsArea">

                        <button type="submit" class="btn-update btn btn-info btn-sm">Update</button>

                        <button class="btn-cancel btn btn-secondary btn-sm" type="button"
                        @click="editing">Cancel</button>

                    </div> 
                </form>
            </div>

            {{-- @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif --}}

        </div>
        @can ('update', $thread)
            <div class="card-footer">
                <div class="thread__leftButtonsArea">

                        <button class="btn-edit btn btn-sm btn-primary" @click="editing">
                            Edit
                        </button>

                        <form action="{{ $thread->path() }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn-delete btn btn-danger btn-sm">Delete
                                Thread</button>
                        </form>

                </div>
            </div>
        @endcan
    </div>
</div>