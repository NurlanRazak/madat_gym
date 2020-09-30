<template>
    <div class="context-menu" v-if="visible" :style="`top: ${top}px;left: ${left}px;`">
        <ul v-if="type == 'weeks'">
            <li>
                <button @click="callAction('createWeek')">Создать неделю</button>
            </li>
        </ul>
        <ul v-else-if="type == 'week'">
            <li v-if="$parent.target.can_draft && !$parent.target.deleted && false">
                <button @click="callAction('draftWeek')">Сделать неактивной</button>
            </li>
            <li v-else-if="$parent.target.draft && false">
                <button @click="callAction('publishWeek')">Сделать активной</button>
            </li>
            <li>
                <button @click="callAction('duplicateWeek')">Дублировать неделю</button>
            </li>
            <li v-if="$parent.target.deleted">
                <button @click="callAction('restoreWeek')">Восстановить неделю</button>
            </li>
            <li v-else-if="$parent.target.can_draft">
                <button @click="callAction('removeWeek')">Удалить неделю</button>
            </li>
        </ul>
        <ul v-else-if="type == 'training'">
            <li>
                <button @click="callAction('createExercise')">Добавить упражнение</button>
            </li>
            <li v-if="$parent.target.deleted">
                <button @click="callAction('restoreGroup')">Восстановить</button>
            </li>
            <li v-else>
                <button @click="callAction('deleteGroup')">Удалить</button>
            </li>
        </ul>
        <ul v-else-if="type == 'planeat'">
            <li>
                <button @click="callAction('createPlaneat')">Добавить план питания</button>
            </li>
            <li v-if="$parent.target.deleted">
                <button @click="callAction('restoreGroup')">Восстановить</button>
            </li>
            <li v-else>
                <button @click="callAction('deleteGroup')">Удалить</button>
            </li>
        </ul>
        <ul v-else-if="type == 'relaxtraining'">
            <li>
                <button @click="callAction('createRelaxexercise')">Добавить занятие</button>
            </li>
            <li v-if="$parent.target.deleted">
                <button @click="callAction('restoreGroup')">Восстановить</button>
            </li>
            <li v-else>
                <button @click="callAction('deleteGroup')">Удалить</button>
            </li>
        </ul>
        <ul v-else-if="type == 'weekday'">
            <li>
                <button @click="callAction('createTraniningGroup')">Добавить тренировку</button>
            </li>
            <li>
                <button @click="callAction('createEathour')">Добавить час приема</button>
            </li>
            <li>
                <button @click="callAction('createRelaxGroup')">Добавить тренировку отдыха</button>
            </li>
        </ul>
        <ul v-else-if="type == 'group-item'">
            <li v-if="$parent.target.deleted">
                <button @click="callAction('restoreItem')">Восстановить</button>
            </li>
            <li v-else>
                <button @click="callAction('deleteItem')">Удалить</button>
            </li>
        </ul>
        <ul v-else-if="type == 'group-subitem'">
            <li v-if="$parent.target.deleted">
                <button @click="callAction('restoreSubitem')">Восстановить</button>
            </li>
            <li v-else>
                <button @click="callAction('deleteSubitem')">Удалить</button>
            </li>
        </ul>
        <ul v-else-if="type == 'group-item-planeat'">
            <li v-if="$parent.target.deleted">
                <button @click="callAction('restoreItem')">Восстановить план питания</button>
            </li>
            <li v-else>
                <button @click="callAction('deleteItem')">Удалить план питания</button>
            </li>
            <li>
                <button @click="callAction('createMeal')">Добавить блюдо</button>
            </li>
        </ul>
    </div>
</template>

<script>


export default {
    props: [
        'type', 'top', 'left', 'visible'
    ],
    data() {
        return {

        }
    },
    methods: {
        callAction(action) {
            this.$parent[action].call()
            this.$parent.menuVisible = false
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
