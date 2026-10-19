<x-calc.page
    title="Net Carbs Calculator - SolveKit"
    description="Free net carbs calculator: net carbohydrate from a Nutrition Facts label, subtracting fibre and half of sugar alcohols."
    lede="Work out net carbs from a label."
    about="Net carbs = total carbohydrate − dietary fibre − ½ × sugar alcohols (− allulose). It is a convention used in low-carb diets, not an FDA-defined term; many people subtract erythritol in full because it is barely absorbed. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'net_carbs', 'fields' => ['carbs', 'fiber', 'sugar_alcohol', 'allulose', 'servings']]"
    :how-to="[
        ['name' => 'Copy the label values', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the net carbs with 24 g carbs, 8 g fibre and 6 g sugar alcohols?', 'answer' => '13.0 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="carbs" label="Total carbohydrate" value="24" min="0" step="any" suffix="g" />
        <x-calc.field name="fiber" label="Dietary fibre" value="8" min="0" step="any" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sugar_alcohol" label="Sugar alcohols" value="6" min="0" step="any" suffix="g" />
        <x-calc.field name="allulose" label="Allulose" value="0" min="0" step="any" suffix="g" />
        <x-calc.field name="servings" label="Servings per pack" value="2" min="0" step="1" />
    </div>

    <x-calc.result label="Net carbs per serving" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['carbs' => 24, 'fiber' => 8, 'sugar_alcohol' => 6, 'allulose' => 0, 'servings' => 2],
        'Bread' => ['carbs' => 15, 'fiber' => 3, 'sugar_alcohol' => 0, 'allulose' => 0, 'servings' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pack' => ['label' => 'Whole pack'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>net = carbs − fibre − ½ sugar alcohols</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
