<x-calc.page
    title="Buffer pH Calculator (Henderson–Hasselbalch) - SolveKit"
    description="Free buffer pH calculator: Henderson-Hasselbalch pH from acid and base, or the base to acid ratio for a target pH, with common buffer pKa values."
    lede="Work out a buffer's pH, or the acid and base needed for a target pH."
    about="The Henderson–Hasselbalch equation links pH to the pKa and the ratio of the base form [A⁻] to the acid form [HA]. A buffer works best within about 1 pH unit of its pKa. pKa values are at 25 °C and shift with temperature and ionic strength, so check the final pH with a meter."
    :calc="['engine' => 'lab', 'tool' => 'buffer', 'fields' => ['buffer', 'pka', 'mode', 'base', 'acid', 'target', 'total'], 'data' => config('chemistry_data.buffers')]"
    :how-to="[
        ['name' => 'Pick a buffer', 'text' => 'Or choose Custom and enter a pKa.'],
        ['name' => 'Choose what to find', 'text' => 'The pH of a mix, or the split for a target pH.'],
        ['name' => 'Check with a meter', 'text' => 'Adjust the final pH with acid or base.'],
    ]"
    :faqs="[
        ['question' => 'What is the Henderson–Hasselbalch equation?', 'answer' => 'pH = pKa + log₁₀([A⁻] ÷ [HA]).'],
        ['question' => 'Which buffer should I use?', 'answer' => 'One whose pKa is within 1 unit of your target pH, e.g. HEPES (7.5) for pH 7.4.'],
        ['question' => 'Why does Tris pH change with temperature?', 'answer' => 'Its pKa drops by about 0.03 per °C, so set the pH at the temperature you will use it.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="buffer" label="Buffer" :options="collect(config('chemistry_data.buffers'))->map(fn ($item) => $item['name'].' (pKa '.$item['pka'].')')->put('custom', 'Custom pKa')->all()" selected="tris" />
        <div data-show-when="buffer:custom" hidden>
            <x-calc.field name="pka" label="pKa" value="7" min="0" max="14" />
        </div>
    </div>

    <x-calc.segmented name="mode" legend="Find" :options="['ph' => 'pH from amounts', 'ratio' => 'Amounts for a pH']" selected="ph" />

    <div data-show-when="mode:ph">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="base" label="Base form [A⁻]" value="50" min="0" suffix="mM" />
            <x-calc.field name="acid" label="Acid form [HA]" value="50" min="0" suffix="mM" />
        </div>
    </div>

    <div data-show-when="mode:ratio" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="target" label="Target pH" value="7.4" min="0" max="14" />
            <x-calc.field name="total" label="Total buffer concentration" value="100" min="0" suffix="mM" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Equal acid and base' => ['buffer' => 'tris', 'mode' => 'ph', 'base' => 50, 'acid' => 50],
        'HEPES pH 7.4, 100 mM' => ['buffer' => 'hepes', 'mode' => 'ratio', 'target' => 7.4, 'total' => 100],
        'Phosphate pH 7.0' => ['buffer' => 'phosphate', 'mode' => 'ratio', 'target' => 7, 'total' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ratio' => ['label' => 'Base : acid ratio'],
            'pka' => ['label' => 'pKa used'],
            'range' => ['label' => 'Useful buffering range'],
            'acid' => ['label' => 'Acid form'],
            'base_amount' => ['label' => 'Base form'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pH = pKa + log₁₀([A⁻] ÷ [HA])</li>
            <li>[A⁻] ÷ [HA] = 10^(pH − pKa)</li>
            <li>[HA] = total ÷ (1 + ratio)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
