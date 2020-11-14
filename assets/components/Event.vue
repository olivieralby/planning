<template>
    <div class="event col-md-12">
        <a @click.prevent="change()" >
            <span class="material-icons">
            add_box
            </span>Ajouter un évènement
        </a>
        <div class="row">
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
                <button class="btn btn-primary">add</button>
            </form>

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
            event:{
                label:"",
                day:"",
                action:""
            },
            liste:{
                label:"",
                day:"",
                action:""
            }
        }
    },
    mounted(){
        this.show=false,
        axios.get('/api/events',this.liste).then(resp=>{this.liste=resp.data['hydra:member'];}).catch(error=>console.log(error))
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
            axios.get('/api/events/'+id,this.event).then(resp=>{this.event=resp.data;console.log(resp)}).catch(error=>console.error(error))
        },
        delete_edit(id){
            axios.delete('/api/delete/'+id).catch(error=>console.error(error))
            window.redirect.replace = "http://localhost:8000/home"

        },
        send_edit(id){
            axios.put('/api/events/'+id,this.event).then(resp=>console.log(resp)).catch(error=>console.error(error))
            this.show_edit=false;
            window.redirect.replace = "http://localhost:8000/home"
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
</style>