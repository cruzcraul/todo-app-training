<template>
    <div class="container">
        <todo-input v-on:addTodo="addTodo"></todo-input>
        <table class="table is-bordered">
            <todo-item 
                v-on:removeTodo="removeTodo"
                v-on:toggleDone="toggleDone"
                v-for="todo in items"
                :id="todo.id"
                :text="todo.text"
                :done="todo.done"
                :key="todo.id">
            </todo-item>
        </table>
    </div>
</template>

<script>
    var TodoItem  = require('./TodoItem.vue');
    var TodoInput  = require('./TodoInput.vue');
    /**
     * Tips:
     * - En mounted pueden obtener el listado del backend de todos y dentro de la promesa de axios asirnarlo
     *   al arreglo que debe tener una estructura similar a los datos de ejemplo.
     * - En addTodo, removeTodo y toggleTodo deben hacer los cambios pertinentes para que las modificaciones,
     *   addiciones o elimicaiones tomen efecto en el backend asi como la base de datos.
     */
    export default {
        data () {
            return {
                items: [],
            }
        },
        mounted () {
            this.axios.get('/api/todos').then((response) => {
                this.items = response.data;
            });
        },
        methods: {
            addTodo (text)  {
                this.axios.post('/api/todos', {'text': text}).then((response) => {
                    this.items.push(response.data)
                });
            },
            removeTodo (todoId) {
                this.$dialog.confirm("¿Estás seguro que deseas eliminar este recordatorio?", {
                    loader: true,
                    okText: 'Sí',
                    cancelText: 'No',
                })
                .then((dialog) => {
                    this.axios.delete('/api/todos/'+todoId).then((response) => {
                        dialog.close();
                        if (response.data.rslt) {
                            this.items = this.items.filter(function (item) {
                                return item.id !== todoId
                            })
                        }
                    });
                    setTimeout(() => {
                        dialog.close();
                    }, 2500);
                }).catch(function (error) {
                    console.log(error.response);
                });
            },
            toggleDone (todoId) {
                this.axios.put('/api/todos/'+todoId).then((response) => {
                    if (response.data.rslt) {
                        this.items = this.items.filter(function (item) {
                            if (item.id == todoId) {
                                item.done = !item.done
                            }
                            return item
                        })
                    }
                });
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
