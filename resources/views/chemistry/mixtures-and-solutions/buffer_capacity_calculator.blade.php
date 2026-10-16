<x-calc.page
    title="Buffer Capacity Calculator - SolveKit"
    description="Free buffer capacity calculator: β from pKa, total concentration and pH with the Van Slyke equation, and acid or base to shift the pH."
    lede="Work out how strongly a buffer resists a pH change."
    about="Buffer capacity β is the strong acid or base (mol/L) needed to change the pH by one unit. Van Slyke's (1922) equation includes the buffer pair and water. Capacity is greatest at pH = pKa and falls quickly beyond ±1 unit. The amounts to shift by 0.1 pH are integrated exactly over that range."
    :calc="['engine' => 'chem-mix', 'tool' => 'buffer_capacity', 'fields' => ['buffer', 'pka', 'total', 'ph'], 'data' => config('chemistry_data')]"
    :how-to="[
        ['name' => 'Pick the buffer', 'text' => 'Or enter its pKa.'],
        ['name' => 'Enter concentration and pH', 'text' => 'Total of acid and base forms.'],
    ]"
    :faqs="[
        ['question' => 'When is buffer capacity highest?', 'answer' => 'At pH = pKa, where acid and base forms are equal.'],
        ['question' => 'How do I increase capacity?', 'answer' => 'Use a more concentrated buffer; capacity scales with concentration.'],
        ['question' => 'What units does β have?', 'answer' => 'mol/L of strong acid or base per pH unit.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="buffer" label="Buffer" :options="collect(config('chemistry_data.buffers'))->map(fn ($item) => $item['name'].' (pKa '.$item['pka'].')')->put('custom', 'Custom pKa')->all()" selected="phosphate" />
        <div data-show-when="buffer:custom" hidden>
            <x-calc.field name="pka" label="pKa" value="7" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="total" label="Total buffer concentration" value="0.1" min="0" suffix="M" />
        <x-calc.field name="ph" label="pH" value="7.2" min="0" max="14" />
    </div>

    <x-calc.result label="Buffer capacity β" />

    <x-calc.options :examples="[
        '0.1 M phosphate at 7.2' => ['buffer' => 'phosphate', 'total' => 0.1, 'ph' => 7.2],
        '0.05 M Tris at 7.4' => ['buffer' => 'tris', 'total' => 0.05, 'ph' => 7.4],
        'Acetate far from pKa' => ['buffer' => 'acetate', 'total' => 0.1, 'ph' => 6.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'max' => ['label' => 'Maximum capacity'],
            'up' => ['label' => 'Base to raise 0.1 pH'],
            'down' => ['label' => 'Acid to lower 0.1 pH'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>β = ln 10 (Kw/[H⁺] + [H⁺] + C Ka [H⁺] ÷ (Ka + [H⁺])²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
