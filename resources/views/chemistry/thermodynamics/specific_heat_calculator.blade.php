<x-calc.page
    title="Specific Heat Calculator - SolveKit"
    description="Free specific heat calculator: solve q = mcΔT for heat, mass, specific heat or temperature change, and find a metal's specific heat by calorimetry."
    lede="Solve q = mcΔT, or find a specific heat by calorimetry."
    about="Heat equals mass × specific heat × temperature change. Material presets are from LibreTexts (water 4.186 J/(g·K)). In calorimetry mode a hot sample is dropped into water; the heat it loses equals the heat the water gains, which gives the sample's specific heat."
    :calc="['engine' => 'chem-thermo', 'tool' => 'specific_heat', 'fields' => ['mode', 'solve', 'material', 'q', 'm', 'c', 'dt', 'metal_mass', 'metal_t', 'water_mass', 'water_t', 'final_t'], 'data' => ['specific_heats' => config('chemistry_data.specific_heats')]]"
    :how-to="[
        ['name' => 'Choose the mode', 'text' => 'Solve q = mcΔT or calorimetry.'],
        ['name' => 'Enter the values', 'text' => 'Mass in grams, temperatures in °C.'],
    ]"
    :faqs="[
        ['question' => 'What is the specific heat of water?', 'answer' => '4.186 J/(g·K), one calorie per gram per degree.'],
        ['question' => 'Why does water heat slowly?', 'answer' => 'Its specific heat is high, so it takes a lot of energy to warm.'],
        ['question' => 'How does calorimetry find specific heat?', 'answer' => 'Heat lost by the hot sample equals heat gained by the water.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Mode" :options="['solve' => 'q = mcΔT', 'calorimetry' => 'Calorimetry']" selected="solve" />

    <div data-show-when="mode:solve">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="solve" label="Solve for" :options="['q' => 'Heat q', 'm' => 'Mass m', 'c' => 'Specific heat c', 'dt' => 'Temperature change ΔT']" selected="q" />
            <x-calc.select name="material" label="Material" :options="collect(config('chemistry_data.specific_heats'))->map(fn ($s) => $s['name'].' ('.$s['c'].')')->put('custom', 'Custom')->all()" selected="water" />
        </div>
    </div>

    <div data-show-when="mode:solve">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="q" label="Heat q" value="4186" suffix="J" />
            <x-calc.field name="m" label="Mass m" value="100" min="0" suffix="g" />
        </div>
    </div>

    <div data-show-when="mode:solve">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="c" label="Custom specific heat" value="0.9" min="0" suffix="J/(g·K)" />
            <x-calc.field name="dt" label="Temperature change" value="10" suffix="°C" />
        </div>
    </div>

    <div data-show-when="mode:calorimetry" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="metal_mass" label="Sample mass" value="50" min="0" suffix="g" />
            <x-calc.field name="metal_t" label="Sample start" value="100" suffix="°C" />
        </div>
    </div>

    <div data-show-when="mode:calorimetry" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="water_mass" label="Water mass" value="100" min="0" suffix="g" />
            <x-calc.field name="water_t" label="Water start" value="20" suffix="°C" />
            <x-calc.field name="final_t" label="Final temperature" value="23.6" suffix="°C" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Heat 100 g water by 10 °C' => ['mode' => 'solve', 'solve' => 'q', 'material' => 'water', 'm' => 100, 'dt' => 10],
        'Warm 500 g aluminum' => ['mode' => 'solve', 'solve' => 'q', 'material' => 'aluminum', 'm' => 500, 'dt' => 30],
        'Identify a metal' => ['mode' => 'calorimetry', 'metal_mass' => 50, 'metal_t' => 100, 'water_mass' => 100, 'water_t' => 20, 'final_t' => 23.6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'q' => ['label' => 'Heat'],
            'closest' => ['label' => 'Material'],
            'kj' => ['label' => 'In BTU'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>q = m × c × ΔT</li>
            <li>calorimetry: m c ΔT (sample) = m c ΔT (water)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
