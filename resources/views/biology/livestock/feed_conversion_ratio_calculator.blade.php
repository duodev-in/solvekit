<x-calc.page
    title="Feed Conversion Ratio Calculator - SolveKit"
    description="Free feed conversion ratio calculator: FCR, feed efficiency and feed cost per unit of weight gain."
    lede="Work out feed conversion ratio and feed cost per unit of gain."
    about="Feed conversion ratio (FCR) is feed eaten divided by weight gained, in the same unit. Lower is better: broilers reach about 1.6, pigs about 2.5 to 3 and feedlot cattle about 6."
    :calc="['engine' => 'livestock', 'tool' => 'fcr', 'fields' => ['feed', 'gain', 'price']]"
    :how-to="[
        ['name' => 'Enter feed and gain', 'text' => 'In the same unit, e.g. lb and lb.'],
        ['name' => 'Add a price', 'text' => 'Per unit of feed, for cost of gain.'],
    ]"
    :faqs="[
        ['question' => 'What is a good FCR for broilers?', 'answer' => 'About 1.5 to 1.8.'],
        ['question' => 'And for pigs?', 'answer' => 'About 2.5 to 3.0 from weaning to market.'],
        ['question' => 'What is feed efficiency?', 'answer' => 'The inverse: gain ÷ feed, often given as a percentage.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="feed" label="Feed eaten" value="1200" min="0" />
        <x-calc.field name="gain" label="Weight gained" value="420" min="0" />
    </div>

    <x-calc.field name="price" label="Feed price per unit (optional)" value="0.15" min="0" suffix="$" placeholder="Optional" />

    <x-calc.result label="Feed conversion ratio" />

    <x-calc.options :examples="[
        'Pigs' => ['feed' => 1200, 'gain' => 420, 'price' => 0.15],
        'Broilers' => ['feed' => 4, 'gain' => 2.5, 'price' => 0.3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'efficiency' => ['label' => 'Feed efficiency'],
            'cost' => ['label' => 'Feed cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FCR = feed ÷ gain</li>
            <li>efficiency = gain ÷ feed</li>
            <li>cost of gain = FCR × feed price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
