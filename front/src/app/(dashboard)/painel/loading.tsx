import Skeleton from '@/components/skeleton'

export default function HomeLoading() {
  return (
    <div className="flex flex-wrap flex-row justify-center gap-6">
      <Skeleton className="rounded-lg w-[280px] h-[280px] bg-zinc-800 overflow-hidden flex justify-center" />
      <Skeleton className="rounded-lg w-[280px] h-[280px] bg-zinc-800 overflow-hidden flex justify-center" />
      <Skeleton className="rounded-lg w-[280px] h-[280px] bg-zinc-800 overflow-hidden flex justify-center" />
      <Skeleton className="rounded-lg w-[280px] h-[280px] bg-zinc-800 overflow-hidden flex justify-center" />
      {/* 4 */}
      <Skeleton className="rounded-lg w-[280px] h-[280px] bg-zinc-800 overflow-hidden flex justify-center" />
      <Skeleton className="rounded-lg w-[280px] h-[280px] bg-zinc-800 overflow-hidden flex justify-center" />
      <Skeleton className="rounded-lg w-[280px] h-[280px] bg-zinc-800 overflow-hidden flex justify-center" />
      <Skeleton className="rounded-lg w-[280px] h-[280px] bg-zinc-800 overflow-hidden flex justify-center" />
    </div>
  )
}
