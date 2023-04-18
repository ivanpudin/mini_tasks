import './assets/css/App.css'
import { useState, useEffect } from 'react'
import { UserContext } from './context'
import { BrowserRouter, Route, Routes, Navigate } from 'react-router-dom'
import Login from './components/Login'
import TasksTable from './components/TasksTable'
import Header from './components/Header'
import CreateTask from './components/CreateTask'
import Task from './components/Task'
import Home from './components/Home'
import Convertor from './components/Convertor'

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
      return <Navigate to="/todo" replace />
    }
    return children
  }

  return (
    <BrowserRouter>
      <UserContext.Provider value={[userState, setUserState]}>
        <Header logout={handleLogout} />
        <div className="Todo">
          <Routes>
            <Route path='/' element={<Home />} />
            <Route path='/convertor' element={<Convertor />}/>
            <Route path='/contact' />
            <Route path="/todo/" element={<Login />} />
            <Route
              path="/todo/tasks"
              element={
                <ProtectedRoute userState={localStorage.getItem('userId')}>
                  <TasksTable />
                </ProtectedRoute>
              }
            />
            <Route
              path="/todo/your-tasks/"
              element={
                <ProtectedRoute userState={localStorage.getItem('userId')}>
                  <TasksTable user={userState.id} />
                </ProtectedRoute>
              }
            />
            <Route
              path="/todo/create-task/"
              element={
                <ProtectedRoute userState={localStorage.getItem('userId')}>
                  <CreateTask />
                </ProtectedRoute>
              }
            />
            <Route
              path="/todo/tasks/:task_id"
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
