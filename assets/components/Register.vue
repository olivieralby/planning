<template>
    <div class="row">
        <div class="col-md-7">
        <h1>Créer un compte</h1>
        <form action="" method="post" @submit="valid">
            <div class="form-group">
                <label for="">Prénom</label>
                <input type="text" name="firstname" class="form-control col-md-9" v-model="user.firstname">
            </div>
            <div class="form-group">
                 <label for="">Nom</label>
                <input type="text" name="lastname" class="form-control col-md-9" v-model="user.lastname">
           </div>
            <div class="form-group">
                 <label for="">email</label>
                <input type="text" name="email" class="form-control col-md-9" v-model="user.email">
            </div>
            <div class="form-group">
                 <label for="">Mot de passe</label>
                <input type="text" name="password" class="form-control col-md-9" v-model="user.password">
            </div>
            <div class="form-group">
                 <label for="">Confirmez votre mot de passe</label>
                <input type="text" name="confirm" class="form-control col-md-9" v-model="repeat">
            </div>
            <button class="btn btn-success">Créé</button>
        </form>
        </div>
        <div class="col-md-5 mt-5 p-5">

                <img src="/images/ecole.jpg" alt="">
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
            repeat:""
        }
    },
    methods:{
        valid(e){
            e.preventDefault();
            
            axios.post('/api/users', this.user)
            window.location.href = "http://localhost:8000/home"

        }
    }
    
}
</script>