<template>
    <div>
        <div class="row">
            <div id='external-events2' class="mt-5 col-md-3">
                    <p>
                        <strong>Activités</strong>
                    </p>
                    <p><span style="font-size:19px; color:white;">{{ user.firstname}} </span> <span style="font-size:24px;color:white;">{{ user.lastname}} </span></p>
                    
                    <div v-for="acti in activite.activite" :key="acti.color" class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event mt-2'>
                        <div class='fc-event-main' :style="{backgroundColor:acti.color}">{{ acti.label }}</div>
                    </div>
            </div>           
            <div id="calendar2" class="col-md-9"></div>
        </div>
        <!-- modal pour supprimer un planning -->
                <div id="calendarModal" class="modal fade col-12">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="col-md-7">
                                    <span>Activité : </span>
                                    <h4 id="modalTitle" class="modal-title"></h4>
                                </div>

                            </div>
                            <div id="modalBody" class="modal-body">
                                <p>Voulez-vous supprimer cet événement?</p>
                                <p>Date : <span class="modalbody"></span></p>
                                <a class="btn btn-danger yes" data-dismiss="modal">oui</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</template>
<script>
import { Calendar } from '@fullcalendar/core';
import interactionPlugin, {
    Draggable
} from '@fullcalendar/interaction'
import dayGridPlugin from '@fullcalendar/daygrid';
import axios from 'axios';
import moment from 'moment'
let $ = require('jquery');
export default {
    props:{user:Object,activite:Object},
    data(){
        return {
        }
    },
    mounted(){
        let draggableEl = document.getElementById('external-events2');
        new Draggable(draggableEl, {
        itemSelector: '.fc-event',
        eventData: function(eventEl) {
             return {
            title: eventEl.innerText,
            //color: $(this).data("color")
             };
         }
        });
        let calendarEl = document.getElementById('calendar2');
        let calendar = new Calendar(calendarEl,{
            plugins:[dayGridPlugin, interactionPlugin],
            selectable:true,
            editable:true,
            droppable:true,
            locale:'fr',
            events:{
                url:'/calendar/show/'+this.user.id,
                method:'get'
            },
            drop:(start)=>{

                 let activites = ""
                 if(start.draggedEl.innerText==="Travaillé"){
                      activites = 1
                 }else if(start.draggedEl.innerText==="Absent"){
                      activites = 2

                 }else if(start.draggedEl.innerText==="1/2 journée"){
                      activites = 3
                    
                 }else{
                      activites = 4
                 }
                 let event = {"start":start.dateStr,"end":start.dateStr,"activites":activites}
                 this.load(event)
            },
            eventClick: function (event, jsEvent, view) {
                $('#modalTitle').html(event.event.title);
                $('.modalbody').html(moment(event.event.start).format('l'));
                $('#calendarModal').modal();
                document.querySelector('.yes').addEventListener('click', function () {

                    axios
                        .delete('/calendar/destroy/' + event.event.id, {data: {event: event.event}})
                        .then((event) => console.log(event))
                })
            }

        })
        calendar.render();
        calendar.on('eventChange',function(info){
            console.log(info);
            let event = {"start":info.event.startStr, "end":info.event.endStr, "id":info.event.id,
            "oldstart":info.oldEvent.startStr,"oldend":info.oldEvent.endStr}
            axios.put('/calendar/update',event).then(resp=>console.log(resp)).catch(error=>console.error(error));
        })
    },
    methods:{
                load(event){
                    console.log(this.user)
                    axios.post('/calendar/new',{event,"user":this.user}).then(resp=>console.log(resp)).catch(error=>console.log(error))

                }

    }
    
}
</script>
<style lang="">
    
</style>