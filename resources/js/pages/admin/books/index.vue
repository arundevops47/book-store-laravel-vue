<script setup>
import AddNewBookDrawer from '@/views/admin/books/add/AddNewBookDrawer.vue'
import EditBookDrawer from '@/views/admin/books/edit/EditBookDrawer.vue'
import { useBookListStore } from '@/views/admin/books/useBookListStore'
import { avatarText } from '@core/utils/formatters'
import { useToast } from "vue-toastification";

const toast = useToast();
const bookListStore = useBookListStore()
const bookData = ref() 
const searchQuery = ref('')
const rowPerPage = ref(10)
const currentPage = ref(1)
const totalPage = ref(1)
const totalBooks = ref(0)
const sortBy = ref('asc')
const books = ref([])
const showLoader = ref(false)
const isAddNewBookDrawerVisible = ref(false)
const isEditBookDrawerVisible = ref(false);
const showConfirmDeleteDialog = ref(false);
const deleteBookId = ref('')
// 👉 Fetching books
const fetchBooks = () => {
  bookListStore.fetchBooks({
    q: searchQuery.value,
    perPage: rowPerPage.value,
    page: currentPage.value,
		sortBy: sortBy.value,
  }).then(res => {
    books.value = res.data.results.data
    totalBooks.value = res.data.results.total
		// console.log('totalPage ', Math.ceil(res.data.results.total/rowPerPage.value));
    totalPage.value = Math.ceil(res.data.results.total/rowPerPage.value);
  }).catch(err => {
    console.error('err ', err)
  })
}

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

const addNewBook = bookData => {
  bookListStore.addBook(bookData).then((res)=> {
		toast.success(res.data.msg, {
			timeout: 2000
		});
		// refetch Book
		fetchBooks()
	})
}


const updateBook = bookData => {
  bookListStore.updateBook(bookData).then((res)=> {
		toast.success(res.data.msg, {
			timeout: 2000
		});
		// refetch Book
		fetchBooks()
	})
}

const handleActionDelete = async (bookId) => {
	showConfirmDeleteDialog.value = true;
	deleteBookId.value = bookId;
}

const onClickEditBook = (book) => {
	bookData.value = book;
	isEditBookDrawerVisible.value = true	
}

const deleteBook = () => {
  bookListStore.deleteBook(deleteBookId.value).then((res) => {
		showConfirmDeleteDialog.value = false;
		deleteBookId.value = '';
		toast.success(res.data.msg, {
			timeout: 2000
		});
		// refetch Book
		fetchBooks()
	})

}

</script>

