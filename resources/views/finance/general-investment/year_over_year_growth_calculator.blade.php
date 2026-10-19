<x-calc.page
    title="Year Over Year Growth Calculator - SolveKit"
    description="Free Year Over Year Growth Calculator: YoY = (this year − last year) ÷ last year. Year-over-year growth compares the same period a year apart, removing seasonality."
    lede="Work out the year-over-year growth from last year and this year."
    about="Year-over-year growth compares the same period a year apart, removing seasonality. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'year_over_year_growth', 'fields' => ['last', 'this']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Last year, This year.'],
        ['name' => 'Read the result', 'text' => 'The year-over-year growth appears as you type, with change below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the year-over-year growth?', 'answer' => 'YoY = (this year − last year) ÷ last year.'],
        ['question' => 'What is the year-over-year growth for last year 1,500,000, this year 1,725,000?', 'answer' => '15%. Change: 225,000.'],
        ['question' => 'And for last year 320, this year 288?', 'answer' => '−10%. Change: −32.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Use the same months or quarters in both years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="last" label="Last year" value="1500000" step="any" />
        <x-calc.field name="this" label="This year" value="1725000" step="any" />
    </div>

    <x-calc.result label="Year-over-year growth" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['last' => 1500000, 'this' => 1725000],
        'Example B' => ['last' => 320, 'this' => 288],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Change'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>YoY = (this year − last year) ÷ last year</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
