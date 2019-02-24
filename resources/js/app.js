import './bootstrap.js';

import Echo from 'laravel-echo';
import Vue from 'vue';

import VueCarousel from 'vue-carousel';
Vue.use(VueCarousel);

import Dashboard from './components/Dashboard';
import Calendar from './components/Calendar';
import Statistics from './components/Statistics';
import InternetConnection from './components/InternetConnection';
// import TeamMember from './components/TeamMember';
import TimeWeather from './components/TimeWeather';
import Trains from './components/Trains';
import Lunch from './components/Lunch';
import Twitter from './components/Twitter';
import Uptime from './components/Uptime';
import Velo from './components/Velo';
import TileTimer from './components/TileTimer';
import BlankTile from './components/BlankTile';
import Deploys from './components/Deploys';
import DeployKpi from './components/DeployKpi';
import ReloadPage from './components/ReloadPage';
import UserImages from './components/UserImages.vue'


new Vue({
    el: '#dashboard',

    components: {
        Dashboard,
        Calendar,
        Statistics,
        InternetConnection,
        // TeamMember,
        TimeWeather,
        Trains,
        Lunch,
        Twitter,
        Uptime,
        Velo,
        TileTimer,
        BlankTile,
        Deploys,
        DeployKpi,
        ReloadPage,
        UserImages
    },


    created() {

        // console.log(window.dashboard);

        let config = {
            broadcaster: 'pusher',
            key: window.dashboard.pusherKey,
            wsHost: window.location.hostname,
            wsPath: window.dashboard.clientConnectionPath,
            wsPort: window.dashboard.wsPort,
            disableStats: true,
        }

        if (window.dashboard.environment === 'local') {
            config.wsPort = 6001;
        }

        //laravel sockets implementation
        // this.echo = new Echo(config);


        this.echo = new Echo({
            broadcaster: 'pusher',
            key: window.dashboard.pusherKey,
            cluster: 'eu',
        });

    },
});
