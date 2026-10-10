<x-tool-page-layout
    title="Ares to Hectares Converter - ConvertPro"
    description="Professional converter for ares and hectares land area measurements. Fast and accurate bidirectional conversion for agricultural and real estate calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Ares to Hectares</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-5">
                                    <div class="lg:col-span-3">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="value" class="block text-xs font-semibold text-slate-700">
                                                                                    Enter Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="value" 
                                                                                        class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                        placeholder="Enter area value"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-slate-500 text-sm font-medium" id="input-unit">ares</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="space-y-1">
                                                                                <span class="block text-xs font-semibold text-slate-700">Conversion Mode</span>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                        <input type="radio" name="direction" value="aresToHectares" class="text-indigo-600" checked>
                                                                                        <span class="text-xs font-medium">Ares to Hectares</span>
                                                                                    </label>
                                                                                    <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                        <input type="radio" name="direction" value="hectaresToAres" class="text-indigo-600">
                                                                                        <span class="text-xs font-medium">Hectares to Ares</span>
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
                                    <div class="space-y-4 lg:col-span-2">
                                        <!-- Result Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Converted Area</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Enter a value to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">Select direction</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
    

</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Ares to Hectares Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">What is an Are?</h4>
                                    <p>An are is a metric unit of area equal to 100 square meters. It's commonly used in agriculture and land measurement, particularly in Europe for smaller land parcels.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">What is a Hectare?</h4>
                                    <p>A hectare equals 10,000 square meters or 100 ares. It's the standard unit for measuring large agricultural areas, forests, and land plots in metric system countries.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Fun Fact:</strong> The hectare is accepted for use with the International System of Units (SI) and is widely used in land registry and agricultural planning!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Quick Reference</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 1 hectare = 100 ares</div>
                                <div>• 1 are = 0.01 hectares</div>
                                <div>• 1 are = 100 square meters</div>
                                <div>• 1 hectare = 10,000 square meters</div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const valueInput = document.getElementById('value');
                        const directionRadios = document.getElementsByName('direction');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const inputUnit = document.getElementById('input-unit');

                        const conversionRates = {
                            aresToHectares: { rate: 0.01, title: 'Area in Hectares', fromUnit: 'ares', toUnit: 'hectares', formula: 'Hectares = Ares × 0.01' },
                            hectaresToAres: { rate: 100, title: 'Area in Ares', fromUnit: 'hectares', toUnit: 'ares', formula: 'Ares = Hectares × 100' }
                        };

                        function getDirection() {
                            return document.querySelector('input[name="direction"]:checked')?.value || 'aresToHectares';
                        }

                        function setDirection(direction) {
                            directionRadios.forEach((radio) => {
                                radio.checked = radio.value === direction;
                            });
                        }

                        function updateLabels() {
                            const direction = getDirection();
                            const conversion = conversionRates[direction];
                            
                            inputUnit.textContent = conversion.fromUnit;
                            unitDisplay.textContent = conversion.toUnit;
                            valueInput.placeholder = `Enter ${conversion.fromUnit}`;
                        }

                        function convert() {
                            const value = parseFloat(valueInput.value);
                            const direction = getDirection();
                            const conversion = conversionRates[direction];

                            if (!isNaN(value) && value >= 0) {
                                const result = value * conversion.rate;
                                
                                // Format the result appropriately
                                let formattedResult;
                                if (result >= 1000000) {
                                    formattedResult = Number(result.toPrecision(5)).toExponential();
                                } else if (result >= 1000) {
                                    formattedResult = result.toLocaleString(undefined, { maximumFractionDigits: 2 });
                                } else if (result >= 1) {
                                    formattedResult = result.toLocaleString(undefined, { maximumFractionDigits: 4 });
                                } else if (result > 0 && result < 0.000001) {
                                    formattedResult = Number(result.toPrecision(4)).toExponential();
                                } else {
                                    formattedResult = result.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                                }
                                
                                output.textContent = formattedResult;
                                unitDisplay.textContent = conversion.toUnit;
                                resultTitle.textContent = conversion.title;
                                resultDescription.textContent = `${value} ${conversion.fromUnit} = ${formattedResult} ${conversion.toUnit}`;
                            } else {
                                output.textContent = "--";
                                unitDisplay.textContent = "Select direction";
                                resultTitle.textContent = 'Converted Area';
                                resultDescription.textContent = 'Enter a value to convert';
                            }
                        }

                        function swapDirection() {
                            const currentDirection = getDirection();
                            const currentValue = valueInput.value;
                            
                            // Swap the direction
                            if (currentDirection === 'aresToHectares') {
                                setDirection('hectaresToAres');
                            } else {
                                setDirection('aresToHectares');
                            }
                            
                            // If there's a value, use the current result as the new input
                            if (currentValue && !isNaN(parseFloat(currentValue))) {
                                const currentResult = output.textContent;
                                if (currentResult !== '--') {
                                    // Parse the current result and set it as the new input
                                    const numericResult = parseFloat(currentResult.replace(/,/g, ''));
                                    if (!isNaN(numericResult)) {
                                        valueInput.value = numericResult;
                                    }
                                }
                            }
                            
                            updateLabels();
                            convert();
                        }

                        function clearInput() {
                            valueInput.value = '';
                            convert();
                            valueInput.focus();
                        }

                        function updateUnitDisplay() {
                            const direction = getDirection();
                            const conversion = conversionRates[direction];
                            if (valueInput.value === '' || isNaN(parseFloat(valueInput.value))) {
                                unitDisplay.textContent = conversion.toUnit;
                            }
                        }

                        // Event listeners
                        valueInput.addEventListener('input', convert);
                        directionRadios.forEach((radio) => {
                            radio.addEventListener('change', function() {
                                updateLabels();
                                convert();
                                updateUnitDisplay();
                            });
                        });
                        clearButton.addEventListener('click', clearInput);

                        // Initialize
                        updateLabels();
                        updateUnitDisplay();
                        
                        // Focus on input when page loads
                        valueInput.focus();

                        // Add keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            } else if (e.ctrlKey && (e.key === 'm' || e.key === 'M')) {
                                e.preventDefault();
                                swapDirection();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
