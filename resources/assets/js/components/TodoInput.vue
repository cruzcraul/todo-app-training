<template>
    <div class="box">
        <div class="field is-grouped">
            <p class="control is-expanded">
                <input class="input" type="text" placeholder="Nuevo recordatorio" v-model="todoItemText" v-on:keyup="keyMonitor">
            </p>
            <p class="control">
                <a class="button is-info" @click="addTodo">
                    Agregar
                </a>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            todoItemText: '',
        }
    },
    methods: {
        keyMonitor: function (event) {
            if(event.key == "Enter") {
                this.addTodo();
            }
        },
        addTodo: function () {
            let text = this.todoItemText.trim()
            if (text != '') {
                this.$emit('addTodo', text)
                this.todoItemText = ''
            }
        }
    }
}
</script>

