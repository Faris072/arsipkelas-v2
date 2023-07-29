<template>
    <div>
        <div><h1>Hello World</h1></div>
        <div>ghasfdghasfgh</div>
        <app-login @info="call">
            inpo
        </app-login>

        <app-login @info="cek">
            inpo2
        </app-login>
    </div>
</template>

<script>
    export default{
        methods: {
            call(){
                alert('p');
            },
            cek(){
                alert('lowww');
            }
        },
    }
</script>