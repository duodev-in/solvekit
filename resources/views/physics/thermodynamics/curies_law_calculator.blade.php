<x-calc.page
    title="Curie's Law Calculator - SolveKit"
    description="Free Curie's law calculator: magnetic susceptibility and magnetisation of a paramagnet."
    lede="Use Curie's law."
    about="Paramagnetic materials magnetise more easily when cold: χ = C/T."
    :calc="['engine' => 'ph-thermo', 'tool' => 'curie', 'fields' => ['Cc', 'T', 'H'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is χ for C = 0.5 K at 300 K?', 'answer' => '0.00166667.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Cc" label="Curie constant (K)" value="0.5" min="0" step="any" />
        <x-calc.field name="T" label="Temperature" value="300" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="H" label="Applied field H (A/m)" value="100000" min="0" step="any" />
    </div>

    <x-calc.result label="Magnetic susceptibility χ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['Cc' => 0.5, 'T' => 300, 'T-unit' => 'k', 'H' => 100000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'M' => ['label' => 'Magnetisation M = χH'],
            'at' => ['label' => 'At twice the temperature'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
