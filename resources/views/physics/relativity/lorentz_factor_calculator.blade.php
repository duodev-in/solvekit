<x-calc.page
    title="Lorentz Factor Calculator - SolveKit"
    description="Free Lorentz factor calculator: γ from speed, or the speed for a given γ."
    lede="Find the Lorentz factor γ."
    about="The Lorentz factor γ = 1/√(1 − v²/c²) sets how much time dilates and lengths contract."
    :calc="['engine' => 'ph-astro', 'tool' => 'lorentz', 'fields' => ['mode', 'v', 'g'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is γ at 0.9c?', 'answer' => '2.2941573.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['v' => 'The speed', 'g' => 'The Lorentz factor']" selected="v" />
        <div data-show-when="mode:v">
            <x-calc.field name="v" label="Speed" value="0.9" placeholder="Speed">
                <label for="calc-v-unit" class="sr-only">Speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:g">
            <x-calc.field name="g" label="Lorentz factor γ" value="2" min="1" step="any" />
        </div>
    </div>

    <x-calc.result label="Lorentz factor γ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'v', 'v' => 0.9, 'v-unit' => 'c', 'g' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'v' => ['label' => 'Speed'],
            'beta' => ['label' => 'β = v/c'],
            'rapidity' => ['label' => 'Rapidity'],
            'contraction' => ['label' => 'Lengths shrink to'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
