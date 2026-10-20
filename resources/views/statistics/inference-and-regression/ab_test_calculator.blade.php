<x-calc.page
    title="AB Test Calculator - SolveKit"
    description="Free A/B test calculator: is variant B’s conversion rate significantly different from A’s? p-value, uplift and confidence interval."
    lede="Check an A/B test."
    about="An A/B test compares two conversion rates with a two-proportion z-test."
    :calc="['engine' => 'st-inf', 'tool' => 'ab_test', 'fields' => ['nA', 'cA', 'nB', 'cB', 'conf', 'tail'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'Is the example difference significant?', 'answer' => 'p = 0.03235: The difference is unlikely to be chance.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nA" label="Visitors to A (control)" value="5000" min="1" step="any" />
        <x-calc.field name="cA" label="Conversions in A" value="400" min="0" step="any" />
        <x-calc.field name="nB" label="Visitors to B (variant)" value="5000" min="1" step="any" />
        <x-calc.field name="cB" label="Conversions in B" value="460" min="0" step="any" />
        <x-calc.field name="conf" label="Confidence level (%)" value="95" min="0" step="any" />
        <x-calc.select name="tail" label="Test" :options="['two' => 'Two-sided (B ≠ A)', 'right' => 'One-sided (B > A)']" selected="two" />
    </div>

    <x-calc.result label="p-value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['nA' => 5000, 'cA' => 400, 'nB' => 5000, 'cB' => 460, 'conf' => 95, 'tail' => 'two'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rates' => ['label' => 'Conversion rates A and B'],
            'uplift' => ['label' => 'Relative uplift'],
            'ci' => ['label' => 'Difference B − A (CI)'],
            'z' => ['label' => 'z'],
            'verdict' => ['label' => 'Result'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
