<script setup>
import navItems from '@/navigation/vertical'
import { useThemeConfig } from '@core/composable/useThemeConfig'
import UserProfile from '@/layouts/components/UserProfile.vue'
import { NavbarLayout } from '@layouts'

const { appRouteTransition, isLessThanOverlayNavBreakpoint } = useThemeConfig()
const { width: windowWidth } = useWindowSize()

const userData = JSON.parse(localStorage.getItem('userData') || 'null')

</script>

<template>
  <NavbarLayout
    :nav-items="navItems"
  	>
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <VBtn
          v-if="isLessThanOverlayNavBreakpoint(windowWidth)"
          icon
          variant="text"
          color="default"
          class="ms-n3"
          size="small"
          @click="toggleVerticalOverlayNavActive(true)"
        	>
          <VIcon
            icon="tabler-menu-2"
            size="24"
          />
        </VBtn>

        <VSpacer />

				<template v-if="!userData">
					<h6 class="text-base px-3">
						<RouterLink
							:to="{ name: 'login' }"
							class="font-weight-medium user-list-name"
						>
							Login
						</RouterLink>
					</h6>

					<h6 class="text-base px-3">
						<RouterLink
							:to="{ name: 'register' }"
							class="font-weight-medium user-list-name"
						>
							Signup
						</RouterLink>
					</h6>				
				</template>

        <UserProfile v-else/>
      </div>
    </template>

    <!-- 👉 Pages -->
    <RouterView v-slot="{ Component }">
      <Transition
        :name="appRouteTransition"
        mode="out-in"
      	>
        <Component :is="Component" />
      </Transition>
    </RouterView>

    <!-- <TheCustomizer /> -->
  </NavbarLayout>
</template>
