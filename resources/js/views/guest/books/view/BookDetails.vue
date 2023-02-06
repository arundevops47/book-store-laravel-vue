<script setup>
import {
  avatarText,
  kFormatter,
} from '@core/utils/formatters'

const props = defineProps({
  book: {
    type: Object,
    required: true,
  },
})

</script>

<template>
	<VCard title="Book Details">
		<div class="d-flex justify-space-between flex-wrap flex-md-nowrap flex-column flex-md-row">
			<div class="ma-auto pa-5">
				<VImg
					width="139"
					:src="book.image"
				/>
			</div>

			<VDivider :vertical="$vuetify.display.mdAndUp" />

			<div>
				<VCardItem>
					<VCardTitle>{{book.title}}</VCardTitle>
					<VCardSubtitle class="text-caption font-weight-bold pa-0">
						By {{book.author}}
					</VCardSubtitle>							
				</VCardItem>

				<VCardText>
					{{book.description}}
				</VCardText>

				<VCardText class="text-subtitle-1">
					<p><span class="font-weight-bold">Genre :</span> <span>{{book.genre}}</span></p>
					<p><span class="font-weight-bold">ISBN :</span> <span>{{book.isbn}}</span></p>
					<p><span class="font-weight-bold">Published :</span> <span>{{book.published}}</span></p>
					<p><span class="font-weight-bold">Publisher :</span> <span>{{book.publisher}}</span></p>
				</VCardText>
			</div>
		</div>
	</VCard>

  <!-- 👉 Edit book info dialog -->
  <!-- <BookInfoEditDialog
    v-model:isDialogVisible="isBookInfoEditDialogVisible"
    :book-data="props.bookData"
  /> -->
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 0.7rem;
}

.text-capitalize {
  text-transform: capitalize !important;
}
</style>
