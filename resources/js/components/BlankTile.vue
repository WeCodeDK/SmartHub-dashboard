<template>
    <tile :position="position" class="z-10"  no-fade>
        <div  class="absolute pin overflow-hidden p-padding filter-fade-tile flex justify-center" >
            <div class="text-center flex items-center">
                <div class="text-xl">
                    <p v-html="emoji(icon)"></p>
                    <p v-html="text"></p>
                </div>
            </div>
        </div>
    </tile>
</template>

<script>
    import {emoji} from '../helpers';
    import echo from '../mixins/echo';
    import moment from 'moment';
    import Tile from './atoms/Tile';

    export default {
        components: {
            Tile,
        },

      // mixins: [echo],

        props: ['position', 'text', 'icon'],

        data() {
            return {
            };
        },

        created() {

        },

        methods: {
            emoji,
            //
            // getEventHandlers() {
            //     return {
            //         'Dashboard.Heartbeat': () => {
            //
            //         },
            //     };
            // },
        },
    };
</script>
