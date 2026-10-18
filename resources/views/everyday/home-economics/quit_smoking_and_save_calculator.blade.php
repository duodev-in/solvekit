<x-calc.page
    title="Quit Smoking And Save Calculator - SolveKit"
    description="Free quit smoking calculator: money saved by quitting cigarettes per month, per year and over the years, and cigarettes not smoked."
    lede="See how much money you save by quitting smoking."
    about="Savings = packs a day × price × 365.25 days. A pack-a-day smoker paying $9 a pack spends about $3,300 a year. Quitting at any age improves health; support is available from smokefree.gov and 1-800-QUIT-NOW in the US."
    :calc="['engine' => 'ev-home', 'tool' => 'quit_smoking', 'fields' => ['unit', 'per_day', 'price', 'per_pack', 'years']]"
    :how-to="[
        ['name' => 'Enter how much you smoke', 'text' => 'Packs or cigarettes a day.'],
        ['name' => 'Enter the price', 'text' => 'And years ahead.'],
    ]"
    :faqs="[
        ['question' => 'How much does a pack a day cost a year?', 'answer' => 'About $3,287 at $9 a pack.'],
        ['question' => 'How much in 10 years?', 'answer' => 'About $32,900.'],
        ['question' => 'Where can I get help quitting?', 'answer' => 'smokefree.gov or 1-800-QUIT-NOW in the US.'],
    ]"
>
    <x-calc.segmented name="unit" legend="Count in" :options="['packs' => 'Packs', 'cigarettes' => 'Cigarettes']" selected="packs" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="per_day" label="A day" value="1" min="0" step="0.5" />
        <x-calc.field name="price" label="Price per pack" value="9" min="0" step="0.01" suffix="$" />
        <x-calc.field name="per_pack" label="Cigarettes per pack" value="20" min="1" step="1" />
    </div>

    <x-calc.field name="years" label="Years" value="10" min="1" step="1" />

    <x-calc.result label="Saved a year" />

    <x-calc.options :decimals="false" :examples="[
        'Pack a day, $9' => ['unit' => 'packs', 'per_day' => 1, 'price' => 9, 'per_pack' => 20, 'years' => 10],
        '10 cigarettes a day' => ['unit' => 'cigarettes', 'per_day' => 10, 'price' => 12, 'per_pack' => 20, 'years' => 5],
        'Two packs' => ['unit' => 'packs', 'per_day' => 2, 'price' => 8, 'per_pack' => 20, 'years' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'month' => ['label' => 'Per month'],
            'total' => ['label' => 'Over the years'],
            'cigarettes' => ['label' => 'Not smoked'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>saved = packs a day × price × 365.25</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
