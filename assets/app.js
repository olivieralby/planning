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
if (window.location.href == "http://localhost:8000/") {
    document.querySelector('.register').addEventListener('click', (e) => {
        e.preventDefault();
            new Vue({
                el: "#home",
                components: {
                    Register
                }
            })
    })
}


if (window.location.href == "http://localhost:8000/home") {
    new Vue({
        el: "#app",
        components: {
            Edit
        }
    })
    
    let link_edit = document.querySelector('.link_edit');

    link_edit.addEventListener('click', function (e) {
        e.preventDefault();
        style('.calendar', 'none')
        style('.annuaire', 'none')
        style('#app', 'block')
        style('.edit', 'flex')
        style('.event', 'none')
        style('#edition', 'none')
        
    })

    document.querySelector('.link_setting').addEventListener('click', function (e) {
        e.preventDefault();
        style('.calendar', 'none')
        style('.annuaire', 'none')
        style('#app', 'none')
        style('.edit', 'none')
        style('.event', 'block')
        style('#edition', 'none')
        
    })
    new Vue({
        el: '#edition',
        components: {
            Annuaire
        }
    })


    document.querySelector('.link_liste').addEventListener('click', function (e) {
        e.preventDefault();
        style('.calendar', 'none')
        style('.annuaire', 'block')
        style('#app', 'none')
        style('.edit', 'none')
        style('.event', 'none')
        style('#edition', 'none')
    })

    new Vue({
        el: '#calendar',
        components: {
            Planning
        }
    })
    new Vue({
        el: '#event',
        components: {
            Event
        }
    })
    document.querySelector('.link_planning').addEventListener('click', function (e) {
        e.preventDefault();
        style('.calendar', 'block')
        style('.annuaire', 'none')
        style('#app', 'none')
        style('.edit', 'none')
        style('.event', 'none')
        style('#edition', 'none')
        

    })
}

function style(element, display) {
    document.querySelector(element).style.display = display;
}