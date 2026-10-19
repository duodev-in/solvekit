<x-calc.page
    title="Cake Serving Calculator - SolveKit"
    description="Free cake serving calculator: party and wedding servings for round, square and sheet cakes and tiered cakes, from the Wilton serving charts."
    lede="Find how many people a cake serves."
    about="Wilton's charts assume two-layer cakes about 4 in tall, cut into 1½ × 2 in party slices or 1 × 2 in wedding slices. Round and square sizes come from the chart; sizes between are scaled by area, and sheet cakes are their area divided by the slice area. For a tiered cake add the tiers (the top tier is often saved, so leave it out if so)."
    :calc="['engine' => 'fd-bake', 'tool' => 'cake_serving', 'fields' => ['shape', 'kind', 'tiers', 'length', 'width'], 'data' => ['cakes' => config('food_data.cakes')]]"
    :how-to="[
        ['name' => 'Choose the shape and slice size', 'text' => ''],
        ['name' => 'Enter the tier sizes or sheet size', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many does a 6, 8 and 10 in round wedding cake serve?', 'answer' => '74 servings wedding servings.'],
        ['question' => 'How many party servings in a 9 × 13 sheet cake?', 'answer' => '39 servings.'],
        ['question' => 'How many does an 8 in round serve?', 'answer' => '20 servings party servings.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Shape" :options="['round' => 'Round', 'square' => 'Square', 'sheet' => 'Sheet (rectangle)']" selected="round" />
        <x-calc.segmented name="kind" legend="Slices" :options="['party' => 'Party', 'wedding' => 'Wedding']" selected="party" />
    </div>

    <div data-show-when="shape:round,square">
        <x-calc.field name="tiers" label="Tier sizes (inches, comma separated)" value="6, 8, 10" type="text" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="shape:sheet" hidden>
            <x-calc.field name="length" label="Length" value="13" min="0" step="any" suffix="in" />
        </div>
        <div data-show-when="shape:sheet" hidden>
            <x-calc.field name="width" label="Width" value="9" min="0" step="any" suffix="in" />
        </div>
    </div>

    <x-calc.result label="Servings" />

    <x-calc.options :decimals="false" :examples="[
        'Wedding 3 tiers' => ['shape' => 'round', 'kind' => 'wedding', 'tiers' => '6, 8, 10', 'length' => 13, 'width' => 9],
        '9 × 13 sheet' => ['shape' => 'sheet', 'kind' => 'party', 'tiers' => '6, 8, 10', 'length' => 13, 'width' => 9],
        '8 in round' => ['shape' => 'round', 'kind' => 'party', 'tiers' => '8', 'length' => 13, 'width' => 9],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'slice' => ['label' => 'Slice size'],
            'basis' => ['label' => 'Basis'],
            'other' => ['label' => 'Other cut'],
        ]" />
        <x-calc.grid heading="Tiers" name="tiers" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>servings = Wilton chart (2 layers, 4 in tall)</li>
            <li>sheet = area ÷ slice area</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
