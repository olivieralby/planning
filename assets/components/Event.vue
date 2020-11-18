<template>
    <div class="event col-md-12">
        <!-- div alert pour accès refusé -->
        <div class="alert alert-danger" v-if="error">
            <h3 class="text-danger">Accés refusé</h3>
        </div>
        <div class="row">
        <!-- Créé un événement dans la base de donnée -->
            <div class="make_event">
                <a @click.prevent="change()" v-if="error===false">
                    <span class="material-icons">
                    add_box
                    </span>Ajouter un évènement
                </a>
                <form action="" method="post" class="col-md-9 mt-3" v-if="show" @submit.prevent="send">
                    <div class="form-group">
                        <label for="">Evénement</label>
                        <input type="text" name="label" class="form-control col-md-9" v-model="event.label" >
                    </div>
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" name="day" class="form-control col-md-9" v-model="event.day"  >
                    </div>
                    <div class="form-group">
                        <label for="">action</label>
                        <input type="text" name="action" class="form-control col-md-9" v-model="event.action" >
                    </div>
                    <button class="btn btn-primary">Add</button>
                </form>
            </div>

            
            <div class="col-md-3" v-if="show_edit==false">
                <li v-for="e in liste" :key="e.id">
                    <div >
                        <span ><strong>{{ e.label}} : </strong></span><span> {{e.day}}  </span>
                        <span  style="display:block;cursor:pointer;" @click="change_edit(e.id)"><small>modifier</small></span> 
                        <span  style="display:block;cursor:pointer;" @click="delete_edit(e.id)"><small>supprimer</small></span> 
                    </div>
                </li>
            </div>
            <form class="edit_event col-md-9" method="post" v-if="show_edit" @submit.prevent="send_edit(event.id)">
                <p><strong>Modifier un événement</strong></p>
                <div class="form-group">
                    <label for="">Evénement</label>
                    <input type="text" name="label" class="form-control col-md-9" v-model="event.label" >
                </div>
                <div class="form-group">
                    <label for="">Date</label>
                    <input type="date" name="day" class="form-control col-md-9" v-model="event.day"  >
                </div>
                <div class="form-group">
                    <label for="">action</label>
                    <input type="text" name="action" class="form-control col-md-9" v-model="event.action" >
                </div>
                <button class="btn btn-primary">modifier</button>
            </form>



            <!-- gestion des rôles -->
            <div class="makeRole col-md-12">
                <a href="">Gestion des rôles</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Rôles</th>
                            <th>actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="role in user" :key="role.label">
                            <td>{{ role.lastname }}</td>
                            <td>{{ role.firstname }}</td>
                            <td>{{ role.roles }}</td>
                            <td><span class="material-icons" @click="edit(role.id)">
                                edit
                                </span></td>
                        </tr> 
                    </tbody>
                </table>
                <div  v-if="boolRole" class="editRole">
                    <span class="material-icons" @click="closeEdit" style="color:white;">close</span>
                        <form action="" method="post" @submit="validEdit(role.id)">
                            <div class="form-group" >
                                <label for="">Rôle</label>
                                <input type="text" v-model="role" class="form-control col-md-6">
                            </div>
                            <button class="btn btn-primary">Edit</button>
                        </form>
                </div>
            </div>

        </div>


    </div>
</template>
<script>
import axios from 'axios';
export default {
    data(){
        return {
            show:null,
            show_edit:false,
            error:false,
            event:{
                label:"",
                day:"",
                action:""
            },
            liste:"",
            user:"",
            role:"",
            boolRole:""
        }
    },
    mounted(){
        this.show=false,
        axios.get('/api/events',this.liste).then(resp=>{this.liste=resp.data['hydra:member'];
        }).catch(error=>this.loadError(error))
         axios.get('/api/users',this.user).then(resp=>{this.user=resp.data['hydra:member'];console.log(this.user)
        }).catch(error=>this.loadError(error))
    },
    methods:{
        change(){
            this.show = (this.show===false)?true :false
        },
        send(){
            axios.post('/api/events',this.event).then(resp=>this.event=resp).catch(error=>console.error = error)
        },
        change_edit(id){
            this.show_edit = (this.show_edit===false)?true:false
            axios.get('/api/events/'+id,this.event).then(resp=>{this.event=resp.data;}).catch(error=>console.error(error))
        },
        delete_edit(id){
            axios.delete('/api/delete/'+id).catch(error=>console.error(error))
            window.redirect.replace = "http://localhost:8000/home"
        },
        send_edit(id){
            axios.put('/api/events/'+id,this.event).then(resp=>console.log(resp)).catch(error=>console.error(error))
            this.show_edit=false;
            window.redirect.href = "/home"
        },
        loadError(error){
            this.error = true;
        },
        edit(id){
          this.boolRole = true;
          axios.get('/api/users/'+id).then(resp=>{this.role = resp.data.roles;console.log(this.role) })  
        },
        validEdit(e){
            e.preventDefault();
            axios.post('/api/users', this.role).then(resp=>resp=this.role).catch(error=>console.error(error));
        },

        closeEdit(){
            this.boolRole = false;
        }
    }
    
}
</script>
<style lang="css">
    .event{
        display: none;
    }
    a{
        color:rgb(46, 40, 40);
        cursor:pointer;
    }
    span.material-icons{
        font-size: 24px;
        vertical-align: middle;
        cursor:pointer;
    }
    .editRole{
        position: absolute;
        top:0;
        height: 350px;
        width: 550px;
        background-color: rgba(12, 12, 12, 0.856);
        padding: 20px;

    }
    .editRole form{
        color:white;

    }
</style>