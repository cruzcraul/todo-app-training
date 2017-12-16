<template>
    <tr>
        <td class="is-fullwidth" style="cursor: pointer" :class="{ 'is-done': this.done }" @click="toggleDone()">
            {{text}}
        </td>
        <td class="is-narrow">
            <a class="button is-danger is-small" @click="removeTodo()">Eliminar</a>
        </td>
    </tr>
</template>

<script>
export default {
    props: {
        id: Number,
        text: String,
        done: Boolean
    },
    methods: {
        removeTodo: function() {
            this.$emit('removeTodo', this.id)
        },
        toggleDone: function() {
            this.$emit('toggleDone', this.id)
        }
    }
}
</script>
