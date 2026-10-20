<x-calc.page
    title="Parallel Resistor Calculator - SolveKit"
    description="Free parallel resistor calculator: equivalent resistance, or the resistor to add for a target value."
    lede="Combine resistors in parallel."
    about="In parallel, conductances add: 1/R = Σ1/Rᵢ. The result is always below the smallest resistor."
    :calc="['engine' => 'ph-elec', 'tool' => 'resistors_parallel', 'fields' => ['mode', 'list', 'unit', 'target'], 'unitFields' => ['target' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 100, 220 and 470 Ω in parallel?', 'answer' => '59.977 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Find" :options="['total' => 'The total of several resistors', 'missing' => 'The resistor to add for a target']" selected="total" />
        <x-calc.textarea name="list" label="Resistors (comma or line separated; 4.7k, 1M allowed)" value="100, 220, 470" rows="3" />
        <x-calc.select name="unit" label="Plain numbers are in" :options="['ohm' => 'Ω', 'kohm' => 'kΩ', 'megohm' => 'MΩ']" selected="ohm" />
        <div data-show-when="mode:missing">
            <x-calc.field name="target" label="Target total" value="50" min="0" placeholder="Target total">
                <label for="calc-target-unit" class="sr-only">Target total unit</label>
                <select id="calc-target-unit" name="target-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Equivalent resistance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'total', 'list' => '100, 220, 470', 'unit' => 'ohm', 'target' => 50, 'target-unit' => 'ohm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cond' => ['label' => 'Total conductance'],
            'note' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
