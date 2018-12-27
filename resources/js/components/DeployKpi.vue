<template>
    <tile :position="position" class="z-10"  no-fade>
        <div  class="absolute pin overflow-hidden p-padding ">
            <div class="text-lg text-center w-full mb-2"> Deploy stats 📡</div>
            <div class="flex">
                <div class="text-sm w-1/4 text-center"><span class="text-xs">Yearly</span> <br> {{kpi.yearly}}</div>
                <div class="text-sm w-1/4 text-center"><span class="text-xs">Monthly</span> <br> {{kpi.monthly}}</div>
                <div class="text-sm w-1/4 text-center"><span class="text-xs">Weekly</span> <br> {{kpi.weekly}}</div>
                <div class="text-sm w-1/4 text-center"><span class="text-xs">Daily</span> <br> {{kpi.daily}}</div>
            </div>
        </div>
    </tile>
</template>

<script>
    import echo from '../mixins/echo';
    import moment from 'moment';
    import Tile from './atoms/Tile';
    import saveState from 'vue-save-state';

    export default {
        components: {
            Tile,
        },

       mixins: [echo, saveState],

        props: ['position'],

        data() {
            return {
                kpi: {}
            };
        },

        created() {

        },

        methods: {

            getEventHandlers() {
                return {
                    'Deploy.DeployKpi': response => {
                        this.kpi = response.kpi
                    },
                };
            },

            getSaveStateConfig() {
                return {
                    cacheKey: 'deploy_kpi',
                };
            },
        },
    };
</script>
