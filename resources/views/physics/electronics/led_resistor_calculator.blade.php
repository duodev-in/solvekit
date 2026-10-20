<x-calc.page
    title="LED Resistor Calculator - SolveKit"
    description="Free LED resistor calculator: series resistor value and power for one or more LEDs."
    lede="Find the LED series resistor."
    about="An LED needs a resistor to set its current: R = (V_s − nV_f)/I. The forward voltage depends on the colour."
    :calc="['engine' => 'ph-elec', 'tool' => 'led_resistor', 'fields' => ['Vs', 'led', 'Vf', 'I', 'n', 'out'], 'unitFields' => ['Vs' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'Vf' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'resistance', 'speed', 'voltage'])->all(), 'physics' => collect(config('physics_data'))->only(['leds'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What resistor runs a red LED at 20 mA from 5 V?', 'answer' => '150 Ω, Use 150 Ω (E12) → 20 mA.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Vs" label="Supply voltage" value="5" placeholder="Supply voltage">
            <label for="calc-Vs-unit" class="sr-only">Supply voltage unit</label>
            <select id="calc-Vs-unit" name="Vs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="led" label="LED colour" :options="['red' => 'Red', 'orange' => 'Orange', 'yellow' => 'Yellow', 'green' => 'Green (standard)', 'true_green' => 'Green (InGaN, bright)', 'blue' => 'Blue', 'white' => 'White', 'infrared' => 'Infrared', 'custom' => 'Other (enter the value)']" selected="red" />
        <div data-show-when="led:custom">
            <x-calc.field name="Vf" label="Forward voltage" value="2" placeholder="Forward voltage">
                <label for="calc-Vf-unit" class="sr-only">Forward voltage unit</label>
                <select id="calc-Vf-unit" name="Vf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="I" label="LED current" value="20" placeholder="LED current">
            <label for="calc-I-unit" class="sr-only">LED current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ma')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="n" label="LEDs in series" value="1" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['ohm' => 'Ω', 'mohm' => 'mΩ', 'kohm' => 'kΩ', 'megohm' => 'MΩ', 'gohm' => 'GΩ']" selected="ohm" />
    </div>

    <x-calc.result label="Resistor value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ohm', 'Vs' => 5, 'Vs-unit' => 'v', 'led' => 'red', 'Vf' => 2, 'Vf-unit' => 'v', 'I' => 20, 'I-unit' => 'ma', 'n' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'e12' => ['label' => 'Next standard value (E12)'],
            'P' => ['label' => 'Resistor power'],
            'rating' => ['label' => 'Suggested rating'],
            'Pled' => ['label' => 'Power in each LED'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
