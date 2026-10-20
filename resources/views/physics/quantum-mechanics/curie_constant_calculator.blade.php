<x-calc.page
    title="Curie Constant Calculator - SolveKit"
    description="Free Curie constant calculator: C from ion density, J and g, with the effective moment."
    lede="Find the Curie constant."
    about="The Curie constant sets how strongly a paramagnet responds at a given temperature. It depends on how many magnetic ions there are and their moment g√(J(J+1)) μ_B."
    :calc="['engine' => 'ph-quantum', 'tool' => 'curie_constant', 'fields' => ['n', 'J', 'g'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is C for the example ions?', 'answer' => '1.64392 K.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="n" label="Number density of magnetic ions (per m³)" value="1e+28" min="0" step="any" />
        <x-calc.field name="J" label="Total angular momentum J" value="3.5" min="0" step="any" />
        <x-calc.field name="g" label="Landé g-factor" value="2" min="0" step="any" />
    </div>

    <x-calc.result label="Curie constant" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 1e+28, 'J' => 3.5, 'g' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'peff' => ['label' => 'Effective moment'],
            'molar' => ['label' => 'Molar Curie constant (cgs)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
