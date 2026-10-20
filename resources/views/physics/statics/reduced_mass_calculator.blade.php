<x-calc.page
    title="Reduced Mass Calculator - SolveKit"
    description="Free reduced mass calculator: μ = m₁m₂/(m₁ + m₂) for two-body problems, in u or kg."
    lede="Find the reduced mass of two bodies."
    about="A two-body problem behaves like one body of reduced mass μ = m₁m₂ ÷ (m₁ + m₂). It is close to the smaller mass when the other is much heavier, as in a diatomic molecule like HCl."
    :calc="['engine' => 'ph-mech', 'tool' => 'reduced_mass', 'fields' => ['m1', 'm2', 'out'], 'unitFields' => ['m1' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all(), 'm2' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'particle_mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the reduced mass of ¹H³⁵Cl?', 'answer' => '0.979593 u.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m1" label="Mass 1" value="1.00782503207" min="0" placeholder="Mass 1">
            <label for="calc-m1-unit" class="sr-only">Mass 1 unit</label>
            <select id="calc-m1-unit" name="m1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'u')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="m2" label="Mass 2" value="34.968852682" min="0" placeholder="Mass 2">
            <label for="calc-m2-unit" class="sr-only">Mass 2 unit</label>
            <select id="calc-m2-unit" name="m2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'u')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'u' => 'u', 'me' => 'mₑ', 'mevc2' => 'MeV/c²']" selected="u" />
    </div>

    <x-calc.result label="Reduced mass μ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'u', 'm1' => 1.00782503207, 'm1-unit' => 'u', 'm2' => 34.968852682, 'm2-unit' => 'u'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kg' => ['label' => 'In kilograms'],
            'ratio' => ['label' => 'μ ÷ smaller mass'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
