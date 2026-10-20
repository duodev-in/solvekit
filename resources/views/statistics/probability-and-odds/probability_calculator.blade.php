<x-calc.page
    title="Probability Calculator - SolveKit"
    description="Free probability calculator: P(A and B), P(A or B), complements and conditional probability for two events, with a Venn diagram."
    lede="Combine two probabilities."
    about="For two events the addition rule gives P(A or B) = P(A) + P(B) − P(A and B), and the multiplication rule gives P(A and B). Also known as AND Probability Calculator, OR Probability Calculator and Probability Fraction Calculator."
    :calc="['engine' => 'st-prob', 'tool' => 'probability', 'fields' => ['pA', 'pB', 'relation', 'pAB'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(A or B) for independent events with 0.5 and 0.3?', 'answer' => '0.65.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pA" label="P(A)" value="0.5" min="0" step="any" />
        <x-calc.field name="pB" label="P(B)" value="0.3" min="0" step="any" />
        <x-calc.select name="relation" label="A and B are" :options="['independent' => 'Independent', 'exclusive' => 'Mutually exclusive', 'given' => 'I know P(A and B)']" selected="independent" />
        <div data-show-when="relation:given">
            <x-calc.field name="pAB" label="P(A and B)" value="0.1" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="P(A and B)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pA' => 0.5, 'pB' => 0.3, 'relation' => 'independent', 'pAB' => 0.1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Probabilities of each region" name="venn" />
        <x-calc.rows heading="Details" :rows="[
            'or' => ['label' => 'P(A or B)'],
            'notA' => ['label' => 'P(not A)'],
            'notB' => ['label' => 'P(not B)'],
            'xor' => ['label' => 'P(exactly one)'],
            'neither' => ['label' => 'P(neither)'],
            'aGivenB' => ['label' => 'P(A | B)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
