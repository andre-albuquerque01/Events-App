'use client'

import { InsertUserEvents } from '@/action/events/hasEvent/insert/route'

export interface AddToCartButtonProps {
  eventId: string
}

export default function AddToCartButton({ eventId }: AddToCartButtonProps) {
  const handleInsert = async () => {
    if (confirm('Tem certeza que quer participar do evento?')) {
      const response = await InsertUserEvents({ idEvents: eventId })
      if (response.message === 'Cadastro realizado com sucesso')
        alert('Cadastro realizado com sucesso')
      else if (response.message === 'Erro, já participando do mesmo evento')
        alert('Erro, já fez a inscrição para o evento')
      else if (response.message === 'Evento com o maximo de ocupacao')
        alert('Os ingressos estão esgostados!')
      else alert('Erro, não foi possível fazer a inscrição!')
    }
  }
  return (
    <button
      type="button"
      className="mt-8 flex h-12 items-center justify-center rounded-full bg-emerald-600 font-semibold text-white"
      onClick={handleInsert}
    >
      Participar do evento
    </button>
  )
}
