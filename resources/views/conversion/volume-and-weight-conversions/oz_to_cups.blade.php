@php
    $units = config('units.volume');
    $listed = ['cup_us', 'cup_metric', 'cup_uk', 'tbsp_us', 'tsp_us', 'ml', 'pt_us'];
@endphp

<x-calc.page
    title="Ounces to Cups Converter - SolveKit"
    description="Professional ounces to cups converter for cooking and baking. Convert fluid ounces (fl oz) to cups with precision for recipe measurements."
    lede="Convert US fluid ounces to cups, or cups to fluid ounces."
    about="A US cup is exactly 8 US fluid ounces. Metric (250 mL) and imperial (284.1 mL) cups hold a little more, so the result changes with the cup standard you pick. These are fluid ounces of volume, not ounces of weight."
    :calc="['engine' => 'units', 'units' => $units, 'list' => $listed, 'quickRef' => ['floz_us:@cup' => [2, 4, 6, 8, 12, 16], '@cup:floz_us' => [0.25, 0.5, 0.75, 1, 2, 4]], 'min' => 0, 'kitchenFraction' => true]"
    :how-to="[
        ['name' => 'Choose a direction and cup', 'text' => 'Fluid ounces to cups or back, and which cup standard.'],
        ['name' => 'Enter the amount', 'text' => 'The result shows the nearest kitchen fraction when there is one.'],
    ]"
    :faqs="[
        ['question' => 'How many ounces are in a cup?', 'answer' => 'A US cup is 8 US fluid ounces. A metric cup is 8.45 US fl oz.'],
        ['question' => 'Is a fluid ounce the same as an ounce of weight?', 'answer' => 'No. Fluid ounces measure volume. 8 fl oz of water weighs about 8.3 oz, but 8 fl oz of flour weighs much less.'],
        ['question' => 'How many cups is 12 oz?', 'answer' => '12 US fl oz is 1½ US cups.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['floz_us:@cup' => 'Fluid oz → Cups', '@cup:floz_us' => 'Cups → Fluid oz']" selected="floz_us:@cup" />

    <x-calc.segmented name="cup" legend="Cup standard" :options="['cup_us' => 'US 8 fl oz', 'cup_metric' => 'Metric 250 mL', 'cup_uk' => 'Imperial 284 mL']" selected="cup_us" />

    <x-calc.field name="value" label="Amount" value="12" min="0" suffix="fl oz" suffix-ref="value-suffix" placeholder="Enter an amount" />

    <x-calc.result label="US cups" />

    <x-calc.options :examples="[
        'Mug 10 fl oz' => ['value' => 10, 'direction' => 'floz_us:@cup'],
        'Recipe ¾ cup' => ['value' => 0.75, 'direction' => '@cup:floz_us'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="$listed" heading="12 fl oz in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cups = fl oz × 29.5735 mL ÷ cup size in mL</li>
            <li>1 US cup = 8 US fl oz</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
