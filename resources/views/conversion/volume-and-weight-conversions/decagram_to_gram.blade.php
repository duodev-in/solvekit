<x-tool-page-layout
    title="Decagram to Gram Converter - SolveKit"
    description="Professional decagram to gram converter for metric weight conversions. Convert decagrams (dag) to grams (g) with precise calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Decagram to Gram</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="decagram" class="block text-sm font-semibold text-slate-700">
                                                                                    Enter Value in Decagrams
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="decagram" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter decagrams (e.g., 2.5)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">dag</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">1 decagram = 10 grams</p>
                                                                            </div>

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="dag-to-g" class="text-yellow-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Decagrams → Grams</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="g-to-dag" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Grams → Decagrams</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + M to switch mode</p>
                                                                                <button
                                                                                    type="button"
                                                                                    id="clearButton"
                                                                                    class="rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700"
                                                                                >
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-4">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Equivalent in Grams</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Metric weight conversion</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">g</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Metric Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Milligrams</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="mgOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Kilograms</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="kgOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Ounces</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="ozOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Metric Weight System</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 dag = 10 g</div>
                                                        <div>• 1 g = 1000 mg</div>
                                                        <div>• 1 kg = 100 dag</div>
                                                        <div>• 1 dag = 0.35 oz</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Decagram Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">What is a Decagram?</h4>
                                    <p>A decagram (dag) is a metric unit of mass equal to 10 grams. It's part of the International System of Units (SI) and is commonly used in some European countries for food packaging and measurements.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Practical Applications</h4>
                                    <p>Used in cooking, nutrition labeling, laboratory measurements, and commercial food packaging where intermediate weight units between grams and kilograms are needed.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Metric Tip:</strong> Decagrams are particularly useful for portion control and recipe scaling in professional kitchens!
                                </p>
                            </div>
                        </div>

                        <!-- Common Weight Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Weight Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Cookie</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="1">1 dag</div>
                                    <div class="text-[11px] text-slate-500">10 grams</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Slice of Bread</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="2.5">2.5 dag</div>
                                    <div class="text-[11px] text-slate-500">25 grams</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Chocolate Bar</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="5">5 dag</div>
                                    <div class="text-[11px] text-slate-500">50 grams</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Apple</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="15">15 dag</div>
                                    <div class="text-[11px] text-slate-500">150 grams</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const decagramInput = document.getElementById('decagram');
                        const directionRadios = document.getElementsByName('direction');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const mgOutput = document.getElementById('mgOutput');
                        const kgOutput = document.getElementById('kgOutput');
                        const ozOutput = document.getElementById('ozOutput');

                        function formatNumber(num) {
                            if (num >= 1000000) {
                                return Number(num.toPrecision(5)).toExponential();
                            } else if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else if (Math.abs(num) < 1) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            } else {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                            }
                        }

                        function convert() {
                            const value = parseFloat(decagramInput.value);
                            const direction = document.querySelector('input[name="direction"]:checked').value;

                            if (!isNaN(value) && value >= 0) {
                                let grams, decagrams;

                                if (direction === 'dag-to-g') {
                                    decagrams = value;
                                    grams = value * 10;
                                    resultTitle.textContent = 'Equivalent in Grams';
                                    resultDescription.textContent = 'Decagrams to grams conversion';
                                    output.textContent = formatNumber(grams);
                                    unitDisplay.textContent = 'g';
                                } else {
                                    grams = value;
                                    decagrams = value / 10;
                                    resultTitle.textContent = 'Equivalent in Decagrams';
                                    resultDescription.textContent = 'Grams to decagrams conversion';
                                    output.textContent = formatNumber(decagrams);
                                    unitDisplay.textContent = 'dag';
                                }

                                // Additional conversions (always from grams)
                                const milligrams = grams * 1000;
                                const kilograms = grams / 1000;
                                const ounces = grams * 0.035274;

                                mgOutput.textContent = formatNumber(milligrams) + ' mg';
                                kgOutput.textContent = formatNumber(kilograms) + ' kg';
                                ozOutput.textContent = formatNumber(ounces) + ' oz';
                            } else {
                                output.textContent = "--";
                                mgOutput.textContent = "--";
                                kgOutput.textContent = "--";
                                ozOutput.textContent = "--";
                            }
                        }

                        function updateLabels() {
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            const inputLabel = document.querySelector('label[for="decagram"]');
                            const placeholder = decagramInput.getAttribute('placeholder');

                            if (direction === 'dag-to-g') {
                                inputLabel.textContent = 'Enter Value in Decagrams';
                                decagramInput.placeholder = 'Enter decagrams (e.g., 2.5)';
                                document.querySelector('.absolute span').textContent = 'dag';
                            } else {
                                inputLabel.textContent = 'Enter Value in Grams';
                                decagramInput.placeholder = 'Enter grams (e.g., 25)';
                                document.querySelector('.absolute span').textContent = 'g';
                            }
                        }

                        function clearInput() {
                            decagramInput.value = '';
                            convert();
                            decagramInput.focus();
                        }

                        // Event listeners
                        decagramInput.addEventListener('input', convert);
                        directionRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabels();
                                convert();
                            });
                        });
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example weights
                        const exampleWeights = document.querySelectorAll('[data-weight]');
                        exampleWeights.forEach(element => {
                            element.addEventListener('click', function() {
                                const weightValue = this.getAttribute('data-weight');
                                
                                // Set to dag-to-g mode
                                document.querySelector('input[value="dag-to-g"]').checked = true;
                                updateLabels();
                                
                                decagramInput.value = weightValue;
                                convert();
                                decagramInput.focus();
                            });
                        });

                        // Initialize
                        decagramInput.focus();
                        updateLabels();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                // Toggle direction
                                const currentDirection = document.querySelector('input[name="direction"]:checked').value;
                                const newDirection = currentDirection === 'dag-to-g' ? 'g-to-dag' : 'dag-to-g';
                                document.querySelector(`input[value="${newDirection}"]`).checked = true;
                                updateLabels();
                                convert();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
