<template>
    <div>
        <h3>Hello, World!</h3>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolores, architecto, quae velit cumque cupiditate
            repellat pariatur atque vero quidem et eveniet molestias quis ad eius in nobis perferendis odit animi.</p>
        <p>the counter is: {{ count }}</p>
        <button @click="onclickHandle"> increase!!</button>
    </div>
    <div>
        <p v-if="color == 'red'">the color is red and the message is :` {{ myMessage }}`</p>
        <p v-else>the color is not red and the message is :` {{ myMessage }}`</p>
    </div>
    <div>
        <TestComponent title="this is title" description="<b>this is descriotion</b>">     
            <applicationLogo/>       
        </TestComponent>
        
    </div>

</template>

<script setup>
defineOptions({layout: SampleLayout});
const {count, myMessage, onclickHandle, color} = useTest()
</script>
<style scoped>
h1 {
    color: #42b983;
}

.red {
    background: red;
    color: white;
}
</style>