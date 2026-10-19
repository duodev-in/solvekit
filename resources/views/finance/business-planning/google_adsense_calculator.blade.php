<x-calc.page
    title="Google AdSense Calculator - SolveKit"
    description="Free AdSense earnings estimator: daily, monthly and yearly revenue from your page views and your own page RPM or CTR and CPC."
    lede="Estimate AdSense earnings from your traffic."
    about="Earnings = page views ÷ 1,000 × page RPM, or page views × CTR × CPC. Use the RPM from your own AdSense reports; it varies widely by topic, country and season (from under $1 to over $30). Figures are estimates. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'adsense', 'fields' => ['mode', 'views', 'rpm', 'ctr', 'cpc']]"
    :how-to="[
        ['name' => 'Enter daily page views', 'text' => ''],
        ['name' => 'Enter your RPM, or CTR and CPC', 'text' => 'From your AdSense reports.'],
    ]"
    :faqs="[
        ['question' => 'What do 5,000 page views a day earn at a $4 RPM?', 'answer' => '$608.75 a month.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Estimate from" :options="['rpm' => 'Page RPM', 'cpc' => 'CTR and CPC']" selected="rpm" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="views" label="Page views a day" value="5000" min="0" step="1" />
        <x-calc.field name="rpm" label="Page RPM" value="4" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ctr" label="Ad CTR" value="1.2" step="any" suffix="%" />
        <x-calc.field name="cpc" label="Average CPC" value="0.35" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Estimated earnings a month" />

    <x-calc.options :decimals="false" :examples="[
        'RPM' => ['mode' => 'rpm', 'views' => 5000, 'rpm' => 4, 'ctr' => '', 'cpc' => ''],
        'CTR and CPC' => ['mode' => 'cpc', 'views' => 5000, 'rpm' => '', 'ctr' => 1.2, 'cpc' => 0.35],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'day' => ['label' => 'A day'],
            'year' => ['label' => 'A year'],
            'rpm' => ['label' => 'Page RPM'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>earnings = views ÷ 1,000 × RPM</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
