<template>
    <div class="context-menu" v-if="type" :style="`top: ${top}px;left: ${left}px;`">
        <ul v-if="type == 'weeks'">
            <li>
                <button @click="callAction('createWeek')">Создать неделю</button>
            </li>
        </ul>
        <ul v-else-if="type == 'week'">
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
        <ul v-else-if="type == 'training'">
            <li>
                <button @click="callAction('createExercise')">Добавить упражнение</button>
            </li>
        </ul>
        <ul v-else-if="type == 'planeat'">
            <li>
                <button @click="callAction('createMeal')">Добавить блюдо</button>
            </li>
        </ul>
        <ul v-else-if="type == 'relaxtraining'">
            <li>
                <button @click="callAction('createRelaxexercise')">Добавить заняти</button>
            </li>
        </ul>
        <ul v-else-if="type == 'weekday'">
            <li>
                <button @click="callAction('createTraniningGroup')">Добавить тренировку</button>
                <button @click="callAction('createEatGroup')">Добавить план питания</button>
                <button @click="callAction('createRelaxGroup')">Добавить тренировку отдыха</button>
            </li>
        </ul>
        <ul v-else-if="type == 'group-item'">
            <li>
                <button @click="callAction('deleteItem')">Удалить</button>
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
            this.$parent[action].call()
            this.$parent.type = null
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
