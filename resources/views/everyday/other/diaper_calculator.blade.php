<x-calc.page
    title="Diaper Calculator - SolveKit"
    description="Free diaper calculator: how many diapers a baby needs from one age to another, and what they cost."
    lede="Work out how many diapers your baby will need."
    about="Diapers = changes a day × days at each age. Newborns are often changed 10 or more times a day, falling to about 6–8 by the toddler years; the defaults are typical of diaper makers' guides and you can change them. Most children are potty trained between about 2 and 3 years old."
    :calc="['engine' => 'ev-care', 'tool' => 'diapers', 'fields' => ['from', 'to', 'band1', 'band2', 'band3', 'band4', 'price']]"
    :how-to="[
        ['name' => 'Enter the age range', 'text' => 'In months.'],
        ['name' => 'Adjust changes a day', 'text' => 'And the price per diaper.'],
    ]"
    :faqs="[
        ['question' => 'How many diapers does a baby use in the first year?', 'answer' => 'About 2,900 at these settings.'],
        ['question' => 'How many diapers until potty training?', 'answer' => 'About 6,200 by 30 months at these settings.'],
        ['question' => 'How many newborn diapers do I need?', 'answer' => 'About 300 for the first month at 10 a day.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="from" label="From age" value="0" min="0" max="48" step="1" suffix="months" />
        <x-calc.field name="to" label="To age" value="30" min="1" max="48" step="1" suffix="months" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="band1" label="Changes a day, 0–1 month" value="10" min="0" step="1" />
        <x-calc.field name="band2" label="1–5 months" value="9" min="0" step="1" />
        <x-calc.field name="band3" label="5–12 months" value="7" min="0" step="1" />
        <x-calc.field name="band4" label="12+ months" value="6" min="0" step="1" />
    </div>

    <x-calc.field name="price" label="Price per diaper" value="0.25" min="0" step="0.01" suffix="$" />

    <x-calc.result label="Diapers needed" />

    <x-calc.options :decimals="false" :examples="[
        'Birth to 30 months' => ['from' => 0, 'to' => 30, 'band1' => 10, 'band2' => 9, 'band3' => 7, 'band4' => 6, 'price' => 0.25],
        'First year' => ['from' => 0, 'to' => 12, 'band1' => 10, 'band2' => 9, 'band3' => 7, 'band4' => 6, 'price' => 0.25],
        'Toddler 18–36 months' => ['from' => 18, 'to' => 36, 'band1' => 10, 'band2' => 9, 'band3' => 7, 'band4' => 5, 'price' => 0.3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cost' => ['label' => 'Cost'],
            'boxes' => ['label' => 'Boxes'],
        ]" />
        <x-calc.quick-ref heading="By age" name="bands" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>diapers = Σ months × 30.44 × changes a day</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
