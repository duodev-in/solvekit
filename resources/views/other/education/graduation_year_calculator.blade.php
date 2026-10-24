<x-calc.page
    title="Graduation Year Calculator - SolveKit"
    description="Free graduation year calculator: high-school graduation year from a date of birth (US, England or custom rules)."
    lede="Find a graduation year."
    about="Children start school in the year they reach a set age by a cut-off date, so the birth date fixes the graduation year. Also known as Graduation Calculator by Birthday, School Age Calculator and What Grade Was I in Year Calculator."
    :calc="['engine' => 'ot-edu', 'tool' => 'graduation', 'fields' => ['birth', 'system', 'cutoffMonth', 'cutoffDay', 'startAge', 'years', 'year'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'When does a child born 15 March 2010 graduate (US)?', 'answer' => 'In 2028.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="birth" label="Date of birth" value="2010-03-15" type="date" />
        <x-calc.select name="system" label="School system" :options="['us' => 'United States (K at 5 by 1 Sept; 13 years K–12)', 'england' => 'England & Wales (Reception at 4 by 1 Sept; to Year 13)', 'custom' => 'Custom']" selected="us" />
        <div data-show-when="system:custom">
            <x-calc.field name="cutoffMonth" label="Cut-off month (1–12)" value="9" min="1" step="any" />
        </div>
        <div data-show-when="system:custom">
            <x-calc.field name="cutoffDay" label="Cut-off day" value="1" min="1" step="any" />
        </div>
        <div data-show-when="system:custom">
            <x-calc.field name="startAge" label="Age to start by the cut-off" value="5" min="0" step="any" />
        </div>
        <div data-show-when="system:custom">
            <x-calc.field name="years" label="Years of school to graduation" value="13" min="1" step="any" />
        </div>
        <x-calc.field name="year" label="What grade in school year starting (optional)" value="2026" min="1900" step="any" />
    </div>

    <x-calc.result label="Expected graduation year" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['birth' => '2010-03-15', 'system' => 'us', 'cutoffMonth' => 9, 'cutoffDay' => 1, 'startAge' => 5, 'years' => 13, 'year' => 2026],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'start' => ['label' => 'First school year'],
            'grade' => ['label' => 'Grade in the chosen year'],
            'age' => ['label' => 'Age at graduation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
