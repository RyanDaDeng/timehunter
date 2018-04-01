<template>
    <div id="app">
        <PublicHome></PublicHome>
    </div>
</template>
<script>
    import PublicHome from './forms/public/Navigation.vue';
    export default {
        name: 'app',
        components: {
            PublicHome
        }
    };
</script>

<style>

    a,header,body{
        font-family: 'Proxima Nova', sans-serif;
    }

</style>