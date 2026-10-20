<x-calc.page
    title="Magnetic Permeability Calculator - SolveKit"
    description="Free magnetic permeability calculator: μ and μ_r for common materials, or from B and H."
    lede="Find magnetic permeability."
    about="Permeability μ = μ₀μ_r measures how easily a material carries magnetic flux. Ferrites and steels concentrate flux thousands of times more than air."
    :calc="['engine' => 'ph-em', 'tool' => 'permeability', 'fields' => ['mode', 'mat', 'mur', 'B', 'H'], 'unitFields' => ['B' => collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'magnetic_field', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['permeability'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the permeability of MnZn ferrite?', 'answer' => '0.00251327 H/m H/m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['material' => 'The material', 'mur' => 'Relative permeability', 'BH' => 'B and H']" selected="material" />
        <div data-show-when="mode:material">
            <x-calc.select name="mat" label="Material" :options="['vacuum' => 'Vacuum or air', 'copper' => 'Copper', 'aluminium' => 'Aluminium', 'water' => 'Water', 'nickel' => 'Nickel', 'carbon_steel' => 'Carbon steel', 'electrical_steel' => 'Electrical (silicon) steel', 'iron' => 'Iron (99.8% pure)', 'ferrite' => 'Manganese-zinc ferrite', 'permalloy' => 'Permalloy', 'mumetal' => 'Mu-metal']" selected="ferrite" />
        </div>
        <div data-show-when="mode:mur">
            <x-calc.field name="mur" label="Relative permeability" value="1000" min="0" step="any" />
        </div>
        <div data-show-when="mode:BH">
            <x-calc.field name="B" label="Flux density B" value="1" placeholder="Flux density B">
                <label for="calc-B-unit" class="sr-only">Flux density B unit</label>
                <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:BH">
            <x-calc.field name="H" label="Field strength H (A/m)" value="400" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Permeability μ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'material', 'mat' => 'ferrite', 'mur' => 1000, 'B' => 1, 'B-unit' => 't', 'H' => 400],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mur' => ['label' => 'Relative permeability μ_r'],
            'chi' => ['label' => 'Magnetic susceptibility χ'],
            'kind' => ['label' => 'Type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
