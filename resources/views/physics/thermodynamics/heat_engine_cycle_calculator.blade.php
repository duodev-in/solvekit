<x-calc.page
    title="Heat Engine Cycle Calculator - SolveKit"
    description="Free heat engine cycle calculator: ideal efficiency of Otto, Diesel and Brayton cycles."
    lede="Find ideal cycle efficiency."
    about="Air-standard cycles idealise real engines. Efficiency rises with compression ratio (Otto, Diesel) or pressure ratio (Brayton)."
    :calc="['engine' => 'ph-thermo', 'tool' => 'heat_engine', 'fields' => ['cycle', 'r', 'rc', 'rp', 'gamma'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the Otto efficiency at 10:1?', 'answer' => '60.19%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="cycle" label="Cycle" :options="['otto' => 'Otto (petrol engine)', 'diesel' => 'Diesel', 'brayton' => 'Brayton (gas turbine)']" selected="otto" />
        <div data-show-when="cycle:otto,diesel">
            <x-calc.field name="r" label="Compression ratio" value="10" min="1" step="any" />
        </div>
        <div data-show-when="cycle:diesel">
            <x-calc.field name="rc" label="Cut-off ratio (Diesel)" value="2" min="1" step="any" />
        </div>
        <div data-show-when="cycle:brayton">
            <x-calc.field name="rp" label="Pressure ratio (Brayton)" value="15" min="1" step="any" />
        </div>
        <x-calc.field name="gamma" label="γ" value="1.4" min="1" step="any" />
    </div>

    <x-calc.result label="Ideal thermal efficiency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cycle' => 'otto', 'r' => 10, 'rc' => 2, 'rp' => 15, 'gamma' => 1.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Real engines'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
