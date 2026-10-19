<x-calc.page
    title="Prescription Refill Calculator - SolveKit"
    description="Free prescription refill calculator: when a prescription runs out and the earliest date you can usually refill it, from the fill date, quantity and daily use."
    lede="Find when to refill a prescription."
    about="Days supply = quantity ÷ units used a day; the medicine runs out that many days after it was filled. Many US insurers allow a refill once about 75–80% of the supply is used (often stricter for controlled substances), so the earliest refill is about fill date + 0.8 × days supply. Check your plan and pharmacy. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'refill', 'fields' => ['filled', 'quantity', 'per_day', 'window', 'today']]"
    :how-to="[
        ['name' => 'Enter the fill date and quantity', 'text' => ''],
        ['name' => 'Enter daily use and the refill rule', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When do 90 tablets at 3 a day filled on 1 October 2026 run out?', 'answer' => 'Oct 31, 2026 (30-day supply; earliest refill about Oct 25, 2026 (80% used)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="filled" label="Filled on" value="2026-10-01" type="date" />
        <x-calc.field name="quantity" label="Quantity" value="90" min="0" step="1" />
        <x-calc.field name="per_day" label="Used a day" value="3" min="0" step="0.5" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="window" label="Refill allowed after" :options="['75' => '75% used', '80' => '80% used', '85' => '85% used', '90' => '90% used']" selected="80" />
        <x-calc.field name="today" label="As of" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <x-calc.result label="Runs out on" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['filled' => '2026-10-01', 'quantity' => 90, 'per_day' => 3, 'window' => '80', 'today' => '2026-10-19'],
        'Monthly' => ['filled' => '2026-09-25', 'quantity' => 30, 'per_day' => 1, 'window' => '75', 'today' => '2026-10-19'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'supply' => ['label' => 'Days supply'],
            'earliest' => ['label' => 'Earliest refill'],
            'left' => ['label' => 'Left now'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>run-out = fill + quantity ÷ daily use</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
