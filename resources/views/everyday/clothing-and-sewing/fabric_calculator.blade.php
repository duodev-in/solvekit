<x-calc.page
    title="Fabric Calculator - SolveKit"
    description="Free fabric calculator: yardage for your pattern pieces on your fabric width, with seam allowances, nap and shrinkage, and a cutting layout."
    lede="Work out how much fabric your project needs."
    about="List the pieces (length along the fabric, width across it, how many). They are laid out in rows across the fabric width, longest first, and turned when that saves width unless the fabric has a nap or one-way print. Add seam allowance if your sizes do not include it, and a few percent for shrinkage when pre-washing. For the guided version of the fabric quiz, start from an example and edit it."
    :calc="['engine' => 'ev-clothing', 'tool' => 'fabric', 'fields' => ['pieces', 'piece_unit', 'fabric', 'add_seam', 'nap', 'shrink'], 'unitFields' => ['fabric' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'add_seam' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'List your pieces', 'text' => 'From the pattern, with counts.'],
        ['name' => 'Enter fabric width and options', 'text' => 'Nap, seam allowance, shrinkage.'],
    ]"
    :faqs="[
        ['question' => 'How much fabric do I need?', 'answer' => 'Add the pieces in rows across the fabric width; this does it for you.'],
        ['question' => 'What is nap?', 'answer' => 'A pile or print that runs one way, so pieces cannot be turned.'],
        ['question' => 'How much extra for shrinkage?', 'answer' => 'About 3–5% for cotton you will pre-wash.'],
    ]"
>
    <x-calc.rows-editor name="pieces" label="Pieces" :columns="['name' => 'Piece', 'length' => 'Length', 'width' => 'Width', 'count' => 'Count']" :rows="[['Skirt front', 26, 30, 1], ['Skirt back', 26, 30, 2], ['Waistband', 4, 32, 1], ['Pocket', 8, 7, 2]]" add-label="Add piece" :text="['name']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.segmented name="piece_unit" legend="Piece sizes in" :options="['in' => 'Inches', 'cm' => 'cm']" selected="in" />
        <x-calc.field name="fabric" label="Fabric width" value="44" min="0" placeholder="Fabric width">
            <label for="calc-fabric-unit" class="sr-only">Fabric width unit</label>
            <select id="calc-fabric-unit" name="fabric-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="add_seam" label="Add seam allowance" value="0" min="0" placeholder="Add seam allowance">
            <label for="calc-add_seam-unit" class="sr-only">Add seam allowance unit</label>
            <select id="calc-add_seam-unit" name="add_seam-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="nap" label="Nap or one-way print (do not turn pieces)" :checked="false" />
        <x-calc.field name="shrink" label="Shrinkage allowance" value="5" min="0" max="20" step="1" suffix="%" />
    </div>

    <x-calc.result label="Fabric needed" />

    <x-calc.options :examples="[
        'A-line skirt' => ['pieces' => 'Skirt front	26	30	1
Skirt back	26	30	2
Waistband	4	32	1
Pocket	8	7	2', 'piece_unit' => 'in', 'fabric' => 44, 'fabric-unit' => 'in', 'add_seam' => 0, 'add_seam-unit' => 'in', 'nap' => false, 'shrink' => 5],
        'Cushion covers' => ['pieces' => 'Cushion front	19	19	4
Cushion back	19	13	8', 'piece_unit' => 'in', 'fabric' => 54, 'fabric-unit' => 'in', 'add_seam' => 0, 'add_seam-unit' => 'in', 'nap' => false, 'shrink' => 0],
        'Velvet (nap), cm' => ['pieces' => 'Front	70	55	1
Back	70	30	2
Sleeve	60	40	2', 'piece_unit' => 'cm', 'fabric' => 140, 'fabric-unit' => 'cm', 'add_seam' => 1.5, 'add_seam-unit' => 'cm', 'nap' => true, 'shrink' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact length'],
            'rows' => ['label' => 'Layout'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="Cutting layout" name="layout" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pieces packed in rows across the width, longest first</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
