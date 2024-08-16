'use server'
import ApiServer from '@/data/api'
import { cookies } from 'next/headers'

export async function GetShowEventsUser(id: string) {
  try {
    const response = await ApiServer(`showEventsUser/${id}`, {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${cookies().get('token')?.value}`,
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      next: {
        revalidate: 60 * 30,
        tags: ['userEvents', 'events'],
      },
    })

    const data = await response.json()

    return data.data
  } catch (error) {
    return { data: [] }
  }
}
