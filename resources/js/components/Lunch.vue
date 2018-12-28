<template>
    <tile :position="position">
        <div class="justify-items-center h-full flex items-center" >
            <carousel :per-page="1" :autoplay="true" :autoplayTimeout="5000" :loop="true" :paginationEnabled="false" >
                <slide v-for="lunches in lunch_split"  v-bind:key="lunches[0].id">
                    <div class="lunch-box text-center" v-for="lunch in lunches"  v-bind:key="lunch.id">
                        <h2 class="mb-0 text-sm text-center">{{lunch.headline}}<span class="ml-2 text-md" v-html="specifyEmoji(lunch.headline)"></span></h2>
                        <p class="text-xs" v-html="lunch.body"></p>
                    </div>
                </slide>
            </carousel>

        </div>
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

        computed: {
            // a computed getter
            lunch_split: function () {
               var split = this.lunch_items.reduce(function(result, value, index, array) {
                    if (index % 2 === 0)
                        result.push(array.slice(index, index + 2));
                    return result;
                }, []);

               return split;
            }
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

<style>
    .lunch-box{
        padding: 0.7rem 0;
    }

    .VueCarousel{
        width: 100%;
    }
</style>
