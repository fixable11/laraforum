<template>
    <div class="form-group">
        <label for="channel_id">Choose a channel</label>
        <select v-model="selected" :disabled="activeState" name="channel_id" id="channel_id" class="form-control" required>
            <option value="0">Choose one..</option>

            <option v-for="channel in channels" 
                    v-show="channel.category_id == categoryId" 
                    :value="channel.id" 
                    :key="channel.id">
                {{ channel.name }}
            </option>
        </select>
        <input type="hidden" class="form-control">
    </div>
</template>

<script>

    export default {
        props : ['channels', 'activeState', 'categoryId', 'selectedChannel'],
        data() {
            return {
                selected: this.selectedChannel > 0 ? this.selectedChannel : 0,
            }
        },
        computed:{

        },

        methods: {
 
        }
    }
</script>