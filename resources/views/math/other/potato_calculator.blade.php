<x-calc.page
    title="Potato Calculator - SolveKit"
    description="Potato paradox calculator: dry 100 kg of 99% water potatoes to 98% water and they weigh 50 kg."
    lede="Solve the potato paradox."
    about="The dry matter does not change. At 99% water, 100 kg of potatoes hold 1 kg of solids; at 98% water that 1 kg must be 2% of the total, so the total is 50 kg. A one-point change in water content halved the weight. Also known as potato paradox calculator."
    :calc="['engine' => 'mt-other', 'tool' => 'potato', 'fields' => ['m1', 'w1', 'w2']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => '100 kg of 99% water potatoes dry to 98%. How much do they weigh?', 'answer' => '50 kg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="m1" label="Starting mass" value="100" min="0" step="any" />
        <x-calc.field name="w1" label="Water at the start (%)" value="99" min="0" max="100" step="any" />
        <x-calc.field name="w2" label="Water afterwards (%)" value="98" min="0" max="100" step="any" />
    </div>

    <x-calc.result label="New mass" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['m1' => 100, 'w1' => 99, 'w2' => 98],
        'Fruit' => ['m1' => 10, 'w1' => 90, 'w2' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dry' => ['label' => 'Dry matter'],
            'water' => ['label' => 'Water'],
            'lost' => ['label' => 'Mass lost'],
            'lesson' => ['label' => 'Why'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>m₂ = m₁(1 − w₁) ÷ (1 − w₂)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
