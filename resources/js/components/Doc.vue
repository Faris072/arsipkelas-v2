<template>
    <div>
        <button @click="$emit('info')"><slot></slot></button>

        <button @click="sd('aaaaaaaaa')">asas</button>
    </div>
</template>

<script>
    export default{
        methods: {
            sd(message){
                alert(message)
            }
        },
    }
</script>