@php
    $crops = config('biology_data.grain_test_weights');
    $pound = config('units.mass.lb.factor') / 1000;
    // One unit table per crop (base: kilograms); only the bushel changes with the crop.
    $unitSets = collect($crops)->map(fn ($crop) => [
        'bu' => ['name' => 'Bushels', 'symbol' => 'bu', 'factor' => $crop['lb'] * $pound],
        'lb' => ['name' => 'Pounds', 'symbol' => 'lb', 'factor' => $pound],
        'cwt' => ['name' => 'Hundredweight (US)', 'symbol' => 'cwt', 'factor' => 100 * $pound],
        'ton_us' => ['name' => 'US tons', 'symbol' => 'US ton', 'factor' => 2000 * $pound],
        'kg' => ['name' => 'Kilograms', 'symbol' => 'kg', 'factor' => 1],
        't' => ['name' => 'Metric tonnes', 'symbol' => 't', 'factor' => 1000],
    ])->all();
    $units = $unitSets['corn'];
@endphp

<x-calc.page
    title="Grain Conversion Calculator - SolveKit"
    description="Free grain conversion calculator: bushels to pounds, kilograms and tonnes for corn, soybeans, wheat and other grains."
    lede="Convert grain between bushels and weight for each crop."
    about="A bushel is a volume, so its weight depends on the crop. Grain is traded on standard test weights set by the USDA, for example 56 lb per bushel for corn and 60 lb for soybeans and wheat. Pick the crop and the conversion uses its test weight."
    :calc="['engine' => 'units', 'unitSets' => $unitSets, 'unitSetControl' => 'crop', 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Pick the crop', 'text' => 'Its standard test weight is used for bushels.'],
        ['name' => 'Enter the amount', 'text' => 'Every unit for that crop is listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'How many pounds are in a bushel of corn?', 'answer' => '56 lb of shelled corn at the standard test weight.'],
        ['question' => 'How many bushels of soybeans are in a metric tonne?', 'answer' => 'About 36.74 bushels, at 60 lb per bushel.'],
        ['question' => 'Why do test weights differ from my scale?', 'answer' => 'Actual weight per bushel varies with moisture and kernel quality; standard weights are used for trading.'],
    ]"
>
    <x-calc.select name="crop" label="Crop" :options="collect($crops)->map(fn ($crop) => $crop['name'].' ('.$crop['lb'].' lb/bu)')->all()" selected="corn" />

    <x-calc.unit-pair :units="$units" from="bu" to="t" value="1000" min="0" label="Amount" />

    <x-calc.result label="Metric tonnes">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Corn 5,000 bu' => ['crop' => 'corn', 'value' => 5000, 'from' => 'bu'],
        'Wheat 25 t' => ['crop' => 'wheat', 'value' => 25, 'from' => 't'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="1,000 bu in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = bushels × test weight (lb/bu)</li>
            <li>corn 56 · soybeans 60 · wheat 60 · barley 48 · oats 32 lb/bu</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
