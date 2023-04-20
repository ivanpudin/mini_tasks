import React, { useState } from 'react'
import { createUser } from '../api'
import { useNavigate } from 'react-router-dom'
import md5 from 'md5'
import classes from '../assets/css/table.module.css'
import '../assets/css/Login.css'

const CreateUser = () => {
  const [userData, setUserData] = useState({})
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
      await createUser(userData.firstname, userData.lastname, userData.email, md5(userData.password))
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
    <div className='Create_user'>
      <div className='area'>
        <h2>Create new user</h2>
        <form className={classes.contact_form} onSubmit={handleSubmit}>
          <label htmlFor="firstname">Firstname:</label>
          <input type="text" name="firstname" onChange={onChangeInput} required />
          <label htmlFor="lastname">Firstname:</label>
          <input type="text" name="lastname" onChange={onChangeInput} required />
          <label htmlFor="email">Email:</label>
          <input type="email" name="email" onChange={onChangeInput} required />
          <label htmlFor="password">Password:</label>
          <input
            type="password"
            name="password"
            onChange={onChangeInput}
            required
          />
          <button className={classes.button_form}>Register user</button>
          {error && <div>{error}</div>}
        </form>
      </div>
    </div>
  )
}

export default CreateUser
