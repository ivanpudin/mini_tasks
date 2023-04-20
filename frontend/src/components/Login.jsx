import React, { useContext, useState } from 'react'
import { UserContext } from '../context'
import { loginUser } from '../api'
import { useNavigate } from 'react-router-dom'
import md5 from 'md5'
import classes from '../assets/css/table.module.css'
import '../assets/css/Login.css'

const Login = () => {
  const [userData, setUserData] = useState({})
  const [userState, setUserState] = useContext(UserContext)
  const [error, setError] = useState('')
  const navigate = useNavigate()

  const onChangeInput = (e) => {
    setUserData({
      ...userData,
      [e.target.name]: e.target.value
    })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      const res = await loginUser(userData.email, md5(userData.password))
      setUserState({
        id: res.id,
        firstname: res.firstname,
        lastname: res.lastname
      })
      navigate('/todo/tasks')
    } catch (error) {
      if (error.message) {
        setError(error.message)
      } else {
        console.error(error)
      }
    }
  }

  return (
    <div className='Login'>
      <div className='area'>
        <h2>Login</h2>
        <form className={classes.login} onSubmit={handleSubmit}>
          <label htmlFor="email">Email:</label>
          <input type="email" name="email" onChange={onChangeInput} required />
          <label htmlFor="password">Password:</label>
          <input
            type="password"
            name="password"
            onChange={onChangeInput}
            required
          />
          <button className={classes.button_form}>Login</button>
          {error && <div>{error}</div>}
        </form>
      </div>
    </div>
  )
}

export default Login
