<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                <div>
                    <div class="headline">
                    <h3>{{ data.title }}</h3>
                    </div>
                    <span class="grey--text">{{ data.created_by }} asked at {{ data.created_at }}</span>
                </div>
                <v-spacer></v-spacer>
                <v-btn color="teal" dark>{{ totalReply }} Replies</v-btn>
            </v-card-title>
            <v-card-text v-html="body"></v-card-text>
            <v-card-actions v-if="own">
                <v-btn icon small @click="edit">
                    <v-icon color="orange">edit</v-icon>
                </v-btn>
                <v-btn icon small @click="destroy">
                    <v-icon color="red">delete</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
export default {
    props: ['data'],
    data(){
        return{
            totalReply: this.data.total_reply,
            own: User.own(this.data.user_id)
        }
    },
    created() {
        EventBus.$on('newReply', ()=>{
                this.totalReply++
        })

        Echo.private('App.User.' + User.id())
            .notification((notification) => {
                //console.log(notification.type);
                this.totalReply++
            });

        EventBus.$on('deleteReply', ()=>{
                this.totalReply--
        })

        Echo.channel('DeleteReplyChannel')
            .listen('DeleteReplyEvent', (e) => {
                this.totalReply--
            })
    },
    computed:{
        body(){
            return md.parse(this.data.body)
        }
    },
    methods:{
        edit(){
            EventBus.$emit('startEditing')
            // axios.delete(`/api/question/${this.data.slug}`)
            // .then(response => this.$router.push('/forum'))
            // .catch(error => console.log(error.response.data))
        },
        destroy(){
            axios.delete(`/api/question/${this.data.slug}`)
            .then(response => this.$router.push('/forum'))
            .catch(error => console.log(error.response.data))
        }
    }
}
</script>

<style scoped>

</style>
