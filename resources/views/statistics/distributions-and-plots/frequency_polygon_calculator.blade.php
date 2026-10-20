<x-calc.page
    title="Frequency Polygon Calculator - SolveKit"
    description="Free frequency polygon maker: plot class frequencies at their midpoints and join them into a polygon."
    lede="Draw a frequency polygon."
    about="A frequency polygon joins the midpoints of the classes at their frequencies, closing to zero at each end."
    :calc="['engine' => 'st-dist', 'tool' => 'freq_polygon', 'fields' => ['data', 'k', 'width', 'start'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'Where is the highest point in the example?', 'answer' => '6 at 45.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data" value="23, 29, 31, 35, 36, 38, 41, 42, 44, 45, 47, 49, 52, 55, 58, 61, 63, 67, 72, 78" rows="3" />
        <x-calc.field name="k" label="Number of classes (0 = Sturges)" value="6" min="0" step="any" />
        <x-calc.field name="width" label="Class width (optional)" value="10" min="0" step="any" />
        <x-calc.field name="start" label="First class starts at (optional)" value="20" step="any" />
    </div>

    <x-calc.result label="Class midpoints plotted" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '23, 29, 31, 35, 36, 38, 41, 42, 44, 45, 47, 49, 52, 55, 58, 61, 63, 67, 72, 78', 'k' => 6, 'width' => 10, 'start' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Frequency polygon" name="poly" />
        <x-calc.rows heading="Details" :rows="[
            'width' => ['label' => 'Class width'],
            'peak' => ['label' => 'Highest point'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Points of the polygon" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
