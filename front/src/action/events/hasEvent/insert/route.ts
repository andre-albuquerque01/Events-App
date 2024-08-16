'use server'
import ApiServer from '@/data/api'
import { revalidateTag } from 'next/cache'
import { cookies } from 'next/headers'

export async function InsertUserEvents(requestBody: object) {
  try {
    const response = await ApiServer(`userEvents`, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${cookies().get('token')?.value}`,
      },
      body: JSON.stringify(requestBody),
    })

    const data = await response.json()

    if (data.message === 'Error, participando do mesmo evento') {
      return 'Já está participando desse evento'
    }
    console.log(data)

    revalidateTag('userEvents')
    return data.data
  } catch (error) {
    console.log('Erro ao analisar JSON:', error)
  }
}
