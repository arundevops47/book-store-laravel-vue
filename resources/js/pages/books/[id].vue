<script setup>
import { useBookListStore } from '@/views/guest/books/useBookListStore'
import BookDetails from '@/views/guest/books/view/BookDetails.vue'

const bookListStore = useBookListStore()
const route = useRoute()
const book = ref()

bookListStore.fetchBook(Number(route.params.id)).then(res => {
  book.value = res.data.book;
})
</script>

<template>
	<div>
		<VRow v-if="book">
			<VCol
				cols="12"
				md="6"
				lg="12"
				>
				<BookDetails :book="book"/>
			</VCol>
		</VRow>
		<VCard class="px-5 py-4 mb-4 text-center" v-else>
			No book found
		</VCard>
	</div>
</template>

<route lang="yaml">
meta:
  layout: home
  action: read
  subject: Auth
</route>
