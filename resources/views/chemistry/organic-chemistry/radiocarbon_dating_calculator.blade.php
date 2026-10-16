<x-calc.page
    title="Radiocarbon Dating Calculator (Carbon 14 Dating) - SolveKit"
    description="Free radiocarbon dating calculator: conventional radiocarbon age from percent modern carbon, F14C or activity ratio."
    lede="Work out a radiocarbon age from the carbon-14 remaining."
    about="By international convention the conventional radiocarbon age uses the Libby half-life of 5568 years: t = −8033 ln F, in years before present (1950). The age with the measured half-life (5700 years, NUBASE2020) is shown too. Converting to calendar years needs a calibration curve such as IntCal20, which this tool does not apply."
    :calc="['engine' => 'chem-organic', 'tool' => 'radiocarbon', 'fields' => ['input', 'value', 'modern']]"
    :how-to="[
        ['name' => 'Enter the measurement', 'text' => 'Percent modern carbon, F¹⁴C or activity.'],
    ]"
    :faqs="[
        ['question' => 'Why use 5568 years?', 'answer' => 'Conventional radiocarbon ages keep Libby\'s value so results stay comparable.'],
        ['question' => 'Is this the calendar age?', 'answer' => 'No, it must be calibrated, because atmospheric ¹⁴C has varied over time.'],
        ['question' => 'How far back does it work?', 'answer' => 'About 50,000 years, after which too little ¹⁴C remains.'],
    ]"
>
    <x-calc.segmented name="input" legend="Measured as" :options="['percent' => 'Percent modern', 'fraction' => 'F¹⁴C', 'activity' => 'Activity']" selected="percent" />

    <x-calc.field name="value" label="Value" value="50" min="0" />

    <div data-show-when="input:activity" hidden>
        <x-calc.field name="modern" label="Modern activity" value="13.56" min="0" help="Same unit as the sample, e.g. dpm/g C" />
    </div>

    <x-calc.result label="Radiocarbon age" />

    <x-calc.options :examples="[
        '50% modern' => ['input' => 'percent', 'value' => 50],
        'F¹⁴C = 0.25' => ['input' => 'fraction', 'value' => 0.25],
        'Activity 6.78 of 13.56' => ['input' => 'activity', 'value' => 6.78, 'modern' => 13.56],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'decay' => ['label' => 'Physical decay age'],
            'fraction' => ['label' => 'Carbon-14 remaining'],
            'halves' => ['label' => 'Half-lives elapsed'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>conventional age t = −8033 ln F (BP)</li>
            <li>decay age t = −(5700 ÷ ln 2) ln F</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
