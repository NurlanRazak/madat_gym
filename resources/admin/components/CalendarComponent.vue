<template>
    <div class="container-fluid">
        <div class="row weeks-wrapper">
            <div class="col-sm-1 weeks">
                <div class="top">
                    <h4>Недели</h4>
                    <div class="week" v-for="(day, index) in days" :key="index" >
                        <button @click.prevent="">
                            {{ index }}th week
                        </button>
                    </div>
                </div>
                <div class="bottom">
                    <button class="left-action">Удалить неделю</button>
                    <button class="left-action">Сделать активной/неактивной</button>
                </div>
            </div>
            <div class="col-sm-11">
                <div class="head">
                    <button v-for="(action, index) in actions" :key="index" :class="['action', action.class]" @click.prevent="callAction(action.action)">{{ action.label }}</button>
                </div>
                <div class="content">
                    <div class="day" v-for="(day, index) in days" :key="index">
                        <div class="d-content day-title">{{ day }}</div>
                        <div class="d-content day-content">
                            <div class="task" v-for="index in 5" :key="index">
                                task {{ index }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="save">
                    <button class="save-action">Сохранить изменения в неделе</button>
                    <button class="save-action">Отменить изменения</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            days: [
                'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье',
            ],
            actions: [
                {label:'Создать неделю', class: 'green', action: 'createWeek'},
                {label:'Добавить группу', class: 'transparent', action: 'createGroup'},
                {label:'Добавить упражнение', class: 'yellow', action: 'createExercise'},
                {label:'Добавить блюдо', class: 'orange', action: 'createMeal'},
                {label:'Добавить занятие', class: 'red', action: 'createAction'},
            ],
        }
    },
    methods: {
        callAction(action) {
            this[action]()
        },
        createWeek() {
            alert('creat week')
        },
        createGroup() {
            alert('creat group')
        },
        createExercise() {
            alert('creat exercise')
        },
        createMeal() {
            alert('creat meal')
        },
        createAction() {
            alert('creat action')
        },
    }
}
</script>

<style scoped>
.weeks-wrapper {
    padding: 10px;
    display: flex;
}
.top {
    width: 100%;
}
.bottom {
    width: 100%;
}
.left-action {
    margin: 3px;
    padding: 5px;
}
.weeks {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 10px;
    text-align: center;
    border: 1px solid grey;
}
.week {
    padding: 5px;
}
.content {
    display: flex;
    justify-content: space-between;
    border: 1px solid grey;
    padding: 10px;
    padding-bottom: 0;
    margin: 10px;
    margin-top: 20px;
}
.task {
    cursor: pointer;
    padding: 10px;
    margin: 10px;
    border: 1px solid grey;
    border-radius: 5px;
    background-color: lightgrey;
}
.day {
    width:100%;
    text-align: center;
    display: flex;
    flex-direction: column;
}
.day-title {
    padding: 10px;
    border-bottom: 1px solid grey;
}
.day-content {
    height: 500px;
}
.day:not(:last-child) .d-content {
    border-right: 1px solid grey;
}
.head {
    padding: 5px;
    margin: 10px;
    margin-top: 0;
    border: 1px solid grey;
}
.action {
    padding: 5px 20px;
    margin: 5px;
    border-radius: 5px;
    font-weight: 450;
}
.action.green {
    background-color: rgba(130, 200, 100, .5);
    border: 1px solid rgba(130, 200, 100, 1);
}
.action.red {
    background-color: rgba(255, 100, 100, .5);
    border: 1px solid rgba(255, 100, 100, 1);
}
.action.transparent {
    background-color: transparent;
    border: 1px solid black;
}
.action.yellow {
    background-color: rgba(250, 230, 160, .5);
    border: 1px solid rgba(250, 230, 160, 1);
}
.action.orange {
    background-color: rgba(220, 180, 150, .4);
    border: 1px solid rgba(200, 170, 150, 1);
}
.save {
    padding: 5px;
    margin: 10px;
    margin-bottom: 0;
    border: 1px solid grey;
    text-align: right;
}
.save-action {
    padding: 5px;
    margin: 3px;
}
</style>
