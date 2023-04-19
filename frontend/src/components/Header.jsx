import React, { useContext  } from 'react'
import { NavLink, useNavigate } from 'react-router-dom'
import { UserContext } from '../context'
import '../assets/css/Header.css'

const Header = (props) => {
  const [userState, setUserState] = useContext(UserContext)
  const navigate = useNavigate()

  return (
    <div>
      {props.headerState && <header>
        <h2>camel_case</h2>
        <NavLink onClick={props.handleOverlay}>Back</NavLink>
      </header>}


      {!props.headerState && <header>
        <nav>
          <ul>
            <li>
              <NavLink to="/todo/tasks/">All tasks</NavLink>
            </li>
            <li>
              <NavLink to="/todo/your-tasks/">Your</NavLink>
            </li>
            <li>
              <NavLink to="/todo/create-task/">Create</NavLink>
            </li>
            <li>
              <NavLink onClick={props.handleOverlay}>Back</NavLink>
            </li>
          </ul>
        </nav>
        {userState.id && (
          <div className='logout'>
            <p>
              Welcome, {userState.firstname} {userState.lastname}
            </p>
            <button onClick={props.logout}>Logout</button>
          </div>
        )}
        {!userState.id && (
          <div className='logout'>
            <button onClick={navigate("/todo/create_user")}>Create user</button>
          </div>
        )}
      </header>}
    </div>
  )
}

export default Header
