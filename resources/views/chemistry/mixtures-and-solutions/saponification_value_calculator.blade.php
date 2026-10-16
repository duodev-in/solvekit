<x-calc.page
    title="Saponification Value Calculator - SolveKit"
    description="Free saponification calculator: lye (NaOH or KOH) and water for a soap recipe from oil weights, SAP values and superfat."
    lede="Work out the lye and water for a soap recipe."
    about="Each oil needs a set amount of lye to turn into soap, its saponification (SAP) value. Lye = Σ oil weight × SAP ratio, reduced by the superfat. SAP values are averages from From Nature With Love's chart; natural oils vary by batch, so a 5% superfat gives a safety margin. Always handle lye with gloves and eye protection."
    :calc="['engine' => 'chem-mix', 'tool' => 'saponification', 'fields' => ['lye', 'weight_unit', 'oil_1', 'weight_1', 'oil_2', 'weight_2', 'oil_3', 'weight_3', 'oil_4', 'weight_4', 'oil_5', 'weight_5', 'superfat', 'purity', 'water_value', 'water_mode'], 'data' => ['oils' => config('chemistry_data.oils')]]"
    :how-to="[
        ['name' => 'Choose the lye', 'text' => 'NaOH for bars, KOH for liquid soap.'],
        ['name' => 'Add your oils', 'text' => 'Up to five, with weights.'],
        ['name' => 'Set superfat and water', 'text' => '5% superfat is common.'],
    ]"
    :faqs="[
        ['question' => 'What is a SAP value?', 'answer' => 'The milligrams of KOH needed to saponify 1 g of oil.'],
        ['question' => 'What is superfat?', 'answer' => 'Leaving a little oil unsaponified so no free lye remains; 5% is typical.'],
        ['question' => 'How much water should I use?', 'answer' => 'Commonly 33% to 38% of the oil weight, or about 2 to 3 parts water per part lye.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="lye" legend="Lye" :options="['naoh' => 'NaOH (bar soap)', 'koh' => 'KOH (liquid soap)']" selected="naoh" />
        <x-calc.segmented name="weight_unit" legend="Weights in" :options="['g' => 'g', 'oz' => 'oz']" selected="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="oil_1" label="Oil 1" :options="collect(config('chemistry_data.oils'))->map(fn ($o) => $o['name'])->prepend('None', 'none')->all()" selected="olive_oil" />
        <x-calc.field name="weight_1" label="Weight 1" value="500" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="oil_2" label="Oil 2" :options="collect(config('chemistry_data.oils'))->map(fn ($o) => $o['name'])->prepend('None', 'none')->all()" selected="coconut_oil_rbd" />
        <x-calc.field name="weight_2" label="Weight 2" value="300" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="oil_3" label="Oil 3" :options="collect(config('chemistry_data.oils'))->map(fn ($o) => $o['name'])->prepend('None', 'none')->all()" selected="none" />
        <x-calc.field name="weight_3" label="Weight 3" value="" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="oil_4" label="Oil 4" :options="collect(config('chemistry_data.oils'))->map(fn ($o) => $o['name'])->prepend('None', 'none')->all()" selected="none" />
        <x-calc.field name="weight_4" label="Weight 4" value="" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="oil_5" label="Oil 5" :options="collect(config('chemistry_data.oils'))->map(fn ($o) => $o['name'])->prepend('None', 'none')->all()" selected="none" />
        <x-calc.field name="weight_5" label="Weight 5" value="" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="superfat" label="Superfat" value="5" min="0" max="40" suffix="%" />
        <x-calc.field name="purity" label="Lye purity" value="100" min="1" max="100" suffix="%" help="KOH is often 90%" />
        <x-calc.field name="water_value" label="Water" value="33" min="0" />
    </div>

    <x-calc.segmented name="water_mode" legend="Water as" :options="['percent' => '% of oils', 'ratio' => 'Water : lye ratio']" selected="percent" />

    <x-calc.result label="Lye needed" />

    <x-calc.options :examples="[
        'Olive and coconut bar' => ['lye' => 'naoh', 'weight_unit' => 'g', 'oil_1' => 'olive_oil', 'weight_1' => 500, 'oil_2' => 'coconut_oil_rbd', 'weight_2' => 300, 'superfat' => 5, 'purity' => 100, 'water_value' => 33, 'water_mode' => 'percent'],
        'Castile (100% olive)' => ['lye' => 'naoh', 'weight_unit' => 'g', 'oil_1' => 'olive_oil', 'weight_1' => 1000, 'oil_2' => 'none', 'weight_2' => '', 'superfat' => 5, 'purity' => 100, 'water_value' => 33, 'water_mode' => 'percent'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'water' => ['label' => 'Water'],
            'concentration' => ['label' => 'Lye concentration'],
            'oils' => ['label' => 'Total oils'],
        ]" />
        <x-calc.quick-ref heading="Lye for each oil" name="oils" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lye = Σ weight × SAP ratio × (1 − superfat)</li>
            <li>NaOH ratio = SAP ÷ 1402.5; KOH ratio = SAP ÷ 1000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
