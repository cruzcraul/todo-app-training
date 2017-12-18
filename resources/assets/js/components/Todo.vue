<template>
    <div class="container">
        <todo-input v-on:addTodo="addTodo"></todo-input>
        <table class="table is-bordered">
            <todo-item 
                v-on:removeTodo="removeTodo"
                v-on:toggleDone="toggleDone"
                v-for="todo in todos"
                :id="todo.id"
                :text="todo.text"
                :done="todo.done"
                :key="todo.id">
            </todo-item>
        </table>
    </div>
</template>

<script>
    /**
     * Tips:
     * - En mounted pueden obtener el listado del backend de todos y dentro de la promesa de axios asirnarlo
     *   al arreglo que debe tener una estructura similar a los datos de ejemplo.
     * - En addTodo, removeTodo y toggleTodo deben hacer los cambios pertinentes para que las modificaciones,
     *   addiciones o elimicaiones tomen efecto en el backend asi como la base de datos.
     */

    import { mapState } from 'vuex'
    import store from '../vuex/store/todos/store';
    import TodoItem from './TodoItem.vue';
    import TodoInput from './TodoInput.vue';

    export default {
        store: store,
        mounted: function () {
            this.$store.dispatch('LOAD_TODO_LIST')
        },
        computed: mapState([
            'todos'
        ]),
        methods: {
            addTodo (text)  {
                this.$store.dispatch('ADD_NEW_TODO', text)
            },
            removeTodo (todoId) {
                this.$dialog.confirm("¿Estás seguro que deseas eliminar este recordatorio?", {
                    loader: true,
                    okText: 'Sí',
                    cancelText: 'No',
                })
                .then((dialog) => {
                    this.$store.dispatch('REMOVE_TODO', todoId)
                    dialog.close();
                    setTimeout(() => {
                        dialog.close();
                    }, 2500);
                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            toggleDone (todoId) {
                this.$store.dispatch('TOGGLE_DONE', todoId)
            }
        },
        components: {
            'todo-item': TodoItem,
            'todo-input': TodoInput
        }
    }
</script>

<style>
    .is-done {
        text-decoration: line-through;
    }
</style>
