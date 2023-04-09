<?php include_once 'massConvertor.php';?>
<?php include_once 'temperatureConvertor.php';?>
<form method='POST'>
  <fieldset>
    <legend>Select the unit of measure to convert</legend>
    <select name='unit1' onchange='updateValues(this.value)' required>
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
    <input type='number' step="0.01" id='quantity' name='quantity' required/>
    <legend>Select the unit of measure to convert</legend>
    <select name='unit2' id='unit-select' required >
    <option value="" disabled selected>Select unit</option>'
    </select>
  </fieldset>
  <button type='submit'>Submit</button>
</form>

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

$units = isset($_POST['unit1'], $_POST['unit2'], $_POST['quantity']) ? [$_POST['unit1'], $_POST['unit2'], (float)$_POST['quantity']] : [];

if (count($units) === 3) {
  list($unit1, $unit2, $quantity) = $units;
 
  if (in_array($unit1, ['kg', 'grams', 'lb'])) {
    $equals = (new massConvertor())->convert($unit1, $unit2, $quantity);
  } elseif (in_array($unit1,['celsius', 'fahrenheit', 'kelvin'])) {
    $equals = (new temperatureConvertor())->convert($unit1, $unit2, $quantity);
    
  }
   /* add code for other converters. */
  ;

  $formatted_quantity = floor($quantity) == $quantity ? number_format($quantity) : number_format($quantity, 2, '.', ',');

  $formatted_equals = floor($equals) == $equals ? number_format($equals) : number_format($equals, 2, '.', ',');

  echo "<span>{$formatted_quantity} {$unitNames[$unit1]} equals to {$formatted_equals} {$unitNames[$unit2]}</span>";
}

?>