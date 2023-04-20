import React, { useState } from 'react'
import { submitForm } from '../api'
import classes from '../assets/css/table.module.css'
import '../assets/css/Contact.css'

const Contact = () => {
  const [userData, setUserData] = useState({})
  const [output, setOutput] = useState({})

  const onChangeInput = (e) => {
    setUserData({
      ...userData,
      [e.target.name]: e.target.value
    })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      const res = await submitForm(
        userData.name,
        userData.email,
        userData.subject,
        userData.message
      )
      setOutput(res)
    } catch (error) {
      if (error.message) {
        setOutput(error.message)
      } else {
        console.error(error)
      }
    }
  }

  return (
    <div className="Contact">
      <div className="area">
        <h2>Contact us</h2>
        <form className={classes.contact_form} onSubmit={handleSubmit}>
          <label htmlFor="name">Name</label>
          <input type="text" name="name" onChange={onChangeInput} required />
          <label htmlFor="email">Email</label>
          <input type="email" name="email" onChange={onChangeInput} required />
          <label htmlFor="subject">Subject</label>
          <input type="text" name="subject" onChange={onChangeInput} required />
          <label htmlFor="message">Message</label>
          <input type="text" name="message" onChange={onChangeInput} required />
          <button className={classes.button_form}>Message us</button>
        </form>
      </div>
      {output.message && <span>{output.message}</span>}
    </div>
  )
}

export default Contact
