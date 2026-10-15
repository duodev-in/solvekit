@php
    $tables = [
        'Length' => 'length', 'Area' => 'area', 'Volume' => 'volume', 'Mass' => 'mass', 'Temperature' => 'temperature',
        'Speed' => 'speed', 'Time' => 'time', 'Pressure' => 'pressure', 'Energy' => 'energy', 'Power' => 'power', 'Data' => 'data',
    ];
    // Keys repeat across tables (e.g. "m"), so prefix them with their table name.
    $units = [];
    $groups = [];
    foreach ($tables as $label => $table) {
        foreach (config("units.{$table}") as $key => $unit) {
            $units["{$table}.{$key}"] = $unit;
            $groups[$label][] = "{$table}.{$key}";
        }
    }
@endphp

<x-calc.page
    title="Conversion Calculator - SolveKit"
    description="Professional general purpose conversion calculator. Convert between multiple unit categories including length, weight, volume, temperature, and more with comprehensive unit support."
    lede="One converter for length, area, volume, mass, temperature, speed, time, pressure, energy, power and data."
    about="Pick any unit and the target list stays within the same kind of quantity, so you can never convert joules to watts by mistake. Each kind converts through its own base unit using exact definitions, and temperature handles the offsets between scales."
    :calc="['engine' => 'units', 'units' => $units, 'groups' => $groups, 'list' => array_keys($units)]"
    :how-to="[
        ['name' => 'Pick the unit you have', 'text' => 'Units are grouped by quantity in the menu.'],
        ['name' => 'Pick the unit you want', 'text' => 'Only units of the same quantity are offered.'],
        ['name' => 'Enter the value', 'text' => 'Every unit of that quantity is listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'Which quantities can I convert?', 'answer' => 'Length, area, volume, mass, temperature, speed, time, pressure, energy, power and data size.'],
        ['question' => 'Why can I not convert energy to power?', 'answer' => 'They are different quantities: power is energy per unit time. Use the kWh and W units with a time to relate them.'],
        ['question' => 'Are the factors exact?', 'answer' => 'Yes, where an exact definition exists, such as 1 in = 2.54 cm and 1 lb = 0.45359237 kg.'],
    ]"
>
    <x-calc.unit-pair :units="$units" :groups="$groups" from="length.m" to="length.ft" value="1" label="Value" />

    <x-calc.result label="Feet">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Room 20 m²' => ['value' => 20, 'from' => 'area.m2', 'to' => 'area.ft2'],
        'Fever 102 °F' => ['value' => 102, 'from' => 'temperature.f', 'to' => 'temperature.c'],
        'Bill 450 kWh' => ['value' => 450, 'from' => 'energy.kwh', 'to' => 'energy.mj'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="In other units" />
    </x-slot:panel>

    <x-slot:formula>
        <p class="font-mono text-slate-800">result = value × (from unit in base) ÷ (to unit in base)</p>
        <p>Temperatures also add an offset: °F = °C × 9/5 + 32, K = °C + 273.15.</p>
    </x-slot:formula>
</x-calc.page>
