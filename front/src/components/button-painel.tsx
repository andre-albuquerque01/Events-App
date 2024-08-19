'use client'

import { SquarePen, Trash2, UsersRound } from 'lucide-react'

interface typeProps {
  idEvents: number
}

async function deleteEvents(id: number) {
  await fetch(`http://localhost:3000/api/events/delete/${id}`, {
    method: 'DELETE',
  })
}

export default function ButtonPainel({ idEvents }: typeProps) {
  const handleUpdate = () => {
    window.location.href = `/events/update/${idEvents}`
  }

  const handleParticipants = () => {
    window.location.href = `/events/whoParticipant/${idEvents}`
  }
  
  const handleDelete = async () => {
    if (confirm('Tem certeza que quer excluir?')) {
      await deleteEvents(idEvents)
      window.location.replace(`/painel`)
    }
  }

  return (
    <div className="flex items-center justify-center gap-4 w-20">
      <button onClick={handleParticipants} title="Pessoas participando">
        <UsersRound />
      </button>
      <button onClick={handleUpdate} title="Editar item">
        <SquarePen />
      </button>
      <button onClick={handleDelete} title="Excluir item">
        <Trash2 />
      </button>
    </div>
  )
}
