<x-calc.page
    title="Combined Gas Law Calculator - SolveKit"
    description="Free combined gas law calculator: new volume or pressure with the combined, Boyle's, Charles's or Gay-Lussac's law."
    lede="Work out how a gas responds when pressure, volume or temperature changes."
    about="For a fixed amount of gas, P₁V₁ ÷ T₁ = P₂V₂ ÷ T₂. Holding one variable constant gives Boyle's law (constant T), Charles's law (constant P) and Gay-Lussac's law (constant V). Temperatures are converted to kelvin."
    :calc="['engine' => 'chem-physical', 'tool' => 'combined_gas', 'fields' => ['law', 'p1', 'v1', 't1', 'p2', 't2'], 'unitFields' => ['p1' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 'v1' => collect(config('units.volume'))->only(['ml', 'l'])->all(), 't1' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all(), 'p2' => collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi'])->all(), 't2' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()]]"
    :how-to="[
        ['name' => 'Pick the law', 'text' => 'Or the combined law for all three changing.'],
        ['name' => 'Enter the starting state', 'text' => 'And the new conditions.'],
    ]"
    :faqs="[
        ['question' => 'What is Boyle\'s law?', 'answer' => 'At constant temperature, P × V stays the same.'],
        ['question' => 'What is Charles\'s law?', 'answer' => 'At constant pressure, volume is proportional to absolute temperature.'],
        ['question' => 'Why convert to kelvin?', 'answer' => 'The laws hold for absolute temperature only.'],
    ]"
>
    <x-calc.select name="law" label="Law" :options="['combined' => 'Combined gas law', 'boyle' => 'Boyle\'s law (constant T)', 'charles' => 'Charles\'s law (constant P)', 'gay_lussac' => 'Gay-Lussac\'s law (constant V)']" selected="combined" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="law:combined,boyle,gay_lussac">
            <x-calc.field name="p1" label="P₁" value="100" min="0" placeholder="P₁">
                <label for="calc-p1-unit" class="sr-only">P₁ unit</label>
                <select id="calc-p1-unit" name="p1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="law:combined,boyle,charles">
            <x-calc.field name="v1" label="V₁" value="10" min="0" placeholder="V₁">
                <label for="calc-v1-unit" class="sr-only">V₁ unit</label>
                <select id="calc-v1-unit" name="v1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="law:combined,charles,gay_lussac">
            <x-calc.field name="t1" label="T₁" value="25" placeholder="T₁">
                <label for="calc-t1-unit" class="sr-only">T₁ unit</label>
                <select id="calc-t1-unit" name="t1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="law:combined,boyle">
            <x-calc.field name="p2" label="P₂" value="200" min="0" placeholder="P₂">
                <label for="calc-p2-unit" class="sr-only">P₂ unit</label>
                <select id="calc-p2-unit" name="p2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['kpa', 'atm', 'bar', 'mmhg', 'pa', 'psi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="law:combined,charles,gay_lussac">
            <x-calc.field name="t2" label="T₂" value="100" placeholder="T₂">
                <label for="calc-t2-unit" class="sr-only">T₂ unit</label>
                <select id="calc-t2-unit" name="t2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Combined change' => ['law' => 'combined', 'p1' => 100, 'p1-unit' => 'kpa', 'v1' => 10, 'v1-unit' => 'l', 't1' => 25, 't1-unit' => 'c', 'p2' => 200, 'p2-unit' => 'kpa', 't2' => 100, 't2-unit' => 'c'],
        'Boyle\'s law' => ['law' => 'boyle', 'p1' => 1, 'p1-unit' => 'atm', 'v1' => 6, 'v1-unit' => 'l', 'p2' => 3, 'p2-unit' => 'atm'],
        'Charles\'s law' => ['law' => 'charles', 'v1' => 2, 'v1-unit' => 'l', 't1' => 0, 't1-unit' => 'c', 't2' => 100, 't2-unit' => 'c'],
        'Tire in the sun' => ['law' => 'gay_lussac', 'p1' => 220, 'p1-unit' => 'kpa', 't1' => 20, 't1-unit' => 'c', 't2' => 50, 't2-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ratio' => ['label' => 'Change'],
            'law' => ['label' => 'Law used'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P₁V₁ ÷ T₁ = P₂V₂ ÷ T₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
