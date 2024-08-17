'use client'
import { InsertEvent } from '@/action/events/insert/route'
import {
  ArrowLeft,
  CalendarDays,
  CircleDollarSign,
  CircleUserRound,
  File,
  Hash,
  Layers,
  Receipt,
  SquareUserIcon,
  Timer,
} from 'lucide-react'
import Link from 'next/link'
import { useRouter } from 'next/navigation'
import { FormEvent, useState } from 'react'

export default function InsertEvents() {
  const [error, setError] = useState('')
  const router = useRouter()
  async function handlePost(e: FormEvent<HTMLFormElement>) {
    e.preventDefault()
    const formData = new FormData(e.currentTarget)
    const data = Object.fromEntries(formData)

    const response = await InsertEvent(data)
    if (response.message === 'success') {
      alert('Cadastrado com sucesso')
      router.back()
    }
    setError(response)
  }

  return (
    <div className="flex justify-center items-center min-h-screen">
      <form
        onSubmit={handlePost}
        className="bg-zinc-700 flex flex-col items-center justify-center w-[420px] min-h-auto p-2 rounded-xl max-sm:w-[360px] relative mt-10"
      >
        <Link
          href="/configuration"
          className="absolute top-0 left-0 mt-4 ml-4 flex flex-row justify-start items-start"
        >
          <ArrowLeft /> Voltar
        </Link>
        <p className="text-xl mb-5 mt-11">Cadastrado do evento</p>
        <div className="mt-5">
          <label htmlFor="title">Título</label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <CircleUserRound className="w-5 h-5 text-zinc-500" />
            <input
              type="text"
              name="title"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="Título"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="price">Preço</label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <CircleDollarSign className="w-5 h-5 text-zinc-500" />
            <input
              type="number"
              step="0.01"
              name="price"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="Preço"
              max="999999"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="qtdParcelamento">
            Quantidade de parcelas, sem juros
          </label>
          <div className="flex w-[320px] items-center gap-3 rounded-full   bg-zinc-800 px-5 py-3 ring-zinc-700">
            <Receipt className="w-5 h-5 text-zinc-500" />
            <input
              type="number"
              name="qtdParcelamento"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="Quantidade de parcelas"
              max="99"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="department">Departamento</label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <Layers className="w-5 h-5 text-zinc-500" />
            <input
              type="department"
              name="department"
              id="department"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="Departamento"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="occupation">Quantidade de pessoas</label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <Hash className="w-5 h-5 text-zinc-500" />
            <input
              type="number"
              name="occupation"
              id="occupation"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="Ocupação"
              max="9999"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="dateEvent">Data do evento</label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <CalendarDays className="w-5 h-5 text-zinc-500" />
            <input
              type="date"
              name="dateEvent"
              id="dateEvent"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="Dia do evento"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="timeEvent">Horario de inicio</label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <Timer className="w-5 h-5 text-zinc-500" />
            <input
              type="time"
              name="timeEvent"
              id="timeEvent"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="timeStart"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="pathName">Imagem do evento</label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <File className="w-5 h-5 text-zinc-500" />
            <input
              type="text"
              name="pathName"
              id="pathName"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500"
              placeholder="Image do evento"
              required
            />
          </div>
        </div>
        <div className="mt-5">
          <label htmlFor="description">Descrição</label>
          <div className="flex w-[320px] items-center gap-3 rounded-full bg-zinc-800 px-5 py-3 ring-zinc-700">
            <SquareUserIcon className="w-5 h-5 text-zinc-500" />
            <textarea
              name="description"
              id="description"
              className="flex-1 bg-transparent text-sm outline-none placeholder:text-zinc-500 max-w-96 max-h-40"
            ></textarea>
          </div>
        </div>
        {error && <span className="text-red-400 text-sm">{error}</span>}
        <button
          type="submit"
          className="mt-8 flex h-12 w-[320px] items-center justify-center rounded-full bg-emerald-600 font-semibold text-white"
        >
          Salvar
        </button>
      </form>
    </div>
  )
}
