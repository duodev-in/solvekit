<x-calc.page
    title="Dating Theory Calculator - SolveKit"
    description="Free dating theory calculator: the 37% rule (optimal stopping) for choosing the best partner."
    lede="Apply the 37% rule."
    about="The optimal stopping rule says: see about 37% of the options, then pick the next one better than all of them."
    :calc="['engine' => 'ot-play', 'tool' => 'dating_theory', 'fields' => ['n'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many of 20 should you skip?', 'answer' => '7 candidates.'],
    ]"
>
    <x-calc.field name="n" label="Candidates you could meet" value="20" min="1" step="any" />

    <x-calc.result label="Reject the first" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'chance' => ['label' => 'Chance of choosing the very best'],
            'then' => ['label' => 'Then choose'],
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
