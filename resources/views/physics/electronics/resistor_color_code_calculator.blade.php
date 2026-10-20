<x-calc.page
    title="Resistor Color Code Calculator - SolveKit"
    description="Free resistor color code calculator: value, tolerance and temperature coefficient from 4, 5 or 6 bands."
    lede="Read resistor colour bands."
    about="Resistor bands give two or three digits, a multiplier, a tolerance and sometimes a temperature coefficient (IEC 60062). Yellow–violet–red–gold is 4.7 kΩ ±5%."
    :calc="['engine' => 'ph-elec', 'tool' => 'resistor_colour', 'fields' => ['bands', 'b1', 'b2', 'b3', 'mult', 'tol', 'tc'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is yellow, violet, red, gold?', 'answer' => '4.7 kΩ, ±5%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="bands" label="Bands" :options="['4' => '4 bands', '5' => '5 bands', '6' => '6 bands']" selected="4" />
        <x-calc.select name="b1" label="Band 1" :options="['black' => 'Black', 'brown' => 'Brown', 'red' => 'Red', 'orange' => 'Orange', 'yellow' => 'Yellow', 'green' => 'Green', 'blue' => 'Blue', 'violet' => 'Violet', 'grey' => 'Grey', 'white' => 'White']" selected="yellow" />
        <x-calc.select name="b2" label="Band 2" :options="['black' => 'Black', 'brown' => 'Brown', 'red' => 'Red', 'orange' => 'Orange', 'yellow' => 'Yellow', 'green' => 'Green', 'blue' => 'Blue', 'violet' => 'Violet', 'grey' => 'Grey', 'white' => 'White']" selected="violet" />
        <div data-show-when="bands:5,6">
            <x-calc.select name="b3" label="Band 3 (digit)" :options="['black' => 'Black', 'brown' => 'Brown', 'red' => 'Red', 'orange' => 'Orange', 'yellow' => 'Yellow', 'green' => 'Green', 'blue' => 'Blue', 'violet' => 'Violet', 'grey' => 'Grey', 'white' => 'White']" selected="black" />
        </div>
        <x-calc.select name="mult" label="Multiplier" :options="['black' => 'Black', 'brown' => 'Brown', 'red' => 'Red', 'orange' => 'Orange', 'yellow' => 'Yellow', 'green' => 'Green', 'blue' => 'Blue', 'violet' => 'Violet', 'gold' => 'Gold', 'silver' => 'Silver']" selected="red" />
        <x-calc.select name="tol" label="Tolerance" :options="['brown' => 'Brown', 'red' => 'Red', 'orange' => 'Orange', 'yellow' => 'Yellow', 'green' => 'Green', 'blue' => 'Blue', 'violet' => 'Violet', 'grey' => 'Grey', 'gold' => 'Gold', 'silver' => 'Silver', 'none' => 'None']" selected="gold" />
        <div data-show-when="bands:6">
            <x-calc.select name="tc" label="Temperature coefficient" :options="['black' => 'Black', 'brown' => 'Brown', 'red' => 'Red', 'orange' => 'Orange', 'yellow' => 'Yellow', 'green' => 'Green', 'blue' => 'Blue', 'violet' => 'Violet', 'grey' => 'Grey']" selected="brown" />
        </div>
    </div>

    <x-calc.result label="Resistance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bands' => '4', 'b1' => 'yellow', 'b2' => 'violet', 'b3' => 'black', 'mult' => 'red', 'tol' => 'gold', 'tc' => 'brown'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'Range with tolerance'],
            'tc' => ['label' => 'Temperature coefficient'],
            'code' => ['label' => 'Bands read'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
