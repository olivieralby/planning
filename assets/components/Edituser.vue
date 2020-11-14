<template>
    <div class="col-md-12 edituser bg-dark">
        <form class="col-md-12" method="post" @submit.prevent="valid" >
            <h3>Modifier le profil </h3>
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
    props:{id:Object},
    data(){
        return {
            user:"",
            repeat:"",
            password:"",
            edit:true
        }
    },
    mounted(){
        console.log(this.id)
        this.user = this.id;
       // axios.get('http://localhost:8000/home/'+this.id, this.user).then(resp=>this.user=resp)
    },
    
}
</script>
<style lang="css">
    h3 span.material-icons{
        font-size: 48px;
        vertical-align: middle;
        cursor:pointer;
    }
</style>