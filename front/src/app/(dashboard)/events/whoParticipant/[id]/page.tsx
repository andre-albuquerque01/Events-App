import { GetShowEventsUser } from '@/action/events/hasEvent/getShowEventsUser/route'
import { EventsInterface } from '@/data/types/events'
import { Metadata } from 'next'
import Link from 'next/link'

export const metadata: Metadata = {
  title: 'Participantes',
}

interface EventsProps {
  params: {
    id: string
  }
}

export default async function WhoParticipant({ params }: EventsProps) {
  const eventos = (await GetShowEventsUser(params.id)) as EventsInterface[]

  return (
    <>
      <div className="flex flex-col gap-4">
        {eventos.length > 0 && (
          <>
            <p className="font-sm">Lista participantes do evento:</p>
            <div className="flex flex-row justify-around flex-wrap md:w-[50%]">
              <p className="font-lg w-[50%] text-center truncate">
                Nome do participante
              </p>
              <p className="font-lg w-[50%] text-center truncate">Evento</p>
            </div>
          </>
        )}
        {eventos.length > 0 ? (
          eventos.map((events) => (
            <div
              className="flex flex-row justify-center items-center flex-wrap md:w-[50%]"
              key={events.idHasEvents}
            >
              <p className="font-sm w-[50%] text-center truncate">
                {events.users.name}
              </p>
              <Link
                href={`/events/${events.event.idEvents}`}
                className="font-sm w-[50%] text-center truncate"
              >
                {events.event.title}
              </Link>
              <div className="w-[100%] h-px bg-zinc-500"></div>
            </div>
          ))
        ) : (
          <p className="font-sm">Nenhum participante neste evento</p>
        )}
      </div>
    </>
  )
}
