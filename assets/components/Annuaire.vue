<template>
    <div class="col-md-12">
        <div class="show_planning">
                <planningid :user="userid" :activite="{activite}" v-if="sur"></planningid>
        </div>
        <div class="showed">
            <transition name="fade">
                <edituser :id="id" v-if="edit"></edituser>
            </transition>
        </div>
    </div>
</template>
<script>
import Edituser from './Edituser';
import Planningid from './Planningid'
import Datatable from 'datatables.net';
import axios from 'axios';
var $ = require('jquery');
export default {
    data(){
        return {
            edit:false,
            id:null,
            userid:null,
            activite:null,
            sur:false
        }
    },
    components:{Edituser, Planningid},
    mounted(){
        axios.get('/calendar/activite', this.activite).then(resp=>this.activite=resp.data)
         let calendarEl = $('#calendar');
         axios.get('/api/users', this.users).then((resp) => {
            this.users = resp.data['hydra:member']
            $('#table_id').DataTable({
                data: this.users,
                columns: [{
                        data: "firstname"
                    },
                    {
                        data: "lastname"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "null",
                        render: function () {
                            return `<a href="" class="table_edit" style="color:orange"><span class="material-icons table_edit">
                                        edit
                                        </span></a><a href="" class="table_planning" style="color:pink"><span class="material-icons table_planning">
                                        today
                                        </span></a>`
                        }
                    },
                ]
            }, )
            $('.table_edit').on('click',  (e)=> {
                e.preventDefault();
                $('#table_id tbody tr').removeClass('select');
                $(e.target.parentNode.parentNode.parentNode).addClass('select');
                var selected_row = $('#table_id').DataTable().rows('.select').data()[0];
                this.cc(selected_row)
                document.getElementById('edition').style.display = "block"
                document.querySelector('.showed').style.display = "block"
                document.querySelector('.annuaire').style.display = "none"

                //history.replaceState({},"",'http://localhost:8000/home/'+selected_row.id)
            })

            $('.table_planning').on('click',(e)=>{
                e.preventDefault()
                $('#table_id tbody tr').removeClass('select');
                $(e.target.parentNode.parentNode.parentNode).addClass('select');  
                var selected_row = $('#table_id').DataTable().rows('.select').data()[0];
                document.querySelector('.annuaire').style.display = "none"
                document.getElementById('edition').style.display = "block"
                this.planning(selected_row)
            })
        })
        
    },
    methods:{
        cc(id){
            this.id = id;
            this.edit = true;
        },
        planning(id){
            this.userid = id;
            this.sur = true
        }
    }
    
}
</script>
<style lang="css">
#table_id{
    margin: 0;
    padding: 0;
}
    .showed{
        display: none;
    }
    .fade-enter-active, .fade-leave-active {
        transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
        transform:translateX(50px);
    }
</style>