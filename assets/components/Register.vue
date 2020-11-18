<template>
    <div class=" register_block">
        <div class="row">
        <form action="" method="post" @submit="valid" class="col-md-6 ml-5">
            <p class="text-light">Créer un compte</p>
            <div class="form-group">
                <label for="">Prénom</label>
                <input type="text" name="firstname" class="form-control" v-model="user.firstname">
            </div>
            <div class="form-group">
                 <label for="">Nom</label>
                <input type="text" name="lastname" class="form-control " v-model="user.lastname">
           </div>
            <div class="form-group">
                 <label for="">email</label>
                <input type="text" name="email" class="form-control " v-model="user.email">
            </div>
            <div class="form-group">
                 <label for="">Mot de passe</label>
                <input type="text" name="password" class="form-control " v-model="user.password">
            </div>
            <div class="form-group">
                 <label for="">Confirmez votre mot de passe</label>
                <input type="text" name="confirm" class="form-control " v-model="repeat">
            </div>
            <button class="btn btn-success">Créé</button>
        </form>
        <div class="col-md-5 mt-5 p-5">

                <img src="/images/ecole.jpg" alt="">
        </div>
        </div>

    </div>
</template>
<script>
import axios from 'axios'
export default {
    data(){
        return {
            user:{
                firstname:"",
                lastname:"",
                email:"",
                password:""
            },
            repeat:"",
        }
    },
    methods:{
        valid(e){
            e.preventDefault();
            axios.post('/api/users', this.user)
            window.location.href = "/home"

        },
        
    }
    
}
</script>
<style lang="css">
    .register_block{
        position: absolute;
        left:0;
        right:0;
        top:0;
        bottom:0;
        background-color: rgba(15, 15, 15, 0.856);
    }
    .register_block form label{
        color:white;
        
    }
</style>