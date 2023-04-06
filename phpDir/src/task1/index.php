<?php require_once 'mass.php';?>
<link rel="stylesheet" href="style.css" />

<header>
    <h1>Measurement convertor</h1>
</header>

<main>
  <form method='POST'>
    <fieldset>
      <legend>Select the unit of measure to convert</legend>
      <select name='unit' onchange='updateValues(this.value)'>
        <option value='' disabled selected>Select unit</option>
        <optgroup label='Mass'>
          <option value='kg'>Kilograms</option>
          <option value='grams'>Grams</option>
          <option value='lb'>Pounds</option>
        </optgroup>
        <optgroup label='Speed'>
          <option value='kph'>Kilometers per hour</option>
          <option value='mps'>Meters per second</option>
          <option value='knots'>Knots</option>
        </optgroup>
        <optgroup label='Temperature'>
          <option value='celsius'>Celsius</option>
          <option value='kelvin'>Kelvin</option>
          <option value='fahrenheit'>Fahrenheit</option>
        </optgroup>
      </select>
      <legend>Select the amount of unit</legend>
      <input type='number' id='quantity' name='quantity' />
      <legend>Select the unit of measure to convert</legend>
      <select name='unit_2' id='unit-select'>
      <option value="" disabled selected>Select unit</option>'
      </select>
    </fieldset>
    <button type='submit'>Submit</button>
  </form>
</main>

<script>
  function updateValues(unit) {
    const mass = [
      { short: 'kg', full: 'Kilograms' },
      { short: 'grams', full: 'Grams' },
      { short: 'lb', full: 'Pounds' },
    ]
    const temperature = [
      { short: 'kelvin', full: 'Kelvin' },
      { short: 'celsius', full: 'Celsius' },
      { short: 'fahrenheit', full: 'Fahrenheit' },
    ]
    const speed = [
      { short: 'kph', full: 'Kilometers per hour' },
      { short: 'mps', full: 'Meters per second' },
      { short: 'knots', full: 'Knots' },
    ]
    const select = document.getElementById('unit-select')
    select.innerHTML = ''
    if (mass.map((item) => item.short).includes(unit)) {
      select.innerHTML += '<option value="" disabled selected>Select unit</option>'
      mass.forEach((element) => {
        if (element.short != unit) {
          select.innerHTML += `<option value='${element.short}'>${element.full}</option>`
        }
      })
    } else if (temperature.map((item) => item.short).includes(unit)) {
      select.innerHTML += '<option value="" disabled selected>Select unit</option>'
      temperature.forEach((element) => {
        if (element.short != unit) {
          select.innerHTML += `<option value='${element.short}'>${element.full}</option>`
        }
      })
    } else if (speed.map((item) => item.short).includes(unit)) {
      select.innerHTML += '<option value="" disabled selected>Select unit</option>'
      speed.forEach((element) => {
        if (element.short != unit) {
          select.innerHTML += `<option value='${element.short}'>${element.full}</option>`
        }
      })
    }
  }
</script>

<?php
$unitNames = [
    'kg' => 'kilograms',
    'grams' => 'grams',
    'lb' => 'pounds',
    'kelvin' => 'kelvin',
    'celsius' => 'celsius',
    'fahrenheit' => 'fahrenheit',
    'kph' => 'kilometers per hour',
    'mps' => 'meters per second',
    'knots' => 'knots',
];

$units = isset($_POST['unit'], $_POST['unit_2'], $_POST['quantity']) ? [$_POST['unit'], $_POST['unit_2'], $_POST['quantity']] : [];

if (count($units) === 3 && (int) $_POST['quantity'] > 0) {
    $quantity = $_POST['quantity'];

    $equals = 0;

    if (in_array($_POST['unit'], ['kg', 'grams', 'lb'])) {
        $equals = massConvertor($_POST['unit'], $_POST['unit_2'], (int) $_POST['quantity']);
    } elseif (true) { /* add code for other converters */
    }
    ;

    $formatted_quantity = floor($quantity) == $quantity ? number_format($quantity) : number_format($quantity, 3, '.', ',');

    $formatted_equals = floor($equals) == $equals ? number_format($equals) : number_format($equals, 3, '.', ',');

    echo "<p><span>{$formatted_quantity} {$unitNames[$_POST['unit']]} equals to {$formatted_equals} {$unitNames[$_POST['unit_2']]}</span></p>";
}

?>