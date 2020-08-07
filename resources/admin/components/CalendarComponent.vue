<template>
    <div class="container-fluid">
        <form action="">
            <select name="program_id" v-model="program_id">
                <option :value="program.id" v-for="program in programs" :key="program.id">{{ program.name }}</option>
            </select>
        </form>
        <div class="row weeks-wrapper">
            <div class="col-sm-1 weeks">
                <div class="top">
                    <h4>Недели</h4>
                    <div class="week" v-for="week in Object.keys(data)" :key="week" >
                        <button @click.prevent="setActiveWeek(week)" :class="{'--active': activeWeek == week}">
                            {{ week }} неделя
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
                            <div :class="['task', `${group.type}`]" v-for="(group, index) in data[activeWeek][index]" :key="index">
                                <div>{{ group.name }}</div>
                                <div>
                                    {{ group.hour_start }} - {{ group.hour_finish }}
                                </div>
                                <div class="task-content">
                                    <div class="task-item" v-for="(item, index) in group.items">
                                        {{ item.name }}
                                    </div>
                                </div>
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
    props: [
        'programs',
        'current_program',
        'groups'
    ],
    data() {
        return {
            data: this.groups,
            program_id: this.current_program ? this.current_program : (this.programs.length ? this.programs[0].id : null),
            days: [
                'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье',
            ],
            actions: [
                {label:'Создать неделю', class: 'green', action: 'createWeek'},
                {label:'Добавить группу', class: 'transparent', action: 'createGroup'},
                {label:'Добавить упражнение', class: 'training', action: 'createExercise'},
                {label:'Добавить блюдо', class: 'planeat', action: 'createMeal'},
                {label:'Добавить занятие', class: 'relaxtraining', action: 'createAction'},
            ],
            activeWeek: (this.groups && Object.keys(this.groups).length) ? Object.keys(this.groups)[0] : null,
        }
    },
    mounted() {
        console.log(this.data)
    },
    methods: {
        setActiveWeek(week) {
            this.activeWeek = week
        },
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
.task-training {
    background-color:
}
.task-content {
    padding: 10px;
}
.task-item {
    padding: 2px;
    margin: 5px;
    background-color: rgba(178, 215, 247, 1);
    border: 1px solid rgb(50 148 250);
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

.day:not(:last-child) {
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
.green {
    background-color: rgba(130, 200, 100, .5);
    border: 1px solid rgba(130, 200, 100, 1);
}
.relaxtraining {
    background-color: rgba(255, 100, 100, .5);
    border: 1px solid rgba(255, 100, 100, 1);
}
.transparent {
    background-color: transparent;
    border: 1px solid black;
}
.training {
    background-color: rgba(250, 230, 160, .5);
    border: 1px solid rgba(250, 230, 160, 1);
}
.planeat {
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
