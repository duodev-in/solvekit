<x-calc.page
    title="Venn Diagram Calculator - SolveKit"
    description="Free Venn diagram calculator: regions, unions and intersections for two or three sets, from lists or counts."
    lede="Draw a Venn diagram."
    about="A Venn diagram shows how sets overlap. Inclusion–exclusion gives the size of the union from the sets and their overlaps."
    :calc="['engine' => 'st-desc', 'tool' => 'venn', 'fields' => ['mode', 'A', 'B', 'C', 'nA', 'nB', 'nC', 'nAB', 'nAC', 'nBC', 'nABC', 'total'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many items are in the union of the example sets?', 'answer' => '7.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Enter" :options="['lists2' => 'Two lists of items', 'lists3' => 'Three lists of items', 'counts2' => 'Counts for two sets', 'counts3' => 'Counts for three sets']" selected="lists2" />
        <div data-show-when="mode:lists2,lists3">
            <x-calc.textarea name="A" label="Set A" value="apple, banana, cherry, date, fig" rows="3" />
        </div>
        <div data-show-when="mode:lists2,lists3">
            <x-calc.textarea name="B" label="Set B" value="banana, date, grape, kiwi" rows="3" />
        </div>
        <div data-show-when="mode:lists3">
            <x-calc.textarea name="C" label="Set C" value="cherry, date, kiwi, lemon" rows="3" />
        </div>
        <div data-show-when="mode:counts2,counts3">
            <x-calc.field name="nA" label="|A|" value="30" min="0" step="any" />
        </div>
        <div data-show-when="mode:counts2,counts3">
            <x-calc.field name="nB" label="|B|" value="25" min="0" step="any" />
        </div>
        <div data-show-when="mode:counts3">
            <x-calc.field name="nC" label="|C|" value="20" min="0" step="any" />
        </div>
        <div data-show-when="mode:counts2,counts3">
            <x-calc.field name="nAB" label="|A ∩ B|" value="10" min="0" step="any" />
        </div>
        <div data-show-when="mode:counts3">
            <x-calc.field name="nAC" label="|A ∩ C|" value="6" min="0" step="any" />
        </div>
        <div data-show-when="mode:counts3">
            <x-calc.field name="nBC" label="|B ∩ C|" value="5" min="0" step="any" />
        </div>
        <div data-show-when="mode:counts3">
            <x-calc.field name="nABC" label="|A ∩ B ∩ C|" value="2" min="0" step="any" />
        </div>
        <div data-show-when="mode:counts2,counts3">
            <x-calc.field name="total" label="Total in the universe (optional)" value="60" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Union" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'lists2', 'A' => 'apple, banana, cherry, date, fig', 'B' => 'banana, date, grape, kiwi', 'C' => 'cherry, date, kiwi, lemon', 'nA' => 30, 'nB' => 25, 'nC' => 20, 'nAB' => 10, 'nAC' => 6, 'nBC' => 5, 'nABC' => 2, 'total' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Venn diagram" name="venn" />
        <x-calc.rows heading="Details" :rows="[
            'inter' => ['label' => 'Intersection of all'],
            'only' => ['label' => 'In exactly one set'],
            'none' => ['label' => 'In none (needs a total)'],
            'detail' => ['label' => 'Regions'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
