import axios from '@axios'
import { defineStore } from 'pinia'

export const useBookListStore = defineStore('BookListStore', {
  actions: {
    // 👉 Fetch books data
    fetchBooks(params) { 
      return new Promise((resolve, reject) => {
        axios.get(`/api/admin/books`, { params })
				.then(response => resolve(response))
				.catch(error => reject(error))
      })
		},
    // 👉 Add Book
    addBook(bookData) {
      return new Promise((resolve, reject) => {
        axios.post('/api/admin/books/save',bookData)
				.then(res => resolve(res))
        .catch(error => reject(error))
      })
    },
    // 👉 fetch single book
    fetchBook(id) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/admin/books/${id}`)
				.then(response => resolve(response))
				.catch(error => reject(error))
      })
    },
    // 👉 update Book
    updateBook(bookData) {
      return new Promise((resolve, reject) => {
        axios.put('/api/admin/books/update/'+bookData.id, bookData)
				.then(response => resolve(response))
        .catch(error => reject(error))
      })
    },		
    // 👉 delete book
    deleteBook(id) {
      return new Promise((resolve, reject) => {
        axios.delete(`/api/admin/books/${id}`)
				.then(response => resolve(response))
				.catch(error => reject(error))
      })
    },		
  },
})
