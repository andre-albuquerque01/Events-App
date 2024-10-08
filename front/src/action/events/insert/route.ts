'use server'
import ApiServer from '@/data/api'
import { revalidateTag } from 'next/cache'
import { cookies } from 'next/headers'

export async function InsertEvent(requestBody: object) {
  try {
    const response = await ApiServer(`events`, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${cookies().get('token')?.value}`,
      },
      body: JSON.stringify(requestBody),
    })

    const data = await response.json()

    revalidateTag('events')
    return data.data
  } catch (error) {
    console.log('Erro ao analisar JSON:', error)
  }
}
