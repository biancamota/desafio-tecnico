import { api } from 'boot/axios'

export default function useApi (url) {
  const getAll = async () => {
    try {
      const { data } = await api.get(url)
      return data
    } catch (error) {
      throw new Error(error)
    }
  }

  const getById = async (id) => {
    try {
      const { data } = await api.get(`${url}/${id}`)
      return data
    } catch (error) {
      throw new Error(error)
    }
  }

  const save = async (dataForm) => {
    try {
      const { data } = await api.post(url, dataForm)
      return data
    } catch (error) {
      throw new Error(error)
    }
  }

  const update = async (dataForm) => {
    try {
      const { data } = await api.put(`${url}/${dataForm.id}`, dataForm)
      return data
    } catch (error) {
      throw new Error(error)
    }
  }

  const remove = async (id) => {
    try {
      const { data } = await api.delete(`${url}/${id}`)
      return data
    } catch (error) {
      throw new Error(error)
    }
  }

  return {
    getAll,
    save,
    update,
    remove,
    getById
  }
}
