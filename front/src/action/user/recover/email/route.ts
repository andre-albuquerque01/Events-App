'use server'
import ApiServer from '@/data/api'

export async function SendEmailRecover(requestBody: object) {
  try {
    const response = await ApiServer('sendTokenRecover', {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(requestBody),
    })

    const data = await response.json()
    if (data.error !== undefined) {
      return new Response(JSON.stringify({ error: 'Error', status: 400 }), {
        status: 400,
      })
    }

    return data.data
  } catch (error) {
    console.error(error)
  }
}
