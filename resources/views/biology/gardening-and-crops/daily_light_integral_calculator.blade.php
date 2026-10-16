<x-calc.page
    title="Daily Light Integral Calculator - SolveKit"
    description="Free daily light integral (DLI) calculator: mol/m²/day from PPFD and hours of light."
    lede="Work out the daily light integral from light intensity and day length."
    about="DLI is the total photosynthetic light a plant gets in a day. Multiply PPFD (µmol/m²/s) by the hours of light and by 0.0036 to get mol/m²/day."
    :calc="['engine' => 'garden', 'tool' => 'dli', 'fields' => ['ppfd', 'hours']]"
    :how-to="[
        ['name' => 'Measure PPFD', 'text' => 'With a quantum (PAR) meter at canopy height, or from the light\'s chart.'],
        ['name' => 'Enter the hours', 'text' => 'How long the lights or sun shine per day.'],
    ]"
    :faqs="[
        ['question' => 'What DLI do tomatoes need?', 'answer' => 'Fruiting crops like tomatoes do best around 20 to 30 mol/m²/day.'],
        ['question' => 'What DLI for houseplants?', 'answer' => 'Many foliage houseplants manage on 4 to 10 mol/m²/day.'],
        ['question' => 'Where does 0.0036 come from?', 'answer' => '3,600 seconds per hour ÷ 1,000,000 µmol per mol.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ppfd" label="PPFD" value="400" min="0" suffix="µmol/m²/s" />
        <x-calc.field name="hours" label="Hours of light" value="16" min="0" max="24" />
    </div>

    <x-calc.result label="Daily light integral" />

    <x-calc.options :examples="[
        'Grow light 600 for 12 h' => ['ppfd' => 600, 'hours' => 12],
        'Window 150 for 10 h' => ['ppfd' => 150, 'hours' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="Hours needed at this PPFD" name="quick-ref" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DLI = PPFD × hours × 0.0036</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
