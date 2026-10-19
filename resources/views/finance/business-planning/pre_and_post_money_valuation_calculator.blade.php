<x-calc.page
    title="Pre and Post Money Valuation Calculator - SolveKit"
    description="Free Pre and Post Money Valuation Calculator: post = pre + investment. Post-money valuation is the company's value right after the new money arrives."
    lede="Work out the post-money valuation from pre-money valuation and investment."
    about="Post-money valuation is the company's value right after the new money arrives. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'pre_and_post_money_valuation', 'fields' => ['pre', 'investment']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Pre-money valuation, Investment.'],
        ['name' => 'Read the result', 'text' => 'The post-money valuation appears as you type, with investor ownership, existing owners keep below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the post-money valuation?', 'answer' => 'Post = pre + investment; investor stake = investment ÷ post.'],
        ['question' => 'What is the post-money valuation for pre-money valuation $4,000,000, investment $1,000,000?', 'answer' => '$5,000,000.00. Investor ownership: 20%.'],
        ['question' => 'And for pre-money valuation $8,000,000, investment $2,000,000?', 'answer' => '$10,000,000.00. Investor ownership: 20%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Founders\' ownership falls by the investor\'s stake.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pre" label="Pre-money valuation" value="4000000" step="0.01" suffix="$" />
        <x-calc.field name="investment" label="Investment" value="1000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Post-money valuation" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['pre' => 4000000, 'investment' => 1000000],
        'Example B' => ['pre' => 8000000, 'investment' => 2000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Investor ownership'],
            'r2' => ['label' => 'Existing owners keep'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>post = pre + investment</li>
            <li>investor stake = investment ÷ post</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
