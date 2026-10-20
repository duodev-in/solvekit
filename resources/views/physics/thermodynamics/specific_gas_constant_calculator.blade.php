<x-calc.page
    title="Specific Gas Constant Calculator - SolveKit"
    description="Free specific gas constant calculator: R_s = R/M with c_p and c_v for common gases."
    lede="Find the specific gas constant."
    about="Each gas has its own constant R/M. For air it is 287 J/(kg·K)."
    :calc="['engine' => 'ph-thermo', 'tool' => 'specific_gas_constant', 'fields' => ['gas', 'M', 'out'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'specific_heat', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['gases'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is R_s for air?', 'answer' => '287.055 J/(kg·K).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="gas" label="Gas" :options="['air' => 'Air', 'nitrogen' => 'Nitrogen', 'oxygen' => 'Oxygen', 'co2' => 'Carbon dioxide', 'methane' => 'Methane', 'propane' => 'Propane', 'hydrogen' => 'Hydrogen', 'helium' => 'Helium', 'argon' => 'Argon', 'steam' => 'Water vapour', 'ammonia' => 'Ammonia', 'custom' => 'Other (enter the value)']" selected="air" />
        <div data-show-when="gas:custom">
            <x-calc.field name="M" label="Molar mass (g/mol)" value="28.9647" min="0" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['jkgk' => 'J/(kg·K)', 'kjkgk' => 'kJ/(kg·K)', 'jgk' => 'J/(g·K)', 'calgc' => 'cal/(g·°C)', 'btulbf' => 'BTU/(lb·°F)']" selected="jkgk" />
    </div>

    <x-calc.result label="Specific gas constant" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'jkgk', 'gas' => 'air', 'M' => 28.9647],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cp' => ['label' => 'c_p (from γ)'],
            'cv' => ['label' => 'c_v (from γ)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
