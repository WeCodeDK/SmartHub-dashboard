<template>
    <tile :position="position" class="z-10">
        <ul class="grid" style="grid-auto-rows: auto;">
            <li
                    class="overflow-hidden pb-4 mb-4 border-b-2 border-screen"
                    v-for="image in images"
            >
                <div >
                    <img :src="image">
                </div>
            </li>
        </ul>
    </tile>
</template>

<script>
    import echo from '../mixins/echo';
    import moment from 'moment';
    import Tile from './atoms/Tile';
    import saveState from 'vue-save-state';
    import RelativeDate from './atoms/RelativeDate';
    import {diffInSeconds} from '../helpers';

    export default {
        components: {
            Tile,
            RelativeDate
        },

        mixins: [echo, saveState],


        props: ['position'],

        data() {
            return {
                images: [],
                images_waiting_line: [],
            };
        },

        created() {

        },

        methods: {

            getEventHandlers() {
                //{"status":"success","server":{"id":212437,"name":"DeepLearning"},"site":{"id":661791,"name":"webot"},"commit_hash":"d850f0269c3e1f2470465d99c721c01469435f0a","commit_url":"https://github.com/WeCodeDK/WeBot/commit/d850f0269c3e1f2470465d99c721c01469435f0a","commit_author":"alexander_wecode","commit_message":"pass object by reference"}
                return {
                    'Misc.PushImage': response => {
                        this.images_waiting_line.push(response.image_url)
                        this.processWaitingLine()
                    },
                };
            },

            processWaitingLine() {
                if (this.images_waiting_line.length === 0) {
                    return;
                }

                this.images.unshift(this.images_waiting_line.shift());
                this.images = this.images.slice(0, 3);

            },
            getSaveStateConfig() {
                return {
                    cacheKey: 'images',
                };
            },
        },
    };
</script>
