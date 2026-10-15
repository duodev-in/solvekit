@php
    $groups = collect(config('substances'))->only(['construction']);
    $substances = $groups->flatMap(fn ($group) => $group['items'])->all();
@endphp

<x-calc.page
    title="Cubic Yards to Tons Converter - SolveKit"
    description="Professional cubic yards to tons converter for construction materials. Convert volume to weight for concrete, soil, gravel, and other bulk materials."
    lede="Estimate how many tons a volume of gravel, sand, soil or concrete weighs."
    about="Weight is volume times density. A cubic yard is 0.7646 m³, and bulk densities here are typical loose values in t/m³ (equal to g/mL). Moisture and compaction change real weights, so use the supplier's density when you have it."
    :calc="['engine' => 'substance', 'volumeUnits' => config('units.volume'), 'massUnits' => config('units.mass'), 'volume' => 'yd3', 'mass' => 't', 'substances' => $substances, 'densityLabel' => 't/m³', 'rows' => ['mass' => ['ton_us', 'ton_uk', 'kg', 'lb']], 'compare' => array_keys($substances)]"
    :how-to="[
        ['name' => 'Pick the material', 'text' => 'Its typical density fills in; replace it with your supplier\'s figure if you have one.'],
        ['name' => 'Enter the volume', 'text' => 'Type the volume in cubic yards.'],
        ['name' => 'Read the weight', 'text' => 'Metric tons are shown first, with US tons and pounds beside them.'],
    ]"
    :faqs="[
        ['question' => 'How much does a cubic yard of gravel weigh?', 'answer' => 'About 1.4 US tons (1.27 metric tons), depending on stone size and moisture.'],
        ['question' => 'How much does a cubic yard of concrete weigh?', 'answer' => 'About 4,050 lb, roughly 2 US tons or 1.84 metric tons.'],
        ['question' => 'Why is the result approximate?', 'answer' => 'Bulk materials settle, compact and hold water, so their density varies. The values here are typical loose densities.'],
    ]"
>
    <x-calc.substance :groups="$groups" selected="gravel" label="Material" density-label="t/m³" />

    <x-calc.field name="value" label="Volume" value="10" min="0" suffix="yd³" suffix-ref="value-suffix" placeholder="Cubic yards" />

    <x-calc.result label="Metric tons" />

    <x-calc.options :examples="[
        'Driveway 12 yd³' => ['value' => 12],
        'Garden bed 3 yd³' => ['value' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="Also weighs" name="also" :generated="true" />
        <x-calc.quick-ref heading="Same volume of other materials" name="compare" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>m³ = yd³ × 0.764554857984</li>
            <li>metric tons = m³ × density (t/m³)</li>
            <li>US tons = metric tons ÷ 0.90718474</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
