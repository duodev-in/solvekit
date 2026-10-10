<x-tool-page-layout
    title="Decimeter to Meter Converter - ConvertPro"
    description="Professional decimeter to meter converter for simple metric conversions. Fast and accurate bidirectional conversion between decimeters and meters."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Decimeter to Meter</h1>
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
                                                                                        placeholder="Enter measurement value"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-slate-500 text-sm font-medium" id="input-unit">dm</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="space-y-1">
                                                                                <span class="block text-xs font-semibold text-slate-700">Conversion Mode</span>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                        <input type="radio" name="direction" value="dmToM" class="text-indigo-600" checked>
                                                                                        <span class="text-xs font-medium">Decimeters to Meters</span>
                                                                                    </label>
                                                                                    <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                        <input type="radio" name="direction" value="mToDm" class="text-indigo-600">
                                                                                        <span class="text-xs font-medium">Meters to Decimeters</span>
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
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Converted Length</h4>
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
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Decimeter to Meter Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">What is a Decimeter?</h4>
                                    <p>A decimeter (dm) is a metric unit of length equal to one-tenth of a meter or 10 centimeters. It's commonly used in Europe for measuring smaller objects and distances.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Applications</h4>
                                    <p>Decimeter conversions are useful in education, construction measurements, fabric sizing, and scientific calculations where intermediate metric units are needed.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Memory Tip:</strong> Think "deci" = one-tenth, so 1 decimeter = 0.1 meters!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Quick Reference</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 1 meter = 10 decimeters</div>
                                <div>• 1 decimeter = 0.1 meters</div>
                                <div>• 1 decimeter = 10 centimeters</div>
                                <div>• 1 decimeter = 100 millimeters</div>
                            </div>
                        </div>

                        <!-- Common Measurements -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Decimeter Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Smartphone</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-value="1.5" data-from="dm">1.5 dm</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Desk Height</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-value="0.75" data-from="m">0.75 m</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Door Height</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-value="2" data-from="m">2 m</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">School Ruler</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-value="3" data-from="dm">3 dm</div>
                                </div>
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
                            dmToM: { rate: 0.1, title: 'Length in Meters', fromUnit: 'dm', toUnit: 'm', formula: 'Meters = Decimeters × 0.1' },
                            mToDm: { rate: 10, title: 'Length in Decimeters', fromUnit: 'm', toUnit: 'dm', formula: 'Decimeters = Meters × 10' }
                        };

                        function getDirection() {
                            return document.querySelector('input[name="direction"]:checked')?.value || 'dmToM';
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
                            valueInput.placeholder = `Enter ${conversion.fromUnit === 'dm' ? 'decimeters' : 'meters'}`;
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
                                resultTitle.textContent = 'Converted Length';
                                resultDescription.textContent = 'Enter a value to convert';
                            }
                        }

                        function swapDirection() {
                            const currentDirection = getDirection();
                            const currentValue = valueInput.value;
                            
                            // Swap the direction
                            if (currentDirection === 'dmToM') {
                                setDirection('mToDm');
                            } else {
                                setDirection('dmToM');
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

                        // Add clickable functionality to example measurements
                        const exampleMeasurements = document.querySelectorAll('[data-value]');
                        exampleMeasurements.forEach(element => {
                            element.addEventListener('click', function() {
                                const measurementValue = this.getAttribute('data-value');
                                const fromUnit = this.getAttribute('data-from');
                                
                                valueInput.value = measurementValue;
                                if (fromUnit === 'dm') {
                                    setDirection('dmToM');
                                } else {
                                    setDirection('mToDm');
                                }
                                updateLabels();
                                convert();
                                valueInput.focus();
                            });
                        });

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
