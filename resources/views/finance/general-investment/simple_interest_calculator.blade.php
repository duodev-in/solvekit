<x-calc.page
    title="Simple Interest Calculator - SolveKit"
    description="Free Simple Interest Calculator: I = P × r × t. Simple interest is paid only on the principal, never on earlier interest."
    lede="Work out the interest from principal, annual rate and years."
    about="Simple interest is paid only on the principal, never on earlier interest. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'simple_interest', 'fields' => ['principal', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Principal, Annual rate, Years.'],
        ['name' => 'Read the result', 'text' => 'The interest appears as you type, with total below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the interest?', 'answer' => 'I = P × r × t.'],
        ['question' => 'What is the interest for principal $10,000, annual rate 5%, years 3?', 'answer' => '$1,500.00. Total: $11,500.00.'],
        ['question' => 'And for principal $750, annual rate 12%, years 0.5?', 'answer' => '$45.00. Total: $795.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compound interest grows faster over long periods.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="principal" label="Principal" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual rate" value="5" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="3" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Interest" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['principal' => 10000, 'rate' => 5, 'years' => 3],
        'Example B' => ['principal' => 750, 'rate' => 12, 'years' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Total'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>I = P × r × t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
