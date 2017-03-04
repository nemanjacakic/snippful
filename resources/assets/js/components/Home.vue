<style>
    body {
        background: #fff;
    }

    .title {
        font-size: 50px;
        text-align: center;
        color: #000;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
<template>
    <h1 class="title">Snippful</h1>
</template>

<script>
    export default {
        mounted() {
           this.$emit('loaded');
        }
    }
</script>
