import { BASE_URL } from './constants'

export const loginUser = async (email, password) => {
  const action = 'get_user'
  const response = await fetch(`${BASE_URL}`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ email, password, action })
  })

  if (response.status === 401) {
    throw new Error('Wrong email or password')
  } else if (!response.ok) {
    const error = await response.json()
    throw new Error(error.message || 'Failed to fetch tasks')
  }

  const data = await response.json()
  const { id, firstname, lastname } = data

  localStorage.setItem('userId', id)
  localStorage.setItem('userFirstName', firstname)
  localStorage.setItem('userLastName', lastname)

  return data
}

export const getTasks = async (user = null, deadline = null) => {
  let url = BASE_URL + '?action=get_tasks'
  if (user != null) {
    url += `&user=${user}`
  }
  if (deadline !== null) {
    url += `&deadline=${deadline}`
  }
  const response = await fetch(url, {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' }
  })

  if (response.status === 204) {
    return []
  } else if (!response.ok) {
    const error = await response.json()
    throw new Error(error.message || 'Failed to fetch tasks')
  }

  return await response.json()
}

export const getTask = async (task) => {
  const response = await fetch(`${BASE_URL}?action=get_task&task=${task}`, {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' }
  })

  if (response.status === 204) {
    throw new Error('There is no task with this id')
  } else if (!response.ok) {
    const error = await response.json()
    throw new Error(error.message || 'Failed to fetch task')
  }

  return await response.json()
}

export const getUsers = async () => {
  const response = await fetch(`${BASE_URL}?action=get_users`, {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' }
  })

  if (response.status === 204) {
    throw new Error('No more users(')
  } else if (!response.ok) {
    const error = await response.json()
    throw new Error(error.message || 'Failed to fetch tasks')
  }

  return await response.json()
}

export const createTask = async (title, description, deadline, performer) => {
  const action = 'create_task'
  const response = await fetch(`${BASE_URL}`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ title, description, deadline, performer, action })
  })

  if (response.status === 500) {
    throw new Error('Cannot create task')
  } else if (!response.ok) {
    const error = await response.json()
    throw new Error(error.message || 'Failed to fetch tasks')
  }

  return await response.json()
}

export const closeTask = async (id, comment) => {
  const action = 'close_task'
  const [day, month, year] = new Date().toLocaleDateString().split('/')
  const closing_date = year + '-' + month + '-' + day
  const status = 1
  const response = await fetch(`${BASE_URL}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action, id, comment, closing_date, status })
  })

  if (response.status === 400) {
    throw new Error('Cannot update task')
  } else if (!response.ok) {
    const error = await response.json()
    throw new Error(error.message || 'Failed to update task')
  }

  return await response.json()
}

export const convertor = async (unit1, unit2, quantity) => {
  const response = await fetch('http://localhost:7001/task1/measurement-api.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ unit1, unit2, quantity })
  })

  if (response.status === 401) {
    throw new Error('Wrong email or password')
  } else if (!response.ok) {
    const error = await response.json()
    throw new Error(error.message || 'Failed to fetch tasks')
  }

  return await response.json()
}
