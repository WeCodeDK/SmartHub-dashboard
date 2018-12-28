<template>
    <tile :position="position">
        <ul class="grid" style="grid-auto-rows: auto;">
            <li
                    class="overflow-hidden pb-4 mb-4 border-b-2 border-screen"
                    v-for="lunch in lunch_items"
            >
               <div>
                    <p class="mb-0 text-sm">{{lunch.headline}}<span class="ml-2 text-md" v-html="specifyEmoji(lunch.headline)"></span></p>
                    <p class="text-xs" v-html="lunch.body"></p>
               </div>
            </li>
        </ul>
    </tile>
</template>

<script>
    import {emoji, formatTime} from '../helpers';
    import echo from '../mixins/echo';
    import Tile from './atoms/Tile';
    import saveState from 'vue-save-state';
    import moment from 'moment';

    export default {
        components: {
            Tile,
        },

        mixins: [echo, saveState],

        props: {
            position: {
                type: String,
            },
        },

        data() {
            return {
                lunch_items: [],
            };
        },

        methods: {
            emoji,
            formatTime,

            getEventHandlers() {
                return {
                    'Lunch.LunchFetched': response => {
                        this.lunch_items = response.lunch;
                    },
                };
            },

            getSaveStateConfig() {
                return {
                    cacheKey: 'lunch',
                };
            },

            specifyEmoji(type)
            {
                 var emoji = '🥖';

                 if( type.includes("Varm")) emoji = '🍲';
                 if( type.includes("Vegetar")) emoji = '🥦';
                 if( type.includes("Salat")) emoji = '🥗';
                 if( type.includes("Pålæg")) emoji = '🥩';
                 if( type.includes("Delikatesse")) emoji = '🧀';

                 return this.emoji(emoji);
            },

        },

    };
</script>
