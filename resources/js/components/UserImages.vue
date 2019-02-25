<template>
    <tile :position="position" class="z-10">
        <!--<ul class="grid" style="grid-auto-rows: auto;">-->
        <!--<li-->
        <!--class="overflow-hidden pb-4"-->
        <!--v-for="image in images"-->
        <!--&gt;-->
        <!--<div >-->
        <!--<img :src="image">-->
        <!--</div>-->
        <!--</li>-->
        <!--</ul>-->
        <div class="flex flex-wrap content-center h-full">
            <div v-for="g in grid" class="w-1/2 gif-container" v-bind:class="[tile[g]]">
                <img v-if="images[g]" :src="images[g]">
            </div>
        </div>
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
                grid: [0, 1, 2, 3],
                tile: [
                    'box1',
                    'box2',
                    'box3',
                    'box4',
                ]
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
                this.images = this.images.slice(0, 4);

            },
            getSaveStateConfig() {
                return {
                    cacheKey: 'images',
                };
            },
        },
    };
</script>

<style scoped>

    .gif-container {
        height: 50%;
        padding: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .box1{
        border-bottom: 1px solid lightgrey;
        border-right: 1px solid lightgrey;
    }

    .box2{
        border-bottom: 1px solid lightgrey;
    }

    .box3{
        border-right: 1px solid lightgrey;
    }

    .box4{

    }


</style>
