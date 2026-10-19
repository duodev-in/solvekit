<x-calc.page
    title="Hand Sanitizer Calculator - Coronavirus - SolveKit"
    description="Free hand sanitizer calculator: scale the WHO hand-rub recipes (80% ethanol or 75% isopropyl alcohol) to any batch size."
    lede="Scale the WHO hand-rub recipe."
    about="The WHO Guide to Local Production (2010) gives two formulations for 10 litres: 8,333 mL of 96% ethanol (or 7,515 mL of 99.8% isopropyl alcohol), 417 mL of 3% hydrogen peroxide and 145 mL of 98% glycerol, topped up with distilled or boiled cooled water. Leave the bottles 72 hours before use. Alcohol is flammable; keep it away from flames and children. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'sanitizer', 'fields' => ['litres', 'formula']]"
    :how-to="[
        ['name' => 'Enter the batch size', 'text' => ''],
        ['name' => 'Choose the alcohol', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much ethanol for a 1-litre batch?', 'answer' => '833 mL ethanol 96%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="litres" label="Batch size" value="1" min="0" step="any" suffix="L" />
        <x-calc.select name="formula" label="Formulation" :options="['ethanol' => 'I: ethanol 80%', 'isopropanol' => 'II: isopropyl alcohol 75%']" selected="ethanol" />
    </div>

    <x-calc.result label="WHO hand-rub recipe" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['litres' => 1, 'formula' => 'ethanol'],
        'Isopropyl 5 L' => ['litres' => 5, 'formula' => 'isopropanol'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'peroxide' => ['label' => 'Hydrogen peroxide'],
            'glycerol' => ['label' => 'Glycerol'],
            'water' => ['label' => 'Water'],
            'quarantine' => ['label' => 'Before use'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.grid heading="Recipe" name="recipe" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>amounts × litres ÷ 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
