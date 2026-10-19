<x-calc.page
    title="Absence Rate per Employee Calculator - SolveKit"
    description="Free Absence Rate per Employee Calculator: days per employee = days lost ÷ employees. Days lost per employee is how public bodies such as the UK ONS report sickness absence."
    lede="Work out the days lost per employee from total days lost and employees."
    about="Days lost per employee is how public bodies such as the UK ONS report sickness absence. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'days_per_employee', 'fields' => ['days', 'employees']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total days lost, Employees.'],
        ['name' => 'Read the result', 'text' => 'The days lost per employee appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the days lost per employee?', 'answer' => 'Days per employee = days lost ÷ employees.'],
        ['question' => 'What is the days lost per employee for total days lost 480, employees 100?', 'answer' => '4.8 days.'],
        ['question' => 'And for total days lost 90, employees 25?', 'answer' => '3.6 days.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The UK average is around 4–8 days a year.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="days" label="Total days lost" value="480" min="0" step="any" suffix="days" />
        <x-calc.field name="employees" label="Employees" value="100" step="any" />
    </div>

    <x-calc.result label="Days lost per employee" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['days' => 480, 'employees' => 100],
        'Example B' => ['days' => 90, 'employees' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>days per employee = days lost ÷ employees</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
