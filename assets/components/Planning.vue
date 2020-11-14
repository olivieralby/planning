<template>
    <div>
        
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
    props:{user:Number},
    
    mounted(){
        let draggableEl = document.getElementById('external-events');
        new Draggable(draggableEl, {
        itemSelector: '.fc-event',
        eventData: function(eventEl) {
            return {
            title: eventEl.innerText
            };
        }
        });
        let calendarEl = document.getElementById('calendar');
        let calendar = new Calendar(calendarEl,{
            plugins:[dayGridPlugin, interactionPlugin],
            selectable:true,
            editable:true,
            droppable:true,
            locale:'fr',
            events:{
                url:'/calendar/show/'+this.user,
                method:'get',
                extraParams:{
                    day_id:"day_id"
                }
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
            let event = {"start":info.event.startStr, "end":info.event.endStr, "id":info.event.id,"oldstart":info.oldEvent.startStr,"oldend":info.oldEvent.endStr}
            axios.put('/calendar/update',event).then(resp=>console.log(resp)).catch(error=>console.error(error));
        })
    },
    methods:{
        load(event){
            console.log(this.user)
            axios.post('/calendar/new',{event,"user":{"id":this.user}}).then(resp=>console.log(resp)).catch(error=>console.log(error))

        }

    }
    
}
</script>