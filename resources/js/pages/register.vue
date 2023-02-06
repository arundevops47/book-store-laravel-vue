<script setup>
import axios from '@axios'
import { VForm } from 'vuetify/components'
import { themeConfig } from '@themeConfig'
import { useAppAbility } from '@/plugins/casl/useAppAbility'
import { VNodeRenderer } from '@layouts/components/VNodeRenderer'
import { useToast } from "vue-toastification";
import {
  alphaDashValidator,
  emailValidator,
  requiredValidator,
} from '@validators'

const refVForm = ref()
const name = ref('')
const email = ref('')
const password = ref('')
const confirm_password = ref('')

// Router
const route = useRoute()
const router = useRouter()
const toast = useToast();

// Ability
const ability = useAppAbility()

// Form Errors
const errors = ref({
	name: undefined,
  email: undefined,
  password: undefined,
	confirm_password: undefined,
})

const register = () => {
  axios.post('/api/register', {
    name: name.value,
    email: email.value,
    password: password.value,
		confirm_password: confirm_password.value,
  }).then(res => {
		toast.success(res.data.msg, {
			timeout: 2000
		});

		router.push('login')
    return null
  }).catch(err => {
		console.log('err ', err)
    const { errors: formErrors } = err.response.data
    errors.value = formErrors
  })
}

const isPasswordVisible = ref(false)

const onSubmit = () => {
  refVForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid)
      register()
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
            Please sign-up for new account
          </p>
        </VCardText>

        <VCardText>
          <VForm
            ref="refVForm"
            @submit.prevent="onSubmit"
          	>
            <VRow>
              <!-- Name -->
              <VCol cols="12">
                <VTextField
                  v-model="name"
                  :rules="[requiredValidator]"
                  label="Name"
									:error-messages="errors.name"
                />
              </VCol>

              <!-- email -->
              <VCol cols="12">
                <VTextField
                  v-model="email"
                  :rules="[requiredValidator, emailValidator]"
                  label="Email"
                  type="email"
									:error-messages="errors.email"
                />
              </VCol>

              <!-- password -->
              <VCol cols="12">
                <VTextField
                  v-model="password"
                  :rules="[requiredValidator]"
                  label="Password"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
									:error-messages="errors.password"
                />
              </VCol>

              <!-- password -->
              <VCol cols="12">
                <VTextField
                  v-model="confirm_password"
                  :rules="[requiredValidator]"
                  label="Confirm Password"
									type="text"
									:error-messages="errors.confirm_password"
                />

                <VBtn
                  block
                  type="submit"
									class="mt-4"
                	>
                  Sign up
                </VBtn>
              </VCol>

							<VCol
								cols="12"
								class="text-center"
								>
								<!-- create account -->
									<span>Already have an account?</span>
									<RouterLink
										class="text-primary ms-2"
										:to="{ name: 'login' }"
										>
										Sign in instead
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
