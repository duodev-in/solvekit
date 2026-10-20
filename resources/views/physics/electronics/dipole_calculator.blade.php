<x-calc.page
    title="Dipole Calculator - SolveKit"
    description="Free dipole antenna calculator: half-wave dipole length and leg length for any frequency."
    lede="Cut a half-wave dipole."
    about="A half-wave dipole is about 95% of half a free-space wavelength long because of end effects: 468/f(MHz) feet."
    :calc="['engine' => 'ph-elec', 'tool' => 'dipole_antenna', 'fields' => ['f', 'k', 'out'], 'unitFields' => ['f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long is a 20 m band dipole at 14.2 MHz?', 'answer' => '10.0283 m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="f" label="Frequency" value="14.2" min="0" placeholder="Frequency">
            <label for="calc-f-unit" class="sr-only">Frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mhz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="k" label="End-effect factor" value="0.95" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Total dipole length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'f' => 14.2, 'f-unit' => 'mhz', 'k' => 0.95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'leg' => ['label' => 'Each leg'],
            'free' => ['label' => 'Free-space half wavelength'],
            'ft' => ['label' => 'In feet (468 ÷ f MHz)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
