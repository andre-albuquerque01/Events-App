'use client'
import { UpdatePasswordRecover } from '@/action/user/recover/updatePassword/route'
import { ValidatePassword } from '@/functions/validatePassword'
import { ArrowLeft, CircleUserRound, LockKeyhole } from 'lucide-react'
import Link from 'next/link'
import { FormEvent, useState } from 'react'

export default function UpdatePassword() {
  const [error, setError] = useState('')

  async function handleSearch(e: FormEvent<HTMLFormElement>) {
    e.preventDefault()
    const formData = new FormData(e.currentTarget)
    const data = Object.fromEntries(formData)
    if (data.password === data.password_confirmation) {
      setError(ValidatePassword(String(data.password)))
      const response = await UpdatePasswordRecover(data)
      setError(response)
    }
    setError('Senhas não correspondem')
  }

  return (
    <div className="flex flex-col justify-center items-center h-screen">
      <div className="bg-zinc-700 flex flex-col items-center justify-center w-[400px] h-[480px] rounded-xl max-sm:w-[360px] relative">
        <form onSubmit={handleSearch}>
          <Link
            href="/user/recover/verifyToken"
            className="absolute top-0 left-0 mt-4 ml-4 flex flex-row justify-start items-start"
          >
            <ArrowLeft /> Voltar
          </Link>
          <p className="text-xl mb-7 mt-5">Alterar a senha</p>
          <div className="">
            <label htmlFor="password">Nova senha</label>
            <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
              <CircleUserRound className="w-5 h-5 text-zinc-500" />
              <input
                type="password"
                name="password"
                id="password"
                className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
                placeholder="Nova senha"
                required
              />
            </div>
          </div>
          <div className="mt-5">
            <label htmlFor="password_confirmation">Confirmação da senha</label>
            <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
              <LockKeyhole className="w-5 h-5 text-zinc-500" />
              <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
                placeholder="Repetir senha"
                required
              />
            </div>
            {error && <span className="text-red-400 text-sm">{error}</span>}
          </div>
          <button className="mt-8 flex h-12 w-[320px] items-center justify-center rounded-full bg-emerald-600 font-semibold text-white">
            Entrar
          </button>
        </form>
      </div>
    </div>
  )
}
