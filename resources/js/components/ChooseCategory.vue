<template>
    <div>
        <div class="form-group">
            <label for="category_id">Choose a category</label>
            <select v-model="selected" @change="selectChange" name="category_id" id="category_id" class="form-control" required>
                <option value="0">Choose one..</option>

                <option v-for="category in categories" :value="category.id" :key="category.id">
                    {{ category.name }}
                </option>
            </select>
            <input type="hidden" class="form-control">
        </div>

        <choose-channel :selectedChannel="selectedChannel" :activeState="activeState" :categoryId="categoryId" :channels="channels"></choose-channel>
        
    </div>
</template>

<script>
    import ChooseChannel from "../components/ChooseChannel.vue";

    export default {
        props : ['categories', 'channels', 'selectedCategory', 'selectedChannel'],
        components: {
            ChooseChannel,
        },
        data() {
            return {
                activeState: this.selectedCategory > 0 ? false : true,
                categoryId: this.selectedCategory > 0 ? this.selectedCategory : 0,
                selected: this.selectedCategory > 0 ? this.selectedCategory : 0,
            }
        },
        computed:{

        },

        methods: {
            selectChange(event){
                let options = event.target.options;
                let selectedIndex = options.selectedIndex;
                if(selectedIndex > 0) {
                    this.activeState = false;
                    this.categoryId = parseInt(options[selectedIndex].value);
                } else {
                    this.activeState = true;
                     this.categoryId = 0;
                }
            }
        }
    }
</script>