<template>
    <div class="container-fluid">
        <mousemenu :type="type" :top="top" :left="left" v-click-outside="hideContextMenu" :visible="menuVisible" />
        <form action="">
            <select name="program_id" v-model="program_id">
                <option :value="program.id" v-for="program in programs" :key="program.id">{{ program.name }}</option>
            </select>
        </form>
        <div class="row weeks-wrapper">
            <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1 weeks" @contextmenu.prevent="showContextMenu($event, null, 'weeks')">
                <div class="top">
                    <h4>Недели</h4>
                    <draggable :list="data" group="weeks" @start="drag = true" @end="drag = false">
                        <div class="week" v-for="(week, index) of data" :key="index" >
                            <button @click.prevent="setActiveWeek(index)" :class="{'--active': activeWeek == index}" @contextmenu.prevent="showContextMenu($event, { week: index }, 'week')">
                                {{ week.week }} неделя
                            </button>
                        </div>
                    </draggable>
                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-11 col-lg-11">
                <div class="content">
                    <div class="day" v-for="(day, dayIndex) in days" :key="`day_${dayIndex}`" @contextmenu.prevent="showContextMenu($event, { weekDay: dayIndex }, 'weekday')">
                        <div class="d-content day-title">{{ day }}</div>
                        <div class="d-content day-content">
                            <div :class="['task', `${group.type}`]" v-for="(group, groupIndex) in data[activeWeek].data[dayIndex]" :key="`task_${groupIndex}`" @contextmenu.prevent="showContextMenu($event, { weekDay: dayIndex, group: groupIndex }, group.type)">
                                <div>{{ group.name }}</div>
                                <div>
                                    {{ group.hour_start }} - {{ group.hour_finish }}
                                </div>
                                <div v-if="group.type == 'planeat'" class="task-content">
                                    <div class="subitems" v-for="(item, itemIndex) in group.items" :key="itemIndex" @contextmenu.prevent="showContextMenu($event, { weekDay: dayIndex, group: groupIndex, item: itemIndex }, 'group-item-planeat')">
                                        <div class="task-content">
                                            <div class="task-item" v-for="(subitem, subitemIndex) in item.subitems" :key="subitemIndex" @contextmenu.prevent="showContextMenu($event, { weekDay: dayIndex, group: groupIndex, item: itemIndex, subitem: subitemIndex }, 'group-subitem')">
                                                {{ subitem.name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="task-content">
                                    <div class="task-item" v-for="(item, itemIndex) in group.items" :key="itemIndex" @contextmenu.prevent="showContextMenu($event, { weekDay: dayIndex, group: groupIndex, item: itemIndex }, 'group-item')">
                                        {{ item.name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="save">
                    <button class="save-action">Сохранить изменения</button>
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
            menuVisible: false,
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
            activeWeek: (this.groups && Object.keys(this.groups).length) ? Object.keys(this.groups)[0] : null,
        }
    },
    mounted() {
        console.log(this.data)
    },
    methods: {
        setItemData(data) {
            this.data[this.activeWeek].data[this.target.weekDay][this.target.group].items.push(data)
            this.target = null
            this.type = null
            console.log(data, this.type, this.target)
        },
        setGroupData(data) {

        },
        setSubitemData(data) {
            console.log(this.data[this.activeWeek].data[this.target.weekDay][this.target.group])
            this.data[this.activeWeek].data[this.target.weekDay][this.target.group].items[this.target.item].subitems.push(data)
            this.target = null
            this.type = null
        },
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
        createEathour() {
            this.showModal('eathour')
        },
        createPlaneat() {
            this.showModal('planeat')
        },
        createMeal() {
            this.showModal('meal')
        },
        createExercise() {
            this.showModal('exercise')
        },
        createRelaxexercise() {
            this.showModal('relaxexercise')
        },
        createTraniningGroup() {
            this.showModal('training')
        },
        createRelaxGroup() {
            this.showModal('relaxtraining')
        },
        deleteItem() {

        },
        deleteSubitem() {

        },
        showModal(type) {
            if (this.modal) {
                this.closeModal()
            }
            this.modal = window.open(`/admin/modal/${type}`, 'modal', `scrollbars=yes,resizable=yes,width=${0.8*window.screen.width},height=${0.8*window.screen.height},top=${Math.floor(window.screen.height*0.1)},left=${Math.floor(window.screen.width*0.1)}`)
        },
        closeModal() {
            this.modal.close()
        },
        showContextMenu(e, target, type) {
            if (!this.menuVisible) {
                this.target = target
                this.top = e.clientY
                this.left = e.clientX
                this.type = type
                this.menuVisible = true
            }
        },
        hideContextMenu() {
            this.menuVisible = false
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
    overflow: scroll;
    padding-bottom: 0;
    margin: 10px;
    margin-top: 0;
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
.subitems {
    padding: 3px;
    margin: 3px;
    background-color: rgba(178, 215, 247, 0.5);
    border: 1px solid rgb(50 148 250);
}
</style>
