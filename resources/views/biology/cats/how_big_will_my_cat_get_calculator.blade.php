<x-calc.page
    title="How Big Will My Cat Get Calculator - SolveKit"
    description="Free kitten growth calculator: estimate your kitten's adult weight from its current weight and age."
    lede="Estimate how big your kitten will grow."
    about="Kittens gain roughly 1 lb (450 g) a month and reach about half their adult weight by 6 months. This uses an approximate growth curve for an average domestic cat; males, and large breeds such as Maine Coons, grow bigger and for longer."
    :calc="['engine' => 'pets', 'tool' => 'kitten_size', 'fields' => ['weight_unit', 'weight', 'weeks']]"
    :how-to="[
        ['name' => 'Weigh your kitten', 'text' => 'Kitchen scales work well.'],
        ['name' => 'Enter the age', 'text' => 'In weeks.'],
    ]"
    :faqs="[
        ['question' => 'How big will my kitten get?', 'answer' => 'Most domestic cats weigh 8 to 11 lb (3.5 to 5 kg) as adults.'],
        ['question' => 'When is a cat fully grown?', 'answer' => 'Usually 12 to 18 months; large breeds later.'],
        ['question' => 'Do male cats grow bigger?', 'answer' => 'Yes, often 1 to 3 lb heavier.'],
    ]"
>
    <x-calc.segmented name="weight_unit" legend="Unit" :options="['lb' => 'lb', 'kg' => 'kg']" selected="lb" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Current weight" value="3" min="0" />
        <x-calc.field name="weeks" label="Age" value="16" min="4" max="64" suffix="weeks" />
    </div>

    <x-calc.result label="Estimated adult weight" />

    <x-calc.options :examples="[
        '3 lb at 16 weeks' => ['weight_unit' => 'lb', 'weight' => 3, 'weeks' => 16],
        '1 kg at 10 weeks' => ['weight_unit' => 'kg', 'weight' => 1, 'weeks' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'Likely range'],
            'grown' => ['label' => 'Fully grown'],
        ]" />
        <x-calc.quick-ref heading="Expected growth" name="growth" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>adult ≈ current weight ÷ share of adult weight at this age</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
