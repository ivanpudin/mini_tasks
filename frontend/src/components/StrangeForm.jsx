import React, { useState } from 'react'
import { submitForm } from '../api'
import { useNavigate } from 'react-router-dom'
import classes from '../assets/css/table.module.css'
import '../assets/css/Login.css'

const StrangeForm = () => {
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
      await submitForm(userData.name, userData.email, userData.subject, userData.message)
      navigate('/NOWHERE/')
    } catch (error) {
      if (error.message) {
        setError(error.message)
      } else {
        console.error(error)
      }
    }
  }

  return (
    <div className='Contact us form'>
      <div className='area'>
        <h2>Contact us</h2>
        <form className={classes.login} onSubmit={handleSubmit}>
          <label htmlFor="name">Name:</label>
          <input type="text" name="name" onChange={onChangeInput} required />
          <label htmlFor="email">Email:</label>
          <input type="email" name="email" onChange={onChangeInput} required />
          <label htmlFor="subject">Subject:</label>
          <input type="text" name="subject" onChange={onChangeInput} required />
          <label htmlFor="message">Message:</label>
          <input type="text" name="message" onChange={onChangeInput} required />
          <button className={classes.button_form}>Register user</button>
          {error && <div>{error}</div>}
        </form>
      </div>
    </div>
  )
}

export default StrangeForm
