<x-calc.page
    title="Conditional Probability Calculator - SolveKit"
    description="Free conditional probability calculator: P(A|B) from P(A and B) and P(B), or from a table of counts, with an independence check."
    lede="Find a conditional probability."
    about="The probability of A given B is the share of B’s outcomes in which A also happens: P(A|B) = P(A and B) ÷ P(B)."
    :calc="['engine' => 'st-prob', 'tool' => 'conditional', 'fields' => ['mode', 'pAB', 'pB', 'ab', 'anb', 'nab', 'nanb'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(A|B) for P(A and B) = 0.12 and P(B) = 0.3?', 'answer' => '0.4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Given" :options="['probs' => 'P(A and B) and P(B)', 'table' => 'A table of counts']" selected="probs" />
        <div data-show-when="mode:probs">
            <x-calc.field name="pAB" label="P(A and B)" value="0.12" min="0" step="any" />
        </div>
        <div data-show-when="mode:probs">
            <x-calc.field name="pB" label="P(B)" value="0.3" min="0" step="any" />
        </div>
        <div data-show-when="mode:table">
            <x-calc.field name="ab" label="A and B" value="30" min="0" step="any" />
        </div>
        <div data-show-when="mode:table">
            <x-calc.field name="anb" label="A and not B" value="20" min="0" step="any" />
        </div>
        <div data-show-when="mode:table">
            <x-calc.field name="nab" label="not A and B" value="45" min="0" step="any" />
        </div>
        <div data-show-when="mode:table">
            <x-calc.field name="nanb" label="not A and not B" value="105" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="P(A | B)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'probs', 'pAB' => 0.12, 'pB' => 0.3, 'ab' => 30, 'anb' => 20, 'nab' => 45, 'nanb' => 105],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pBA' => ['label' => 'P(B | A)'],
            'pA' => ['label' => 'P(A)'],
            'independent' => ['label' => 'Independence check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
