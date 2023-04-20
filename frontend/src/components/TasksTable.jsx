import React, { useEffect, useState } from 'react'
import { getTasks } from '../api'
import { Link } from 'react-router-dom'
import classes from '../assets/css/table.module.css'
import { useContext } from 'react'
import { TaskContext } from '../context'

const TasksTable = ({ user }) => {
  const [tasks, setTasks] = useContext(TaskContext)
  const [deadline, setDeadline] = useState(null)

  useEffect(() => {
    getTasks(user, deadline).then((response) => {
      if (JSON.stringify(response) !== JSON.stringify(tasks)) {
        setTasks(response)
      }
    })
  }, [user, deadline, tasks])

  const onChangeInput = (e) => {
    setDeadline(e.target.value)
  }

  const onClearDate = () => {
    setDeadline(null)
    const input = document.querySelector('input[type="date"]')
    input.value = null
  }

  return (
    <div className="area">
      <h2>Filter date</h2>
      <form className="date_form">
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
                  <Link to={`/todo/tasks/${task.id}`}>{task.title}</Link>
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
