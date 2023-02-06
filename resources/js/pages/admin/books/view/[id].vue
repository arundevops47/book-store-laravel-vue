<script setup>
import { useBookListStore } from '@/views/admin/books/useBookListStore'
import BookDetails from '@/views/admin/books/view/BookDetails.vue'

const bookListStore = useBookListStore()
const route = useRoute()
const book = ref()

bookListStore.fetchBook(Number(route.params.id)).then(res => {
  book.value = res.data.book;
})
</script>

<template>
  <VRow v-if="book">
    <VCol
      cols="12"
      md="6"
      lg="12"
    	>
			<BookDetails :book="book"/>
    </VCol>
  </VRow>
</template>
