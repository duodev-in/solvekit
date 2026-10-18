<x-calc.page
    title="Drip Faucet Calculator - SolveKit"
    description="Free drip faucet calculator: water a leaking tap wastes per day and year, the cost, and the CO₂ to supply it, using the USGS drip size."
    lede="Work out how much water a dripping faucet wastes."
    about="Water lost = drips per minute × 1,440 minutes a day × the volume of a drip. The USGS drip calculator uses ¼ mL per drip (about 15,140 drips per US gallon); larger drips waste more. Supplying and treating the water emits about 0.36 kg CO₂e per m³ (DESNZ 2025)."
    :calc="['engine' => 'eco-living', 'tool' => 'drip', 'fields' => ['drips', 'drip_ml', 'price', 'price_unit'], 'data' => collect(config('ecology_data'))->only(['materials'])->all()]"
    :how-to="[
        ['name' => 'Count the drips', 'text' => 'For one minute.'],
        ['name' => 'Enter your water price', 'text' => 'From your bill.'],
    ]"
    :faqs="[
        ['question' => 'How much water does a dripping tap waste?', 'answer' => 'At 10 drips a minute, about 347 gallons (1,314 L) a year.'],
        ['question' => 'How many drips in a gallon?', 'answer' => 'About 15,140 at ¼ mL each (USGS).'],
        ['question' => 'Is it worth fixing?', 'answer' => 'Usually yes: a new washer is cheap.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="drips" label="Drips per minute" value="10" min="0" step="1" />
        <x-calc.field name="drip_ml" label="Drip size" value="0.25" min="0.01" step="0.01" suffix="mL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Water price (optional)" value="4" min="0" step="0.01" suffix="$" />
        <x-calc.select name="price_unit" label="Price" :options="['m3' => 'per m³ (1,000 L)', 'kgal' => 'per 1,000 US gal']" selected="kgal" />
    </div>

    <x-calc.result label="Water lost" />

    <x-calc.options :examples="[
        '10 drips a minute' => ['drips' => 10, 'drip_ml' => 0.25, 'price' => 4, 'price_unit' => 'kgal'],
        'One drip a second' => ['drips' => 60, 'drip_ml' => 0.25, 'price' => 4, 'price_unit' => 'kgal'],
        'Fast drip, metric' => ['drips' => 120, 'drip_ml' => 0.3, 'price' => 2.5, 'price_unit' => 'm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'liters' => ['label' => 'Liters'],
            'day' => ['label' => 'Per day'],
            'cost' => ['label' => 'Cost'],
            'co2' => ['label' => 'CO₂'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>liters a day = drips/min × 1440 × mL ÷ 1000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
