import axios from 'axios'
import * as types from './mutation-types'

const api = axios.create({ baseURL: "/api" });

const actions = {
    [types.LOAD_TODO_LIST]: function ({ commit }) {
        api.get('/todos').then((response) => {
            commit('LOAD_TODO_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        })
    },
    [types.ADD_NEW_TODO]: function ({ commit }, text) {
        api.post('/todos', { text: text }).then((response) => {
            commit('ADD_NEW_TODO', { todo: response.data })
        }, (err) => {
            console.log(err)
        })
    },
    [types.TOGGLE_DONE]: function ({ commit }, todoId) {
        api.put('/todos/' + todoId).then((response) => {
            if (response.data.rslt) {
                commit('TOGGLE_DONE', { todo: response.data.todo })
            }
        }, (err) => {
            console.log(err)
        })
    },
    [types.REMOVE_TODO]: function ({ commit }, todoId) {
        api.delete('/todos/' + todoId).then((response) => {
            if (response.data.rslt) {
                commit('REMOVE_TODO', todoId)
            }
        }, (err) => {
            console.log(err)
        })
    }
}

export default actions