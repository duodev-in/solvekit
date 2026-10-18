<x-calc.page
    title="Fish Mercury Calculator - SolveKit"
    description="Free fish mercury calculator: your mercury intake from the fish you eat against the EPA reference dose, using FDA mercury levels for 66 fish and shellfish."
    lede="Work out how much mercury you get from the fish you eat."
    about="Dose = mercury in the fish (ppm, mg per kg) × grams eaten ÷ body weight. The FDA measured mean mercury in commercial fish from 1990 to 2012: under 0.02 ppm for salmon, sardines and shrimp, 0.13 for canned light tuna and about 1 ppm for swordfish and shark. The EPA reference dose for methylmercury is 0.1 µg per kg of body weight per day."
    :calc="['engine' => 'eco-science', 'tool' => 'fish_mercury', 'fields' => ['mass', 'fish1', 'grams1', 'fish2', 'grams2', 'fish3', 'grams3'], 'unitFields' => ['mass' => collect(config('units.mass'))->only(['lb', 'kg'])->all()], 'data' => collect(config('ecology_data'))->only(['fish', 'mercury_rfd'])->all()]"
    :how-to="[
        ['name' => 'Choose the fish you eat', 'text' => 'Up to three kinds.'],
        ['name' => 'Enter grams per week', 'text' => 'A typical serving is about 113 g (4 oz).'],
    ]"
    :faqs="[
        ['question' => 'Which fish are lowest in mercury?', 'answer' => 'Scallops, shrimp, sardines, salmon and tilapia, under 0.02 ppm.'],
        ['question' => 'Which fish should I limit?', 'answer' => 'Swordfish, shark, king mackerel, bigeye tuna and Gulf tilefish.'],
        ['question' => 'What is the reference dose?', 'answer' => 'An intake the EPA considers safe over a lifetime: 0.1 µg/kg/day.'],
    ]"
>
    <x-calc.field name="mass" label="Body weight" value="70" min="0" placeholder="Body weight">
        <label for="calc-mass-unit" class="sr-only">Body weight unit</label>
        <select id="calc-mass-unit" name="mass-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fish1" label="Fish 1" :options="collect(config('ecology_data.fish'))->sortBy('name')->map(fn ($x) => $x['name'].' ('.$x['ppm'].' ppm)')->all()" selected="tuna_canned_light" />
        <x-calc.field name="grams1" label="Grams per week" value="150" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fish2" label="Fish 2" :options="collect(config('ecology_data.fish'))->sortBy('name')->map(fn ($x) => $x['name'].' ('.$x['ppm'].' ppm)')->all()" selected="salmon_fresh_frozen" />
        <x-calc.field name="grams2" label="Grams per week" value="225" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fish3" label="Fish 3" :options="collect(config('ecology_data.fish'))->sortBy('name')->map(fn ($x) => $x['name'].' ('.$x['ppm'].' ppm)')->all()" selected="swordfish" />
        <x-calc.field name="grams3" label="Grams per week" value="0" min="0" />
    </div>

    <x-calc.result label="Mercury intake" />

    <x-calc.options :examples="[
        'Tuna and salmon' => ['mass' => 70, 'mass-unit' => 'kg', 'fish1' => 'tuna_canned_light', 'grams1' => 150, 'fish2' => 'salmon_fresh_frozen', 'grams2' => 225, 'fish3' => 'swordfish', 'grams3' => 0],
        'Swordfish weekly' => ['mass' => 150, 'mass-unit' => 'lb', 'fish1' => 'swordfish', 'grams1' => 170, 'fish2' => 'shrimp', 'grams2' => 100, 'fish3' => 'cod', 'grams3' => 0],
        'Child, 20 kg, albacore' => ['mass' => 20, 'mass-unit' => 'kg', 'fish1' => 'tuna_canned_albacore', 'grams1' => 60, 'fish2' => 'pollock', 'grams2' => 60, 'fish3' => 'cod', 'grams3' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'week' => ['label' => 'Per week'],
            'limit' => ['label' => 'Against the reference dose'],
            'advice' => ['label' => 'Advice'],
        ]" />
        <x-calc.quick-ref heading="By fish" name="fish" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dose (µg/kg/day) = Σ ppm × g per week ÷ 7 ÷ kg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
