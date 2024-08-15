'use server'
import ApiServer from '@/data/api'
import { redirect } from 'next/navigation'

export async function UpdatePasswordRecover(requestBody: object) {
  try {
    const response = await ApiServer(`resetPassword`, {
      method: 'PUT',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(requestBody),
    })
    const data = await response.json()
    const message =
      data && data.data && typeof data.data.message === 'string'
        ? data.data.message
        : JSON.stringify(data?.data?.message || '')

    if (
      message &&
      message.includes('The password field must be at least 8 characters.')
    )
      return 'A senha deve ter ao menos 8 caracters'
    if (
      message &&
      message.includes('The password field must contain at least one symbol.')
    )
      return 'A senha precisa de um caracter especial'
    if (
      message &&
      message.includes(
        'The password field must contain at least one uppercase and one lowercase letter.',
      )
    )
      return 'Senha precisa de ao menos uma letra maisucla e uma minisucla'

    if (
      message &&
      message.includes(
        'The given password has appeared in a data leak. Please choose a different password.',
      )
    )
      return 'Senha fraca.'
  } catch (error) {
    console.log('Erro ao analisar JSON:', error)
  }
  redirect('/login')
}
