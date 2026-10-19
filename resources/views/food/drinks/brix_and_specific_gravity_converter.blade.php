<x-calc.page
    title="Brix and Specific Gravity Converter - SolveKit"
    description="Free Brix to specific gravity converter: convert between degrees Brix, specific gravity and Plato for juice, wort, must and syrups, with potential alcohol."
    lede="Convert Brix, specific gravity and Plato."
    about="Brix is grams of sugar per 100 g of solution; specific gravity compares the density with water. A standard approximation links them: SG = 1 + Brix ÷ (258.6 − 0.88 × Brix). Plato is close to Brix for wort. Potential alcohol assumes the sugar ferments fully (to 1.000) or to a typical 1.010 finish."
    :calc="['engine' => 'fd-drinks', 'tool' => 'brix', 'fields' => ['value', 'scale']]"
    :how-to="[
        ['name' => 'Enter the reading', 'text' => ''],
        ['name' => 'Choose its scale', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What SG is 21 Brix grape juice?', 'answer' => '1.087, 11.5% if fermented dry (to 1.000); 10.2% to 1.010.'],
        ['question' => 'What Brix is SG 1.050?', 'answer' => '12.4 °Bx.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Reading" value="21" min="0" step="any" />
        <x-calc.select name="scale" label="Scale" :options="['brix' => 'Brix (°Bx) or Plato', 'sg' => 'Specific gravity']" selected="brix" />
    </div>

    <x-calc.result label="Specific gravity" />

    <x-calc.options :decimals="false" :examples="[
        '21 Brix' => ['value' => 21, 'scale' => 'brix'],
        'SG 1.050' => ['value' => 1.05, 'scale' => 'sg'],
        '12 Plato wort' => ['value' => 12, 'scale' => 'brix'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'sg' => ['label' => 'Specific gravity'],
            'brix' => ['label' => 'Brix'],
            'plato' => ['label' => 'Plato'],
            'potential' => ['label' => 'Potential alcohol'],
            'sugar' => ['label' => 'Sugar'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SG = 1 + Bx ÷ (258.6 − (Bx ÷ 258.2) × 227.1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
