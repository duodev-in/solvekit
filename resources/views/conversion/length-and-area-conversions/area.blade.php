<x-tool-page-layout
    title="Area Calculator - ConvertPro"
    description="Professional area calculator to convert between square meters, square feet, acres, hectares, and other area units. Fast and accurate conversions."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Area Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-5">
                                    <div class="lg:col-span-3">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Value and Units -->
                                                                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                                                            <div class="space-y-2">
                                                                                <label for="value" class="block text-xs font-semibold text-slate-700">
                                                                                    Enter Area Value
                                                                                </label>
                                                                                <input 
                                                                                    type="number" 
                                                                                    id="value" 
                                                                                    class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                    placeholder="Enter area value"
                                                                                    step="any"
                                                                                    min="0"
                                                                                >
                                                                            </div>

                                                                            <!-- From Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="from" class="block text-xs font-semibold text-slate-700">
                                                                                    From Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="from" 
                                                                                    class="w-full rounded-md border border-slate-300 bg-white"
                                                                                >
                                                                                    <option value="sqm">Square Meters (m²)</option>
                                                                                    <option value="sqft">Square Feet (ft²)</option>
                                                                                    <option value="sqin">Square Inches (in²)</option>
                                                                                    <option value="sqyd">Square Yards (yd²)</option>
                                                                                    <option value="sqkm">Square Kilometers (km²)</option>
                                                                                    <option value="sqmm">Square Millimeters (mm²)</option>
                                                                                    <option value="sqcm">Square Centimeters (cm²)</option>
                                                                                    <option value="hectare">Hectares (ha)</option>
                                                                                    <option value="acre">Acres</option>
                                                                                    <option value="ares">Ares (a)</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- To Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="to" class="block text-xs font-semibold text-slate-700">
                                                                                    To Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="to" 
                                                                                    class="w-full rounded-md border border-slate-300 bg-white"
                                                                                >
                                                                                    <option value="sqm">Square Meters (m²)</option>
                                                                                    <option value="sqft">Square Feet (ft²)</option>
                                                                                    <option value="sqin">Square Inches (in²)</option>
                                                                                    <option value="sqyd">Square Yards (yd²)</option>
                                                                                    <option value="sqkm">Square Kilometers (km²)</option>
                                                                                    <option value="sqmm">Square Millimeters (mm²)</option>
                                                                                    <option value="sqcm">Square Centimeters (cm²)</option>
                                                                                    <option value="hectare">Hectares (ha)</option>
                                                                                    <option value="acre">Acres</option>
                                                                                    <option value="ares">Ares (a)</option>
                                                                                </select>
                                                                            </div>

                                                                            </div>

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + Shift + C to clear</p>
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
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">Select units</div>
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
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Area Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Applications</h4>
                                    <p>Area calculations are essential for real estate transactions, construction planning, landscaping projects, agricultural planning, and scientific measurements across various fields.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Precision & Accuracy</h4>
                                    <p>Our calculator uses international standard conversion factors for maximum accuracy across all area units, ensuring reliable results for professional and personal use.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Professional Tip:</strong> For large-scale measurements, consider using hectares or square kilometers for better readability!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Quick Reference</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 1 m² = 10.764 ft²</div>
                                <div>• 1 acre = 4,047 m²</div>
                                <div>• 1 hectare = 10,000 m²</div>
                                <div>• 1 ft² = 144 in²</div>
                                <div>• 1 yd² = 9 ft²</div>
                                <div>• 1 hectare = 100 ares</div>
                            </div>
                        </div>

                        <!-- Common Area Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Area Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Tennis Court</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-area="260" data-unit="sqm">260 m²</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Garden Plot</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-area="0.12" data-unit="hectare">0.12 ha</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small House</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-area="1500" data-unit="sqft">1,500 ft²</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">City Park</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-area="1.5" data-unit="acre">1.5 acres</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const valueInput = document.getElementById('value');
                        const fromSelect = document.getElementById('from');
                        const toSelect = document.getElementById('to');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');

                        // Conversion rates to square meters
                        const conversionRates = {
                            sqm: { toSquareMeters: 1, symbol: 'm²', name: 'Square Meters' },
                            sqft: { toSquareMeters: 0.092903, symbol: 'ft²', name: 'Square Feet' },
                            sqin: { toSquareMeters: 0.00064516, symbol: 'in²', name: 'Square Inches' },
                            sqyd: { toSquareMeters: 0.836127, symbol: 'yd²', name: 'Square Yards' },
                            sqkm: { toSquareMeters: 1000000, symbol: 'km²', name: 'Square Kilometers' },
                            sqmm: { toSquareMeters: 0.000001, symbol: 'mm²', name: 'Square Millimeters' },
                            sqcm: { toSquareMeters: 0.0001, symbol: 'cm²', name: 'Square Centimeters' },
                            hectare: { toSquareMeters: 10000, symbol: 'ha', name: 'Hectares' },
                            acre: { toSquareMeters: 4046.86, symbol: 'acres', name: 'Acres' },
                            ares: { toSquareMeters: 100, symbol: 'a', name: 'Ares' }
                        };

                        function convert() {
                            const value = parseFloat(valueInput.value);
                            const fromUnit = fromSelect.value;
                            const toUnit = toSelect.value;

                            if (!isNaN(value) && value >= 0) {
                                // Convert to square meters first, then to target unit
                                const inSquareMeters = value * conversionRates[fromUnit].toSquareMeters;
                                const result = inSquareMeters / conversionRates[toUnit].toSquareMeters;
                                
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
                                unitDisplay.textContent = conversionRates[toUnit].symbol;
                                resultTitle.textContent = 'Area in ' + conversionRates[toUnit].name;
                                resultDescription.textContent = `${value} ${conversionRates[fromUnit].symbol} = ${formattedResult} ${conversionRates[toUnit].symbol}`;
                            } else {
                                output.textContent = "--";
                                unitDisplay.textContent = "Select units";
                                resultTitle.textContent = 'Converted Area';
                                resultDescription.textContent = 'Enter a value to convert';
                            }
                        }

                        function clearInput() {
                            valueInput.value = '';
                            convert();
                            valueInput.focus();
                        }

                        function updateUnitDisplay() {
                            const toUnit = toSelect.value;
                            if (valueInput.value === '' || isNaN(parseFloat(valueInput.value))) {
                                unitDisplay.textContent = conversionRates[toUnit].symbol;
                            }
                        }

                        // Event listeners
                        valueInput.addEventListener('input', convert);
                        fromSelect.addEventListener('change', function() {
                            convert();
                            updateUnitDisplay();
                        });
                        toSelect.addEventListener('change', function() {
                            convert();
                            updateUnitDisplay();
                        });
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example areas
                        const exampleAreas = document.querySelectorAll('[data-area]');
                        exampleAreas.forEach(element => {
                            element.addEventListener('click', function() {
                                const areaValue = this.getAttribute('data-area');
                                const unitValue = this.getAttribute('data-unit');
                                
                                valueInput.value = areaValue;
                                fromSelect.value = unitValue;
                                convert();
                                valueInput.focus();
                            });
                        });

                        // Initialize
                        updateUnitDisplay();
                        
                        // Focus on input when page loads
                        valueInput.focus();
                        
                        // Set default values
                        fromSelect.value = 'sqft';
                        toSelect.value = 'sqm';

                        // Add keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
