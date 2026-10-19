<x-calc.page
    title="Oven Temperature Converter - SolveKit"
    description="Free oven temperature converter: Fahrenheit, Celsius, fan oven and gas mark, with a full gas mark table."
    lede="Convert oven temperatures between °F, °C, fan and gas mark."
    about="°C = (°F − 32) × 5 ÷ 9. Fan (convection) ovens cook hotter, so recipes use about 20 °C (25 °F) less. UK gas marks run from ¼ (225 °F) to 9 (475 °F); from mark 1 up each mark is 25 °F: °F = 250 + 25 × mark. Oven thermostats are often off by 10–25 °F, so an oven thermometer is worth having."
    :calc="['engine' => 'fd-convert', 'tool' => 'oven', 'fields' => ['temp', 'scale']]"
    :how-to="[
        ['name' => 'Enter the temperature', 'text' => ''],
        ['name' => 'Choose its scale', 'text' => '°F, °C, fan or gas mark.'],
    ]"
    :faqs="[
        ['question' => 'What is 350 °F in Celsius?', 'answer' => '350 °F = 177 °C = 157 °C fan = gas mark 4.'],
        ['question' => 'What is 180 °C fan in °F?', 'answer' => '392 °F = 200 °C = 180 °C fan = gas mark 6.'],
        ['question' => 'What is gas mark 6?', 'answer' => '400 °F = 204 °C = 184 °C fan = gas mark 6.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="temp" label="Temperature" value="350" min="False" step="any" />
        <x-calc.select name="scale" label="Scale" :options="['f' => '°F', 'c' => '°C', 'fan' => '°C fan oven', 'gas' => 'Gas mark']" selected="f" />
    </div>

    <x-calc.result label="Converted temperature" />

    <x-calc.options :decimals="false" :examples="[
        '350 °F' => ['temp' => 350, 'scale' => 'f'],
        '180 °C fan' => ['temp' => 180, 'scale' => 'fan'],
        'Gas 6' => ['temp' => 6, 'scale' => 'gas'],
        '200 °C' => ['temp' => 200, 'scale' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'f' => ['label' => 'Fahrenheit'],
            'c' => ['label' => 'Celsius'],
            'fan' => ['label' => 'Fan oven'],
            'gas' => ['label' => 'Gas mark'],
            'heat' => ['label' => 'Description'],
        ]" />
        <x-calc.grid heading="Gas marks" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>°C = (°F − 32) × 5/9</li>
            <li>fan °C = conventional °C − 20</li>
            <li>°F = 250 + 25 × gas mark</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
