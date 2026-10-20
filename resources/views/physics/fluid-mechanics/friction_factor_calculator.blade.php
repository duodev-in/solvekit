<x-calc.page
    title="Friction Factor Calculator - SolveKit"
    description="Free friction factor calculator: Darcy friction factor from Reynolds number and roughness by Colebrook–White."
    lede="Find the Darcy friction factor."
    about="The Moody chart in a formula: laminar flow gives 64/Re; turbulent flow follows Colebrook–White, solved iteratively, with explicit approximations shown."
    :calc="['engine' => 'ph-fluid', 'tool' => 'friction_factor', 'fields' => ['Re', 'rel'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is f at Re = 10⁵ and ε/D = 0.0009?', 'answer' => '0.0218322.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="Re" label="Reynolds number" value="100000" min="0" step="any" />
        <x-calc.field name="rel" label="Relative roughness ε/D" value="0.0009" min="0" step="any" />
    </div>

    <x-calc.result label="Darcy friction factor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['Re' => 100000, 'rel' => 0.0009],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sj' => ['label' => 'Swamee–Jain (explicit)'],
            'haaland' => ['label' => 'Haaland (explicit)'],
            'fanning' => ['label' => 'Fanning friction factor (f/4)'],
            'regime' => ['label' => 'Regime'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
