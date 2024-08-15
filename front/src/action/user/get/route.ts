'use server'
import ApiServer from '@/data/api'
import { cookies } from 'next/headers'

export async function GetUser() {
  try {
    const cookiesStore = cookies()
    const token = cookiesStore.get('token')
    const id = cookiesStore.get('id')

    const response = await ApiServer(`user/${id?.value}`, {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${token?.value}`,
        'Content-Type': 'application/json',
      },
      next: {
        revalidate: 60 * 30,
        tags: ['user'],
      },
    })

    const data = await response.json()

    return data.data
  } catch (e) {
    return { message: 'Error while fetching event.' }
  }
}
