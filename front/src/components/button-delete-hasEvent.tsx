'use client'

import { Trash2 } from 'lucide-react'

interface typeProps {
  idHasEvents: number
}

async function deleteHasEvents(id: number) {
  await fetch(`http://localhost:3000/api/events/hasEvent/delete/${id}`, {
    method: 'DELETE',
  })
}

export default function ButtonPainelDeleteHasEvent({ idHasEvents }: typeProps) {
  const handleDelete = async () => {
    if (confirm('Tem certeza que quer excluir?')) {
      await deleteHasEvents(idHasEvents)
    }
  }

  return (
    <div className="flex items-center justify-center gap-4 w-20">
      <button onClick={handleDelete} title="Excluir item">
        <Trash2 />
      </button>
    </div>
  )
}
