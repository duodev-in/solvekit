<x-calc.page
    title="Carburetor CFM Calculator - SolveKit"
    description="Free carburetor CFM calculator: carburettor size from displacement, maximum rpm and volumetric efficiency."
    lede="Size a carburettor."
    about="An engine’s airflow is displacement × rpm × volumetric efficiency ÷ 2 for a four-stroke; in cubic inches and CFM that becomes ÷ 3456."
    :calc="['engine' => 'ph-mach', 'tool' => 'carb_cfm', 'fields' => ['V', 'rpm', 've', 'out'], 'unitFields' => ['V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'flow', 'force', 'length', 'mass', 'speed', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What carburettor suits a 350 cid at 6,000 rpm?', 'answer' => '516.5 CFM (an estimate).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="V" label="Engine displacement" value="350" min="0" placeholder="Engine displacement">
            <label for="calc-V-unit" class="sr-only">Engine displacement unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="rpm" label="Maximum rpm" value="6000" min="0" step="any" />
        <x-calc.field name="ve" label="Volumetric efficiency (%)" value="85" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m3s' => 'm³/s', 'm3h' => 'm³/h', 'ls' => 'L/s', 'lmin' => 'L/min', 'gpm' => 'gpm', 'cfm' => 'cfm', 'cfs' => 'ft³/s']" selected="cfm" />
    </div>

    <x-calc.result label="Carburettor size" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cfm', 'V' => 350, 'V-unit' => 'in3', 'rpm' => 6000, 've' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pick' => ['label' => 'Common carburettor sizes near this'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
