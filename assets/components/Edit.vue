<template>
    <div class="edit ">
        <span class="cache"></span>
        <form class="col-md-9" method="post" @submit.prevent="valid">
            <h3>Modifier le profil</h3>
            <div class="form-group">
                <label for="">Prénom</label>
                <input type="text" name="firstname" class="form-control" v-model="user.firstname">
            </div>
            <div class="form-group">
                <label for="">Nom</label>
                <input type="text" name="lastname"  class="form-control" v-model="user.lastname">
            </div>
            <div class="form-group">
                <label for="">email</label>
                <input type="email" name="email"  class="form-control" v-model="user.email">
            </div>
            <div class="form-group">
                <label for="">mot de passe</label>
                <input type="password" id="password"  class="form-control" v-model="password">
                <div class="invalid-feedback">
                Les mots de passes sont différents.
                </div>
            </div>
            <div class="form-group">
                <label for="">Confirmez le mot de passe</label>
                <input type="password"   class="form-control" v-model="repeat">
                
            </div>
            <button class="btn btn-primary">Modifier</button>
        </form>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    props:{id:Number},
    data(){
        return {
            user:"",
            repeat:"",
            password:""
        }
    },
    mounted(){
        axios.get('http://localhost:8000/api/users/'+this.id,this.user).then(resp=>{this.user=resp.data;});
    },

    methods:{
        valid(){
            if(this.password !== this.repeat){
                document.getElementById('password').classList.add('is-invalid');

            }else{
                this.user.password = this.password;
                axios.put('/api/users/'+this.id,this.user).catch(error=>console.log(error))
            }
        }
    }
}
</script>
<style lang="css">
    .edit{
        display:none;
        background:url(/images/occitanie.png)no-repeat;
        background-size: cover;
        position: relative;
    }
    .cache{
        position: absolute;
        top:0;
        left:0;
        height:100%;
        width: 100%;
        background-image: linear-gradient( to right,rgba(15, 15, 15, 0.89),rgb(36, 31, 31), rgba(231, 6, 6, 0.582));
    }
</style>