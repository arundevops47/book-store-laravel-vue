<script setup>
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import {
  requiredValidator,
} from '@validators'

const props = defineProps({
  isDrawerOpen: {
    type: Boolean,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDrawerOpen',
  'bookData',
])

const isFormValid = ref(false)
const refForm = ref()
const title = ref('')
const author = ref('')
const description = ref('')
const image = ref('')
const genre = ref('')
const isbn = ref()
const published = ref()
const publisher = ref()

// 👉 drawer close
const closeNavigationDrawer = () => {
  emit('update:isDrawerOpen', false)
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      emit('bookData', {
        title: title.value,
        author: author.value,
        description: description.value,
        image: image.value,
        genre: genre.value,
        isbn: isbn.value,
        published: published.value,
				publisher: publisher.value,
      })
      emit('update:isDrawerOpen', false)
      nextTick(() => {
        refForm.value?.reset()
        refForm.value?.resetValidation()
      })
    }
  })
}

const handleDrawerModelValueUpdate = val => {
  emit('update:isDrawerOpen', val)
}
</script>

<template>
  <VNavigationDrawer
    temporary
    :width="400"
    location="end"
    class="scrollable-content"
    :model-value="props.isDrawerOpen"
    @update:model-value="handleDrawerModelValueUpdate"
  	>
    <!-- 👉 Title -->
    <div class="d-flex align-center pa-6 pb-1">
      <h6 class="text-h6">
        Add Book
      </h6>

      <VSpacer />

      <!-- 👉 Close btn -->
      <VBtn
        variant="tonal"
        color="default"
        icon
        size="32"
        class="rounded"
        @click="closeNavigationDrawer"
      >
        <VIcon
          size="18"
          icon="tabler-x"
        />
      </VBTn>
    </div>

    <PerfectScrollbar :options="{ wheelPropagation: false }">
      <VCard flat>
        <VCardText>
          <!-- 👉 Form -->
          <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="onSubmit"
          >
            <VRow>
              <!-- 👉 Title -->
              <VCol cols="12">
                <VTextField
                  v-model="title"
                  :rules="[requiredValidator]"
                  label="Title"
                />
              </VCol>

              <!-- 👉 Author -->
              <VCol cols="12">
                <VTextField
                  v-model="author"
                  :rules="[requiredValidator]"
                  label="Author"
                />
              </VCol>

              <!-- 👉 Genre -->
              <VCol cols="12">
                <VTextField
                  v-model="genre"
                  :rules="[requiredValidator]"
                  label="Genre"
                />
              </VCol>

              <!-- 👉 Description -->
              <VCol cols="12">
                <VTextarea
                  v-model="description"
                  :rules="[requiredValidator]"
                  label="Description"
                />
              </VCol>

              <!-- 👉 ISBN -->
              <VCol cols="12">
                <VTextField
                  v-model="isbn"
                  :rules="[requiredValidator]"
                  label="ISBN"
                />
              </VCol>							

              <!-- 👉 Image -->
              <VCol cols="12">
                <VTextField
                  v-model="image"
                  :rules="[requiredValidator]"
                  label="Image"
                />
              </VCol>
							
              <!-- 👉 Published -->
              <VCol cols="12">
                <VTextField
                  v-model="published"
                  :rules="[requiredValidator]"
                  label="Published"
                />
              </VCol>	

              <!-- 👉 Publisher -->
              <VCol cols="12">
                <VTextField
                  v-model="publisher"
                  :rules="[requiredValidator]"
                  label="Publisher"
                />
              </VCol>	

              <!-- 👉 Submit and Cancel -->
              <VCol cols="12">
                <VBtn
                  type="submit"
                  class="me-3"
                	>
                  Submit
                </VBtn>
                <VBtn
                  type="reset"
                  variant="tonal"
                  color="secondary"
                  @click="closeNavigationDrawer"
                	>
                  Cancel
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </PerfectScrollbar>
  </VNavigationDrawer>
</template>
