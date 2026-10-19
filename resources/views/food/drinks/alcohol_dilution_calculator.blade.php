<x-calc.page
    title="Alcohol Dilution Calculator - SolveKit"
    description="Free alcohol dilution calculator: how much water to add to bring a spirit or liqueur down to a target strength (ABV or proof), and the final volume."
    lede="Dilute a spirit to a target strength."
    about="The alcohol stays the same, so volume × strength before = volume × strength after (C₁V₁ = C₂V₂). Water to add = volume × (ABV ÷ target − 1). Ethanol and water contract when mixed (up to about 4% at mid strengths), so the mix measures slightly less than the sum; add water gradually and check with an alcoholmeter for exact work."
    :calc="['engine' => 'fd-drinks', 'tool' => 'dilution', 'fields' => ['volume', 'unit', 'abv', 'target']]"
    :how-to="[
        ['name' => 'Enter the volume and strength', 'text' => ''],
        ['name' => 'Enter the target strength', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much water brings 750 ml at 60% to 40%?', 'answer' => '375 ml (750 ml at 60% + 375 ml water = 1,125 ml at 40%).'],
        ['question' => 'And 1 litre of 95% to 45%?', 'answer' => '1.11 L.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="volume" label="Volume" value="750" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['ml' => 'ml', 'l' => 'litres', 'floz' => 'US fl oz']" selected="ml" />
        <x-calc.field name="abv" label="Strength now" value="60" min="0" max="100" step="any" suffix="% ABV" />
    </div>

    <x-calc.field name="target" label="Target strength" value="40" min="0" max="100" step="any" suffix="% ABV" />

    <x-calc.result label="Water to add" />

    <x-calc.options :decimals="false" :examples="[
        '60 to 40' => ['volume' => 750, 'unit' => 'ml', 'abv' => 60, 'target' => 40],
        'Neutral spirit' => ['volume' => 1, 'unit' => 'l', 'abv' => 95, 'target' => 45],
        'Cask strength' => ['volume' => 25, 'unit' => 'floz', 'abv' => 57, 'target' => 46],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'final' => ['label' => 'Final volume'],
            'proof' => ['label' => 'Proof'],
            'contraction' => ['label' => 'Volume contraction'],
            'alcohol' => ['label' => 'Pure alcohol'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V₂ = V₁ × ABV₁ ÷ ABV₂</li>
            <li>water = V₂ − V₁</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
