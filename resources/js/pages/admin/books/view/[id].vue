<script setup>
import { useAdminBookListStore } from '@/views/admin/books/useAdminBookListStore'
import BookDetails from '@/views/admin/books/view/BookDetails.vue'

const adminBookListStore = useAdminBookListStore()
const route = useRoute()
const book = ref()

adminBookListStore.fetchBook(Number(route.params.id)).then(res => {
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
