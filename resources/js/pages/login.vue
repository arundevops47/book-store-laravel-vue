<script setup>
import axios from '@axios'
import { themeConfig } from '@themeConfig'
import { VForm } from 'vuetify/components'
import { useAppAbility } from '@/plugins/casl/useAppAbility'
import { VNodeRenderer } from '@layouts/components/VNodeRenderer'
import { useToast } from "vue-toastification";
import {
  emailValidator,
  requiredValidator,
} from '@validators'

const isPasswordVisible = ref(false)
const route = useRoute()
const router = useRouter()
const ability = useAppAbility()
const toast = useToast();

const errors = ref({
  email: undefined,
  password: undefined,
})

const refVForm = ref()
const email = ref('')
const password = ref('')
const rememberMe = ref(false)

const login = () => {
  axios.post('/api/login', {
    email: email.value,
    password: password.value,
  }).then(res => {
		const { accessToken, userData, userAbilities } = res.data
    localStorage.setItem('userAbilities', JSON.stringify(userAbilities))
    ability.update(userAbilities)
    localStorage.setItem('userData', JSON.stringify(userData))
    localStorage.setItem('accessToken', JSON.stringify(accessToken))
    // Redirect to `to` query if exist or redirect to index route
    router.replace(route.query.to ? String(route.query.to) : '/')
  }).catch(err => {
		if(err.response.data.msg != undefined) {
			toast.error(err.response.data.msg, {
				timeout: 2000
			});
		}
		else {
			const { errors: formErrors } = err.response.data
			errors.value = formErrors
		}
  })
}

const onSubmit = () => {
  refVForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid)
      login()
  })
}
</script>

<template>
  <VRow
    no-gutters
    class="auth-wrapper"
  	>
    <VCol
      cols="12"
      lg="6"
      class="d-flex align-center justify-center mx-auto"
    	>
      <VCard
        flat
        :max-width="500"
        class="mt-12 mt-sm-0 pa-4"
      	>
        <VCardText 
					class="text-center">
					<RouterLink
						:to="{ name: 'index' }"
						class="font-weight-medium user-list-name"
						>
						<VNodeRenderer
							:nodes="themeConfig.app.logo"
							class="mb-6 logo"
						/>
					</RouterLink>


          <h5 class="text-h5 font-weight-semibold mb-1">
            Welcome to Book Store
          </h5>
          <p class="mb-0">
            Please sign-in to your account
          </p>
        </VCardText>
        <VCardText>
          <VForm
            ref="refVForm"
            @submit.prevent="onSubmit"
          	>
            <VRow>
              <!-- email -->
              <VCol cols="12">
                <VTextField
                  v-model="email"
                  label="Email"
                  type="email"
                  :rules="[requiredValidator, emailValidator]"
                  :error-messages="errors.email"
                />
              </VCol>

              <!-- password -->
              <VCol cols="12">
                <VTextField
                  v-model="password"
                  label="Password"
                  :rules="[requiredValidator]"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :error-messages="errors.password"
                  :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />

                <div class="d-flex align-center flex-wrap justify-space-between mt-2 mb-4">
                  <VCheckbox
                    v-model="rememberMe"
                    label="Remember me"
                  />
                  <!-- <RouterLink
                    class="text-primary ms-2 mb-1"
                    :to="{ name: 'forgot-password' }"
                  	>
                    Forgot Password?
                  </RouterLink> -->
                </div>

                <VBtn
                  block
                  type="submit"
									class="mt-4"
                >
                  Login
                </VBtn>
              </VCol>

							<!-- create account -->
							<VCol
								cols="12"
								class="text-center"
								>
								<span>New on our platform?</span>
								<RouterLink
									class="text-primary ms-2"
									:to="{ name: 'register' }"
									>
									Create an account
								</RouterLink>
							</VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>

<route lang="yaml">
meta:
  layout: blank
  action: read
  subject: Auth
  redirectIfLoggedIn: true
</route>
