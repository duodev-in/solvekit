<x-calc.page
    title="Bayes' Theorem Calculator - SolveKit"
    description="Free Bayes' theorem calculator: P(A|B) from the prior P(A) and the likelihoods P(B|A) and P(B|not A), with the full probability tree."
    lede="Apply Bayes' theorem."
    about="Bayes' theorem updates a prior probability with new evidence: P(A|B) = P(B|A)·P(A) ÷ P(B), where P(B) adds both ways B can happen."
    :calc="['engine' => 'st-prob', 'tool' => 'bayes', 'fields' => ['pA', 'pBA', 'pBnA'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(A|B) in the example?', 'answer' => '0.102041.'],
        ['question' => 'Why is the answer so low when the test is accurate?', 'answer' => 'Because A is rare: most cases of B come from the much larger group without A.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pA" label="P(A), the prior" value="0.01" min="0" step="any" />
        <x-calc.field name="pBA" label="P(B | A)" value="0.9" min="0" step="any" />
        <x-calc.field name="pBnA" label="P(B | not A)" value="0.08" min="0" step="any" />
    </div>

    <x-calc.result label="P(A | B)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pA' => 0.01, 'pBA' => 0.9, 'pBnA' => 0.08],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pB' => ['label' => 'P(B)'],
            'pAnB' => ['label' => 'P(A | not B)'],
            'lr' => ['label' => 'Likelihood ratio P(B|A) ÷ P(B|not A)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="The four branches" name="tree" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
