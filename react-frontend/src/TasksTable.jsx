import React, { useEffect, useState } from 'react'
import { getTasks } from './api'
import { Link } from 'react-router-dom'
import classes from './table.module.css'

const TasksTable = ({ user }) => {
  const [tasks, setTasks] = useState([])
  const [deadline, setDeadline] = useState(null)

  useEffect(() => {
    getTasks(user, deadline).then((response) => {
      setTasks(response)
    })
  }, [user, deadline])

  const onChangeInput = (e) => {
    setDeadline(e.target.value)
  }

  const onClearDate = () => {
    setDeadline(null)
    const input = document.querySelector('input[type="date"]')
    input.value = null
  }

  return (
    <div>
      <legend>Date filter</legend>
      <form>
        <label>
          <input type="date" name="date" onChange={onChangeInput} />
          <button type="button" onClick={onClearDate}>
            Clear date
          </button>
        </label>
      </form>
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
          {tasks &&
            tasks.map((task) => (
              <tr key={task.id}>
                <td>
                  <Link to={`/tasks/${task.id}`}>{task.title}</Link>
                </td>
                <td>{task.description}</td>
                <td>
                  {task.firstname} {task.lastname}
                </td>
                <td>{task.deadline}</td>
              </tr>
            ))}
        </tbody>
      </table>
    </div>
  )
}

export default TasksTable
