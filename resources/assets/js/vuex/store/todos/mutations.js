import * as types from './mutation-types'

const mutations = {
    [types.LOAD_TODO_LIST]: (state, { list }) => {
        state.todos = list
    },
    [types.ADD_NEW_TODO]: (state, { todo }) => {
        state.todos.push(todo)
    },
    [types.TOGGLE_DONE]: (state, { todo }) => {
        let idx = state.todos.map(p => p.id).indexOf(todo.id)
        state.todos.splice(idx, 1, todo)
    },
    [types.REMOVE_TODO]: (state, todoId) => {
        let idx = state.todos.map(p => p.id).indexOf(todoId)
        state.todos.splice(idx, 1)
    }
}

export default mutations