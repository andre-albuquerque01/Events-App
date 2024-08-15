'use server'

import ApiServer from '@/data/api'
import { cookies } from 'next/headers'
import { redirect } from 'next/navigation'

export async function Login(body: object) {
  try {
    const cookiesStore = cookies()
    const response = await ApiServer('login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(body),
    })

    const data = await response.json()

    const message =
      data && data.data && typeof data.data.message === 'string'
        ? data.data.message
        : JSON.stringify(data?.data?.message || '')

    if (message.includes('Email and password invalid.')) {
      return 'E-mail ou senha inválida!'
    }

    if (message.includes('E-mail não verificado')) {
      return 'E-mail não verificado'
    }

    if (message.includes('Email or password incorrect')) {
      return 'E-mail ou senha inválida!'
    }

    if (message.includes('Email not registered')) {
      return 'E-mail não registrado!'
    }
    if (message.includes('The password field must be at least 8 characters.')) {
      return 'E-mail ou senha inválida!'
    }

    cookiesStore.set('token', data.data.token, {
      expires: Date.now() + 2 * 60 * 60 * 1000,
      secure: true,
      httpOnly: true,
      sameSite: 'strict',
    })
    cookiesStore.set('id', data.data.id, {
      expires: Date.now() + 2 * 60 * 60 * 1000,
      secure: true,
      httpOnly: true,
      sameSite: 'strict',
    })
    cookiesStore.set('r', data.data.r, {
      expires: Date.now() + 2 * 60 * 60 * 1000,
      secure: true,
      httpOnly: true,
      sameSite: 'strict',
    })
  } catch (error) {
    console.log('Erro')
  }
  redirect('/configuration')
}
