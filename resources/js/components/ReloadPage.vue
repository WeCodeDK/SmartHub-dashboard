<template>
</template>

<script>
import echo from '../mixins/echo';

export default {

    mixins: [echo],
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
