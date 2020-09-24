<template>
    <div class="container-fluid" :key="renderKey">
        <mousemenu :type="type" :top="top" :left="left" v-click-outside="hideContextMenu" :visible="menuVisible" />
        <form action="">
            <select name="program_id" v-model="program_id" @change="setProgram">
                <option :value="program.id" v-for="program in programs" :key="program.id">{{ program.name }}</option>
            </select>
        </form>
        <div class="row weeks-wrapper">
            <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1 weeks" @contextmenu.prevent="showContextMenu($event, null, 'weeks')">
                <div class="top">
                    <h4>Недели</h4>
                    <draggable :list="data" group="weeks" @start="drag = true" @end="drag = false">
                        <div class="week" v-for="(week, index) of data" :key="index" >
                            <button @click.prevent="setActiveWeek(index)" :class="{'--active': activeWeek == index, '--deleted': week.deleted}" @contextmenu.prevent="showContextMenu($event, { week: index, deleted: week.deleted }, 'week')">
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
                            <div :class="['task', `${group.type}`, { '--deleted': group.deleted }]" v-for="(group, groupIndex) in data[activeWeek].data[dayIndex]" :key="`task_${groupIndex}`" @contextmenu.prevent="showContextMenu($event, { weekDay: dayIndex, group: groupIndex, deleted: group.deleted }, group.type)">
                                <div>{{ group.name }}</div>
                                <div>
                                    {{ group.hour_start }} - {{ group.hour_finish }}
                                </div>
                                <div v-if="group.type == 'planeat'" class="task-content">
                                    <div :class="['subitems', { '--deleted': item.deleted }]" v-for="(item, itemIndex) in group.items" :key="itemIndex" @contextmenu.prevent="showContextMenu($event, { weekDay: dayIndex, group: groupIndex, item: itemIndex, deleted: item.deleted }, 'group-item-planeat')">
                                        <div class="task-content">
                                            <div :class="['task-item', {'--deleted': subitem.deleted }]" v-for="(subitem, subitemIndex) in item.subitems" :key="subitemIndex" @contextmenu.prevent="showContextMenu($event, { weekDay: dayIndex, group: groupIndex, item: itemIndex, subitem: subitemIndex, deleted: subitem.deleted }, 'group-subitem')">
                                                {{ subitem.name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="task-content">
                                    <div :class="['task-item', { '--deleted': item.deleted }]" v-for="(item, itemIndex) in group.items" :key="itemIndex" @contextmenu.prevent="showContextMenu($event, { weekDay: dayIndex, group: groupIndex, item: itemIndex, deleted: item.deleted }, 'group-item')">
                                        {{ item.name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="save">
                    <button class="save-action" @click="saveCurrentWeek">Сохранить изменения</button>
                    <button class="save-action" @click="refreshPage">Отменить изменения</button>
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
        'groups',
        'program',
        'foodprogram',
        'relaxprogram',
    ],
    data() {
        return {
            renderKey: 1,
            menuVisible: false,
            modal: null,
            target: null,
            type: null,
            top: null,
            left: null,
            drag: false,
            data: [...this.groups],
            program_id: this.current_program ? this.current_program : (this.programs.length ? this.programs[0].id : null),
            days: [
                'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье',
            ],
            activeWeek: (this.groups && this.groups.length) ? 0 : null,
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
        },
        setGroupData(data) {
            this.data[this.activeWeek].data[this.target.weekDay].push(data)
            this.data[this.activeWeek].data[this.target.weekDay].sort((a, b) => {
                if (a.hour_start < b.hour_start) {
                    return -1
                }
                if (a.hour_start > b.hour_start) {
                    return 1
                }
                if (a.hour_finish < b.hour_finish) {
                    return -1
                }
                if (a.hour_finish > b.hour_finish) {
                    return 1
                }
                return 0
            })
            this.target = null
            this.type = null
        },
        setSubitemData(data) {
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
        createEathour() {
            this.showModal('eathour?active=1')
        },
        createPlaneat() {
            this.showModal(`planeat?days=${this.activeWeek * 7 + 1 + this.target.weekDay}&foodprogram_id=${this.foodprogram}&eathours%5B0%5D=${this.data[this.activeWeek].data[this.target.weekDay][this.target.group].id}&active=1`)
        },
        createMeal() {
            this.showModal('meal?active=1')
        },
        createExercise() {
            this.showModal('exercise?active=1')
        },
        createRelaxexercise() {
            this.showModal('relaxexercise?active=1')
        },
        createTraniningGroup() {
            this.showModal(`training?day_number=${this.activeWeek * 7 + 1 + this.target.weekDay}&programtrainings%5B0%5D=${this.program}&active=1`)
        },
        createRelaxGroup() {
            this.showModal(`relaxtraining?number_day=${this.activeWeek * 7 + 1 + this.target.weekDay}&programs%5B0%5D=${this.relaxprogram}&active=1`)
        },
        duplicateWeek() {
            let week = 1 + Math.max.apply(null, this.data.map(function(item) {
                return item.week;
            }))
            let newWeek = Object.assign({}, this.data[this.target.week], { week: week })
            newWeek.data = newWeek.data.map((groups) => {
                return groups.map((group) => {
                    group.items = group.items.map((item) => {
                        if (item.subitems) {
                            item.subitems = item.subitems.map((subitem) => {
                                return Object.assign({ copy: true }, subitem)
                            })
                        }
                        return Object.assign({ copy: true }, item)
                    })
                    return Object.assign({ copy: true }, group)
                })
            })
            this.data.push(newWeek)
        },
        createWeek() {
            let week = 1 + Math.max.apply(null, this.data.map(function(item) {
                return item.week;
            }))
            this.data.push(Object.assign({}, { week: week, data: [] }))
        },
        removeWeek() {
            this.data[this.target.week].deleted = true
        },
        restoreWeek() {
            this.data[this.target.week].deleted = false
        },
        deleteGroup() {
            this.data[this.activeWeek].data[this.target.weekDay][this.target.group].deleted = true
        },
        restoreGroup() {
            this.data[this.activeWeek].data[this.target.weekDay][this.target.group].deleted = false
        },
        deleteItem() {
            this.data[this.activeWeek].data[this.target.weekDay][this.target.group].items[this.target.item].deleted = true
        },
        restoreItem() {
            this.data[this.activeWeek].data[this.target.weekDay][this.target.group].items[this.target.item].deleted = false
        },
        deleteSubitem() {
            this.data[this.activeWeek].data[this.target.weekDay][this.target.group].items[this.target.item].subitems[this.target.subitem].deleted = true
        },
        restoreSubitem() {
            this.data[this.activeWeek].data[this.target.weekDay][this.target.group].items[this.target.item].subitems[this.target.subitem].deleted = false
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
        },
        setProgram() {
            window.location.href = window.location.pathname + `?program_id=${this.program_id}`
        },
        refreshPage() {
            window.location.reload()
        },
        async saveCurrentWeek() {
            await axios.post(`calendar/${this.program_id}`, this.data)
            // window.location.reload()
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
.--deleted {
    opacity: .5;
}
</style>
