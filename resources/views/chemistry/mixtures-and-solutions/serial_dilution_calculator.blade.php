<x-calc.page
    title="Serial Dilution Calculator - SolveKit"
    description="Free serial dilution calculator: concentration in every tube, transfer volume and diluent for a dilution series."
    lede="Plan a serial dilution: concentration in each tube, transfer and diluent volumes."
    about="In a serial dilution each tube is diluted from the one before by the same factor, so tube n holds the stock concentration ÷ factorⁿ. With a final volume V in every tube you move V ÷ factor into V − V ÷ factor of diluent."
    :calc="['engine' => 'lab', 'tool' => 'serial_dilution', 'fields' => ['stock', 'factor', 'steps', 'final_volume']]"
    :how-to="[
        ['name' => 'Enter the stock and factor', 'text' => 'A factor of 10 is a 1:10 series.'],
        ['name' => 'Set tubes and volume', 'text' => 'The volume each tube ends with.'],
        ['name' => 'Follow the tube list', 'text' => 'Mix well before every transfer.'],
    ]"
    :faqs="[
        ['question' => 'What is a 1:10 serial dilution?', 'answer' => 'Each tube is a tenth of the one before: 1 part from the previous tube plus 9 parts diluent.'],
        ['question' => 'How do I make a 2-fold series?', 'answer' => 'Use a factor of 2: half the volume transferred into an equal volume of diluent.'],
        ['question' => 'What is the total dilution?', 'answer' => 'The factor raised to the number of steps, e.g. 10⁶ after six 1:10 steps.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="stock" label="Stock concentration" value="1000" min="0" />
        <x-calc.field name="factor" label="Dilution factor per step" value="10" min="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="steps" label="Number of tubes" value="6" min="1" max="20" step="1" />
        <x-calc.field name="final_volume" label="Volume per tube" value="1000" min="0" help="Any unit, e.g. µL" />
    </div>

    <x-calc.result label="Last tube" />

    <x-calc.options :examples="[
        '10-fold × 6 in 1 mL' => ['stock' => 1000, 'factor' => 10, 'steps' => 6, 'final_volume' => 1000],
        '2-fold × 8 in 100 µL' => ['stock' => 100, 'factor' => 2, 'steps' => 8, 'final_volume' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Each step" :rows="[
            'transfer' => ['label' => 'Transfer each step'],
            'diluent' => ['label' => 'Diluent in each tube'],
        ]" />
        <x-calc.quick-ref heading="Tubes" name="tubes" :generated="true" :collapse="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Cₙ = C₀ ÷ factorⁿ</li>
            <li>transfer = V ÷ factor</li>
            <li>diluent = V − transfer</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
