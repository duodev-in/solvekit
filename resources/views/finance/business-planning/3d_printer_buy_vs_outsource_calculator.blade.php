<x-calc.page
    title="3D Printer - Buy vs Outsource Calculator - SolveKit"
    description="Free 3D printer buy vs outsource calculator: cost per printed part from filament, electricity, labor and wear, and the number of parts before a printer pays for itself."
    lede="Decide whether to buy a 3D printer or outsource prints."
    about="Cost per part = filament (grams × price per kg) + electricity (watts × hours × price per kWh) + labor + machine wear per hour. Break-even = printer price ÷ (outsourced price − cost per part). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'printer', 'fields' => ['printer', 'filament', 'grams', 'hours', 'watts', 'kwh', 'labor_minutes', 'wage', 'wear', 'outsource']]"
    :how-to="[
        ['name' => 'Enter printer and material costs', 'text' => ''],
        ['name' => 'Enter the outsourced quote', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many parts until a $1,200 printer pays off against $22 outsourced parts?', 'answer' => '85 parts.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="printer" label="Printer price" value="1200" step="0.01" suffix="$" />
        <x-calc.field name="filament" label="Filament per kg" value="25" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="grams" label="Grams per part" value="80" min="0" step="any" />
        <x-calc.field name="hours" label="Print hours per part" value="5" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="watts" label="Printer power" value="150" min="0" step="any" suffix="W" />
        <x-calc.field name="kwh" label="Electricity per kWh" value="0.17" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="labor_minutes" label="Hands-on minutes per part" value="10" min="0" step="any" />
        <x-calc.field name="wage" label="Labor cost an hour" value="25" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wear" label="Maintenance and wear per print hour" value="0.3" step="0.01" suffix="$" />
        <x-calc.field name="outsource" label="Outsourced price per part" value="22" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Break-even" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['printer' => 1200, 'filament' => 25, 'grams' => 80, 'hours' => 5, 'watts' => 150, 'kwh' => 0.17, 'labor_minutes' => 10, 'wage' => 25, 'wear' => 0.3, 'outsource' => 22],
        'Cheap service' => ['printer' => 1200, 'filament' => 25, 'grams' => 80, 'hours' => 5, 'watts' => 150, 'kwh' => 0.17, 'labor_minutes' => 10, 'wage' => 25, 'wear' => 0.3, 'outsource' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per' => ['label' => 'In-house cost per part'],
            'material' => ['label' => 'Material'],
            'power' => ['label' => 'Electricity'],
            'saving' => ['label' => 'Saving per part'],
            'at100' => ['label' => 'Net after 100 parts'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>per part = material + power + labor + wear</li>
            <li>break-even = printer ÷ (outsourced − per part)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
