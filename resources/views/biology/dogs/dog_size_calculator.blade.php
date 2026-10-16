<x-calc.page
    title="Dog Size Calculator - SolveKit"
    description="Free puppy weight calculator: estimate how big your puppy will get from current weight, age and expected size."
    lede="Estimate your puppy's adult weight."
    about="Puppies grow at different speeds by size: small breeds are about half grown at 4 months and done by 10 to 12 months, while giant breeds take up to 2 years. Pick the size you expect from the parents or breed; if unsure, try two sizes and compare. These growth curves are approximate."
    :calc="['engine' => 'pets', 'tool' => 'puppy_size', 'fields' => ['size', 'weight_unit', 'weight', 'weeks']]"
    :how-to="[
        ['name' => 'Pick the expected size', 'text' => 'From the breed or parents\' weights.'],
        ['name' => 'Enter weight and age', 'text' => 'Age in weeks.'],
    ]"
    :faqs="[
        ['question' => 'How can I tell how big my puppy will get?', 'answer' => 'Parents\' weights are the best guide; growth curves give an estimate.'],
        ['question' => 'Do paw size and skin show it?', 'answer' => 'Only loosely; weight at a known age is more reliable.'],
        ['question' => 'When are dogs fully grown?', 'answer' => 'Small breeds about 10 to 12 months, giant breeds 18 to 24 months.'],
    ]"
>
    <x-calc.select name="size" label="Expected adult size" :options="['small' => 'Small (under 20 lb)', 'medium' => 'Medium (21–50 lb)', 'large' => 'Large (51–100 lb)', 'giant' => 'Giant (over 100 lb)']" selected="medium" />

    <x-calc.segmented name="weight_unit" legend="Unit" :options="['lb' => 'lb', 'kg' => 'kg']" selected="lb" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Current weight" value="12" min="0" />
        <x-calc.field name="weeks" label="Age" value="16" min="6" max="104" suffix="weeks" />
    </div>

    <x-calc.result label="Estimated adult weight" />

    <x-calc.options :examples="[
        'Medium 12 lb at 16 wk' => ['size' => 'medium', 'weight_unit' => 'lb', 'weight' => 12, 'weeks' => 16],
        'Large 10 kg at 12 wk' => ['size' => 'large', 'weight_unit' => 'kg', 'weight' => 10, 'weeks' => 12],
        'Small 4 lb at 12 wk' => ['size' => 'small', 'weight_unit' => 'lb', 'weight' => 4, 'weeks' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'share' => ['label' => 'Grown so far'],
            'grown' => ['label' => 'Fully grown'],
            'range' => ['label' => 'Likely range'],
        ]" />
        <x-calc.quick-ref heading="Expected growth" name="growth" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>adult ≈ current weight ÷ share of adult weight at this age</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
