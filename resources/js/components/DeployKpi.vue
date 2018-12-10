<template>
    <tile :position="position" class="z-10"  no-fade>
        <div  class="absolute pin overflow-hidden p-padding filter-fade-tile">
            <div class="text-xl"> Deploy stats 📡</div>
            <div>Yearly: {{kpi.yearly}}</div>
            <div>Monthly: {{kpi.monthly}}</div>
            <div>Weekly: {{kpi.weekly}}</div>
            <div>Daily: {{kpi.daily}}</div>
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
