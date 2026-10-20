<x-calc.page
    title="Apparent and Absolute Magnitude Calculator - SolveKit"
    description="Free magnitude calculator: apparent magnitude, absolute magnitude or distance from the distance modulus."
    lede="Solve m − M = 5 log₁₀(d/10 pc)."
    about="Apparent magnitude is how bright a star looks; absolute magnitude is how bright it would look from 10 parsecs. Their difference, the distance modulus, gives the distance."
    :calc="['engine' => 'ph-astro', 'tool' => 'magnitude', 'fields' => ['solve', 'm', 'Mabs', 'd', 'out_d'], 'unitFields' => ['d' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all()], 'data' => ['units' => collect(config('units'))->only(['astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is Sirius’s absolute magnitude?', 'answer' => '1.43198.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['m' => 'Apparent magnitude m', 'Mabs' => 'Absolute magnitude M', 'd' => 'Distance']" selected="Mabs" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:Mabs,d">
            <x-calc.field name="m" label="Apparent magnitude m" value="-1.46" step="any" />
        </div>
        <div data-show-when="solve:m,d" hidden>
            <x-calc.field name="Mabs" label="Absolute magnitude M" value="1.42" step="any" />
        </div>
        <div data-show-when="solve:m,Mabs">
            <x-calc.field name="d" label="Distance" value="2.64" min="0" placeholder="Distance">
                <label for="calc-d-unit" class="sr-only">Distance unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'pc')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:d" hidden>
            <x-calc.select name="out_d" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'au' => 'AU', 'ly' => 'ly', 'pc' => 'pc', 'mpc' => 'Mpc', 'mi' => 'mi']" selected="pc" />
        </div>
    </div>

    <x-calc.result label="Absolute magnitude M" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'Mabs', 'm' => -1.46, 'Mabs' => 1.42, 'd' => 2.64, 'd-unit' => 'pc', 'out_d' => 'pc'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'mod' => ['label' => 'Distance modulus m − M'],
            'ratio' => ['label' => 'Brightness compared with the Sun at the same distance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>m − M = 5 log₁₀(d ÷ 10 pc)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
