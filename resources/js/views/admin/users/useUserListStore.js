import axios from '@axios'
import { defineStore } from 'pinia'

export const useUserListStore = defineStore('UserListStore', {
  actions: {
    // 👉 Fetch users data
    fetchUsers(params) { 
      return new Promise((resolve, reject) => {
        axios.get(`/api/admin/users`, { params })
				.then(response => resolve(response))
				.catch(error => reject(error))
      })
		},
    // 👉 Add User
    addUser(userData) {
      return new Promise((resolve, reject) => {
        axios.post('/api/admin/users/save',userData)
				.then(res => resolve(res))
        .catch(error => reject(error))
      })
    },
    // 👉 fetch single user
    fetchUser(id) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/admin/users/${id}`)
				.then(response => resolve(response))
				.catch(error => reject(error))
      })
    },
    // 👉 update User
    updateUser(userData) {
      return new Promise((resolve, reject) => {
        axios.post('/api/admin/users/update', {
          user: userData,
        })
				.then(response => resolve(response))
        .catch(error => reject(error))
      })
    },		
    // 👉 delete user
    deleteUser(id) {
      return new Promise((resolve, reject) => {
        axios.delete(`/api/admin/users/${id}`)
				.then(response => resolve(response))
				.catch(error => reject(error))
      })
    },		
  },
})
