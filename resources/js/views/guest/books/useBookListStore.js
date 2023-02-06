import axios from '@axios'
import { defineStore } from 'pinia'

export const useBookListStore = defineStore('BookListStore', {
  actions: {
    // 👉 Fetch filters
    fetchFilters(params) { 
      return new Promise((resolve, reject) => {
        axios.get(`/api/filters`, { params })
				.then(response => resolve(response))
				.catch(error => reject(error))
      })
		},		
    // 👉 Fetch books
    fetchBooks(params) { 
      return new Promise((resolve, reject) => {
        axios.get(`/api/books`, { params })
				.then(response => resolve(response))
				.catch(error => reject(error))
      })
		},
    // 👉 fetch single book
    fetchBook(id) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/books/${id}`)
				.then(response => resolve(response))
				.catch(error => reject(error))
      })
    },	
  },
})
