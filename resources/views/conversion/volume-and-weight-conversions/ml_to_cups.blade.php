@php
    $units = config('units.volume');
    $listed = ['cup_us', 'cup_metric', 'cup_uk', 'tbsp_us', 'tsp_us', 'floz_us', 'pt_us'];
@endphp

<x-calc.page
    title="Milliliters to Cups Converter - SolveKit"
    description="Professional milliliters to cups converter for cooking and baking. Convert mL to cups with precision for recipe measurements and culinary applications."
    lede="Convert milliliters to US, metric or imperial cups, or cups back to mL."
    about="Cup sizes differ by country: a US cup is 236.6 mL, a metric cup (Australia, Canada, New Zealand) is 250 mL and an old imperial cup is 284.1 mL. Pick the cup your recipe uses."
    :calc="['engine' => 'units', 'units' => $units, 'list' => $listed, 'quickRef' => ['ml:@cup' => [50, 100, 125, 250, 500, 1000], '@cup:ml' => [0.25, 0.5, 0.75, 1, 2, 4]], 'min' => 0, 'kitchenFraction' => true]"
    :how-to="[
        ['name' => 'Choose a direction and cup', 'text' => 'Milliliters to cups or back, and which cup standard.'],
        ['name' => 'Enter the amount', 'text' => 'The result shows the nearest kitchen fraction when there is one.'],
    ]"
    :faqs="[
        ['question' => 'How many mL are in a cup?', 'answer' => 'A US cup is 236.6 mL, a metric cup is 250 mL and an imperial cup is 284.1 mL. US nutrition labels use 240 mL.'],
        ['question' => 'How many cups is 250 mL?', 'answer' => '250 mL is 1.06 US cups, or exactly 1 metric cup.'],
        ['question' => 'How many tablespoons are in a cup?', 'answer' => 'A US cup holds 16 tablespoons, or 48 teaspoons.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['ml:@cup' => 'mL → Cups', '@cup:ml' => 'Cups → mL']" selected="ml:@cup" />

    <x-calc.segmented name="cup" legend="Cup standard" :options="['cup_us' => 'US 236.6 mL', 'cup_metric' => 'Metric 250 mL', 'cup_uk' => 'Imperial 284 mL']" selected="cup_us" />

    <x-calc.field name="value" label="Amount" value="355" min="0" suffix="mL" suffix-ref="value-suffix" placeholder="Enter an amount" />

    <x-calc.result label="US cups" />

    <x-calc.options :examples="[
        'Can 355 mL' => ['value' => 355, 'direction' => 'ml:@cup'],
        'Recipe 1.5 cups' => ['value' => 1.5, 'direction' => '@cup:ml'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="$listed" heading="355 mL in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cups = mL ÷ cup size in mL</li>
            <li>US 236.5882365 · metric 250 · imperial 284.130625</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
