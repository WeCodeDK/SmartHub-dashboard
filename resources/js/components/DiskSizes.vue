<template>
    <tile :position="position" class="z-10" >
        <ul class="grid" style="grid-auto-rows: auto;">
            <li
                    class="overflow-hidden pb-2 mb-2 border-b-2 border-screen"
                    v-for="size in sizes"
            >
                <div v-if="size.disk" class="markup grid " style="grid-auto-rows: auto" @click="animate">
                    <div class="flex"
                    >
                        <!--<div v-if="deploy.status == 'success'" v-html="emoji('👍')"></div>-->
                        <!--<div v-else="deploy.status == 'success'" v-html="emoji('👎')"></div>-->
                        <div class="leading-tight min-w-0 w-2/3">
                            <div class="truncate text-xxs" v-html="size.server_name"></div>
                        </div>
                        <div class="w-1/3">
                            <div class="truncate truncate text-xxs text-right ">{{size.disk.used}} / {{size.disk.spacetotal}} GB</div>
                        </div>
                    </div>
                    <div class="skillbar clearfix " :data-percent="size.disk_rate">
                        <div class="skillbar-bar" :style="determineColor(size.disk_rate)"></div>
                        <div class="skill-bar-percent Count">{{size.disk_rate}}</div>
                    </div> <!-- End Skill Bar -->

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
    import { diffInSeconds, emoji } from '../helpers';

    export default {
        components: {
            Tile,
            RelativeDate
        },

        mixins: [echo, saveState],


        props: ['position'],

        data() {
            return {
                sizes: [],
            };
        },

        mounted() {
            this.animate();
        },
        methods: {
            emoji,

            getEventHandlers() {
                //{"status":"success","server":{"id":212437,"name":"DeepLearning"},"site":{"id":661791,"name":"webot"},"commit_hash":"d850f0269c3e1f2470465d99c721c01469435f0a","commit_url":"https://github.com/WeCodeDK/WeBot/commit/d850f0269c3e1f2470465d99c721c01469435f0a","commit_author":"alexander_wecode","commit_message":"pass object by reference"}
                return {
                    'Disk.DiskSizeFetched': response => {
                        console.log(response);
                        this.sizes = response.diskSizes;
                        setTimeout(() =>{ this.animate()}, 3000);
                    },
                };
            },

            getSaveStateConfig() {
                return {
                    cacheKey: 'sizes',
                };
            },
            nameFormat(name){
                return name.replace(/<.*>/, '')
            },
            determineColor(rate)
            {
                if(rate <= 25){
                    return 'background: #2ecc71'
                }

                if(rate > 25 && rate < 50){
                    return 'background: #f3eb00'
                }

                if(rate > 50 && rate < 75){
                    return 'background: #e67e22'
                }

                if(rate > 75){
                    return 'background: #e65822'
                }
            },
            animate(){
                console.log('animating');
                $('.skillbar').each(function(){
                    $(this).find('.skillbar-bar').animate({
                        width: $(this).attr('data-percent')+'%'
                    },6000);
                });

                $('.Count').each(function () {
                    var $this = $(this);
                    $({ Counter: 0 }).animate({ Counter: $this.text() }, {
                        duration: 6000,
                        easing: 'swing',
                        step: function () {
                            $this.text(Math.ceil(this.Counter));
                        }
                    });
                });
            }
        },
    };
    
</script>

<style>
    .Count:after{
        content:"%"
    }

    .skillbar {
        position:relative;
        display:block;
        width:100%;
        background:#eee;
        height:.75rem;
        border-radius:3px;
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        -webkit-transition:0.4s linear;
        -moz-transition:0.4s linear;
        -ms-transition:0.4s linear;
        -o-transition:0.4s linear;
        transition:0.4s linear;
        -webkit-transition-property:width, background-color;
        -moz-transition-property:width, background-color;
        -ms-transition-property:width, background-color;
        -o-transition-property:width, background-color;
        transition-property:width, background-color;
    }

    .skillbar-bar {
        height:.75rem;
        width:0px;
        background:#6adcfa;
        border-radius:3px;
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
    }

    .skill-bar-percent {
        position:absolute;
        right:.5rem;
        top:0;
        font-size:.5rem;
        height:.75rem;
        line-height:.75rem;
        color:#ffffff;
        color:rgba(0, 0, 0);
    }
</style>
