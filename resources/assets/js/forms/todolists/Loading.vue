<template>

    <div v-loading.fullscreen.lock="fullscreenLoading">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fullscreenLoading: true
            };
        }
    }
</script>