<template>
  <section>
    <VRow>

      <VCol cols="12">
        <VCard title="Book List">
          <VCardText class="d-flex flex-wrap py-4 gap-4">
            <div
              class="me-3"
              style="width: 80px;"
            >
              <VSelect
                v-model="rowPerPage"
                density="compact"
                variant="outlined"
                :items="[10, 20, 30, 50]"
              />
            </div>

            <VSpacer />

            <div class="app-book-search-filter d-flex align-center justify-end flex-wrap gap-4">
              <!-- 👉 Search  -->
              <div style="width: 10rem;">
                <VTextField
                  v-model="searchQuery"
                  placeholder="Search"
                  density="compact"
                />
              </div>

              <!-- 👉 Export button -->
              <!-- <VBtn
                variant="tonal"
                color="secondary"
                prepend-icon="tabler-screen-share"
              	>
                Export
              </VBtn> -->

              <!-- 👉 Add book button -->
              <VBtn
                prepend-icon="tabler-plus"
                @click="isAddNewBookDrawerVisible = true"
              >
                Add New Book
              </VBtn>
            </div>
          </VCardText>

          <VDivider />

          <VTable class="text-no-wrap">
            <!-- 👉 table head -->
            <thead>
              <tr>
                <th scope="col">
                  ID
                </th>							
                <th scope="col">
                  Title
                </th>
                <th scope="col">
                  Author
                </th>
                <th scope="col">
                  Genre
                </th>								
                <!-- <th scope="col">
                  Description
                </th>	 -->
                <th scope="col">
                  ISBN
                </th>
                <th scope="col">
                  Published	
                </th>		
                <th scope="col">
                  Publisher	
                </th>																																
                <th scope="col">
                  Actions
                </th>
              </tr>
            </thead>
            <!-- 👉 table body -->
            <tbody v-show="books.length">
              <tr
                v-for="book in books"
                :key="book.id"
                style="height: 3.75rem;"
              	>

                <!-- 👉 ID -->
                <td>
                  <span class="text-base font-weight-semibold">{{ book.id }}</span>
                </td>

                <!-- 👉 Title -->
                <td>
                  <div class="d-flex align-center">
                    <VAvatar
                      variant="tonal"
                      class="me-3"
                      size="38"
                    	>
                      <VImg
                        v-if="book.image"
                        :src="book.image"
                      />
                      <span v-else>{{ avatarText(book.title) }}</span>
                    </VAvatar>

                    <div class="d-flex flex-column">
                      <h6 class="text-base">
                        <RouterLink
                          :to="{ name: 'admin-books-view-id', params: { id: book.id } }"
                          class="font-weight-medium book-list-name"
                        >
                          {{ book.title }}
                        </RouterLink>
                      </h6>
                    </div>
                  </div>
                </td>

                <!-- 👉 author -->
                <td>
                  <span class="text-base">{{ book.author }}</span>
                </td>

                <!-- 👉 genre -->
                <td>
                  <span class="text-base">{{ book.genre }}</span>
                </td>

                <!-- 👉 description -->
                <!-- <td>
                  <span class="text-base">{{ book.description }}</span>
                </td> -->

                <!-- 👉 isbn -->
                <td>
                  <span class="text-base">{{ book.isbn }}</span>
                </td>

                <!-- 👉 published -->
                <td>
                  <span class="text-base">{{ book.published }}</span>
                </td>

                <!-- 👉 publisher -->
                <td>
                  <span class="text-base">{{ book.publisher }}</span>
                </td>

                <!-- 👉 Actions -->
                <td
                  class="text-center"
                  style="width: 5rem;"
                	>
                  <VBtn
                    icon
                    size="x-small"
                    color="default"
                    variant="text"
										:to="{ name: 'admin-books-view-id', params: { id: book.id } }"
                  	>
                    <VIcon
                      size="22"
                      icon="tabler-eye"
                    />
                  </VBtn>									
                  <VBtn
                    icon
                    size="x-small"
                    color="default"
                    variant="text"
										@click="onClickEditBook(book)"
                  	>
                    <VIcon
                      size="22"
                      icon="tabler-edit"
                    />
                  </VBtn>

                  <VBtn
                    icon
                    size="x-small"
                    color="default"
                    variant="text"
										@click.stop="handleActionDelete(book.id)"
                  	>
                    <VIcon
                      size="22"
                      icon="tabler-trash"
                    />
                  </VBtn>
                </td>
              </tr>
            </tbody>

            <!-- 👉 table footer  -->
            <tfoot v-show="!books.length">
              <tr>
                <td
                  colspan="9"
                  class="text-center"
                >
                  No book available
                </td>
              </tr>
            </tfoot>
          </VTable>

          <VDivider />

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
        </VCard>
      </VCol>
    </VRow>

    <!-- 👉 Add New Book -->
    <AddNewBookDrawer
      v-model:isDrawerOpen="isAddNewBookDrawerVisible"
      @book-data="addNewBook"
    />

    <!-- 👉 Edit Book -->
    <EditBookDrawer
      v-model:isEditDrawerOpen="isEditBookDrawerVisible"
			:data="bookData"
      @book-data="updateBook"
    />

    <VDialog
			v-model="showConfirmDeleteDialog"
      max-width="390"
    	>
      <VCard>
        <VCardTitle class="text-h5">
          Delete Book
        </VCardTitle>
				<VDivider />
        <VCardText>Are you sure you want to delete this book?</VCardText>
        <VCardActions>
          <VSpacer></VSpacer>
          <VBtn
						variant="flat"
						color="secondary"
						@click="showConfirmDeleteDialog = false"
          	>
            Cancel
          </VBtn>
					<VBtn
						variant="flat"
						color="error"
						:disabled="showLoader"
						:loading="showLoader"
						@click="deleteBook"					
						>
						Delete
					</VBtn>
        </VCardActions>
      </VCard>
    </VDialog>

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
