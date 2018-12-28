<template>
    <tile :position="position">
        <ul class="grid" style="grid-auto-rows: auto;">
            <li
                    class="overflow-hidden pb-4 mb-4 border-b-2 border-screen"
                    v-for="trains in trainConnections"
            >
                <div class="markup grid" style="grid-auto-rows: auto">
                    <div class="w-full text-md mb-1">{{trains[0].legs.destination.name}}</div>
                    <div class="flex">
                        <div class="text-sm w-1/4">
                            <p v-html="trainType(trains[0].legs.type)"></p>
                            <p v-html="emoji('⏱')">️</p>
                            <p v-html="emoji('🔚')"></p>
                        </div>
                        <div v-for="train in trains" class="text-sm w-1/4">
                            <div class="text-center margin-bottom-less">
                                <p class="text-xxs mb-1">{{train.legs.name}}</p>
                                <p class="text-md mb-1">{{timeFormat(train.departure.date)}}</p>
                                <p class="text-md">{{timeFormat(train.arrival.date)}}</p>
                            </div>
                        </div>
                    </div>
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
                trainConnections: [],
            };
        },

        methods: {
            emoji,
            formatTime,

            getEventHandlers() {
                return {
                    'Trains.TrainDataFetched': response => {
                        this.trainConnections = response.trainData;
                    },
                };
            },

            getSaveStateConfig() {
                return {
                    cacheKey: 'trains',
                };
            },

            timeFormat(date){
                var date = moment(date).format('HH:mm');
                return date;
            },

            trainType(type)
            {
                var emoji = '🚆';

                if(type == 'REG') emoji = '🚂';
                if(type == 'S') emoji = '🚃';
                if(type == 'REG') emoji = 'Ⓜ️';

                 return this.emoji(emoji);
            }
        },

    };
</script>
