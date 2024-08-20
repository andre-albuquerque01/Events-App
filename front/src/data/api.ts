export default function ApiServer(path: string, init?: RequestInit) {
  const baseUrl = 'http://localhost'
  const apiPrefix = '/api/v2/'
  const url = new URL(apiPrefix.concat(path), baseUrl)

  return fetch(url, init)
}
