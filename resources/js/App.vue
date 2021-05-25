<template>
    <main>

        <router-view></router-view>
        <FlashMessage position="right top"></FlashMessage>
        <vue-confirm-dialog></vue-confirm-dialog>
    </main>
</template>

<script>
    export default {

    }
</script>
