import '../assets/css/App.css'
import { useState, useEffect } from 'react'
import { UserContext } from '../context'
import { BrowserRouter, Route, Routes, Navigate } from 'react-router-dom'
import Login from './Login'
import TasksTable from './TasksTable'
import Header from './Header'
import CreateTask from './CreateTask'
import Task from './Task'

function Todo() {
  const [userState, setUserState] = useState({})

  useEffect(() => {
    const id = localStorage.getItem('userId')
    if (id) {
      setUserState({
        id: localStorage.getItem('userId'),
        firstname: localStorage.getItem('userFirstName'),
        lastname: localStorage.getItem('userLastName')
      })
    }
  }, [])

  const handleLogout = () => {
    setUserState({})
    localStorage.removeItem('userId')
    localStorage.removeItem('userFirstName')
    localStorage.removeItem('userLastName')
  }

  const ProtectedRoute = ({ userState, children }) => {
    if (!userState) {
      return <Navigate to="/login/" replace />
    }
    return children
  }

  return (
    <BrowserRouter>
      <UserContext.Provider value={[userState, setUserState]}>
        <Header logout={handleLogout} />
        <div className="Todo">
          <Routes>
            <Route path="/login/" element={<Login />} />
            <Route
              path="/tasks"
              element={
                <ProtectedRoute userState={localStorage.getItem('userId')}>
                  <TasksTable />
                </ProtectedRoute>
              }
            />
            <Route
              path="/your-tasks/"
              element={
                <ProtectedRoute userState={localStorage.getItem('userId')}>
                  <TasksTable user={userState.id} />
                </ProtectedRoute>
              }
            />
            <Route
              path="/create-task/"
              element={
                <ProtectedRoute userState={localStorage.getItem('userId')}>
                  <CreateTask />
                </ProtectedRoute>
              }
            />
            <Route
              path="/tasks/:task_id"
              element={
                <ProtectedRoute userState={localStorage.getItem('userId')}>
                  <Task />
                </ProtectedRoute>
              }
            />
          </Routes>
        </div>
      </UserContext.Provider>
    </BrowserRouter>
  )
}

export default Todo
