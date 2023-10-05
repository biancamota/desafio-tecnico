import useApi from 'src/composables/UseApi'

export default function usersService () {
  const { getAll, save, update, remove } = useApi('users')

  return {
    getAll,
    save,
    update,
    remove
  }
}
