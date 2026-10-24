<x-calc.page
    title="Impedance Matching Calculator - SolveKit"
    description="Free impedance matching calculator: L-network inductor and capacitor values to match a source and load at a frequency."
    lede="Design an L-network match."
    about="An L-network of one inductor and one capacitor matches two different resistances at one frequency, for maximum power transfer."
    :calc="['engine' => 'tc-elec', 'tool' => 'impedance_matching', 'fields' => ['rs', 'rl', 'f'], 'unitFields' => ['f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['frequency_hz'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What matches 50 Ω to 200 Ω at 14 MHz?', 'answer' => 'L 984.52 nH, C 98.452 pF.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rs" label="Source resistance Rs (Ω)" value="50" min="0" step="any" />
        <x-calc.field name="rl" label="Load resistance RL (Ω)" value="200" min="0" step="any" />
        <x-calc.field name="f" label="Frequency" value="14" min="0" placeholder="Frequency">
            <label for="calc-f-unit" class="sr-only">Frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mhz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="L-network (low-pass)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rs' => 50, 'rl' => 200, 'f' => 14, 'f-unit' => 'mhz'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'q' => ['label' => 'Loaded Q'],
            'series' => ['label' => 'Series element (low-pass)'],
            'shunt' => ['label' => 'Shunt element (low-pass)'],
            'highpass' => ['label' => 'High-pass version'],
            'placement' => ['label' => 'Placement'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
