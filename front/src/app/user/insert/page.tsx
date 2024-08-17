'use client'
import { InsertUser } from '@/action/user/insert/route'
import { ValidatePassword } from '@/functions/validatePassword'
import {
  ArrowLeft,
  CircleUserRound,
  FileLock2,
  LockKeyhole,
  SquareUserIcon,
} from 'lucide-react'
import Link from 'next/link'
import { useRouter } from 'next/navigation'
import { FormEvent, useState } from 'react'
import InputMask from 'react-input-mask-next'

export default function InsertUserPage() {
  const [error, setError] = useState('')
  const router = useRouter()
  async function handleForm(e: FormEvent<HTMLFormElement>) {
    e.preventDefault()

    const formData = new FormData(e.currentTarget)
    const termAceite = formData.get('term_aceite') === 'on' ? 1 : 0
    formData.set('term_aceite', String(termAceite))
    const data = Object.fromEntries(formData)
    if (data.password === data.password_confirmation) {
      setError(ValidatePassword(String(data.password)))
      const response = await InsertUser(data)
      if (response === 'true') {
        alert('Cadastro feito com sucesso!')
        router.push('/login')
      }
      setError(response)
    }
    setError('Senhas não correspondem')
  }

  return (
    <div className="flex flex-col justify-center items-center h-screen p-2">
      <form
        onSubmit={handleForm}
        className="bg-zinc-700 flex flex-col items-center justify-center w-[420px] p-4 h-auto rounded-xl max-sm:w-[360px] relative"
      >
        <Link
          href="/login"
          className="absolute top-0 left-0 mt-4 ml-4 flex flex-row justify-start items-start"
        >
          <ArrowLeft /> Voltar
        </Link>
        <p className="text-xl mb-7 mt-5">Cadastrado do usuário</p>
        <div className="">
          <label htmlFor="nome">
            Nome <span className="text-red-700">*</span>
          </label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <SquareUserIcon className="w-5 h-5 text-zinc-500" />
            <input
              type="text"
              name="name"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="Nome"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="">
            E-mail <span className="text-red-700">*</span>
          </label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <CircleUserRound className="w-5 h-5 text-zinc-500" />
            <input
              type="email"
              name="email"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="E-mail"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="">
            CPF <span className="text-red-700">*</span>
          </label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <FileLock2 className="w-5 h-5 text-zinc-500" />
            <InputMask
              mask="999.999.999-99"
              type="text"
              name="cpf"
              id="cpf"
              placeholder="CPF"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="password">
            Senha <span className="text-red-700">*</span>{' '}
          </label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <LockKeyhole className="w-5 h-5 text-zinc-500" />
            <input
              type="password"
              name="password"
              id="password"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="Senha"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="password_confirmation">
            Repetir senha <span className="text-red-700">*</span>
          </label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <LockKeyhole className="w-5 h-5 text-zinc-500" />
            <input
              type="password"
              name="password_confirmation"
              id="password_confirmation"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="Confimação da senha"
              required
            />
          </div>
          {error && <span className="text-red-400 text-sm">{error}</span>}
        </div>
        <div className="mt-5">
          <div className="mr-36">
            <input
              type="checkbox"
              name="term_aceite"
              id="term_aceite"
              placeholder="Confimação da senha"
              required
            />
            <label htmlFor="term_aceite" className="ml-2">
              <Link href="/">Termo de aceitação</Link>
            </label>
          </div>
        </div>
        <button className="mt-8 flex h-12 w-[320px] items-center justify-center rounded-full bg-emerald-600 font-semibold text-white">
          Salvar
        </button>
      </form>
    </div>
  )
}
