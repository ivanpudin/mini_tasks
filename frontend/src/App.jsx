import './assets/css/App.css'
import { useState, useEffect } from 'react'
import { UserContext } from './context'
import { BrowserRouter, Route, Routes, Navigate } from 'react-router-dom'
import Login from './components/Login'
import TasksTable from './components/TasksTable'
import Header from './components/Header'
import CreateTask from './components/CreateTask'
import Task from './components/Task'
import Overlay from './components/Overlay'
import Convertor from './components/Convertor'
import CreateUser from './components/CreateUser'
import './assets/css/Todo.css'
import Contact from './components/Contact'

function App() {
  const [userState, setUserState] = useState({})

  const [overlay, setOverlay] = useState(true)

  const [header, setHeader] = useState(true)

  const handleHeader12 = () => {
    setHeader((current) => true)
  }

  const handleHeader3 = () => {
    setHeader((current) => false)
  }

  const handleOverlay = () => {
    setOverlay((current) => !current)
  }

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
        <div className="App">
          <Overlay
            handleOverlay={handleOverlay}
            overlay={overlay}
            handleHeader12={handleHeader12}
            handleHeader3={handleHeader3}
          />
          <Routes>
            <Route
              exact
              path="/convertor"
              element={
                <div className="element_container">
                  <Header handleOverlay={handleOverlay} headerState={header} />
                  <Convertor />
                </div>
              }
            />
            <Route
              exact
              path="/contact"
              element={
                <div className="element_container">
                  <Header handleOverlay={handleOverlay} headerState={header} />
                  <Contact />
                </div>
              }
            />
            <Route
              exact
              path="/todo/"
              element={
                <div className="element_container">
                  <Header
                    handleOverlay={handleOverlay}
                    headerState={header}
                    logout={handleLogout}
                  />
                  <div className="Todo">
                    <Login />
                  </div>
                </div>
              }
            />
            <Route
              path="/todo/tasks"
              element={
                <div className="element_container">
                  <Header
                    handleOverlay={handleOverlay}
                    headerState={header}
                    logout={handleLogout}
                  />
                  <div className="Todo">
                    <ProtectedRoute userState={localStorage.getItem('userId')}>
                      <TasksTable />
                    </ProtectedRoute>
                  </div>
                </div>
              }
            />
            <Route
              path="/todo/your-tasks/"
              element={
                <div className="element_container">
                  <Header
                    handleOverlay={handleOverlay}
                    headerState={header}
                    logout={handleLogout}
                  />
                  <div className="Todo">
                    <ProtectedRoute userState={localStorage.getItem('userId')}>
                      <TasksTable user={userState.id} />
                    </ProtectedRoute>
                  </div>
                </div>
              }
            />
            <Route
              path="/todo/create-task/"
              element={
                <div className="element_container">
                  <Header
                    handleOverlay={handleOverlay}
                    headerState={header}
                    logout={handleLogout}
                  />
                  <div className="Todo">
                    <ProtectedRoute userState={localStorage.getItem('userId')}>
                      <CreateTask />
                    </ProtectedRoute>
                  </div>
                </div>
              }
            />
            <Route
              path="/todo/tasks/:task_id"
              element={
                <div className="element_container">
                  <Header
                    handleOverlay={handleOverlay}
                    headerState={header}
                    logout={handleLogout}
                  />
                  <div className="Todo">
                    <ProtectedRoute userState={localStorage.getItem('userId')}>
                      <Task />
                    </ProtectedRoute>
                  </div>
                </div>
              }
            />
            <Route
              path="/todo/create_user"
              element={
                <div className="element_container">
                  <Header
                    handleOverlay={handleOverlay}
                    headerState={header}
                    logout={handleLogout}
                  />
                  <div className="Todo">
                    <ProtectedRoute userState={localStorage.getItem('userId')}>
                      <CreateUser />
                    </ProtectedRoute>
                  </div>
                </div>
              }
            />
          </Routes>
        </div>
      </UserContext.Provider>
    </BrowserRouter>
  )
}

export default App
