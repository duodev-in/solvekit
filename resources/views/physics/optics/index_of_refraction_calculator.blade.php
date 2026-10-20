<x-calc.page
    title="Index of Refraction Calculator - SolveKit"
    description="Free index of refraction calculator: n = c/v from the speed of light in a medium, or the speed from n."
    lede="Solve n = c ÷ v."
    about="The refractive index is how many times slower light travels in a material than in vacuum. Water (n ≈ 1.333) slows light to about 225,000 km/s."
    :calc="['engine' => 'ph-wave', 'tool' => 'refractive_index', 'fields' => ['solve', 'n', 'v', 'out_v'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'n', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What index slows light to 225,408 km/s?', 'answer' => '1.33.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['n' => 'Refractive index n', 'v' => 'Speed of light in the medium']" selected="n" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:v" hidden>
            <x-calc.field name="n" label="Refractive index n" value="1.33" step="any" />
        </div>
        <div data-show-when="solve:n">
            <x-calc.field name="v" label="Speed of light in the medium" value="225407.863" placeholder="Speed of light in the medium">
                <label for="calc-v-unit" class="sr-only">Speed of light in the medium unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v" hidden>
            <x-calc.select name="out_v" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kms" />
        </div>
    </div>

    <x-calc.result label="Refractive index n" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'n', 'n' => 1.33, 'v' => 225407.863, 'v-unit' => 'kms', 'out_v' => 'kms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'delay' => ['label' => 'Extra delay per kilometre compared with vacuum'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = c ÷ v</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
