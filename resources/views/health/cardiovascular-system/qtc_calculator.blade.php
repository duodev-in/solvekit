<x-calc.page
    title="QTc Calculator - SolveKit"
    description="Free QTc calculator: corrected QT interval by the Bazett, Fridericia, Framingham and Hodges formulas from QT and heart rate or RR, with the prolonged thresholds."
    lede="Correct the QT interval for heart rate."
    about="QT shortens as heart rate rises, so it is corrected to a rate of 60. Bazett QTc = QT ÷ √RR; Fridericia QT ÷ ∛RR; Framingham QT + 154 × (1 − RR); Hodges QT + 1.75 × (HR − 60), with RR in seconds. Bazett over-corrects at fast rates. QTc over 450 ms in men or 460 ms in women is prolonged, and over 500 ms markedly so. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'qtc', 'fields' => ['qt', 'formula', 'input', 'hr', 'rr', 'sex']]"
    :how-to="[
        ['name' => 'Enter QT', 'text' => 'Measured in lead II or V5.'],
        ['name' => 'Enter heart rate or RR', 'text' => ''],
        ['name' => 'Choose the formula', 'text' => 'Fridericia is preferred by many.'],
    ]"
    :faqs="[
        ['question' => 'What is the QTc for QT 400 ms at 80 bpm (Fridericia)?', 'answer' => '440 ms: Normal.'],
        ['question' => 'And by Bazett?', 'answer' => '462 ms.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="qt" label="QT interval" value="400" min="0" step="1" suffix="ms" />
        <x-calc.select name="formula" label="Formula" :options="['bazett' => 'Bazett', 'fridericia' => 'Fridericia', 'framingham' => 'Framingham', 'hodges' => 'Hodges']" selected="fridericia" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.segmented name="input" legend="Rate as" :options="['hr' => 'Heart rate', 'rr' => 'RR interval']" selected="hr" />
        <div data-show-when="input:hr">
            <x-calc.field name="hr" label="Heart rate" value="80" min="0" max="300" step="1" suffix="bpm" />
        </div>
        <div data-show-when="input:rr" hidden>
            <x-calc.field name="rr" label="RR interval" value="750" min="0" step="1" suffix="ms" />
        </div>
    </div>

    <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />

    <x-calc.result label="QTc" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['qt' => 400, 'formula' => 'fridericia', 'input' => 'hr', 'hr' => 80, 'rr' => 750, 'sex' => 'male'],
        'Bazett' => ['qt' => 400, 'formula' => 'bazett', 'input' => 'hr', 'hr' => 80, 'rr' => 750, 'sex' => 'male'],
        'Long' => ['qt' => 480, 'formula' => 'fridericia', 'input' => 'rr', 'hr' => 80, 'rr' => 900, 'sex' => 'female'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Interpretation'],
            'hr' => ['label' => 'Heart rate'],
        ]" />
        <x-calc.grid heading="All formulas" name="formulas" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Bazett: QT ÷ √RR</li>
            <li>Fridericia: QT ÷ ∛RR</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
