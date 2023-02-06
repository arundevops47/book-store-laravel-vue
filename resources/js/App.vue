<script setup>
import { useTheme } from 'vuetify'
import { useThemeConfig } from '@core/composable/useThemeConfig'
import { hexToRgb } from '@layouts/utils'

const {
  syncInitialLoaderTheme,
  syncVuetifyThemeWithTheme: syncConfigThemeWithVuetifyTheme,
  isAppRtl,
} = useThemeConfig()

const { global } = useTheme()

// ℹ️ Sync current theme with initial loader theme
syncInitialLoaderTheme()
syncConfigThemeWithVuetifyTheme()
</script>

<template>
  <VLocaleProvider :rtl="isAppRtl">
    <VApp :style="`--v-global-theme-primary: ${hexToRgb(global.current.value.colors.primary)}`">
      <RouterView />
    </VApp>
  </VLocaleProvider>
</template>
