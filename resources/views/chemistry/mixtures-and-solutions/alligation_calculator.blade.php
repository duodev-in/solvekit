<x-calc.page
    title="Alligation Calculator - SolveKit"
    description="Free alligation calculator: how much of a stronger and a weaker solution to mix for a target strength."
    lede="Find how much of two strengths to mix to reach a target."
    about="Alligation alternate: the parts of the stronger solution equal target − weaker, and the parts of the weaker equal stronger − target. It works for any percent concentration and assumes volumes simply add."
    :calc="['engine' => 'chem-mix', 'tool' => 'alligation', 'fields' => ['high', 'low', 'target', 'total']]"
    :how-to="[
        ['name' => 'Enter the two strengths', 'text' => 'And the strength you want.'],
        ['name' => 'Enter the total', 'text' => 'The amount you want to end up with.'],
    ]"
    :faqs="[
        ['question' => 'What is alligation?', 'answer' => 'A method to mix two strengths into a target strength.'],
        ['question' => 'Can the weaker one be water?', 'answer' => 'Yes, enter 0% for plain diluent.'],
        ['question' => 'Do volumes add exactly?', 'answer' => 'Not always; ethanol and water shrink slightly when mixed.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="high" label="Stronger" value="95" min="0" suffix="%" />
        <x-calc.field name="low" label="Weaker" value="70" min="0" suffix="%" />
        <x-calc.field name="target" label="Target" value="80" min="0" suffix="%" />
    </div>

    <x-calc.field name="total" label="Total amount wanted" value="500" min="0" help="Any unit, e.g. mL or g" />

    <x-calc.result label="Amounts to mix" />

    <x-calc.options :examples="[
        '95% and 70% to 80%' => ['high' => 95, 'low' => 70, 'target' => 80, 'total' => 500],
        'Dilute 30% to 10% with water' => ['high' => 30, 'low' => 0, 'target' => 10, 'total' => 300],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'high' => ['label' => 'Stronger solution'],
            'low' => ['label' => 'Weaker solution'],
            'ratio' => ['label' => 'Ratio'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>parts stronger = target − weaker</li>
            <li>parts weaker = stronger − target</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
