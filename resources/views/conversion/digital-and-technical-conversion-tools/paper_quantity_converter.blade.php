@php
    $units = [
        'sheet' => ['name' => 'Sheets', 'factor' => 1],
        'quire' => ['name' => 'Quires (25)', 'factor' => 25],
        'ream' => ['name' => 'Reams (500)', 'factor' => 500],
        'case' => ['name' => 'Cases (10 reams)', 'factor' => 5000],
    ];
    $sizes = [
        'a4' => ['name' => 'A4 (210 × 297 mm)', 'area' => 0.210 * 0.297],
        'letter' => ['name' => 'US Letter (8.5 × 11 in)', 'area' => 8.5 * 11 * 0.0254 ** 2],
        'legal' => ['name' => 'US Legal (8.5 × 14 in)', 'area' => 8.5 * 14 * 0.0254 ** 2],
        'a3' => ['name' => 'A3 (297 × 420 mm)', 'area' => 0.297 * 0.420],
        'a5' => ['name' => 'A5 (148 × 210 mm)', 'area' => 0.148 * 0.210],
        'tabloid' => ['name' => 'Tabloid (11 × 17 in)', 'area' => 11 * 17 * 0.0254 ** 2],
    ];
@endphp

<x-calc.page
    title="Paper Quantity Converter - SolveKit"
    description="Professional paper quantity converter for ream, sheet, and paper conversions. Calculate printing costs, office supply quantities, and paper weight conversions for business needs."
    lede="Convert between sheets, reams and cases, and work out weight and cost."
    about="A ream is 500 sheets and a case is usually 10 reams. Weight comes from the paper's grammage (GSM, grams per square meter) times the sheet area. Stack height is an estimate of about 1.25 µm per GSM per sheet, so 80 gsm paper is about 0.1 mm thick."
    :calc="['engine' => 'paper', 'units' => $units, 'sizes' => $sizes]"
    :how-to="[
        ['name' => 'Enter the quantity', 'text' => 'In sheets, quires, reams or cases.'],
        ['name' => 'Pick the paper', 'text' => 'Choose the size and enter the GSM printed on the pack (80 gsm is standard copy paper).'],
        ['name' => 'Add a price (optional)', 'text' => 'Enter the price per ream to see the total and per-sheet cost.'],
    ]"
    :faqs="[
        ['question' => 'How many sheets are in a ream?', 'answer' => '500. A case normally holds 10 reams, or 5,000 sheets.'],
        ['question' => 'How much does a ream of A4 weigh?', 'answer' => 'At 80 gsm, about 2.5 kg (500 × 0.06237 m² × 80 g).'],
        ['question' => 'What does GSM mean?', 'answer' => 'Grams per square meter, the weight of one square meter of the paper.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1fr)_minmax(0,1fr)]">
        <x-calc.field name="quantity" label="Quantity" value="3" min="0" placeholder="Quantity" />
        <x-calc.select name="unit" label="Unit" :options="collect($units)->map(fn ($unit) => $unit['name'])->all()" selected="ream" />
        <x-calc.select name="size" label="Paper size" :options="collect($sizes)->map(fn ($size) => $size['name'])->all()" selected="a4" />
        <x-calc.field name="gsm" label="Paper weight" value="80" min="0" suffix="gsm" placeholder="GSM" />
    </div>

    <x-calc.field name="price" label="Price per ream (optional)" value="" min="0" step="0.01" suffix="$" placeholder="e.g. 6.50" />

    <x-calc.result label="Sheets" />

    <x-calc.options :examples="[
        'Office case' => ['quantity' => 1, 'unit' => 'case'],
        '250 sheets of card' => ['quantity' => 250, 'unit' => 'sheet', 'gsm' => 250],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'reams' => ['label' => 'Reams', 'unit' => 'reams'],
            'cases' => ['label' => 'Cases', 'unit' => 'cases'],
            'kg' => ['label' => 'Weight', 'unit' => 'kg'],
            'lb' => ['label' => 'Weight', 'unit' => 'lb'],
            'height' => ['label' => 'Approximate stack height', 'unit' => 'cm'],
            'cost' => ['label' => 'Total cost'],
            'per_sheet' => ['label' => 'Cost per sheet'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sheets = quantity × sheets per unit</li>
            <li>weight = sheets × GSM × sheet area (m²)</li>
            <li>cost = sheets ÷ 500 × price per ream</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
