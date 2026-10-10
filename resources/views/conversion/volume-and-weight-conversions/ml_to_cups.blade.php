<x-tool-page-layout
    title="Milliliters to Cups Converter - SolveKit"
    description="Professional milliliters to cups converter for cooking and baking. Convert mL to cups with precision for recipe measurements and culinary applications."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">mL to Cups</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-slate-700" id="inputLabel">
                                                                                    Enter Volume in Milliliters
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter volume (e.g., 250)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">mL</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500" id="conversionHint">1 US cup = 236.588 mL</p>
                                                                            </div>

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="ml-to-cups" class="text-yellow-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">mL → Cups</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="cups-to-ml" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Cups → mL</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Cup Standard Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Cup Standard
                                                                                </label>
                                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="cupType" value="us" class="text-yellow-600 focus:ring-slate-200" checked>
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">US Cup</span>
                                                                                            <div class="text-[11px] text-slate-500">236.588 mL</div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="cupType" value="metric" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">Metric Cup</span>
                                                                                            <div class="text-[11px] text-slate-500">250 mL</div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="cupType" value="imperial" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">Imperial Cup</span>
                                                                                            <div class="text-[11px] text-slate-500">284.131 mL</div>
                                                                                        </div>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Recipe Ingredient Presets -->
                                                                            

                                                                            <!-- Recipe Scale Calculator -->
                                                                            

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
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Volume in US Cups</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Cooking measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">cups</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- All Cup Standards Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">US Cups</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="usCupsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Metric Cups</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="metricCupsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Imperial Cups</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="imperialCupsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Detailed Cooking Measurements -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <h4 class="text-sm font-semibold text-slate-700 mb-3 text-center">Detailed Cooking Measurements</h4>
                                                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs text-slate-500">
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="tablespoonsOutput">-- tbsp</div>
                                                                                        <div>Tablespoons</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="teaspoonsOutput">-- tsp</div>
                                                                                        <div>Teaspoons</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="flOzOutput">-- fl oz</div>
                                                                                        <div>Fluid Ounces</div>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <div class="font-medium text-slate-700" id="pintsOutput">-- pt</div>
                                                                                        <div>Pints</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Scaled Result (if scaling is active) -->
                                                                            <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200" id="scaledResult" style="display: none;">
                                                                                <h4 class="text-sm font-semibold text-yellow-800 mb-2">Scaled Recipe Amount</h4>
                                                                                <div class="text-lg font-bold text-yellow-700" id="scaledOutput">--</div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="space-y-2">
                                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                                    Common Recipe Measurements
                                                                                                </label>
                                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                                    <button type="button" class="recipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-slate-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="60" data-direction="ml-to-cups">¼ cup</button>
                                                                                                    <button type="button" class="recipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-slate-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="120" data-direction="ml-to-cups">½ cup</button>
                                                                                                    <button type="button" class="recipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-slate-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="240" data-direction="ml-to-cups">1 cup</button>
                                                                                                    <button type="button" class="recipe-preset px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-slate-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="480" data-direction="ml-to-cups">2 cups</button>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                                                                                <h4 class="text-sm font-semibold text-yellow-800 mb-2">Recipe Scaling Helper</h4>
                                                                                                <div class="grid grid-cols-2 gap-3">
                                                                                                    <div>
                                                                                                        <label for="originalServings" class="block text-xs font-medium text-yellow-700 mb-1">Original Servings</label>
                                                                                                        <input type="number" id="originalServings" class="w-full px-2 py-1 text-sm border border-yellow-300 rounded focus:border-slate-400 focus:ring-1 focus:ring-slate-200" placeholder="e.g., 4" min="1">
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <label for="desiredServings" class="block text-xs font-medium text-yellow-700 mb-1">Desired Servings</label>
                                                                                                        <input type="number" id="desiredServings" class="w-full px-2 py-1 text-sm border border-yellow-300 rounded focus:border-slate-400 focus:ring-1 focus:ring-slate-200" placeholder="e.g., 6" min="1">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="mt-2 text-xs text-yellow-700">
                                                                                                    Scale Factor: <span id="scaleFactor" class="font-semibold">--</span>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Cooking Volume Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 US cup = 236.588 mL</div>
                                                        <div>• 1 Metric cup = 250 mL</div>
                                                        <div>• 1 tbsp = 14.787 mL</div>
                                                        <div>• 1 tsp = 4.929 mL</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Milliliters to Cups Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Different Cup Standards</h4>
                                    <p>Cup measurements vary by country: US cups (236.588 mL), metric cups (250 mL), and Imperial cups (284.131 mL). Always check which standard your recipe uses for accurate results.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Cooking Applications</h4>
                                    <p>Essential for international recipe conversions, precise baking measurements, and scaling recipes up or down. Particularly important when converting between American and European recipes.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Baking Tip:</strong> For best results in baking, weigh ingredients when possible. Volume measurements can vary based on how ingredients are packed!
                                </p>
                            </div>
                        </div>

                        <!-- Common Recipe Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Recipe Conversions</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Coffee Cup</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="240">240 mL</div>
                                    <div class="text-[11px] text-slate-500">~1 US cup</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Soup Serving</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="250">250 mL</div>
                                    <div class="text-[11px] text-slate-500">1 metric cup</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Baking Liquid</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="120">120 mL</div>
                                    <div class="text-[11px] text-slate-500">½ US cup</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Large Recipe</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="500">500 mL</div>
                                    <div class="text-[11px] text-slate-500">~2.1 US cups</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const inputLabel = document.getElementById('inputLabel');
                        const inputUnit = document.getElementById('inputUnit');
                        const conversionHint = document.getElementById('conversionHint');
                        const directionRadios = document.getElementsByName('direction');
                        const cupTypeRadios = document.getElementsByName('cupType');
                        const originalServings = document.getElementById('originalServings');
                        const desiredServings = document.getElementById('desiredServings');
                        const scaleFactor = document.getElementById('scaleFactor');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const usCupsOutput = document.getElementById('usCupsOutput');
                        const metricCupsOutput = document.getElementById('metricCupsOutput');
                        const imperialCupsOutput = document.getElementById('imperialCupsOutput');
                        const tablespoonsOutput = document.getElementById('tablespoonsOutput');
                        const teaspoonsOutput = document.getElementById('teaspoonsOutput');
                        const flOzOutput = document.getElementById('flOzOutput');
                        const pintsOutput = document.getElementById('pintsOutput');
                        const scaledResult = document.getElementById('scaledResult');
                        const scaledOutput = document.getElementById('scaledOutput');

                        // Conversion constants (mL)
                        const cupConversions = {
                            us: 236.588,
                            metric: 250,
                            imperial: 284.131
                        };

                        function formatNumber(num) {
                            if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }
                        }

                        function getCupConversion() {
                            const cupType = document.querySelector('input[name="cupType"]:checked').value;
                            return cupConversions[cupType];
                        }

                        function updateScaleFactor() {
                            const orig = parseFloat(originalServings.value);
                            const desired = parseFloat(desiredServings.value);
                            
                            if (!isNaN(orig) && !isNaN(desired) && orig > 0) {
                                const factor = desired / orig;
                                scaleFactor.textContent = factor.toFixed(2) + 'x';
                                return factor;
                            } else {
                                scaleFactor.textContent = '--';
                                return null;
                            }
                        }

                        function convert() {
                            const value = parseFloat(inputValue.value);
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            const cupType = document.querySelector('input[name="cupType"]:checked').value;
                            const conversionRate = getCupConversion();

                            if (!isNaN(value) && value >= 0) {
                                let ml, cups;

                                if (direction === 'ml-to-cups') {
                                    ml = value;
                                    cups = value / conversionRate;
                                    
                                    const cupTypeText = cupType === 'us' ? 'US Cups' : 
                                                      cupType === 'metric' ? 'Metric Cups' : 'Imperial Cups';
                                    
                                    resultTitle.textContent = `Volume in ${cupTypeText}`;
                                    resultDescription.textContent = 'Cooking measurement';
                                    output.textContent = formatNumber(cups);
                                    unitDisplay.textContent = 'cups';
                                } else {
                                    cups = value;
                                    ml = value * conversionRate;
                                    
                                    resultTitle.textContent = 'Volume in Milliliters';
                                    resultDescription.textContent = 'Metric volume measurement';
                                    output.textContent = formatNumber(ml);
                                    unitDisplay.textContent = 'mL';
                                }

                                // Always calculate all cup types and other conversions based on mL
                                const usCups = ml / cupConversions.us;
                                const metricCups = ml / cupConversions.metric;
                                const imperialCups = ml / cupConversions.imperial;
                                const tablespoons = ml / 14.787;
                                const teaspoons = ml / 4.929;
                                const flOz = ml / 29.5735;
                                const pints = usCups / 2;

                                usCupsOutput.textContent = formatNumber(usCups) + ' cups';
                                metricCupsOutput.textContent = formatNumber(metricCups) + ' cups';
                                imperialCupsOutput.textContent = formatNumber(imperialCups) + ' cups';
                                tablespoonsOutput.textContent = formatNumber(tablespoons) + ' tbsp';
                                teaspoonsOutput.textContent = formatNumber(teaspoons) + ' tsp';
                                flOzOutput.textContent = formatNumber(flOz) + ' fl oz';
                                pintsOutput.textContent = formatNumber(pints) + ' pt';

                                // Calculate scaled result if scaling is active
                                const factor = updateScaleFactor();
                                if (factor !== null) {
                                    const scaledValue = direction === 'ml-to-cups' ? ml * factor : cups * factor;
                                    const scaledUnit = direction === 'ml-to-cups' ? 'mL' : 'cups';
                                    scaledOutput.textContent = formatNumber(scaledValue) + ' ' + scaledUnit;
                                    scaledResult.style.display = 'block';
                                } else {
                                    scaledResult.style.display = 'none';
                                }
                            } else {
                                output.textContent = "--";
                                usCupsOutput.textContent = "--";
                                metricCupsOutput.textContent = "--";
                                imperialCupsOutput.textContent = "--";
                                tablespoonsOutput.textContent = "--";
                                teaspoonsOutput.textContent = "--";
                                flOzOutput.textContent = "--";
                                pintsOutput.textContent = "--";
                                scaledResult.style.display = 'none';
                                updateScaleFactor();
                            }
                        }

                        function updateLabels() {
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            const cupType = document.querySelector('input[name="cupType"]:checked').value;

                            if (direction === 'ml-to-cups') {
                                inputLabel.textContent = 'Enter Volume in Milliliters';
                                inputValue.placeholder = 'Enter volume (e.g., 250)';
                                inputUnit.textContent = 'mL';
                                
                                const rate = cupConversions[cupType];
                                const cupName = cupType === 'us' ? 'US cup' : 
                                               cupType === 'metric' ? 'metric cup' : 'Imperial cup';
                                conversionHint.textContent = `1 ${cupName} = ${rate} mL`;
                            } else {
                                const cupTypeText = cupType === 'us' ? 'US Cups' : 
                                                  cupType === 'metric' ? 'Metric Cups' : 'Imperial Cups';
                                
                                inputLabel.textContent = `Enter Volume in ${cupTypeText}`;
                                inputValue.placeholder = `Enter ${cupTypeText.toLowerCase()} (e.g., 1.5)`;
                                inputUnit.textContent = 'cups';
                                
                                const rate = cupConversions[cupType];
                                const cupName = cupType === 'us' ? 'US cup' : 
                                               cupType === 'metric' ? 'metric cup' : 'Imperial cup';
                                conversionHint.textContent = `1 ${cupName} = ${rate} mL`;
                            }
                        }

                        function clearAll() {
                            inputValue.value = '';
                            originalServings.value = '';
                            desiredServings.value = '';
                            convert();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        originalServings.addEventListener('input', convert);
                        desiredServings.addEventListener('input', convert);
                        
                        directionRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabels();
                                convert();
                            });
                        });

                        cupTypeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabels();
                                convert();
                            });
                        });

                        clearButton.addEventListener('click', clearAll);

                        // Recipe preset buttons
                        const recipePresets = document.querySelectorAll('.recipe-preset');
                        recipePresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const direction = this.getAttribute('data-direction');
                                
                                // Set direction
                                document.querySelector(`input[value="${direction}"]`).checked = true;
                                updateLabels();
                                
                                inputValue.value = value;
                                convert();
                                
                                // Update button styles
                                recipePresets.forEach(btn => btn.classList.remove('bg-yellow-100', 'text-yellow-700'));
                                recipePresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-slate-700'));
                                this.classList.remove('bg-gray-100', 'text-slate-700');
                                this.classList.add('bg-yellow-100', 'text-yellow-700');
                            });
                        });

                        // Add clickable functionality to example volumes
                        const exampleVolumes = document.querySelectorAll('[data-volume]');
                        exampleVolumes.forEach(element => {
                            element.addEventListener('click', function() {
                                const volumeValue = this.getAttribute('data-volume');
                                
                                // Set to ml-to-cups mode
                                document.querySelector('input[value="ml-to-cups"]').checked = true;
                                document.querySelector('input[value="us"]').checked = true;
                                updateLabels();
                                
                                inputValue.value = volumeValue;
                                convert();
                                inputValue.focus();
                            });
                        });

                        // Initialize
                        inputValue.focus();
                        updateLabels();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearAll();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                // Toggle direction
                                const currentDirection = document.querySelector('input[name="direction"]:checked').value;
                                const newDirection = currentDirection === 'ml-to-cups' ? 'cups-to-ml' : 'ml-to-cups';
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
