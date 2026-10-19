<x-calc.page
    title="Sleep Debt Calculator - SolveKit"
    description="Free sleep debt calculator: the hours of sleep you are behind over the last nights, compared with your need, and how to catch up."
    lede="Work out your sleep debt."
    about="Sleep debt is the difference between the sleep you need and the sleep you get, added up over recent nights. The AASM and Sleep Research Society advise at least 7 hours a night for adults; teenagers need 8–10. Short sleep builds up, and one long night only partly repays it. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'sleep_debt', 'fields' => ['nights', 'need']]"
    :how-to="[
        ['name' => 'Enter last week\'s sleep', 'text' => ''],
        ['name' => 'Enter how much you need', 'text' => 'Most adults 7–9 hours.'],
    ]"
    :faqs="[
        ['question' => 'What is the sleep debt from 6.5, 7, 5.5, 6, 7.5, 9 and 8 hours with an 8-hour need?', 'answer' => '7.5 h.'],
    ]"
>
    <x-calc.field name="nights" label="Hours slept each night (comma separated)" value="6.5, 7, 5.5, 6, 7.5, 9, 8" type="text" />

    <x-calc.field name="need" label="Hours you need" value="8" min="0" step="any" suffix="h" />

    <x-calc.result label="Sleep debt" />

    <x-calc.options :decimals="false" :examples="[
        'Week' => ['nights' => '6.5, 7, 5.5, 6, 7.5, 9, 8', 'need' => 8],
        'Short week' => ['nights' => '5, 5.5, 6, 5, 6', 'need' => 7.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'average' => ['label' => 'Average'],
            'short' => ['label' => 'Short nights'],
            'recover' => ['label' => 'Catching up'],
            'guideline' => ['label' => 'Guideline'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>debt = Σ max(0, need − slept)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
