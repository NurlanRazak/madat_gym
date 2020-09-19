<template>
    <div class="context-menu" v-if="type" :style="`top: ${top}px;left: ${left}px;`">
        <ul v-if="type == 'week'">
            <li>
                <button @click="callAction('duplicateWeek')">Дублировать неделю</button>
            </li>
            <li>
                <button @click="callAction('removeWeek')">Удалить неделю</button>
            </li>
            <li>
                <button @click="callAction('removeWeek')">Сделать активной</button>
            </li>
            <li>
                <button @click="callAction('removeWeek')">Сделать неактивной</button>
            </li>
        </ul>
    </div>
</template>

<script>


export default {
    props: [
        'type', 'top', 'left'
    ],
    data() {
        return {

        }
    },
    methods: {
        callAction(action) {
            this.$parent.type = null
            this.$parent[action].call()
        }
    }
}

</script>

<style scoped>
.context-menu {
    z-index: 100;
    position: fixed;
}
ul {
    background-color: white;
    border: 1px solid grey;
    padding: 5px 0;
}
ul li {
    list-style: none;
    display: block;
}
button {
    width: 100%;
    text-align: left;
    background-color: transparent;
    border: none;
    padding: 3px 20px;
}
button:hover {
    background-color: rgb(239 239 239);
    border: none;
}
</style>
