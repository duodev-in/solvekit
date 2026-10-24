<x-calc.page
    title="High School GPA Calculator - SolveKit"
    description="Free high school GPA calculator: weighted and unweighted GPA with honors and AP/IB classes."
    lede="Find your high school GPA."
    about="Many high schools add 0.5 points for honors and 1.0 for AP or IB classes in a weighted GPA."
    :calc="['engine' => 'ot-edu', 'tool' => 'hs_gpa', 'fields' => ['courses'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the weighted GPA of the example?', 'answer' => '4.1.'],
    ]"
>
    <x-calc.textarea name="courses" label="Classes: name, grade, credits, level (R, H or AP/IB)" value="English 11, A-, 1, H
AP Chemistry, B+, 1, AP
Algebra II, A, 1, R
US History, B, 1, AP
Spanish III, A, 1, R" rows="5" />

    <x-calc.result label="Weighted GPA" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['courses' => 'English 11, A-, 1, H
AP Chemistry, B+, 1, AP
Algebra II, A, 1, R
US History, B, 1, AP
Spanish III, A, 1, R'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'unweighted' => ['label' => 'Unweighted GPA'],
            'credits' => ['label' => 'Credits'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
