export function FormateDate(updateAt: string) {
  const dateUpdate = new Date(Date.parse(updateAt))
  const formattedDate = dateUpdate
    .toISOString()
    .split('T')[0]
    .split('-')
    .reverse()
    .join('/')
  return formattedDate
}
