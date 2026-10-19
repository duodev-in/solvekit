<x-calc.page
    title="Free Float Calculator - SolveKit"
    description="Free Free Float Calculator: free float = shares outstanding − locked-in shares. Free float is the number of shares available to trade."
    lede="Work out the free float from shares outstanding and locked-in shares (insiders, governments, strategic)."
    about="Free float is the number of shares available to trade. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'free_float', 'fields' => ['outstanding', 'locked']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Shares outstanding, Locked-in shares (insiders, governments, strategic).'],
        ['name' => 'Read the result', 'text' => 'The free float appears as you type, with free float % below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the free float?', 'answer' => 'Free float = shares outstanding − locked-in shares.'],
        ['question' => 'What is the free float for shares outstanding 100,000,000, locked-in shares 35,000,000?', 'answer' => '65,000,000. Free float %: 65%.'],
        ['question' => 'And for shares outstanding 50,000,000, locked-in shares 41,000,000?', 'answer' => '9,000,000. Free float %: 18%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Index providers weight companies by free-float market cap.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="outstanding" label="Shares outstanding" value="100000000" step="any" />
        <x-calc.field name="locked" label="Locked-in shares (insiders, governments, strategic)" value="35000000" step="any" />
    </div>

    <x-calc.result label="Free float" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['outstanding' => 100000000, 'locked' => 35000000],
        'Example B' => ['outstanding' => 50000000, 'locked' => 41000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Free float %'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>free float = shares outstanding − locked-in shares</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
