import { ref } from 'vue'
import { api } from 'boot/axios'

const user = ref(null)

export default function useAuthUser () {
  /**
   * Login with email and password
   */
  const login = async ({ email, password }) => {
    const response = await api.post('login', { email, password })
    if (response.error) throw response.messages.error
    localStorage.setItem('token', response.data.token)
    user.value = response.data.user
    return user
  }

  /**
   * Logout
   */
  const logout = async () => {
    localStorage.removeItem('token')
    user.value = null
  }

  /**
   * Check if the user is logged in or not
   */
  const isLoggedIn = () => {
    return !!localStorage.getItem('token')
  }

  return {
    user,
    login,
    isLoggedIn,
    logout
  }
}
