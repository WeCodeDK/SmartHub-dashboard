<template>
    <tile :position="position" class="z-10"  no-fade>
        <div  class="absolute pin overflow-hidden p-padding filter-fade-tile">
            hello world
        </div>
    </tile>
</template>

<script>
    import echo from '../mixins/echo';
    import moment from 'moment';
    import Tile from './atoms/Tile';

    export default {
        components: {
            Tile,
        },

       mixins: [echo],

        props: ['position'],

        data() {
            return {
            };
        },

        created() {

        },

        methods: {

            getEventHandlers() {
                return {
                    'Dashboard.Heartbeat': () => {

                    },
                };
            },
        },
    };
</script>
