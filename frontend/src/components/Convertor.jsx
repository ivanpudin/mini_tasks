import React, { useState, useEffect } from 'react'
import { convertor } from '../api'
import '../assets/css/Convertor.css'

const Convertor = () => {
  const [convertResult, setConvertResult] = useState({})
  const [error, setError] = useState('')
  const [type, setType] = useState([])
  const [result, setResult] = useState('')

  useEffect(() => {
    getValues()
  }, [convertResult])

  const getValues = () => {
    if (
      convertResult.unit1 === 'kg' ||
      convertResult.unit1 === 'lb' ||
      convertResult.unit1 === 'grams'
    ) {
      setType([
        { short: 'kg', full: 'Kilograms' },
        { short: 'grams', full: 'Grams' },
        { short: 'lb', full: 'Pounds' }
      ])
    } else if (
      convertResult.unit1 === 'kph' ||
      convertResult.unit1 === 'mps' ||
      convertResult.unit1 === 'knots'
    ) {
      setType([
        { short: 'kph', full: 'Kilometers per hour' },
        { short: 'mps', full: 'Meters per second' },
        { short: 'knots', full: 'Knots' }
      ])
    } else if (
      convertResult.unit1 === 'kelvin' ||
      convertResult.unit1 === 'celsius' ||
      convertResult.unit1 === 'fahrenheit'
    ) {
      setType([
        { short: 'kelvin', full: 'Kelvin' },
        { short: 'celsius', full: 'Celsius' },
        { short: 'fahrenheit', full: 'Fahrenheit' }
      ])
    }
  }

  const onChangeInput = (e) => {
    setConvertResult({
      ...convertResult,
      [e.target.name]: e.target.value
    })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      const res = await convertor(
        convertResult.unit1,
        convertResult.unit2,
        convertResult.quantity
      )
      setResult(res.message)
    } catch (error) {
      if (error.message === 'Wrong email or password') {
        setError(error.message)
      } else {
        console.error(error)
      }
    }
  }

  return (
    <div className="Convertor">
      <div className="area">
        <h2>Convert values</h2>
        <form onSubmit={handleSubmit}>
          <legend>Convert from</legend>
          <select name="unit1" onChange={onChangeInput} required>
            <option value="">Select value</option>
            <optgroup label="Mass">
              <option value="kg">Kilograms</option>
              <option value="grams">Grams</option>
              <option value="lb">Pounds</option>
            </optgroup>
            <optgroup label="Speed">
              <option value="kph">Kilometers per hour</option>
              <option value="mps">Meters per second</option>
              <option value="knots">Knots</option>
            </optgroup>
            <optgroup label="Temperature">
              <option value="celsius">Celsius</option>
              <option value="kelvin">Kelvin</option>
              <option value="fahrenheit">Fahrenheit</option>
            </optgroup>
          </select>
          <legend>Amount</legend>
          <input
            type="number"
            step="0.01"
            id="quantity"
            name="quantity"
            onChange={onChangeInput}
            required
          />
          <legend>Convert to</legend>
          <select name="unit2" onChange={onChangeInput} required>
            <option value="">Select value</option>
            {type.map((item) => {
              if (item.short !== convertResult.unit1) {
                return (
                  <option key={item.short} value={item.short}>
                    {item.full}
                  </option>
                )
              }
            })}
          </select>
          <button type="submit">Convert</button>
        </form>
      </div>
      {result && <span>{result}</span>}
    </div>
  )
}

export default Convertor
