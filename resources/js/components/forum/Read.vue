<template>
    <div v-if="question">
        <edit-question v-if="editing"
        :data = question
        ></edit-question>

        <show-question
        v-else
        :data = question
        ></show-question>
        <v-container>
            <replies :question="question"></replies>
            <new-reply v-if="loggedIn" :questionSlug="question.slug"></new-reply>
            <div class="mt-4" v-else>
                <router-link to="/login">Login to reply</router-link>
            </div>
        </v-container>
    </div>
</template>



<script>
import ShowQuestion from './ShowQuestion'
import EditQuestion from './EditQuestion'
import Replies from '../reply/replies'
import NewReply from '../reply/creat'

export default {
    components: {ShowQuestion, EditQuestion, Replies, NewReply},
    data(){
        return{
            question: null,
            editing: false
        }
    },
    created() {
        this.listen()
        this.getQuestion()
    },
    computed:{
        loggedIn(){
            return User.loggedIn()
        }
    },
    methods: {
        listen(){
            EventBus.$on('startEditing', ()=>{
                this.editing = true
            })

            EventBus.$on('cancelEditing', ()=>{
                this.editing = false
            })
        },
        getQuestion(){
            axios.get(`/api/question/${this.$route.params.slug}`)
            .then(response => this.question = response.data.data)
            .catch(error => console.log(error.response.data))
        }
    }
}
</script>

<style scoped>

</style>
