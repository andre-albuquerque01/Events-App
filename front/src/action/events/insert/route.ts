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
    if (data.error !== undefined) {
      return new Response(JSON.stringify({ error: 'Error', status: 400 }), {
        status: 400,
      })
    }
    revalidateTag('events')
    return data.data
  } catch (error) {
    console.log('Erro ao analisar JSON:', error)
  }
}
