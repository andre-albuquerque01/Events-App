'use server'
import ApiServer from '@/data/api'
import { cookies } from 'next/headers'
import { redirect } from 'next/navigation'

export async function Logout() {
  try {
    const cookiesStore = cookies()
    const token = cookiesStore.get('token')

    const response = await ApiServer(`logout`, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${token?.value}`,
      },
    })

    const data = await response.json()
    if (data.error !== undefined) {
      return new Response(JSON.stringify({ error: 'Error', status: 400 }), {
        status: 400,
      })
    }

    cookiesStore.delete('id')
    cookiesStore.delete('token')
    cookiesStore.delete('r')
  } catch (error) {
    console.log('Erro ao analisar JSON:', error)
  }
  redirect('/login')
}
