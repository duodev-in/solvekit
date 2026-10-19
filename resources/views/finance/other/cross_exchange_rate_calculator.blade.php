<x-calc.page
    title="Cross Exchange Rate Calculator - SolveKit"
    description="Free Cross Exchange Rate Calculator: A/C = A/B × B/C. A cross rate links two currencies through a third, usually the US dollar."
    lede="Work out the cross rate A in C from rate A in B (e.g. EUR→USD) and rate B in C (e.g. USD→JPY)."
    about="A cross rate links two currencies through a third, usually the US dollar. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cross_exchange_rate', 'fields' => ['ab', 'bc']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Rate A in B (e.g. EUR→USD), Rate B in C (e.g. USD→JPY).'],
        ['name' => 'Read the result', 'text' => 'The cross rate A in C appears as you type, with inverse (C in A) below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the cross rate A in C?', 'answer' => 'A/C = A/B × B/C.'],
        ['question' => 'What is the cross rate A in C for rate A in B 1.08, rate B in C 150?', 'answer' => '162. Inverse (C in A): 0.006173.'],
        ['question' => 'And for rate A in B 1.27, rate B in C 83.2?', 'answer' => '105.66. Inverse (C in A): 0.009464.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Enter current rates; the result is only as fresh as they are.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ab" label="Rate A in B (e.g. EUR→USD)" value="1.08" step="any" />
        <x-calc.field name="bc" label="Rate B in C (e.g. USD→JPY)" value="150" step="any" />
    </div>

    <x-calc.result label="Cross rate A in C" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ab' => 1.08, 'bc' => 150],
        'Example B' => ['ab' => 1.27, 'bc' => 83.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Inverse (C in A)'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A/C = A/B × B/C</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
