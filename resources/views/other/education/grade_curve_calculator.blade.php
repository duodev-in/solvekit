<x-calc.page
    title="Grade Curve Calculator - SolveKit"
    description="Free grade curve calculator: flat, scaled, square-root or bell curve for a set of test scores."
    lede="Curve test scores."
    about="Teachers curve grades to adjust for a hard test. Each method lifts scores differently."
    :calc="['engine' => 'ot-edu', 'tool' => 'grade_curve', 'fields' => ['scores', 'method', 'add', 'mean', 'sdTarget', 'cap'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the new average after a 7-point flat curve?', 'answer' => '74.83%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="scores" label="Scores (%)" value="45, 52, 58, 61, 64, 67, 70, 72, 75, 79, 83, 88" rows="3" />
        <x-calc.select name="method" label="Curve" :options="['flat' => 'Flat: add the same points to everyone', 'top' => 'Highest score becomes 100', 'sqrt' => 'Square root (10 × √score)', 'bell' => 'Bell curve to a target mean and SD']" selected="flat" />
        <div data-show-when="method:flat">
            <x-calc.field name="add" label="Points to add (flat)" value="7" min="0" step="any" />
        </div>
        <div data-show-when="method:bell">
            <x-calc.field name="mean" label="Target mean (bell)" value="75" min="0" step="any" />
        </div>
        <div data-show-when="method:bell">
            <x-calc.field name="sdTarget" label="Target SD (bell)" value="10" min="0" step="any" />
        </div>
        <x-calc.select name="cap" label="Cap at 100?" :options="['yes' => 'Yes', 'no' => 'No']" selected="yes" />
    </div>

    <x-calc.result label="New average" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['scores' => '45, 52, 58, 61, 64, 67, 70, 72, 75, 79, 83, 88', 'method' => 'flat', 'add' => 7, 'mean' => 75, 'sdTarget' => 10, 'cap' => 'yes'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'before' => ['label' => 'Average before'],
            'range' => ['label' => 'New lowest and highest'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Each score" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
