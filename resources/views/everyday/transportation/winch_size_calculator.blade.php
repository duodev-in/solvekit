<x-calc.page
    title="Winch Size Calculator - SolveKit"
    description="Free winch size calculator: minimum winch rating for a vehicle from its gross weight using the 1.5× rule, and the effect of a snatch block."
    lede="Pick a winch big enough for your vehicle."
    about="Winch makers recommend a rated line pull of at least 1.5 times the vehicle's gross weight (with gear and passengers). Mud, slopes and the number of rope wraps on the drum (pull is rated on the first layer) all reduce real pulling power, so many choose a higher factor. A snatch block nearly doubles the pull."
    :calc="['engine' => 'ev-transport', 'tool' => 'winch', 'fields' => ['weight', 'factor'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the gross weight', 'text' => 'Loaded, with gear.'],
        ['name' => 'Choose the factor', 'text' => '1.5 is the usual minimum.'],
    ]"
    :faqs="[
        ['question' => 'What size winch for a 5,500 lb truck?', 'answer' => 'At least 8,250 lb: a 8,500 lb winch.'],
        ['question' => 'What size winch for a Jeep Wrangler?', 'answer' => 'For about 5,000 lb loaded, 7,500 lb or more.'],
        ['question' => 'Why rate on the first wrap?', 'answer' => 'Pull drops as rope builds up on the drum.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Vehicle gross weight" value="5500" min="0" placeholder="Vehicle gross weight">
            <label for="calc-weight-unit" class="sr-only">Vehicle gross weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="factor" label="Safety factor" value="1.5" min="1" max="3" step="0.1" suffix="×" />
    </div>

    <x-calc.result label="Minimum winch rating" />

    <x-calc.options :examples="[
        '5,500 lb truck' => ['weight' => 5500, 'weight-unit' => 'lb', 'factor' => 1.5],
        '2,200 kg SUV' => ['weight' => 2200, 'weight-unit' => 'kg', 'factor' => 1.5],
        'Heavy use, 2×' => ['weight' => 7000, 'weight-unit' => 'lb', 'factor' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'In kg'],
            'block' => ['label' => 'With a snatch block'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rating ≥ gross weight × 1.5</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
