<x-calc.page
    title="GPA Calculator - SolveKit"
    description="Free GPA calculator: grade point average from letter grades, percentages or points and credits."
    lede="Calculate your GPA."
    about="GPA averages the grade points of your courses, weighted by credits."
    :calc="['engine' => 'ot-edu', 'tool' => 'gpa', 'fields' => ['courses', 'scale'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What GPA do the example grades give?', 'answer' => '3.58.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="courses" label="Courses: name, grade, credits (one per line)" value="Biology, A, 4
Algebra, B+, 3
Spanish, A-, 3
Art, B, 2" rows="4" />
        <x-calc.select name="scale" label="Scale" :options="['4' => '4.0 (A and A+ = 4.0)', '4.3' => '4.3 (A+ = 4.3)']" selected="4" />
    </div>

    <x-calc.result label="GPA" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['courses' => 'Biology, A, 4
Algebra, B+, 3
Spanish, A-, 3
Art, B, 2', 'scale' => '4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'credits' => ['label' => 'Total credits'],
            'quality' => ['label' => 'Quality points'],
            'letter' => ['label' => 'Average letter'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
