import { useEffect, useState } from 'react'
import { getUsers, createTask } from './api'
import { useNavigate } from 'react-router-dom'
import classes from './table.module.css'

const CreateTask = () => {
  const [taskData, setTaskData] = useState({})
  const [users, setUsers] = useState([])
  const [error, setError] = useState('')
  const navigate = useNavigate()

  useEffect(() => {
    getUsers().then((response) => {
      setUsers(response)
    })
  }, [])

  const onChangeInput = (e) => {
    setTaskData({
      ...taskData,
      [e.target.name]:
        e.target.name === 'performer' ? Number(e.target.value) : e.target.value
    })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      await createTask(
        taskData.title,
        taskData.description,
        taskData.deadline,
        taskData.performer
      )
      navigate('/tasks')
    } catch (error) {
      setError(error.message)
    }
  }

  return (
    <>
      <fieldset>
        <legend>Create task</legend>
        <form className={classes.create_task} onSubmit={handleSubmit}>
          <label for="title">Title:</label>
          <input
            type="text"
            name="title"
            id="title"
            onChange={onChangeInput}
            required
          />
          <label for="description">Desription:</label>
          <input
            type="text"
            name="description"
            onChange={onChangeInput}
            required
          />
          <label for="deadline">Deadline:</label>
          <input
            type="date"
            name="deadline"
            onChange={onChangeInput}
            required
          />
          <label for="performer">Performer:</label>
          <select name="performer" onChange={onChangeInput} required>
            <option value="">Select performer</option>
            {users.map((user) => {
              return (
                <option key={user.id} value={user.id}>
                  {user.firstname} {user.lastname}
                </option>
              )
            })}
          </select>
          <button className={classes.button_form}>Create task</button>
        </form>
      </fieldset>
    </>
  )
}

export default CreateTask
