<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <i class="fas fa-bell"></i>
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" :href="notification.data.link" @click="markAsRead(notification)" :key="index" v-for="(notification, index) in notifications">
                <span v-text="notification.data.message"></span>
            </a>
        </div>
    </li>
</template>

<script>
    export default {
        data(){
            return {
                notifications: false,
            }
        },
        created(){
            axios.get('/profiles/' + window.App.user.name + "/notifications")
                .then(response => this.notifications = response.data)
                .catch((error) => {
                    
                });
        },

        methods: {
            markAsRead(notification){
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id)
            }
        }
    }
</script>
