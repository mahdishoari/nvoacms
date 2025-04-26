export default function () {
    const count = ref(0);
    const myMessage = ref('This is yours message')
    const color = ref('blue')
    function onclickHandle() {
        count.value++
    }

    return {
        count,
        color,
        myMessage,
        onclickHandle
    }

}

