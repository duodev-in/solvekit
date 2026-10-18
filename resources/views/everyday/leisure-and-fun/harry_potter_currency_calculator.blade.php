<x-calc.page
    title="Harry Potter Currency Calculator - SolveKit"
    description="Free Harry Potter currency calculator: convert between wizarding Galleons, Sickles and Knuts, and to pounds at J.K. Rowling's rough exchange rate."
    lede="Convert Galleons, Sickles and Knuts."
    about="In the wizarding world, 1 Galleon = 17 Sickles and 1 Sickle = 29 Knuts, so a Galleon is 493 Knuts. In 2001 J.K. Rowling said a Galleon was worth about £5, a figure fans still use; there is no official exchange rate."
    :calc="['engine' => 'ev-fun', 'tool' => 'hp_currency', 'fields' => ['amount', 'from']]"
    :how-to="[
        ['name' => 'Enter an amount', 'text' => 'In Galleons, Sickles, Knuts or pounds.'],
    ]"
    :faqs="[
        ['question' => 'How many Knuts in a Galleon?', 'answer' => '493 (17 Sickles × 29 Knuts).'],
        ['question' => 'How much is a Galleon in pounds?', 'answer' => 'About £5, according to J.K. Rowling in 2001.'],
        ['question' => 'How much did Harry\'s wand cost?', 'answer' => 'Seven Galleons: about £35.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="7" min="0" step="any" />
        <x-calc.select name="from" label="Of" :options="['galleon' => 'Galleons', 'sickle' => 'Sickles', 'knut' => 'Knuts', 'gbp' => 'Pounds (£)']" selected="galleon" />
    </div>

    <x-calc.result label="Galleons, Sickles and Knuts" />

    <x-calc.options :decimals="false" :examples="[
        '7 Galleons (a wand)' => ['amount' => 7, 'from' => 'galleon'],
        '100 Sickles' => ['amount' => 100, 'from' => 'sickle'],
        '£50' => ['amount' => 50, 'from' => 'gbp'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'galleons' => ['label' => 'In Galleons'],
            'knuts' => ['label' => 'In Knuts'],
            'gbp' => ['label' => 'In pounds'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 Galleon = 17 Sickles = 493 Knuts</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
