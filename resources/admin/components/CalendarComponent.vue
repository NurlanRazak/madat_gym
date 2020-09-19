<template>
    <div class="container-fluid">
        <mousemenu :type="type" :top="top" :left="left" v-click-outside="hideContextMenu" />
        <form action="">
            <select name="program_id" v-model="program_id">
                <option :value="program.id" v-for="program in programs" :key="program.id">{{ program.name }}</option>
            </select>
        </form>
        <div class="row weeks-wrapper">
            <div class="col-sm-1 weeks">
                <div class="top">
                    <h4>Недели</h4>
                    <draggable :list="data" group="weeks" @start="drag = true" @end="drag = false">
                        <div class="week" v-for="(week, index) of data" :key="index" >
                            <button @click.prevent="setActiveWeek(index)" :class="{'--active': activeWeek == index}" @contextmenu="showContextMenu($event, index, 'week')">
                                {{ week.week }} неделя
                            </button>
                        </div>
                    </draggable>
                </div>
            </div>
            <div class="col-sm-11">
                <div class="head">
                    <button v-for="(action, index) in actions" :key="index" :class="['action', action.class]" @click.prevent="callAction(action.action)">{{ action.label }}</button>
                </div>
                <div class="content">
                    <div class="day" v-for="(day, index) in days" :key="`day_${index}`">
                        <div class="d-content day-title">{{ day }}</div>
                        <draggable :list="data[activeWeek].data[index]" group="days" :sort="false" class="d-content day-content" @start="drag = true" @end="drag = false">
                            <div :class="['task', `${group.type}`]" v-for="(group, index) in data[activeWeek].data[index]" :key="`task_${index}`">
                                <div>{{ group.name }}</div>
                                <div>
                                    {{ group.hour_start }} - {{ group.hour_finish }}
                                </div>
                                <draggable :list="group.items" :group="`items_${group.type}`" class="task-content">
                                    <div class="task-item" v-for="(item, index) in group.items">
                                        {{ item.name }}
                                    </div>
                                </draggable>
                            </div>
                        </draggable>
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
import draggable from 'vuedraggable'
import ClickOutside from 'vue-click-outside'

export default {
    components: {
        draggable
    },
    directives: {
        ClickOutside
    },
    props: [
        'programs',
        'current_program',
        'groups'
    ],
    data() {
        return {
            modal: null,
            target: null,
            type: null,
            top: null,
            left: null,
            drag: false,
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
        duplicateWeek() {
            this.data.push(Object.assign({}, this.data[this.target], { week: this.data[this.data.length - 1].week + 1 }))
        },
        createWeek() {
            this.data.push(Object.assign({}, { week: this.data[this.data.length - 1].week + 1, data: [] }))
        },
        removeWeek() {
            alert('remove week')
        },
        createGroup() {
            alert('creat group')
        },
        async createExercise() {
            this.modal = window.open('/admin/modal/exercise', 'modal', 'scrollbars=yes,resizable=yes,width=500,height=600')

            // var newdiv = document.createElement('div');
            // newdiv.innerHTML = resp.data
            //
            // document.getElementById('createModal').innerHTML = ''
            // document.getElementById('createModal').appendChild(newdiv)
            // jQuery.ready();
            // var scripts = newdiv.getElementsByTagName('script');
            // for (var ix = 0; ix < scripts.length; ix++) {
            //     eval(scripts[ix].text);
            // }

        },
        createMeal() {
            alert('creat meal')
        },
        createAction() {
            alert('creat action')
        },
        showContextMenu(e, target, type) {
            e.preventDefault()
            this.target = target
            this.top = e.clientY
            this.left = e.clientX
            this.type = type
        },
        hideContextMenu() {
            this.type = null
        }
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
