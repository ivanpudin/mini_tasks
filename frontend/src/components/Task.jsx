import React, { useEffect, useState } from 'react'
import { getTask, closeTask } from '../api'
import { useParams, useNavigate } from 'react-router-dom'
import classes from '../assets/css/table.module.css'

const Task = () => {
  const [taskData, setTaskData] = useState({})
  const [comment, setComment] = useState(null)
  const [error, setError] = useState('')
  const { task_id } = useParams()
  const navigate = useNavigate()

  useEffect(() => {
    getTask(task_id).then((response) => {
      setTaskData(response)
    })
  }, [task_id])

  const onChangeInput = (e) => {
    setComment(e.target.value)
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      await closeTask(taskData.id, comment)

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
    <div className='area'>
      <table>
        <thead>
          <tr>
            <th className={[classes.table_row, classes.table_header].join(' ')}>
              Title
            </th>
            <th className={[classes.table_row, classes.table_header].join(' ')}>
              Description
            </th>
            <th className={[classes.table_row, classes.table_header].join(' ')}>
              Performer
            </th>
            <th className={[classes.table_row, classes.table_header].join(' ')}>
              Deadline
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{taskData.title}</td>
            <td>{taskData.description}</td>
            <td>
              {taskData.firstname} {taskData.lastname}
            </td>
            <td>{taskData.deadline}</td>
          </tr>
        </tbody>
      </table>
      {localStorage.getItem('userFirstName') === taskData.firstname &&
        localStorage.getItem('userLastName') === taskData.lastname && (
          <div className='comments'>
            <h2>Close task</h2>
            <form className={classes.close} onSubmit={handleSubmit}>
              <label htmlFor="comment">Comment:</label>
              <input
                type="text"
                name="comment"
                onChange={onChangeInput}
                required
              />
              <button className={classes.button_form}>Close task</button>
            </form>
          </div>
        )}
    </div>
  )
}

export default Task
