<x-calc.page
    title="YouTube Money Calculator - SolveKit"
    description="Free YouTube earnings estimator: monthly and yearly income from views, the share of monetized views and your RPM."
    lede="Estimate YouTube earnings."
    about="Earnings ≈ views ÷ 1,000 × RPM × monetized share. RPM is what you receive per 1,000 views after YouTube's 45% share; it ranges from under $1 to over $15 depending on topic, audience country and season. Shorts pay much less. Use the RPM in YouTube Studio. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'ad_revenue', 'fields' => ['views', 'monetized', 'rpm']]"
    :how-to="[
        ['name' => 'Enter monthly views', 'text' => ''],
        ['name' => 'Enter your RPM and monetized share', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What do 500,000 views a month earn at a $4 RPM?', 'answer' => '$1,200.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="views" label="Views a month" value="500000" min="0" step="1" />
        <x-calc.field name="monetized" label="Monetized views" value="60" step="any" suffix="%" />
        <x-calc.field name="rpm" label="RPM (from YouTube Studio)" value="4" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Estimated revenue a month" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['views' => 500000, 'monetized' => 60, 'rpm' => 4],
        'Finance channel' => ['views' => 200000, 'monetized' => 80, 'rpm' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'year' => ['label' => 'A year'],
            'day' => ['label' => 'A day'],
            'per1000' => ['label' => 'Per 1,000 views'],
            'range' => ['label' => 'Range'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>earnings = views ÷ 1,000 × share × RPM</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
