<x-calc.page
    title="Fibonacci Retracement Calculator - SolveKit"
    description="Free Fibonacci retracement calculator: 23.6%, 38.2%, 50%, 61.8% and 78.6% retracement levels and extensions from a swing high and low."
    lede="Find Fibonacci retracement levels."
    about="In an uptrend, retracement level = high − (high − low) × ratio; in a downtrend, low + range × ratio. 50% is not a Fibonacci ratio but is widely watched. Traders use the levels as possible support and resistance; they have no guaranteed predictive power. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'fibonacci', 'fields' => ['high', 'low', 'trend']]"
    :how-to="[
        ['name' => 'Enter the swing high and low', 'text' => ''],
        ['name' => 'Choose the trend', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the levels for a move from 100 to 150?', 'answer' => '61.8% at 119.1, 50% at 125.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="high" label="Swing high" value="150" step="0.01" suffix="$" />
        <x-calc.field name="low" label="Swing low" value="100" step="0.01" suffix="$" />
        <x-calc.select name="trend" label="Trend" :options="['up' => 'Uptrend (retracing down)', 'down' => 'Downtrend (bouncing up)']" selected="up" />
    </div>

    <x-calc.result label="61.8% retracement" />

    <x-calc.options :decimals="false" :examples="[
        'Uptrend' => ['high' => 150, 'low' => 100, 'trend' => 'up'],
        'Downtrend' => ['high' => 150, 'low' => 100, 'trend' => 'down'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'r382' => ['label' => '38.2%'],
            'r50' => ['label' => '50%'],
            'r786' => ['label' => '78.6%'],
            'range' => ['label' => 'Range'],
        ]" />
        <x-calc.quick-ref heading="Levels" name="levels" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>level = H − (H − L) × ratio</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
