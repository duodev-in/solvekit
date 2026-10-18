<x-calc.page
    title="Expiration Date Calculator - SolveKit"
    description="Free expiration date calculator: the use-by date from a manufacture or opening date and a shelf life in days, weeks, months or years, and the days left."
    lede="Work out when something expires."
    about="Expiry = the start date (made or opened) + the shelf life. Many cosmetics show a period-after-opening symbol, an open jar marked with months such as 12M. Months are added on the calendar (31 January + 1 month = 28 or 29 February)."
    :calc="['engine' => 'ev-care', 'tool' => 'expiry', 'fields' => ['start', 'on', 'life', 'life_unit']]"
    :how-to="[
        ['name' => 'Enter the start date', 'text' => 'Made or opened.'],
        ['name' => 'Enter the shelf life', 'text' => 'From the label.'],
    ]"
    :faqs="[
        ['question' => 'What does 12M on a cosmetic mean?', 'answer' => 'Use within 12 months of opening.'],
        ['question' => 'When does a product opened 10 April 2026 with 12M expire?', 'answer' => '10 April 2027.'],
        ['question' => 'Is the expiry date a safety date?', 'answer' => 'Follow the label; use-by dates on food are about safety, best-before about quality.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Made or opened on" value="2026-04-10" type="date" />
        <x-calc.field name="on" label="Today" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="life" label="Shelf life" value="12" min="1" step="1" />
        <x-calc.select name="life_unit" label="Unit" :options="['days' => 'days', 'weeks' => 'weeks', 'months' => 'months', 'years' => 'years']" selected="months" />
    </div>

    <x-calc.result label="Use by" />

    <x-calc.options :decimals="false" :examples="[
        'Cream opened, 12M' => ['start' => '2026-04-10', 'on' => '2026-10-18', 'life' => 12, 'life_unit' => 'months'],
        'Medicine, 30 days' => ['start' => '2026-10-01', 'on' => '2026-10-18', 'life' => 30, 'life_unit' => 'days'],
        'Made 2024, 3 years' => ['start' => '2024-02-29', 'on' => '2026-10-18', 'life' => 3, 'life_unit' => 'years'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'left' => ['label' => 'Time left'],
            'status' => ['label' => 'Status'],
            'note' => ['label' => 'Symbol'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>expiry = start + shelf life</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
