<script setup>
import {
  avatarText,
  kFormatter,
} from '@core/utils/formatters'

const props = defineProps({
  bookData: {
    type: Object,
    required: true,
  },
})

const standardPlan = {
  plan: 'Standard',
  price: 99,
  benefits: [
    '10 Books',
    'Up to 10GB storage',
    'Basic Support',
  ],
}

const isBookInfoEditDialogVisible = ref(false)
const isUpgradePlanDialogVisible = ref(false)

const resolveBookStatusVariant = stat => {
  if (stat === 'pending')
    return 'warning'
  if (stat === 'active')
    return 'success'
  if (stat === 'inactive')
    return 'secondary'
  
  return 'primary'
}

const resolveBookRoleVariant = role => {
  if (role === 'subscriber')
    return {
      color: 'warning',
      icon: 'tabler-book',
    }
  if (role === 'author')
    return {
      color: 'success',
      icon: 'tabler-circle-check',
    }
  if (role === 'maintainer')
    return {
      color: 'primary',
      icon: 'tabler-chart-pie-2',
    }
  if (role === 'editor')
    return {
      color: 'info',
      icon: 'tabler-pencil',
    }
  if (role === 'admin')
    return {
      color: 'secondary',
      icon: 'tabler-server-2',
    }
  
  return {
    color: 'primary',
    icon: 'tabler-book',
  }
}
</script>

