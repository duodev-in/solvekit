<x-calc.page
    title="Wastewater Calculator - SolveKit"
    description="Free wastewater calculator for activated sludge: F/M ratio, sludge age (SRT), SVI, detention time and BOD loading."
    lede="Activated-sludge process calculations: F/M ratio, sludge age, SVI, detention time and BOD loading."
    about="These are the standard operator formulas in US units. Loads use the pounds formula: concentration (mg/L) × flow or volume (million gallons) × 8.34 lb per gallon."
    :calc="['engine' => 'wastewater', 'tool' => 'wastewater', 'fields' => ['mode', 'bod', 'flow', 'mlvss', 'volume', 'mlss', 'was', 'was_flow', 'effluent', 'settled']]"
    :how-to="[
        ['name' => 'Choose a calculation', 'text' => 'F/M ratio, sludge age, SVI, detention time or BOD loading.'],
        ['name' => 'Enter the plant values', 'text' => 'Concentrations in mg/L, flows in MGD and volumes in million gallons.'],
    ]"
    :faqs="[
        ['question' => 'What is a good F/M ratio?', 'answer' => 'About 0.2 to 0.5 lb BOD per lb MLVSS per day for conventional activated sludge.'],
        ['question' => 'What sludge age should a plant run?', 'answer' => 'Typically 5 to 15 days; nitrifying plants usually run longer.'],
        ['question' => 'What does a high SVI mean?', 'answer' => 'Above about 150 mL/g the sludge settles poorly, often from filamentous bulking.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" size="sm" :options="['fm' => 'F/M', 'srt' => 'Sludge age', 'svi' => 'SVI', 'detention' => 'Detention', 'bod' => 'BOD load']" selected="fm" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:fm,bod"><x-calc.field name="bod" label="Influent BOD" value="200" min="0" suffix="mg/L" /></div>
        <div data-show-when="mode:fm,srt,detention,bod"><x-calc.field name="flow" label="Flow" value="1.5" min="0" step="0.01" suffix="MGD" /></div>
        <div data-show-when="mode:fm"><x-calc.field name="mlvss" label="MLVSS" value="2200" min="0" suffix="mg/L" /></div>
        <div data-show-when="mode:fm,srt,detention"><x-calc.field name="volume" label="Aeration volume" value="1.2" min="0" step="0.01" suffix="MG" /></div>
        <div data-show-when="mode:srt,svi" hidden><x-calc.field name="mlss" label="MLSS" value="3000" min="0" suffix="mg/L" /></div>
        <div data-show-when="mode:srt" hidden><x-calc.field name="was" label="Waste sludge (WAS)" value="8000" min="0" suffix="mg/L" /></div>
        <div data-show-when="mode:srt" hidden><x-calc.field name="was_flow" label="WAS flow" value="0.04" min="0" step="0.001" suffix="MGD" /></div>
        <div data-show-when="mode:srt" hidden><x-calc.field name="effluent" label="Effluent TSS" value="10" min="0" suffix="mg/L" /></div>
        <div data-show-when="mode:svi" hidden><x-calc.field name="settled" label="30-minute settled volume" value="250" min="0" suffix="mL/L" /></div>
    </div>

    <x-calc.result label="F/M ratio" />

    <x-calc.options :examples="[
        'F/M at 1.5 MGD' => ['mode' => 'fm', 'bod' => 180, 'flow' => 1.5, 'mlvss' => 2400, 'volume' => 1.2],
        'SVI 300 mL / 2,500 mg' => ['mode' => 'svi', 'settled' => 300, 'mlss' => 2500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'food' => ['label' => 'Food or solids load'],
            'micro' => ['label' => 'Microorganisms or solids leaving'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lb = mg/L × MG × 8.34</li>
            <li>F/M = BOD lb/day ÷ MLVSS lb</li>
            <li>SRT = MLSS lb ÷ (WAS lb/day + effluent TSS lb/day)</li>
            <li>SVI = settled mL/L × 1,000 ÷ MLSS mg/L</li>
            <li>detention = volume ÷ flow × 24 h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
