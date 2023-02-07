<script setup>
import {
  avatarText,
  kFormatter,
} from '@core/utils/formatters'

const props = defineProps({
  books: {
    type: Array,
    required: true,
  },
})

</script>

<template>
	<div>
		<VRow>
			<VCol
				cols="12"
				md="4"
				sm="6"
				lg="2"
				v-for="book in books"
				:key="book.id"
				>
				<RouterLink
					:to="{ name: 'books-id', params: { id: book.id } }"
					class="font-weight-medium book-list-name"
					>
					<VCard class="mb-2" style="height:26rem">
						<div class="">
							<div class="ma-auto pa-5 d-flex justify-space-between">
								<VImg
									class="90"
									height="120"
									:src="book.image"
								/>
							</div>
							<VDivider :vertical="$vuetify.display.mdAndUp" />

							<VCardItem>
									<VCardTitle>{{book.title}}</VCardTitle>
							</VCardItem>

							<VCardText>
								<template v-if="book.description.length > 80">
									{{ book.description.substring(0, 80)+'...' }}
								</template>
								<template v-else>
									{{ book.description }}
								</template>
							</VCardText>

							<VCardText class="text-subtitle-1">
								By {{book.author}}
							</VCardText>
						</div>
					</VCard>
				</RouterLink>
			</VCol>
		</VRow>
	</div>
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 0.7rem;
}

.text-capitalize {
  text-transform: capitalize !important;
}
</style>