<template>
  <VRow>
    <!-- SECTION Book Details -->
    <VCol cols="12">
      <VCard v-if="props.bookData">
        <VCardText class="text-center pt-15">
          <!-- 👉 Avatar -->
          <VAvatar
            rounded
            :size="120"
            color="primary"
            variant="tonal"
          >
            <VImg
              v-if="props.bookData.avatar"
              :src="props.bookData.avatar"
            />
            <span
              v-else
              class="text-5xl font-weight-semibold"
            >
              {{ avatarText(props.bookData.fullName) }}
            </span>
          </VAvatar>

          <!-- 👉 Book fullName -->
          <h6 class="text-h6 mt-4">
            {{ props.bookData.fullName }}
          </h6>

          <!-- 👉 Role chip -->
          <VChip
            label
            :color="resolveBookRoleVariant(props.bookData.role).color"
            size="small"
            class="text-capitalize mt-4"
          >
            {{ props.bookData.role }}
          </VChip>
        </VCardText>

        <VCardText class="d-flex justify-center flex-wrap mt-3">
          <!-- 👉 Done task -->
          <div class="d-flex align-center me-8 mb-2">
            <VAvatar
              :size="38"
              rounded
              color="primary"
              variant="tonal"
              class="me-3"
            >
              <VIcon
                size="24"
                icon="tabler-checkbox"
              />
            </VAvatar>

            <div>
              <h6 class="text-base font-weight-semibold">
                {{ kFormatter(props.bookData.taskDone) }}
              </h6>
              <span class="text-sm">Task Done</span>
            </div>
          </div>

          <!-- 👉 Done Project -->
          <div class="d-flex align-center me-4 mb-2">
            <VAvatar
              :size="38"
              rounded
              color="primary"
              variant="tonal"
              class="me-3"
            >
              <VIcon
                size="24"
                icon="tabler-briefcase"
              />
            </VAvatar>

            <div>
              <h6 class="text-base font-weight-semibold">
                {{ kFormatter(props.bookData.projectDone) }}
              </h6>
              <span class="text-sm">Project Done</span>
            </div>
          </div>
        </VCardText>

        <VDivider />

        <!-- 👉 Details -->
        <VCardText>
          <p class="text-sm text-uppercase text-disabled">
            Details
          </p>

          <!-- 👉 Book Details list -->
          <VList class="card-list mt-2">
            <VListItem>
              <VListItemTitle>
                <h6 class="text-base font-weight-semibold">
                  Name:
                  <span class="text-body-2">
                    {{ props.bookData.fullName }}
                  </span>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <h6 class="text-base font-weight-semibold">
                  Billing Email:
                  <span class="text-body-2">{{ props.bookData.email }}</span>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <h6 class="text-base font-weight-semibold">
                  Status:

                  <VChip
                    label
                    size="small"
                    :color="resolveBookStatusVariant(props.bookData.status)"
                    class="text-capitalize"
                  >
                    {{ props.bookData.status }}
                  </VChip>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <h6 class="text-base font-weight-semibold">
                  Role:
                  <span class="text-capitalize text-body-2">{{ props.bookData.role }}</span>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <h6 class="text-base font-weight-semibold">
                  Tax ID:
                  <span class="text-body-2">
                    {{ props.bookData.taxId }}
                  </span>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <h6 class="text-base font-weight-semibold">
                  Contact:
                  <span class="text-body-2">{{ props.bookData.contact }}</span>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <h6 class="text-base font-weight-semibold">
                  Language:
                  <span class="text-body-2">{{ props.bookData.language }}</span>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <h6 class="text-base font-weight-semibold">
                  Country:
                  <span class="text-body-2">{{ props.bookData.country }}</span>
                </h6>
              </VListItemTitle>
            </VListItem>
          </VList>
        </VCardText>

        <!-- 👉 Edit and Suspend button -->
        <VCardText class="d-flex justify-center">
          <VBtn
            variant="elevated"
            class="me-3"
            @click="isBookInfoEditDialogVisible = true"
          >
            Edit
          </VBtn>
          <VBtn
            variant="tonal"
            color="error"
          >
            Suspend
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
    <!-- !SECTION -->

    <!-- SECTION Current Plan -->
    <VCol cols="12">
      <VCard>
        <VCardText class="d-flex">
          <!-- 👉 Standard Chip -->
          <VChip
            label
            color="primary"
            size="small"
          >
            Standard
          </VChip>

          <VSpacer />

          <!-- 👉 Current Price  -->
          <div class="d-flex align-center">
            <sup class="text-primary text-sm font-weight-regular">$</sup>
            <h3 class="text-h3 text-primary font-weight-semibold">
              99
            </h3>
            <sub class="mt-3"><h6 class="text-sm font-weight-regular">/ month</h6></sub>
          </div>
        </VCardText>

        <VCardText>
          <!-- 👉 Price Benefits -->
          <VList class="card-list">
            <VListItem
              v-for="benefit in standardPlan.benefits"
              :key="benefit"
            >
              <VIcon
                size="12"
                color="#A8AAAE"
                class="me-2"
                icon="tabler-circle"
              />
              <span>{{ benefit }}</span>
            </VListItem>
          </VList>

          <!-- 👉 Days -->
          <div class="my-6">
            <div class="d-flex font-weight-semibold mt-3 mb-2">
              <h6 class="text-base font-weight-semibold">
                Days
              </h6>
              <VSpacer />
              <h6 class="text-base font-weight-semibold">
                26 of 30 Days
              </h6>
            </div>

            <!-- 👉 Progress -->
            <VProgressLinear
              rounded
              rounded-bar
              :model-value="65"
              height="8"
              color="primary"
            />

            <p class="mt-2">
              4 days remaining
            </p>
          </div>

          <!-- 👉 Upgrade Plan -->
          <VBtn
            block
            @click="isUpgradePlanDialogVisible = true"
          >
            Upgrade Plan
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
    <!-- !SECTION -->
  </VRow>

  <!-- 👉 Edit book info dialog -->
  <BookInfoEditDialog
    v-model:isDialogVisible="isBookInfoEditDialogVisible"
    :book-data="props.bookData"
  />

  <!-- 👉 Upgrade plan dialog -->
  <BookUpgradePlanDialog v-model:isDialogVisible="isUpgradePlanDialogVisible" />
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 0.7rem;
}

.text-capitalize {
  text-transform: capitalize !important;
}
</style>
