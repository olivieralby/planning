/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';
require('bootstrap')

import Vue from 'vue'
import Edit from "./components/Edit";
import Annuaire from './components/Annuaire.vue';
import Planning from './components/Planning';
import Register from './components/Register';
import Event from './components/Event'
if(window.location.href == "http://localhost:8000"){
    
    new Vue({
        el:"#home",
        components:{Register}
    })
}


if(window.location.href == "http://localhost:8000/home"){
    new Vue({
        el: "#app",
        components: {
            Edit
        }
    })
    let link_edit = document.querySelector('.link_edit');
    
    link_edit.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector('.edit').style.display = "flex";
        document.querySelector('.calendar').style.display = "none";
        document.querySelector('.event').style.display = "none";
        document.querySelector('.annuaire').style.display = "none";
        document.getElementById('app').style.display = "block";
        document.getElementById('edition').style.display = "none"
    })
    
    document.querySelector('.link_setting').addEventListener('click',function(e){
        e.preventDefault();
        document.querySelector('.edit').style.display = "none";
        document.querySelector('.calendar').style.display = "none";
        document.querySelector('.annuaire').style.display = "none";
        document.getElementById('app').style.display = "none";
        document.querySelector('.event').style.display = "block";
        document.getElementById('edition').style.display = "none"
    })
new Vue({
    el: '#edition',
    components: {
        Annuaire
    }
})


document.querySelector('.link_liste').addEventListener('click', function (e) {
    e.preventDefault();
    document.querySelector('.annuaire').style.display = "block";
    document.querySelector('.calendar').style.display = "none";
    document.querySelector('.event').style.display = "none";
    document.getElementById('app').style.display = "none"
    document.querySelector('.edit').style.display = "none";
    document.getElementById('edition').style.display = "none";
    
})

new Vue({
    el: '#calendar',
    components: {
        Planning
    }
})

document.querySelector('.link_planning').addEventListener('click', function (e) {
    e.preventDefault();
    document.querySelector('.calendar').style.display = "block";
    document.querySelector('.annuaire').style.display = "none";
    document.getElementById('app').style.display = "none"
    document.querySelector('.edit').style.display = "none";
    document.getElementById('edition').style.display = "none";
    document.querySelector('.event').style.display = "none";
    
})
}

new Vue({
    el:'#event',
    components:{Event}
})