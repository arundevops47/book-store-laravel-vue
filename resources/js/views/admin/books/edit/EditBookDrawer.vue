<script setup>
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import {
  requiredValidator,
} from '@validators'

const props = defineProps({
  isEditDrawerOpen: {
    type: Boolean,
    required: true,
  },
  data: {
    type: Object,
    required: true,
    default: () => ({
      title: 'Title',
    }),		
  },	
})

const emit = defineEmits([
  'update:isEditDrawerOpen',
  'bookData',
])

const isFormValid = ref(false)
const refForm = ref()

// 👉 drawer close
const closeNavigationDrawer = () => {
  emit('update:isEditDrawerOpen', false)
}

const onSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      emit('bookData', {
				id: props.data.id,
        title: props.data.title,
        author: props.data.author,
        description: props.data.description,
        image: props.data.image,
        genre: props.data.genre,
        isbn: props.data.isbn,
        published: props.data.published,
				publisher: props.data.publisher,
      })
      emit('update:isEditDrawerOpen', false)
    }
  })
}

const handleDrawerModelValueUpdate = val => {
  emit('update:isEditDrawerOpen', val)
}
</script>

<template>
  <VNavigationDrawer
    temporary
    :width="400"
    location="end"
    class="scrollable-content"
    :model-value="props.isEditDrawerOpen"
    @update:model-value="handleDrawerModelValueUpdate"
  	>
    <!-- 👉 Title -->
    <div class="d-flex align-center pa-6 pb-1">
      <h6 class="text-h6">
        Edit Book
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
                  v-model="props.data.title"
                  :rules="[requiredValidator]"
                  label="Title"
                />
              </VCol>

              <!-- 👉 Author -->
              <VCol cols="12">
                <VTextField
                  v-model="props.data.author"
                  :rules="[requiredValidator]"
                  label="Author"
                />
              </VCol>

              <!-- 👉 Genre -->
              <VCol cols="12">
                <VTextField
                  v-model="props.data.genre"
                  :rules="[requiredValidator]"
                  label="Genre"
                />
              </VCol>

              <!-- 👉 Description -->
              <VCol cols="12">
                <VTextarea
                  v-model="props.data.description"
                  :rules="[requiredValidator]"
                  label="Description"
                />
              </VCol>

              <!-- 👉 ISBN -->
              <VCol cols="12">
                <VTextField
                  v-model="props.data.isbn"
                  :rules="[requiredValidator]"
                  label="ISBN"
                />
              </VCol>							

              <!-- 👉 Image -->
              <VCol cols="12">
                <VTextField
                  v-model="props.data.image"
                  :rules="[requiredValidator]"
                  label="Image"
                />
              </VCol>
							
              <!-- 👉 Published -->
              <VCol cols="12">
                <VTextField
                  v-model="props.data.published"
                  :rules="[requiredValidator]"
                  label="Published"
                />
              </VCol>	

              <!-- 👉 Publisher -->
              <VCol cols="12">
                <VTextField
                  v-model="props.data.publisher"
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
