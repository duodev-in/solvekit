<x-calc.page
    title="Hand Drying Footprint Calculator - SolveKit"
    description="Free hand drying footprint calculator: carbon footprint per dry of hot-air dryers, jet dryers and paper towels from power, time, towels and your electricity grid."
    lede="Compare the footprint of hand dryers and paper towels."
    about="A dryer's footprint is its power × drying time × the grid's carbon intensity. Paper towels count the paper made for them, using the DESNZ factor for paper production (manufacturing only; delivery and disposal add a little more). Use the power on the dryer's label and time your own drying."
    :calc="['engine' => 'eco-footprint', 'tool' => 'hand_drying', 'fields' => ['method', 'hot_w', 'hot_s', 'jet_w', 'jet_s', 'towels', 'towel_g', 'dries', 'grid', 'grid_custom'], 'data' => collect(config('ecology_data'))->only(['grid', 'materials'])->all()]"
    :how-to="[
        ['name' => 'Enter each method', 'text' => 'Dryer power and time, or towels and their weight.'],
        ['name' => 'Choose your grid', 'text' => 'Clean grids favour dryers.'],
    ]"
    :faqs="[
        ['question' => 'Are hand dryers better than paper towels?', 'answer' => 'Usually: a jet dryer on an average grid emits a few grams per dry, less than two paper towels.'],
        ['question' => 'How much energy does a dryer use per dry?', 'answer' => 'A 2.3 kW dryer running 30 s uses about 0.02 kWh.'],
        ['question' => 'Does recycled paper help?', 'answer' => 'Yes, recycled paper has a lower footprint than primary paper.'],
    ]"
>
    <x-calc.select name="method" label="Show" :options="['hot_air' => 'Hot-air dryer', 'jet' => 'Jet dryer', 'paper' => 'Paper towels']" selected="hot_air" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hot_w" label="Hot-air dryer power" value="2300" min="0" suffix="W" />
        <x-calc.field name="hot_s" label="Hot-air drying time" value="30" min="0" suffix="s" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="jet_w" label="Jet dryer power" value="1400" min="0" suffix="W" />
        <x-calc.field name="jet_s" label="Jet drying time" value="12" min="0" suffix="s" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="towels" label="Paper towels per dry" value="2" min="0" step="1" />
        <x-calc.field name="towel_g" label="Weight per towel" value="2.5" min="0" step="0.1" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dries" label="Dries per day (optional)" value="100" min="0" step="1" />
        <x-calc.select name="grid" label="Electricity grid" :options="['OWID_WRL' => 'World average'] + collect(config('ecology_data.grid'))->except('OWID_WRL')->sortBy('name')->map(fn ($g) => $g['name'])->all() + ['custom' => 'My own value (g/kWh)']" selected="OWID_WRL" />
    </div>

    <div data-show-when="grid:custom" hidden>
        <x-calc.field name="grid_custom" label="Grid intensity" value="400" min="0" suffix="g CO₂e/kWh" />
    </div>

    <x-calc.result label="Hot-air dryer" />

    <x-calc.options :examples="[
        'Hot-air dryer, world grid' => ['method' => 'hot_air', 'hot_w' => 2300, 'hot_s' => 30, 'jet_w' => 1400, 'jet_s' => 12, 'towels' => 2, 'towel_g' => 2.5, 'dries' => 100, 'grid' => 'OWID_WRL'],
        'Jet dryer, France' => ['method' => 'jet', 'hot_w' => 2300, 'hot_s' => 30, 'jet_w' => 1400, 'jet_s' => 12, 'towels' => 2, 'towel_g' => 2.5, 'dries' => 100, 'grid' => 'FRA'],
        'Paper towels' => ['method' => 'paper', 'hot_w' => 2300, 'hot_s' => 30, 'jet_w' => 1400, 'jet_s' => 12, 'towels' => 2, 'towel_g' => 2.5, 'dries' => 100, 'grid' => 'OWID_WRL'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'year' => ['label' => 'Per year'],
            'hot_air' => ['label' => 'Hot-air dryer'],
            'jet' => ['label' => 'Jet dryer'],
            'paper' => ['label' => 'Paper towels'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dryer: W × s ÷ 3.6 million × g CO₂e/kWh</li>
            <li>paper: towels × grams × 1.345 g CO₂e per g (DESNZ)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
