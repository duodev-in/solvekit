<x-calc.page
    title="Reconstitution Calculator - SolveKit"
    description="Free reconstitution calculator: concentration after dissolving a powder in a diluent, and the volume holding a chosen amount."
    lede="Work out the concentration after dissolving a powder, and how much to draw."
    about="Concentration = powder amount ÷ diluent volume, assuming the powder adds no volume of its own (some powders do; the product insert gives the final volume). This is general laboratory arithmetic. For medicines, follow the product instructions and a clinician's directions."
    :calc="['engine' => 'chem-mix', 'tool' => 'reconstitution', 'fields' => ['amount', 'amount_unit', 'diluent', 'wanted']]"
    :how-to="[
        ['name' => 'Enter the powder amount', 'text' => 'From the vial label.'],
        ['name' => 'Enter the diluent', 'text' => 'The volume you add.'],
        ['name' => 'Enter the amount wanted', 'text' => 'For the volume to draw.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate concentration after reconstitution?', 'answer' => 'Amount ÷ volume of diluent, e.g. 10 mg in 2 mL is 5 mg/mL.'],
        ['question' => 'Does the powder add volume?', 'answer' => 'Sometimes; check the insert for the final volume and use that instead.'],
        ['question' => 'Can I use this for medicine doses?', 'answer' => 'Only as arithmetic; follow the product instructions and your clinician.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Powder amount" value="10" min="0" />
        <x-calc.segmented name="amount_unit" legend="Unit" :options="['mg' => 'mg', 'units' => 'units']" selected="mg" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="diluent" label="Diluent added" value="2" min="0" suffix="mL" />
        <x-calc.field name="wanted" label="Amount wanted (optional)" value="2.5" min="0" placeholder="Optional" />
    </div>

    <x-calc.result label="Concentration" />

    <x-calc.options :examples="[
        '10 mg in 2 mL' => ['amount' => 10, 'amount_unit' => 'mg', 'diluent' => 2, 'wanted' => 2.5],
        '5000 units in 5 mL' => ['amount' => 5000, 'amount_unit' => 'units', 'diluent' => 5, 'wanted' => 1000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'draw' => ['label' => 'Volume to draw'],
            'per_01' => ['label' => 'In 0.1 mL'],
            'doses' => ['label' => 'Portions in the vial'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>concentration = amount ÷ volume</li>
            <li>volume to draw = amount wanted ÷ concentration</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
