<x-calc.page
    title="Interest Per Day Calculator - SolveKit"
    description="Free Interest Per Day Calculator: daily interest = balance × rate ÷ 365. Simple daily interest (per diem) on a balance, as lenders use for payoff quotes."
    lede="Work out the interest per day from balance, annual rate and days in the year."
    about="Simple daily interest (per diem) on a balance, as lenders use for payoff quotes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'interest_per_day', 'fields' => ['balance', 'rate', 'basis']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Balance, Annual rate, Days in the year.'],
        ['name' => 'Read the result', 'text' => 'The interest per day appears as you type, with for 30 days below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the interest per day?', 'answer' => 'Daily interest = balance × rate ÷ 365.'],
        ['question' => 'What is the interest per day for balance $10,000, annual rate 7.5%, days in the year 365 days?', 'answer' => '$2.05. For 30 days: $61.64.'],
        ['question' => 'And for balance $245,000, annual rate 6.25%, days in the year 365 days?', 'answer' => '$41.95. For 30 days: $1,258.56.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Some lenders use a 360-day year, which charges slightly more.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="balance" label="Balance" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual rate" value="7.5" step="any" suffix="%" />
        <x-calc.select name="basis" label="Days in the year" :options="['360' => '360 days', '365' => '365 days']" selected="365" />
    </div>

    <x-calc.result label="Interest per day" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['balance' => 10000, 'rate' => 7.5, 'basis' => '365'],
        'Example B' => ['balance' => 245000, 'rate' => 6.25, 'basis' => '365'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'For 30 days'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>daily interest = balance × rate ÷ 365</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
