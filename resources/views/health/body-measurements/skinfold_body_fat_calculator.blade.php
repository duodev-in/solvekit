<x-calc.page
    title="Skinfold Body Fat Calculator - SolveKit"
    description="Free skinfold body fat calculator: body fat from 3-site or 7-site Jackson & Pollock or 4-site Durnin & Womersley caliper measurements."
    lede="Estimate body fat from skinfold calipers."
    about="Skinfolds (mm) are summed and turned into body density with age- and sex-specific equations, then into fat percentage with the Siri equation (495 ÷ density − 450). Jackson & Pollock 3-site uses chest, abdomen and thigh for men and triceps, suprailiac and thigh for women; 7-site uses all seven; Durnin & Womersley uses biceps, triceps, subscapular and suprailiac. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'skinfold', 'fields' => ['method', 'sex', 'age', 'chest', 'abdomen', 'thigh', 'triceps', 'suprailiac', 'subscapular', 'midaxillary', 'biceps']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => 'Only the listed sites are used.'],
        ['name' => 'Take each skinfold twice and use the average', 'text' => 'Right side, vertical folds except chest and subscapular.'],
    ]"
    :faqs="[
        ['question' => 'What is the body fat of a 30-year-old man with 12, 20 and 15 mm (chest, abdomen, thigh)?', 'answer' => '14.2%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="method" legend="Method" :options="['jp3' => 'JP 3-site', 'jp7' => 'JP 7-site', 'dw4' => 'Durnin 4-site']" selected="jp3" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.field name="age" label="Age" value="30" min="0" step="1" suffix="years" />

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="chest" label="Chest" value="12" min="0" step="any" suffix="mm" />
        <x-calc.field name="abdomen" label="Abdomen" value="20" min="0" step="any" suffix="mm" />
        <x-calc.field name="thigh" label="Thigh" value="15" min="0" step="any" suffix="mm" />
        <x-calc.field name="triceps" label="Triceps" value="12" min="0" step="any" suffix="mm" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="suprailiac" label="Suprailiac" value="14" min="0" step="any" suffix="mm" />
        <x-calc.field name="subscapular" label="Subscapular" value="14" min="0" step="any" suffix="mm" />
        <x-calc.field name="midaxillary" label="Midaxillary" value="12" min="0" step="any" suffix="mm" />
        <x-calc.field name="biceps" label="Biceps" value="6" min="0" step="any" suffix="mm" />
    </div>

    <x-calc.result label="Body fat (Siri)" />

    <x-calc.options :decimals="false" :examples="[
        'JP3 man' => ['method' => 'jp3', 'sex' => 'male', 'age' => 30, 'chest' => 12, 'abdomen' => 20, 'thigh' => 15, 'triceps' => 12, 'suprailiac' => 14, 'subscapular' => 14, 'midaxillary' => 12, 'biceps' => 6],
        'JP7 woman' => ['method' => 'jp7', 'sex' => 'female', 'age' => 35, 'chest' => 10, 'abdomen' => 22, 'thigh' => 25, 'triceps' => 18, 'suprailiac' => 16, 'subscapular' => 15, 'midaxillary' => 12, 'biceps' => 8],
        'Durnin 4-site' => ['method' => 'dw4', 'sex' => 'male', 'age' => 45, 'chest' => 12, 'abdomen' => 20, 'thigh' => 15, 'triceps' => 12, 'suprailiac' => 14, 'subscapular' => 16, 'midaxillary' => 12, 'biceps' => 7],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'density' => ['label' => 'Body density'],
            'brozek' => ['label' => 'Brozek'],
            'sites' => ['label' => 'Sites used'],
            'method' => ['label' => 'Equation'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>density from Σ skinfolds and age</li>
            <li>fat % = 495 ÷ density − 450</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
