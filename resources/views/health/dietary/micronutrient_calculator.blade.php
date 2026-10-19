<x-calc.page
    title="Micronutrient Calculator - SolveKit"
    description="Free micronutrient calculator: compare your vitamin and mineral intakes with the RDA or AI and the upper limit for your age and sex."
    lede="Check vitamins and minerals against your targets."
    about="Enter what you take in each day (from food labels, apps or supplements) in the units shown in the National Academies tables: mg, µg or g. Each is compared with the RDA or AI and the Tolerable Upper Intake Level for your life stage. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'micronutrients', 'fields' => ['items', 'age', 'sex', 'state'], 'data' => ['dri' => config('health_data.dri')]]"
    :how-to="[
        ['name' => 'List nutrients and amounts', 'text' => ''],
        ['name' => 'Enter age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Do 10 µg vitamin D, 800 mg calcium, 14 mg iron and 120 mg vitamin C meet a woman\'s needs?', 'answer' => 'Below target: Vitamin D, Calcium, Iron.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Nutrients (name, amount a day)" :columns="['name' => 'Nutrient', 'amount' => 'Amount']" :rows="[['Vitamin D', '10'], ['Calcium', '800'], ['Iron', '14'], ['Vitamin C', '120']]" add-label="Add nutrient" help="Units: vitamin D, A, K, B12, folate, biotin, iodine, selenium, copper, chromium, molybdenum in µg; others in mg." :text="['name', 'amount']" :lists="['name' => collect(config('health_data.dri.nutrients'))->map(fn ($n) => $n['name'])->values()->all()]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="35" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="female" />
        <x-calc.select name="state" label="Life stage" :options="['none' => 'Not pregnant or breastfeeding', 'pregnancy' => 'Pregnant', 'lactation' => 'Breastfeeding']" selected="none" />
    </div>

    <x-calc.result label="Nutrients meeting the target" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => 'Vitamin D	10
Calcium	800
Iron	14
Vitamin C	120', 'age' => 35, 'sex' => 'female', 'state' => 'none'],
        'Supplements' => ['items' => 'Vitamin D	125
Vitamin A	3500
Zinc	50', 'age' => 45, 'sex' => 'male', 'state' => 'none'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'group' => ['label' => 'Group'],
            'over' => ['label' => 'Above upper limit'],
        ]" />
        <x-calc.grid heading="Nutrients" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>% = intake ÷ RDA or AI</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
