<x-calc.page
    title="Expected Utility Calculator - SolveKit"
    description="Free expected utility calculator: expected utility of a gamble with linear, log or power (CRRA) utility, certainty equivalent and risk premium."
    lede="Value a risky choice with a utility function."
    about="Expected utility EU = Σ p U(W + x), where W is your wealth. Log and power utility (U = W^(1−γ) ÷ (1 − γ)) model risk aversion: the certainty equivalent, the sure amount with the same utility, is below the expected value. The gap is the risk premium. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'expected_utility', 'fields' => ['outcomes', 'wealth', 'utility', 'gamma']]"
    :how-to="[
        ['name' => 'List the outcomes', 'text' => 'Probability and gain or loss.'],
        ['name' => 'Pick a utility', 'text' => 'And your wealth.'],
    ]"
    :faqs="[
        ['question' => 'Is a 50/50 bet of +$10,000 or −$5,000 worth it with $50,000 and log utility?', 'answer' => 'Certainty equivalent $1,961.52, against an expected value of $2,500.00.'],
        ['question' => 'And with power utility γ = 5?', 'answer' => 'Certainty equivalent −$39.99.'],
    ]"
>
    <x-calc.rows-editor name="outcomes" label="Outcomes" :columns="['p' => 'Probability %', 'x' => 'Gain or loss']" :rows="[[50, 10000], [50, -5000]]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="wealth" label="Your wealth" value="50000" step="0.01" suffix="$" />
        <x-calc.select name="utility" label="Utility" :options="['log' => 'Log', 'power' => 'Power (CRRA)', 'linear' => 'Linear (risk-neutral)']" selected="log" />
        <x-calc.field name="gamma" label="Risk aversion γ (power)" value="2" min="0" step="any" />
    </div>

    <x-calc.result label="Certainty equivalent" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['outcomes' => '50 10000
50 -5000', 'wealth' => 50000, 'utility' => 'log', 'gamma' => 2],
        'Very cautious' => ['outcomes' => '50 10000
50 -5000', 'wealth' => 50000, 'utility' => 'power', 'gamma' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'eu' => ['label' => 'Expected utility'],
            'ev' => ['label' => 'Expected value'],
            'premium' => ['label' => 'Risk premium'],
            'verdict' => ['label' => 'Verdict'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EU = Σ p U(W + x)</li>
            <li>U = ln W or W^(1−γ) ÷ (1 − γ)</li>
            <li>CE = U⁻¹(EU) − W</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
