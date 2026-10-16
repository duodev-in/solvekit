<x-calc.page
    title="Tree Leaves Calculator - SolveKit"
    description="Free tree leaves calculator: estimate how many leaves a tree has from crown size."
    lede="Estimate how many leaves are on a tree."
    about="Leaf area is the crown's ground area times the leaf area index (LAI: leaf area per unit of ground, typically 3 to 6 for broadleaf trees). Dividing by the size of one leaf gives an estimate of the number of leaves."
    :calc="['engine' => 'forestry', 'tool' => 'leaves', 'fields' => ['crown', 'lai', 'leaf_size'], 'unitFields' => ['crown' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the crown', 'text' => 'Width of the leafy crown at its widest.'],
        ['name' => 'Adjust leaf size', 'text' => 'A maple leaf is roughly 80 to 120 cm²; small leaves are under 20 cm².'],
    ]"
    :faqs="[
        ['question' => 'How many leaves does a mature tree have?', 'answer' => 'A large shade tree can carry around 200,000 leaves or more.'],
        ['question' => 'What is leaf area index?', 'answer' => 'Total one-sided leaf area divided by the ground area under the crown.'],
        ['question' => 'Is this exact?', 'answer' => 'No. It is an order-of-magnitude estimate.'],
    ]"
>
    <x-calc.field name="crown" label="Crown width" value="30" min="0" placeholder="Crown width">
        <label for="calc-crown-unit" class="sr-only">Crown width unit</label>
        <select id="calc-crown-unit" name="crown-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lai" label="Leaf area index" value="5" min="0" step="0.5" />
        <x-calc.field name="leaf_size" label="Area of one leaf" value="50" min="0" suffix="cm²" />
    </div>

    <x-calc.result label="Estimated leaves" />

    <x-calc.options :examples="[
        'Large maple' => ['crown' => 40, 'lai' => 5, 'leaf_size' => 100],
        'Small birch' => ['crown' => 15, 'lai' => 4, 'leaf_size' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'crown_area' => ['label' => 'Crown area'],
            'leaf_area' => ['label' => 'Total leaf area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>leaves = π × (crown ÷ 2)² × LAI ÷ leaf area</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
