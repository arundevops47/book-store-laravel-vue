<script setup>
import navItems from '@/navigation/horizontal'
import { useThemeConfig } from '@core/composable/useThemeConfig'
import { themeConfig } from '@themeConfig'
import UserProfile from '@/layouts/components/UserProfile.vue'
import { HorizontalNavLayout } from '@layouts'
import { VNodeRenderer } from '@layouts/components/VNodeRenderer'

const { appRouteTransition } = useThemeConfig()
const userData = JSON.parse(localStorage.getItem('userData') || 'null')

</script>

<template>
  <HorizontalNavLayout
    :nav-items="navItems"
  	>
    <!-- 👉 navbar -->
    <template #navbar>
      <RouterLink
        to="/"
        class="app-logo d-flex align-center gap-x-3"
      	>
        <VNodeRenderer :nodes="themeConfig.app.logo" />

        <h1 class="app-title font-weight-bold leading-normal text-xl">
          {{ themeConfig.app.title }}
        </h1>
      </RouterLink>
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

    </template>

    <!-- 👉 Pages -->
    <RouterView v-slot="{ Component, route }">
      <Transition
        :name="appRouteTransition"
        mode="out-in"
      	>
        <Component
          :is="Component"
          :key="route.path"
        />
      </Transition>
    </RouterView>

    <!-- <TheCustomizer /> -->
  </HorizontalNavLayout>
</template>
