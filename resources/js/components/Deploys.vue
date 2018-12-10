<template>
    <tile :position="position" class="z-10" >
        <ul class="grid" style="grid-auto-rows: auto;">
            <li
                    class="overflow-hidden pb-4 mb-4 border-b-2 border-screen"
                    v-for="deploy in deploys"
            >
                <div class="markup grid gap-padding" style="grid-auto-rows: auto">
                    <div
                            class="grid gap-2 items-center w-full"
                            style="grid-template-columns: auto 1fr"
                    >
                        <div v-if="deploy.status == 'success'">👍</div>
                        <div v-else="deploy.status == 'success'">👎</div>
                        <div class="leading-tight min-w-0">
                            <h2 class="truncate" v-html="deploy.site.name"></h2>
                            <div class="truncate text-sm" v-html="deploy.server.name"></div>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm">@{{deploy.commit_author}}</div>
                        <div  v-html="deploy.commit_message"></div>
                        <div class="mt-1 text-xs text-dimmed">
                            <relative-date :moment="deploy.date"></relative-date>
                        </div>
                    </div>
                    <img
                            v-if="deploy.image"
                            class="max-h-48 mx-auto"
                            style="objection-fit: cover;"
                            :src="deploy.image"
                    />
                    <div
                            v-if="deploy.hasQuote"
                            class="py-2 pl-2 text-xs text-dimmed border-l-2 border-screen"
                            v-html="deploy.quote.html"
                    ></div>
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
    import { diffInSeconds } from '../helpers';

    export default {
        components: {
            Tile,
            RelativeDate
        },

        mixins: [echo, saveState],


        props: ['position'],

        data() {
            return {
                deploys: [],
                deploys_waiting_line: [],
            };
        },

        created() {

        },

        methods: {

            getEventHandlers() {
                //{"status":"success","server":{"id":212437,"name":"DeepLearning"},"site":{"id":661791,"name":"webot"},"commit_hash":"d850f0269c3e1f2470465d99c721c01469435f0a","commit_url":"https://github.com/WeCodeDK/WeBot/commit/d850f0269c3e1f2470465d99c721c01469435f0a","commit_author":"alexander_wecode","commit_message":"pass object by reference"}
                return {
                    'Deploy.ForgeDeploy': response => {
                        response.deployProperties.date = moment().toString();
                        this.deploys_waiting_line.push(response.deployProperties)
                        this.processWaitingLine()
                    },
                };
            },

            processWaitingLine() {
                if (this.deploys_waiting_line.length === 0) {
                    return;
                }

                console.log(this.deploys_waiting_line);

                this.deploys.unshift(this.deploys_waiting_line.shift());
                this.deploys = this.deploys.slice(0, 12);

            },
            getSaveStateConfig() {
                return {
                    cacheKey: 'deploys',
                };
            },
        },
    };
</script>
