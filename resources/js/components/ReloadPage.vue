<template>
</template>

<script>
import echo from '../mixins/echo';

export default {

    mixins: [echo],
    //
    // data() {
    //     return {
    //         offline: false,
    //         lastHeartBeatReceivedAt: moment(),
    //     };
    // },

    methods: {
        getEventHandlers() {
            return {
                'Dashboard.ReloadDashboard': () => {
                    location.reload();
                },
            };
        },
    },
};
</script>
