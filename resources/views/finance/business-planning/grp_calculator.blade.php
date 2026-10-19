<x-calc.page
    title="GRP Calculator - SolveKit"
    description="Free GRP Calculator: GRP = reach (%) × frequency. Gross rating points measure the size of an advertising campaign: 60% reach seen 3 times is 180 GRPs."
    lede="Work out the gross rating points from reach and average frequency."
    about="Gross rating points measure the size of an advertising campaign: 60% reach seen 3 times is 180 GRPs. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'grp', 'fields' => ['reach', 'frequency']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Reach, Average frequency.'],
        ['name' => 'Read the result', 'text' => 'The gross rating points appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the gross rating points?', 'answer' => 'GRP = reach (%) × frequency.'],
        ['question' => 'What is the gross rating points for reach 60%, average frequency 3?', 'answer' => '180.'],
        ['question' => 'And for reach 45%, average frequency 4.5?', 'answer' => '202.5.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Target rating points (TRPs) are the same measure for a target audience.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="reach" label="Reach" value="60" step="any" suffix="%" />
        <x-calc.field name="frequency" label="Average frequency" value="3" step="any" />
    </div>

    <x-calc.result label="Gross rating points" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['reach' => 60, 'frequency' => 3],
        'Example B' => ['reach' => 45, 'frequency' => 4.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GRP = reach (%) × frequency</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
