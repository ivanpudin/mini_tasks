import { useContext, useEffect, useState } from 'react'
import { getUsers, createTask } from '../api'
import { TaskContext } from '../context'
import { useNavigate } from 'react-router-dom'
import classes from '../assets/css/table.module.css'

const CreateTask = () => {
  const [taskData, setTaskData] = useContext(TaskContext)
  const [users, setUsers] = useState([])
  const [message, setMessage] = useState({})
  const [task, setTask] = useState({})
  const navigate = useNavigate()

  useEffect(() => {
    getUsers().then((response) => {
      if (JSON.stringify(response) !== JSON.stringify(users)) {
        setUsers(response)
      }
    })
  }, [users])

  const onChangeInput = (e) => {
    setTask({
      ...task,
      [e.target.name]:
        e.target.name === 'performer' ? Number(e.target.value) : e.target.value
    })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      const res = await createTask(
        task.title,
        task.description,
        task.deadline,
        task.performer
      ).then((res) => {
          setTaskData([...taskData, JSON.parse(res)])
        })
        .then(
          setTimeout(() => {
            navigate('/todo/tasks')
          }, 200)
        )
    } catch (error) {
      setMessage(error.message)
    }
  }

  return (
    <div className="area">
      <h2>Create task</h2>
      <form className={classes.create_task} onSubmit={handleSubmit}>
        <label htmlFor="title">Title:</label>
        <input
          type="text"
          name="title"
          id="title"
          onChange={onChangeInput}
          required
        />
        <label htmlFor="description">Desription:</label>
        <input
          type="text"
          name="description"
          onChange={onChangeInput}
          required
        />
        <label htmlFor="deadline">Deadline:</label>
        <input type="date" name="deadline" onChange={onChangeInput} required />
        <label htmlFor="performer">Performer:</label>
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
      {message.message && <span>{message.message}</span>}
    </div>
  )
}

export default CreateTask
