<x-calc.page
    title="Cat BMI Calculator - SolveKit"
    description="Free cat BMI calculator: feline body mass index body fat percentage from rib cage and leg measurements."
    lede="Estimate your cat's body fat from two measurements."
    about="The feline body mass index (Hawthorne and Butterwick, 2000) estimates body fat from the rib cage circumference at the ninth rib and the lower back leg length from knee to ankle, measured with the cat standing. Healthy cats are generally about 10 to 30% body fat."
    :calc="['engine' => 'pets', 'tool' => 'cat_bmi', 'fields' => ['rib_cage', 'leg'], 'unitFields' => ['rib_cage' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'leg' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the rib cage', 'text' => 'Around the chest at the 9th rib, cat standing.'],
        ['name' => 'Measure the leg', 'text' => 'Back leg from the knee to the ankle.'],
    ]"
    :faqs="[
        ['question' => 'What is a healthy body fat for cats?', 'answer' => 'About 10 to 30%.'],
        ['question' => 'Why not just weigh my cat?', 'answer' => 'Frame size varies, so weight alone does not show fatness.'],
        ['question' => 'Is this accurate?', 'answer' => 'It is a field estimate; body condition scoring by a vet is also useful.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rib_cage" label="Rib cage circumference" value="34" min="0" placeholder="Rib cage circumference">
            <label for="calc-rib_cage-unit" class="sr-only">Rib cage circumference unit</label>
            <select id="calc-rib_cage-unit" name="rib_cage-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="leg" label="Lower leg, knee to ankle" value="12" min="0" placeholder="Lower leg, knee to ankle">
            <label for="calc-leg-unit" class="sr-only">Lower leg, knee to ankle unit</label>
            <select id="calc-leg-unit" name="leg-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Feline body fat" />

    <x-calc.options :examples="[
        'Average cat' => ['rib_cage' => 34, 'rib_cage-unit' => 'cm', 'leg' => 12, 'leg-unit' => 'cm'],
        'Heavy cat' => ['rib_cage' => 48, 'rib_cage-unit' => 'cm', 'leg' => 12, 'leg-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Band'],
            'rib' => ['label' => 'Rib cage'],
            'leg' => ['label' => 'Leg'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>% fat = ((rib cage ÷ 0.7062) − leg) ÷ 0.9156 − leg (cm)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
