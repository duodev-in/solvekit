<x-calc.page
    title="Safety Stock Calculator - SolveKit"
    description="Free safety stock calculator: buffer stock for a service level from demand variability and lead time (and lead-time variability), with the reorder point."
    lede="Work out safety stock and reorder point."
    about="Safety stock = Z × √(L × σd² + d² × σL²), where d is average daily demand, σd its standard deviation, L the lead time in days and σL its standard deviation; Z comes from the service level (1.645 for 95%). Reorder point = d × L + safety stock. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'safety_stock', 'fields' => ['demand', 'sd', 'lead', 'sd_lead', 'service']]"
    :how-to="[
        ['name' => 'Enter demand and its variability', 'text' => ''],
        ['name' => 'Enter lead time and service level', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What safety stock gives 95% service with 40 ± 12 a day and a 7 ± 1.5-day lead time?', 'answer' => '112 units; reorder at 392 units.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="demand" label="Average daily demand" value="40" min="0" step="any" />
        <x-calc.field name="sd" label="Standard deviation of daily demand" value="12" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lead" label="Lead time" value="7" min="0" step="any" suffix="days" />
        <x-calc.field name="sd_lead" label="Standard deviation of lead time" value="1.5" min="0" step="any" suffix="days" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="service" label="Service level" :options="['90' => '90%', '95' => '95%', '97.5' => '97.5%', '98' => '98%', '99' => '99%', '99.9' => '99.9%']" selected="95" />
    </div>

    <x-calc.result label="Safety stock" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['demand' => 40, 'sd' => 12, 'lead' => 7, 'sd_lead' => 1.5, 'service' => '95'],
        'Steady supplier' => ['demand' => 40, 'sd' => 12, 'lead' => 7, 'sd_lead' => 0, 'service' => '99'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rop' => ['label' => 'Reorder point'],
            'lead' => ['label' => 'Demand during lead time'],
            'formula' => ['label' => 'Formula used'],
            'days' => ['label' => 'Days of cover'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SS = Z √(L σd² + d² σL²)</li>
            <li>ROP = d L + SS</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
