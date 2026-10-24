<x-calc.page
    title="PTE Score Calculator - SolveKit"
    description="Free PTE score calculator: convert a PTE Academic score to the equivalent IELTS band (Pearson concordance, 2025)."
    lede="Convert PTE to IELTS."
    about="Pearson publishes a concordance between PTE Academic and IELTS Academic scores."
    :calc="['engine' => 'ot-edu', 'tool' => 'pte', 'fields' => ['pte'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'other' => collect(config('other_data'))->only(['pte_ielts'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What IELTS band matches PTE 65?', 'answer' => 'IELTS 7.'],
    ]"
>
    <x-calc.field name="pte" label="PTE Academic overall score (10–90)" value="65" min="10" step="any" />

    <x-calc.result label="Equivalent IELTS band" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pte' => 65],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'PTE range for that band'],
            'next' => ['label' => 'Score for the next band'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Pearson concordance (July 2025)" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
