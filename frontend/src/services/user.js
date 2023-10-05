import useApi from 'src/composables/UseApi'

export default function usersService () {
  const { getAll, save, update, remove, getById } = useApi('users')

  return {
    getAll,
    save,
    update,
    remove,
    getById
  }
}
