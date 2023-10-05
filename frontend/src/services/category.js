import useApi from 'src/composables/UseApi'

export default function categoriesService () {
  const { getAll, save, update, remove } = useApi('categories')

  return {
    getAll,
    save,
    update,
    remove
  }
}
