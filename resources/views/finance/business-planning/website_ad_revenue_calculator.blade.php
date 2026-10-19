<x-calc.page
    title="Website Ad Revenue Calculator - SolveKit"
    description="Free website ad revenue calculator: monthly and yearly display ad revenue from page views and your RPM."
    lede="Estimate website ad revenue."
    about="Revenue = page views ÷ 1,000 × RPM (revenue per thousand page views). Ad networks such as Mediavine or Raptive report RPMs of roughly $10–40 for US-heavy traffic; AdSense is usually lower. Use your own RPM. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'ad_revenue', 'fields' => ['views', 'rpm']]"
    :how-to="[
        ['name' => 'Enter monthly page views', 'text' => ''],
        ['name' => 'Enter your RPM', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What do 150,000 page views earn at a $15 RPM?', 'answer' => '$2,250.00 a month.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="views" label="Page views a month" value="150000" min="0" step="1" />
        <x-calc.field name="rpm" label="RPM" value="15" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Estimated revenue a month" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['views' => 150000, 'rpm' => 15],
        'Small blog' => ['views' => 20000, 'rpm' => 6],
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
            <li>revenue = views ÷ 1,000 × RPM</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
