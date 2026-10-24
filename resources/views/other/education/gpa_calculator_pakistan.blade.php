<x-calc.page
    title="GPA Calculator Pakistan - SolveKit"
    description="Free GPA calculator for Pakistan: GPA and CGPA on the HEC 4.0 scale from marks and credit hours, with the percentage."
    lede="Calculate GPA on the HEC scale."
    about="Pakistan’s Higher Education Commission sets a uniform grading scale: 85% and above is an A (4.0)."
    :calc="['engine' => 'ot-edu', 'tool' => 'gpa_pakistan', 'fields' => ['courses'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'other' => collect(config('other_data'))->only(['hec'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What GPA do the example marks give?', 'answer' => '3.47.'],
    ]"
>
    <x-calc.textarea name="courses" label="Courses: name, marks % (or letter), credit hours" value="Calculus, 88, 3
Physics, 76, 4
English, 69, 2
Programming, 82, 3" rows="4" />

    <x-calc.result label="GPA" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['courses' => 'Calculus, 88, 3
Physics, 76, 4
English, 69, 2
Programming, 82, 3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'credits' => ['label' => 'Credit hours'],
            'percent' => ['label' => 'Equivalent percentage (band minimum)'],
            'letter' => ['label' => 'Letter for the GPA'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Courses" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
