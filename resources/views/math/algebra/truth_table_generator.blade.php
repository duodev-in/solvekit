<x-calc.page
    title="Truth Table Generator - SolveKit"
    description="Free truth table generator: the full truth table of a logic expression (and, or, not, xor, implies, iff), with tautology check and DNF."
    lede="Build a truth table."
    about="Type a logic expression with letters for statements and and/or/not/xor/->/<-> (or ∧ ∨ ¬ ⊕ → ↔). Every combination of true and false is evaluated; the expression is a tautology if it is always true. The disjunctive normal form lists the true rows."
    :calc="['engine' => 'mt-alg2', 'tool' => 'truth_table', 'fields' => ['expr']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Is ((p → q) ∧ ¬q) → ¬p a tautology?', 'answer' => 'Tautology (always true).'],
    ]"
>
    <x-calc.field name="expr" label="Logic expression" value="(p -> q) and not q -> not p" type="text" inputmode="text" />

    <x-calc.result label="Classification" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['expr' => '(p -> q) and not q -> not p'],
        'XOR' => ['expr' => 'p xor q'],
        'Three' => ['expr' => '(a or b) and (not a or c)'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'vars' => ['label' => 'Variables'],
            'dnf' => ['label' => 'Disjunctive normal form'],
            'count' => ['label' => 'True and false rows'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Truth table" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>all 2ⁿ assignments</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
