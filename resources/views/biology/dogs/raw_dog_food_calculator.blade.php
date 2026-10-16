<x-calc.page
    title="Raw Dog Food Calculator - SolveKit"
    description="Free raw dog food calculator: grams of raw food per day and the muscle, bone and organ split for BARF or prey model diets."
    lede="Work out how much raw food to feed and how to split it."
    about="Adult dogs are usually fed 2 to 3% of their ideal body weight a day in raw food; active dogs more, and puppies about 5 to 8% of current weight. Prey model raw is about 80% muscle, 10% bone, 5% liver and 5% other organ; BARF adds about 10% vegetables. Raw diets carry bacterial risks; discuss balance with your vet."
    :calc="['engine' => 'pets', 'tool' => 'raw_food', 'fields' => ['weight', 'percent', 'ratio'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the weight', 'text' => 'Ideal adult weight.'],
        ['name' => 'Set the percent', 'text' => '2 to 3% for most adults.'],
        ['name' => 'Pick the diet', 'text' => 'Prey model or BARF.'],
    ]"
    :faqs="[
        ['question' => 'How much raw food for a 50 lb dog?', 'answer' => 'About 1 to 1.5 lb (450 to 680 g) a day at 2 to 3%.'],
        ['question' => 'How much for puppies?', 'answer' => 'About 5 to 8% of current weight, split into 3 or 4 meals.'],
        ['question' => 'Is raw food safe?', 'answer' => 'It can carry Salmonella and other bacteria; handle it carefully and talk to your vet.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Dog weight" value="50" min="0" placeholder="Dog weight">
            <label for="calc-weight-unit" class="sr-only">Dog weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="percent" label="Percent of body weight" value="2.5" min="0" max="10" suffix="%" />
    </div>

    <x-calc.segmented name="ratio" legend="Diet" :options="['pmr' => 'Prey model 80/10/10', 'barf' => 'BARF 70/10/10/10']" selected="pmr" />

    <x-calc.result label="Raw food per day" />

    <x-calc.options :examples="[
        '50 lb adult 2.5%' => ['weight' => 50, 'weight-unit' => 'lb', 'percent' => 2.5, 'ratio' => 'pmr'],
        'Active 20 kg, BARF 3%' => ['weight' => 20, 'weight-unit' => 'kg', 'percent' => 3, 'ratio' => 'barf'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'muscle' => ['label' => 'Muscle meat'],
            'bone' => ['label' => 'Raw edible bone'],
            'liver' => ['label' => 'Liver'],
            'organ' => ['label' => 'Other secreting organ'],
            'plants' => ['label' => 'Vegetables and fruit'],
            'week' => ['label' => 'Per week'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>grams/day = weight × percent</li>
            <li>prey model: 80% muscle, 10% bone, 5% liver, 5% organ</li>
            <li>BARF: 70% muscle, 10% bone, 5% liver, 5% organ, 10% plants</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
