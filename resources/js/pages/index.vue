<script setup>
import { useBookListStore } from '@/views/guest/books/useBookListStore'
import { avatarText } from '@core/utils/formatters'
import { useToast } from "vue-toastification";
import BookList from '@/views/guest/books/view/BookList.vue'

const toast = useToast();
const bookListStore = useBookListStore()
const books = ref([])
const bookData = ref() 
const searchQuery = ref('')
const rowPerPage = ref(12)
const currentPage = ref(1)
const totalPage = ref(1)
const totalBooks = ref(0)
const sortBy = ref('asc')
const showLoader = ref(false)
const filters = ref([])
const selectedFilters = ref({})
const selectedCheckbox = ref([]);

// 👉 Fetching filters
const fetchFilters = () => {	
  bookListStore.fetchFilters().then(res => {
		filters.value = res.data.filters
  }).catch(err => {
    console.error('err ', err)
  })
}

const onClickCheckbox = (ev, filter) => {
  let selectedFilter = JSON.parse(JSON.stringify(filter));
	if(selectedFilters.value[selectedFilter.value] != undefined) {
		let idx = selectedFilters.value[selectedFilter.value].indexOf(ev.target.value)
		if (idx === -1) {
			selectedFilters.value[selectedFilter.value].push(ev.target.value)
		}
		else {
			selectedFilters.value[selectedFilter.value].splice(idx, 1);
		}
	}
	else {
		selectedFilters.value[selectedFilter.value] = [];
		selectedFilters.value[selectedFilter.value].push(ev.target.value)
	}
}

watchEffect(fetchFilters)

// 👉 Fetching books
const fetchBooks = () => {
	let params = {
    q: searchQuery.value,
    perPage: rowPerPage.value,
    page: currentPage.value,
		sortBy: sortBy.value,
  }

  let filters = JSON.parse(JSON.stringify(selectedFilters.value));
	if(Object.keys(filters).length) {
		params.filters = {}
		for (const [key, value] of Object.entries(filters)) {
			params.filters[key] = value.map(v => '(' + v + ')').join(" OR ");
		}
	}

  bookListStore.fetchBooks(params).then(res => {
    books.value = res.data.data.data
    totalBooks.value = res.data.data.total
    totalPage.value = Math.ceil(res.data.data.total/rowPerPage.value);
  }).catch(err => {
    console.error('err ', err)
  })
}

// fetchBooks()
watchEffect(fetchBooks)
// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value)
    currentPage.value = totalPage.value
})

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = books.value.length ? (currentPage.value - 1) * rowPerPage.value + 1 : 0
  const lastIndex = books.value.length + (currentPage.value - 1) * rowPerPage.value
  return `Showing ${ firstIndex } to ${ lastIndex } of ${ totalBooks.value } entries`
})

</script>

<template>
  <section>
		<VRow class="pb-4">
			<VCol 
				cols="12">
				<VCard>
					<VCardText class="d-flex flex-wrap py-4 gap-4">
						<div class="app-book-search-filter d-flex align-center justify-start flex-wrap gap-4">
							<VTextField
								v-model="searchQuery"
								placeholder="Search Title"
								density="compact"
							/>
						</div>					
						<VSpacer />
						<div class="me-3">
							<VSelect
								v-model="rowPerPage"
								density="compact"
								variant="outlined"
								:items="[12, 24, 48]"
							/>
						</div>
					</VCardText>
				</VCard>
			</VCol>
		</VRow>

    <VRow>
			<VCol 
				cols="12"
				md="12"
				lg="2">
				<VCard>
					<VCardTitle class="font-weight-bold pb-5">
						Filter Results
					</VCardTitle>
					<VExpansionPanels
						>
						<VExpansionPanel
							v-for="filter in filters"
							>
							<VExpansionPanelTitle>{{ filter.label }}</VExpansionPanelTitle>
							<VExpansionPanelText>
								<VCheckbox 
									v-for="(item, index) in filter.items" 
									v-model="selectedCheckbox"
									:hide-details="index !== filter.items.length - 1" 
									:key="item" 
									:value="item" 
									:label="`${item}`" 
									@click="onClickCheckbox($event,filter)"
									/>
							</VExpansionPanelText>
						</VExpansionPanel>
					</VExpansionPanels>
				</VCard>
			</VCol>

			<VCol 
				cols="12"
				md="6"
				lg="10"
				>
				<template v-if="books.length">
					<BookList :books="books"/>
				</template>
				<template v-else>
				</template>

				<VCardText class="d-flex align-center flex-wrap justify-space-between gap-4 py-3 px-5">
					<span class="text-sm text-disabled">
						{{ paginationData }}
					</span>

					<VPagination
						v-model="currentPage"
						size="small"
						:total-visible="5"
						:length="totalPage"
					/>
				</VCardText>

			</VCol>
    </VRow>
  </section>
</template>

<style lang="scss">
.app-book-search-filter {
  inline-size: 31.6rem;
}

.text-capitalize {
  text-transform: capitalize;
}

.book-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>


<route lang="yaml">
meta:
  layout: home
</route>
