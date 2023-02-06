<script setup>
import axios from '@axios'
import { initialAbility } from '@/plugins/casl/ability'
import { useAppAbility } from '@/plugins/casl/useAppAbility'

const router = useRouter()
const ability = useAppAbility()
const userData = JSON.parse(localStorage.getItem('userData') || 'null')

const logout = () => {
  axios.get('/api/logout')
	.then(res => {
		localStorage.removeItem('userData')
		localStorage.removeItem('accessToken')
		router.push('/login').then(() => {
			localStorage.removeItem('userAbilities')
			ability.update(initialAbility)
		})
  }).catch(err => {
		if(err.response.data.msg != undefined) {
			toast.error(err.response.data.msg, {
				timeout: 2000
			});
		}
  })
}
</script>

<template>
  <VBadge
    dot
    location="bottom right"
    offset-x="3"
    offset-y="3"
    bordered
    color="success"
  	>
    <VAvatar
      class="cursor-pointer"
      color="primary"
      variant="tonal"
    	>
      <VImg
        v-if="userData && userData.avatar"
        :src="userData.avatar"
      />
      <VIcon
        v-else
        icon="tabler-user"
      />

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="230"
        location="bottom end"
        offset="14px"
      	>
        <VList>
          <!-- 👉 User Name and role -->
          <VListItem>
            <VListItemTitle class="font-weight-semibold">
              {{ userData.name }} ({{ userData.role }})
            </VListItemTitle>
          </VListItem>

          <VDivider class="my-2" />

          <!-- 👉 Profile -->
          <!-- <VListItem :to="{ name: 'user-profile-id', params: { id: userData.id } }">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-user"
                size="22"
              />
            </template>

            <VListItemTitle>Profile</VListItemTitle>
          </VListItem> -->

          <!-- Divider -->
          <!-- <VDivider class="my-2" /> -->

          <!-- 👉 Logout -->
          <VListItem
            link
            @click="logout"
          	>
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-logout"
                size="22"
              />
            </template>

            <VListItemTitle>Logout</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VAvatar>
  </VBadge>
</template>
