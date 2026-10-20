<x-calc.page
    title="Excess Electrons Calculator - SolveKit"
    description="Free excess electrons calculator: how many extra electrons make up a given charge."
    lede="Solve n = Q ÷ e."
    about="Charge comes in whole numbers of the elementary charge, 1.602 × 10⁻¹⁹ C. One microcoulomb is over six trillion electrons."
    :calc="['engine' => 'ph-em', 'tool' => 'excess_electrons', 'fields' => ['solve', 'n', 'Q', 'out_Q'], 'unitFields' => ['Q' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all()], 'data' => ['units' => collect(config('units'))->only(['charge', 'energy', 'force', 'length', 'mass', 'n', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'How many electrons are in 1 µC?', 'answer' => '6,241,510,000,000.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['n' => 'Number of excess electrons', 'Q' => 'Charge (magnitude)']" selected="n" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:Q" hidden>
            <x-calc.field name="n" label="Number of excess electrons" value="6241510000000" step="any" />
        </div>
        <div data-show-when="solve:n">
            <x-calc.field name="Q" label="Charge (magnitude)" value="1" placeholder="Charge (magnitude)">
                <label for="calc-Q-unit" class="sr-only">Charge (magnitude) unit</label>
                <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'uc')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q" hidden>
            <x-calc.select name="out_Q" label="Show the result in" :options="['c' => 'C', 'mc' => 'mC', 'uc' => 'µC', 'nc' => 'nC', 'ah' => 'Ah', 'mah' => 'mAh', 'e' => 'e']" selected="uc" />
        </div>
    </div>

    <x-calc.result label="Number of excess electrons" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'n', 'n' => 6241510000000, 'Q' => 1, 'Q-unit' => 'uc', 'out_Q' => 'uc'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'mass' => ['label' => 'Mass of those electrons'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = Q ÷ e</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
